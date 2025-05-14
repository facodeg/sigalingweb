<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Izin;
use App\Models\Company;
use App\Models\Note;
use App\Models\Pinjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::where('status', 'pending')->get();
        $totalajuanpinjaman = $pinjaman->count();

        $attendances = Attendance::with('user')->get();

        $anggotas = Anggota::where('status', 'proses')->get();

        // Menghitung jumlah anggota yang diproses
        $totalProses = $anggotas->count();

        // Fetch all izin data
        $izinData = Izin::with('user')->get();

        $noteData = Note::with('user')->get();

        // Count the number of unapproved izin
        $unapprovedIzinCount = $izinData->where('is_approved', 0)->count();

        // Fetch company time in and out
        $company = Company::first();
        $noteCount = $noteData->count();

        // Process chart data for izin
        $izinChartData = $izinData->groupBy('reason')->map(function ($row) {
            return $row->count();
        });

        // Calculate counts for attendance status
        $lateCount = $attendances
            ->filter(function ($item) use ($company) {
                return Carbon::parse($item->time_in)->gt(Carbon::parse($company->time_in));
            })
            ->count();

        $earlyLeaveCount = $attendances
            ->filter(function ($item) use ($company) {
                return Carbon::parse($item->time_out)->lt(Carbon::parse($company->time_out));
            })
            ->count();

        $onTimeCount = $attendances->count() - ($lateCount + $earlyLeaveCount);

        return view('pages.dashboard', compact('attendances', 'noteCount', 'noteData', 'izinChartData', 'company', 'izinData', 'unapprovedIzinCount', 'lateCount', 'earlyLeaveCount', 'onTimeCount', 'totalProses', 'totalajuanpinjaman'));
    }
}