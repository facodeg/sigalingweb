<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use App\Models\Izin; // Pastikan untuk mengimpor model Izin
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Untuk ekspor PDF
use App\Exports\ReportExport; // Pastikan Anda membuat export ini

class ReportController extends Controller
{
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', now()->month); // Default to current month
        $year = $request->input('year', now()->year); // Default to current year

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $company = Company::first();
        $users = User::where('position', 'Staff')->get(); // Filter by position "Staff"

        $report = [];

        // Hitung jumlah hari kerja dalam bulan tersebut
        $totalDaysInMonth = $startDate->daysInMonth;
        $totalWorkdays = $startDate->copy()->daysUntil($endDate->copy()->endOfMonth()->addDay())
            ->filter(function (Carbon $date) {
                return !$date->isSunday(); // Menghitung hari kerja (Senin-Sabtu)
            })->count();

        foreach ($users as $user) {
            $userAttendances = $attendances->where('user_id', $user->id);

            $total = $userAttendances->count();
            $late = $userAttendances->where('time_in', '>', $company->time_in)->count();
            $early_leave = $userAttendances->where('time_out', '<', $company->time_out)->count();
            $on_time = $total - $late - $early_leave;

            $userIzin = Izin::where('user_id', $user->id)
                ->whereBetween('date_izin', [$startDate, $endDate])
                ->count();

            $totalPresence = $total + $userIzin;
            $wajibHadir = $totalWorkdays;
            $ketidakhadiran = $wajibHadir - $total;

            $report[$user->id] = [
                'user_name' => $user->name,
                'total' => $total,
                'late' => $late,
                'early_leave' => $early_leave,
                'on_time' => $on_time,
                'izin' => $userIzin,
                'wajib_hadir' => $wajibHadir,
                'ketidakhadiran' => $ketidakhadiran,
            ];
        }

        return view('pages.monthly_report', compact('report'));
    }

    // Fungsi untuk eksport PDF
    public function exportPdf(Request $request)
    {
        $report = $this->generateReportData($request);

        $pdf = PDF::loadView('pages.report_pdf', compact('report'));
        return $pdf->download('laporan_presensi_bulanan.pdf');
    }

    private function generateReportData($request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $company = Company::first();
        $users = User::where('position', 'Staff')->get();

        // Hitung jumlah hari kerja dalam bulan tersebut
        $totalDaysInMonth = $startDate->daysInMonth;
        $totalWorkdays = $startDate->copy()->daysUntil($endDate->copy()->endOfMonth()->addDay())
            ->filter(function (Carbon $date) {
                return !$date->isSunday(); // Menghitung hari kerja (Senin-Sabtu)
            })->count();

        $report = [];

        foreach ($users as $user) {
            $userAttendances = $attendances->where('user_id', $user->id);

            $total = $userAttendances->count();
            $late = $userAttendances->where('time_in', '>', $company->time_in)->count();
            $early_leave = $userAttendances->where('time_out', '<', $company->time_out)->count();
            $on_time = $total - $late - $early_leave;

            $userIzin = Izin::where('user_id', $user->id)
                ->whereBetween('date_izin', [$startDate, $endDate])
                ->count();

            $totalPresence = $total + $userIzin;
            $wajibHadir = $totalWorkdays;
            $ketidakhadiran = $wajibHadir - $total;

            $report[$user->id] = [
                'user_name' => $user->name,
                'total' => $total,
                'late' => $late,
                'early_leave' => $early_leave,
                'on_time' => $on_time,
                'izin' => $userIzin,
                'wajib_hadir' => $wajibHadir,
                'ketidakhadiran' => $ketidakhadiran,
            ];
        }

        return $report;
    }
}
