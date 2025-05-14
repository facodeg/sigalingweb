<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //index
    public function index()
    {
        // Ambil data attendance dengan relasi user
        $attendance = Attendance::with('user')->orderBy('user_id')->get();

        // Ambil data company, asumsi hanya ada satu perusahaan
        $company = Company::first(); // Sesuaikan dengan cara Anda mengambil data perusahaan

        // Hitung status untuk setiap attendance
        $attendance = $attendance->map(function ($item) use ($company) {
            // Menghitung status time in
            $item->time_in_status = \Carbon\Carbon::parse($item->time_in)->gt(\Carbon\Carbon::parse($company->time_in))
                ? 'Terlambat'
                : 'Sesuai';

            // Menghitung status time out
            $item->time_out_status = \Carbon\Carbon::parse($item->time_out)->lt(\Carbon\Carbon::parse($company->time_out))
                ? 'Pulang Cepat'
                : 'Sesuai';

            return $item;
        });

        // Kirim data attendance dan company ke view
        return view('pages.presensi.index', compact('attendance', 'company'));
    }

    //create
    public function create()
    {
        $users = User::all(); // Menambahkan data pengguna untuk dropdown
        return view('pages.presensi.create', compact('users'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'date' => 'required|date',
            'latlon_in' => 'required',
            'latlon_out' => 'required',
        ]);

        $attendance = new Attendance();
        $attendance->user_id = $request->user_id;
        $attendance->time_in = $request->time_in;
        $attendance->time_out = $request->time_out;
        $attendance->date = $request->date;
        $attendance->latlon_in = $request->latlon_in;
        $attendance->latlon_out = $request->latlon_out;
        $attendance->save();

        return redirect()->route('attendances.index')->with('success', 'Attendance created successfully');
    }

    //edit
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = User::all(); // Menambahkan data pengguna untuk dropdown
        return view('pages.presensi.edit', compact('attendance', 'users'));
    }

    //update
    public function update(Request $request, $id)
{

    $attendance = Attendance::findOrFail($id);
    $attendance->user_id = $request->user_id;
    $attendance->time_in = $request->time_in;
    $attendance->time_out = $request->time_out;
    $attendance->date = $request->date;
    $attendance->latlon_in = $request->latlon_in;
    $attendance->latlon_out = $request->latlon_out;
    $attendance->save();

    return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
}


    //destroy
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}
