<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pemasok;
use App\Models\Barang;
use App\Models\PembelianDetail;
use App\Models\Stok;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    // public function index()
    // {
    //     $pembelian = Pembelian::with(['pemasok', 'barang', 'user'])->get();
    //     return view('pages.pembelian.index', compact('pembelian'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data pembelian beserta relasi yang dibutuhkan
            $data = Pembelian::with(['pemasok', 'user', 'details.barang'])->get();

            return DataTables::of($data)
                ->addColumn('barang', function ($row) {
                    $barang = '';
                    foreach ($row->details as $detail) {
                        $barang .= '<li>' . $detail->barang->nama . '</li>';
                    }
                    return '<ul>' . $barang . '</ul>';
                })
                ->addColumn('jumlah_barang', function ($row) {
                    $jumlah = '';
                    foreach ($row->details as $detail) {
                        $jumlah .= '<li>' . $detail->jumlah_barang . '</li>';
                    }
                    return '<ul>' . $jumlah . '</ul>';
                })
                ->addColumn('harga_barang', function ($row) {
                    $harga = '';
                    foreach ($row->details as $detail) {
                        $harga .= '<li>' . number_format($detail->harga_barang, 2) . '</li>';
                    }
                    return '<ul>' . $harga . '</ul>';
                })
                ->addColumn('harga_jual', function ($row) {
                    $hargaJual = '';
                    foreach ($row->details as $detail) {
                        $hargaJual .= '<li>' . number_format($detail->harga_jual, 2) . '</li>';
                    }
                    return '<ul>' . $hargaJual . '</ul>';
                })
                ->addColumn('total_harga', function ($row) {
                    $totalHarga = 0;
                    foreach ($row->details as $detail) {
                        // Menghitung total harga (harga barang * jumlah barang)
                        $totalHarga += $detail->harga_barang * $detail->jumlah_barang;
                    }
                    return number_format($totalHarga, 2);
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('pembelian.edit', $row->id);
                    $deleteUrl = route('pembelian.destroy', $row->id);

                    return '
                    <a href="' .
                        $editUrl .
                        '" class="btn btn-warning btn-sm">Edit</a>
                    <form action="' .
                        $deleteUrl .
                        '" method="POST" style="display:inline;" onsubmit="return confirm(\'Anda yakin ingin menghapus data ini?\');">
                        ' .
                        csrf_field() .
                        '
                        ' .
                        method_field('DELETE') .
                        '
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                ';
                })
                ->rawColumns(['barang', 'jumlah_barang', 'harga_barang', 'harga_jual', 'action'])
                ->make(true);
        }

        return view('pages.pembelian.index');
    }

    public function create()
    {
        $latestPurchase = Pembelian::latest()->first();
        $kodePembelian = 'PB-' . date('Ymd') . '-' . str_pad($latestPurchase ? $latestPurchase->id + 1 : 1, 4, '0', STR_PAD_LEFT);

        $pemasok = Pemasok::all();
        $barang = Barang::all();
        return view('pages.pembelian.create', compact('pemasok', 'barang', 'kodePembelian'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'kode_pembelian' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'id_pemasok' => 'required|exists:pemasok,id',
            'pajak' => 'required|numeric|min:0',
            'barang' => 'required|array',
            'barang.*.id_barang' => 'required|exists:barang,id',
            'barang.*.jumlah_barang' => 'required|numeric|min:1',
            'barang.*.harga_barang' => 'required|numeric|min:0',
            'barang.*.harga_jual' => 'required|numeric|min:0',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Perhitungan total harga pembelian (termasuk pajak)
            $subtotal = collect($request->barang)->sum(function ($item) {
                return $item['harga_barang'] * $item['jumlah_barang'];
            });

            // Menghitung total harga setelah pajak
            $totalHarga = $subtotal + $subtotal * ($request->pajak / 100);

            // Simpan data pembelian
            $pembelian = Pembelian::create([
                'kode_pembelian' => $request->kode_pembelian,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'id_pemasok' => $request->id_pemasok,
                'id_user' => Auth::id(),
                'pajak' => $request->pajak,
                'total_harga' => $totalHarga,
                'status' => 'completed',
            ]);

            // Simpan detail pembelian dan update stok barang
            foreach ($request->barang as $barang) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'id_barang' => $barang['id_barang'],
                    'jumlah_barang' => $barang['jumlah_barang'],
                    'harga_barang' => $barang['harga_barang'],
                    'harga_jual' => $barang['harga_jual'],
                ]);

                // Ambil stok sebelum perubahan
                $stok = Stok::where('id_barang', $barang['id_barang'])->first();
                $stokSebelumnya = $stok ? $stok->jumlah_stok : 0;

                // Update stok barang
                if ($stok) {
                    $stok->jumlah_stok += $barang['jumlah_barang'];
                    $stok->save();
                } else {
                    // Jika stok tidak ada, tambahkan stok baru
                    $stok = Stok::create([
                        'id_barang' => $barang['id_barang'],
                        'jumlah_stok' => $barang['jumlah_barang'],
                    ]);
                }

                // Simpan log perubahan stok
                StokLog::create([
                    'id_barang' => $barang['id_barang'],
                    'jumlah_perubahan' => $barang['jumlah_barang'],
                    'tipe' => 'pembelian', // Atur tipe sesuai dengan jenis transaksi
                    'tanggal_perubahan' => now(), // Waktu perubahan stok
                    'transaksi_id' => $pembelian->id, // ID transaksi dari pembelian
                    'harga_barang' => $barang['harga_barang'], // Harga barang saat pembelian
                    'stok_sebelumnya' => $stokSebelumnya, // Stok sebelum perubahan
                    'stok_sesudah' => $stok->jumlah_stok,
                    'id_user' => Auth::id(),
                ]);
            }

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Redirect kembali ke halaman pembelian dengan pesan sukses
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->route('pembelian.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Pembelian $pembelian)
    {
        $pemasok = Pemasok::all();
        $barang = Barang::all();
        return view('pages.pembelian.edit', compact('pembelian', 'pemasok', 'barang'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'kode_pembelian' => 'required|unique:pembelian,kode_pembelian,' . $pembelian->id,
            'tanggal_pembelian' => 'required|date',
            'id_pemasok' => 'required|exists:pemasok,id',
            'id_user' => 'required|exists:users,id',
            'id_barang' => 'required|exists:barang,id',
            'jumlah_barang' => 'required|integer',
            'harga_barang' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'pajak_barang' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'pajak' => 'required|numeric',
            'status' => 'required|in:pending,completed,canceled',
        ]);

        $pembelian->update($request->all());
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui.');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function storeToSession(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah_barang' => 'required|numeric|min:1',
            'harga_barang' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $barang = session()->get('barang', []);

        $barang[] = [
            'id_barang' => $request->id_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'harga_barang' => $request->harga_barang,
            'harga_jual' => $request->harga_jual,
        ];

        session()->put('barang', $barang);

        return response()->json(['success' => 'Data berhasil ditambahkan ke sesi!']);
    }

    public function inputBarang(Request $request)
    {
        // Validasi data input
        $request->validate(
            [
                'id_barang' => 'required|exists:barang,id',
                'jumlah_barang' => 'required|integer|min:1',
                'harga_barang' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
            ],
            [
                'id_barang.required' => 'Pilih barang yang akan dibeli.',
                'id_barang.exists' => 'Barang tidak ditemukan.',
                'jumlah_barang.required' => 'Jumlah barang harus diisi.',
                'harga_barang.required' => 'Harga barang harus diisi.',
                'harga_jual.required' => 'Harga jual harus diisi.',
            ],
        );

        // Ambil ID user yang sedang login
        $idUser = Auth::id();

        // Siapkan data untuk disimpan
        $dataPembelian = [
            'id_barang' => $request->id_barang,
            'id_user' => $idUser,
            'jumlah_barang' => $request->jumlah_barang,
            'harga_barang' => $request->harga_barang,
            'harga_jual' => $request->harga_jual,
            'status' => 'pending', // Set status sebagai pending
        ];

        // Simpan data ke dalam tabel pembelian
        Pembelian::create($dataPembelian);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan.');
    }
}