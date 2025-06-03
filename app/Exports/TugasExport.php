<?php

namespace App\Exports;

use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TugasExport implements FromView
{
    public function view(): View
    {
        $tugas = Tugas::query();
        if (request()->dates) {
            $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', request()->dates)[0])->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', request()->dates)[1])->format('Y-m-d');
            $tugas = Tugas::whereIn('kandang_id', request()->kandang)->where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate)->with('tugasTelur', 'tugasKeadaanBebek', 'kandang')->get() ?? [];
        } else {
            $tugas = Tugas::whereIn('kandang_id', request()->kandang)->with('tugasTelur', 'tugasKeadaanBebek', 'kandang')->get() ?? [];
        }
        return view('exports.invoices', [
            'tugas' => $tugas,
            'start_date' => $start_date ?? null,
            'end_date' => $end_date ?? null
        ]);
    }
}
