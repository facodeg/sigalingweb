<?php

use App\Http\Controllers\AjuanAnggotaController;
use App\Http\Controllers\AlamatDomisiliController;
use App\Http\Controllers\Anggota\AkunAnggotaController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\ApiWhatsappController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardKoperasiController;
use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KonfirmasiAnggotaController;
use App\Http\Controllers\LimitPinjamanController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PendaftaranAnggotaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PendidikanTbController;
use App\Http\Controllers\PendidikanUserKaryawanController;
use App\Http\Controllers\PengajuanPinjamanController;
use App\Http\Controllers\PerAnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RiwayatJabatanController;
use App\Http\Controllers\SimpananWajibController;
use App\Http\Controllers\SipController;
use App\Http\Controllers\SkkRequestController;
use App\Http\Controllers\SpkrkkController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\StorageLinkController;
use App\Http\Controllers\StrController;
use App\Http\Controllers\SuratPraktekSatuController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAnggotaController;
use App\Http\Controllers\WhatsAppController;
use App\Models\City;
use App\Models\District;

use App\Models\Province;
use App\Models\Village;

Route::get('/preview-pdf/{filename}', function ($filename) {
    $path = storage_path('app/public/spkrkk/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
})->name('preview.pdf');

// Halaman cetak surat permohonan (contoh berdasarkan ID)
Route::get('/skk-requests/{id}/cetak', [SkkRequestController::class, 'cetak'])->name('skk.cetak');


Route::get('/', function () {
    if (Auth::check()) {
        // Jika pengguna sudah login, redirect ke halaman utama
        return redirect()->route('home');
    }

    // Jika pengguna belum login, tampilkan halaman login
    return view('pages.auth.login');
});

Route::get('/api/indonesia/provinces', function () {
    return response()->json(Province::all());
});

Route::get('/api/indonesia/cities/{provinceCode}', function ($provinceCode) {
    return response()->json(City::where('province_code', $provinceCode)->get());
});

Route::get('/api/indonesia/districts/{cityCode}', function ($cityCode) {
    return response()->json(District::where('city_code', $cityCode)->get());
});

Route::get('/api/indonesia/villages/{districtCode}', function ($districtCode) {
    return response()->json(Village::where('district_code', $districtCode)->get());
});

Route::get('/storage-link', [StorageLinkController::class, 'createLink']);

Route::get('/register', [DaftarController::class, 'showRegistration'])->name('register');
Route::post('/register', [DaftarController::class, 'register']);

Route::get('/pendaftaran', [PendaftaranAnggotaController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranAnggotaController::class, 'store'])->name('pendaftaran.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Rute untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Halaman utama admin
    Route::post('/simpananwajib/baru', [SimpananWajibController::class, 'baru'])->name('simpananwajib.baru');

    Route::post('/simpanan-wajib/kirim-pesan-semua', [SimpananWajibController::class, 'kirimPesanSemua'])->name('simpanan_wajib.kirimPesanSemua');

    Route::resource('limitpinjaman', LimitPinjamanController::class);
    Route::get('/admin/home', [DashboardKoperasiController::class, 'index'])->name('admin.home');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('companies', CompanyController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('izins', IzinController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('pegawais', PegawaiController::class);
    Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('/anggotas/{id}/rincian', [AnggotaController::class, 'rincian'])->name('anggotas.rincian');
    Route::post('/anggotas/{id}/update-simpanan', [AnggotaController::class, 'updateSimpanan'])->name('anggotas.updateSimpanan');
    Route::resource('anggotas', AnggotaController::class);
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('angsuran', AngsuranController::class);
    Route::get('/angsuran/angsuran-ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);
    Route::get('/angsuran/angsuran-sisa/{no_pinjaman}', [AngsuranController::class, 'getSisaPinjaman']);
    Route::get('/angsuran/ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);
    Route::resource('simpanan_wajib', SimpananWajibController::class);
    Route::resource('kategori', KategoriController::class);
    Route::post('/simpanan-wajib/update-simpanan', [SimpananWajibController::class, 'updateSimpanan'])->name('simpanan_wajib.updateSimpanan');
    Route::get('/dashboard-koperasi', [DashboardKoperasiController::class, 'index'])->name('dashboard.koperasi');
    Route::resource('units', UnitsController::class);
    Route::resource('pemasok', PemasokController::class);
    Route::resource('merek', MerekController::class);
    Route::post('merek/{id}/update-status', [MerekController::class, 'updateStatus'])->name('merek.updateStatus');
    Route::resource('barang', BarangController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::post('/session/store', [PembelianController::class, 'storeToSession'])->name('session.store');
    Route::get('/pendaftaran', [AnggotaController::class, 'pendaftran'])->name('pendaftaran');
    // routes/web.php

    Route::get('/anggota/perbarui', [PerAnggotaController::class, 'indexPerbarui'])->name('anggotas.perbarui');
    Route::post('/anggota/perbarui', [PerAnggotaController::class, 'perbarui'])->name('anggotas.perbarui.submit');

    Route::resource('whatsapp', WhatsAppController::class);
    Route::resource('apiwhatsapp', ApiWhatsappController::class);

    Route::post('/pembelian/inputbarang', [PembelianController::class, 'inputBarang'])->name('pembelian.inputbarang');

    Route::get('/users/autogenerate', [UserController::class, 'autoGenerate'])->name('users.autogenerate');

    Route::get('stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('stok/{id_barang}/history', [StokController::class, 'history'])->name('stok.history');

    Route::resource('pendidikan', PendidikanController::class);
    Route::resource('surat_praktek_satu', SuratPraktekSatuController::class);

    Route::get('surat_praktek_satu/cetak/{surat}', [SuratPraktekSatuController::class, 'cetak'])->name('surat_praktek_satu.cetak');

    Route::get('surat_praktek_satu/cetak2/{id}', [SuratPraktekSatuController::class, 'cetak2'])->name('surat_praktek_satu.cetak2');

    Route::post('/surat_praktek_satu/update-status', [\App\Http\Controllers\SuratPraktekSatuController::class, 'updateStatus'])->name('surat_praktek_satu.updateStatus');

    Route::post('/surat-praktek-satu/update-tanggal', [SuratPraktekSatuController::class, 'updateTanggal'])->name('surat_praktek_satu.updateTanggal');

    Route::get('/surat-praktek-satu/{id}/cetak-izin-atasan', [SuratPraktekSatuController::class, 'cetakIzinAtasan'])->name('surat_praktek_satu.cetak_izin_atasan');
    Route::get('/surat-praktek-satu/{id}/cetak-hari-jam', [SuratPraktekSatuController::class, 'cetakHariJam'])->name('surat_praktek_satu.cetak_hari_jam');
    Route::get('/surat_praktek_satu/cetak_keterangan/{id}', [SuratPraktekSatuController::class, 'cetakKeterangan'])->name('surat_praktek_satu.cetak_keterangan');

    Route::resource('pegawai', PegawaiController::class);
    // Route::resource('pendidikan', PendidikanController::class);

    Route::resource('surat_praktek_satu', SuratPraktekSatuController::class);

    Route::resource('karyawan', KaryawanController::class);

    Route::get('/karyawan/{id}/rincian', [KaryawanController::class, 'rincian'])->name('karyawan.rincian');

    Route::resource('spkrkk', SpkrkkController::class)->only(['store', 'update', 'destroy']);

    // STR
    Route::post('/str/store', [StrController::class, 'store'])->name('str.store');
    Route::get('/str/{id}/edit', [StrController::class, 'edit'])->name('str.edit');
    Route::put('/str/{id}', [StrController::class, 'update'])->name('str.update');
    Route::delete('/str/{id}', [StrController::class, 'destroy'])->name('str.destroy');

    // SIP
    Route::post('/sip/store', [SipController::class, 'store'])->name('sip.store');
    Route::put('/sip/{id}', [SipController::class, 'update'])->name('sip.update');
    Route::delete('/sip/{id}', [SipController::class, 'destroy'])->name('sip.destroy');

    Route::post('/karyawan/update-status-nakes', [App\Http\Controllers\KaryawanController::class, 'updateStatusNakes'])->name('karyawan.updateStatusNakes');

    Route::resource('pendidikan_tb', PendidikanTbController::class)->only(['store', 'update', 'destroy']);
});

// Rute untuk koperasi
Route::middleware(['auth', 'anggota'])->group(function () {
    // Halaman utama koperasi

    Route::get('/pegawairsudl/home', [PerAnggotaController::class, 'rincian'])->name('peranggota.home');

    // Manajemen anggota koperasi

    Route::resource('anggota', PerAnggotaController::class);

    Route::get('/anggota/perbarui', [PerAnggotaController::class, 'indexPerbarui'])->name('anggotas.perbarui');
    Route::post('/anggota/perbarui', [PerAnggotaController::class, 'perbarui'])->name('anggotas.perbarui.submit');

    Route::resource('anggotass', AjuanAnggotaController::class);

    Route::resource('pengajuanpinjaman', PengajuanPinjamanController::class);

    Route::get('/anggota/{id}/edit-password', [AkunAnggotaController::class, 'editPassword'])->name('koperasi.anggota.edit-password');
    Route::put('/anggota/{id}/update-password', [AkunAnggotaController::class, 'updatePassword'])->name('koperasi.anggota.update-password');

    Route::post('/domisili/store', [AlamatDomisiliController::class, 'store'])->name('domisili.store');
    Route::resource('alamat', AlamatDomisiliController::class)->only(['edit', 'destroy', 'store']);

    Route::post('/pendidikanuser/store', [PendidikanUserKaryawanController::class, 'store'])->name('pendidikanuser.store');
    Route::put('/pendidikanuser/{id}', [PendidikanUserKaryawanController::class, 'update'])->name('pendidikanuser.update');
    Route::delete('/pendidikanuser/{id}', [PendidikanUserKaryawanController::class, 'destroy'])->name('pendidikanuser.destroy');
    Route::put('/alamat/{id}', [AlamatDomisiliController::class, 'update'])->name('alamat.update');

    Route::post('/user/update-phone', [UserController::class, 'updatePhone'])->name('user.updatePhone');

    Route::post('/str/store', [StrController::class, 'store'])->name('str.store');
    Route::get('/str/{id}/edit', [StrController::class, 'edit'])->name('str.edit');
    Route::put('/str/{id}', [StrController::class, 'update'])->name('str.update');
    Route::delete('/str/{id}', [StrController::class, 'destroy'])->name('str.destroy');

    // SIP
    Route::post('/sip/store', [SipController::class, 'store'])->name('sip.store');
    Route::put('/sip/{id}', [SipController::class, 'update'])->name('sip.update');
    Route::delete('/sip/{id}', [SipController::class, 'destroy'])->name('sip.destroy');

    Route::resource('spkrkk', SpkrkkController::class)->only(['store', 'update', 'destroy']);
    Route::resource('keluarga', DataKeluargaController::class)->only(['store', 'update', 'destroy']);
});
Route::middleware(['auth', 'koperasi'])->group(function () {
    // Halaman utama koperasi
    Route::post('/simpanan-wajib/kirim-pesan-semua', [SimpananWajibController::class, 'kirimPesanSemua'])->name('simpanan_wajib.kirimPesanSemua');
    Route::resource('limitpinjaman', LimitPinjamanController::class);
    Route::get('/koperasi/home', [DashboardKoperasiController::class, 'index'])->name('koperasi.home');
    Route::post('/simpananwajib/baru', [SimpananWajibController::class, 'baru'])->name('simpananwajib.baru');
    // Manajemen anggota koperasi
    Route::resource('anggotas', AnggotaController::class);
    Route::get('/anggotas/{id}/rincian', [AnggotaController::class, 'rincian'])->name('anggotas.rincian');
    Route::post('/anggotas/{id}/update-simpanan', [AnggotaController::class, 'updateSimpanan'])->name('anggotas.updateSimpanan');
    Route::resource('konfirmasi', KonfirmasiAnggotaController::class);
    Route::patch('/konfirmasi/anggota/{anggota}', [KonfirmasiAnggotaController::class, 'updateStatus'])->name('pages.konfirmasi.updateStatus');

    // Pinjaman dan angsuran
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('angsuran', AngsuranController::class);
    Route::get('/angsuran/angsuran-ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);
    Route::get('/angsuran/angsuran-sisa/{no_pinjaman}', [AngsuranController::class, 'getSisaPinjaman']);
    Route::get('/angsuran/ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);

    // Simpanan wajib
    Route::resource('simpanan_wajib', SimpananWajibController::class);
    Route::post('/simpanan-wajib/update-simpanan', [SimpananWajibController::class, 'updateSimpanan'])->name('simpanan_wajib.updateSimpanan');

    Route::resource('usersanggota', UserAnggotaController::class);

    Route::patch('pinjaman/{pinjaman}/update-status', [PinjamanController::class, 'updateStatus'])->name('pinjaman.update-status');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Halaman utama admin
    Route::post('/simpananwajib/baru', [SimpananWajibController::class, 'baru'])->name('simpananwajib.baru');

    Route::post('/simpanan-wajib/kirim-pesan-semua', [SimpananWajibController::class, 'kirimPesanSemua'])->name('simpanan_wajib.kirimPesanSemua');

    Route::resource('limitpinjaman', LimitPinjamanController::class);
    Route::get('/admin/home', [DashboardKoperasiController::class, 'index'])->name('admin.home');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('companies', CompanyController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('izins', IzinController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('pegawais', PegawaiController::class);
    Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('/anggotas/{id}/rincian', [AnggotaController::class, 'rincian'])->name('anggotas.rincian');
    Route::post('/anggotas/{id}/update-simpanan', [AnggotaController::class, 'updateSimpanan'])->name('anggotas.updateSimpanan');
    Route::resource('anggotas', AnggotaController::class);
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('angsuran', AngsuranController::class);
    Route::get('/angsuran/angsuran-ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);
    Route::get('/angsuran/angsuran-sisa/{no_pinjaman}', [AngsuranController::class, 'getSisaPinjaman']);
    Route::get('/angsuran/ke/{no_pinjaman}', [AngsuranController::class, 'getAngsuranKe']);
    Route::resource('simpanan_wajib', SimpananWajibController::class);
    Route::resource('kategori', KategoriController::class);
    Route::post('/simpanan-wajib/update-simpanan', [SimpananWajibController::class, 'updateSimpanan'])->name('simpanan_wajib.updateSimpanan');
    Route::get('/dashboard-koperasi', [DashboardKoperasiController::class, 'index'])->name('dashboard.koperasi');
    Route::resource('units', UnitsController::class);
    Route::resource('pemasok', PemasokController::class);
    Route::resource('merek', MerekController::class);
    Route::post('merek/{id}/update-status', [MerekController::class, 'updateStatus'])->name('merek.updateStatus');
    Route::resource('barang', BarangController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::post('/session/store', [PembelianController::class, 'storeToSession'])->name('session.store');
    Route::get('/pendaftaran', [AnggotaController::class, 'pendaftran'])->name('pendaftaran');
    // routes/web.php

    Route::get('/anggota/perbarui', [PerAnggotaController::class, 'indexPerbarui'])->name('anggotas.perbarui');
    Route::post('/anggota/perbarui', [PerAnggotaController::class, 'perbarui'])->name('anggotas.perbarui.submit');

    Route::resource('whatsapp', WhatsAppController::class);
    Route::resource('apiwhatsapp', ApiWhatsappController::class);

    Route::post('/pembelian/inputbarang', [PembelianController::class, 'inputBarang'])->name('pembelian.inputbarang');

    Route::get('/users/autogenerate', [UserController::class, 'autoGenerate'])->name('users.autogenerate');

    Route::get('stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('stok/{id_barang}/history', [StokController::class, 'history'])->name('stok.history');
});
