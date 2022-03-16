<?php

namespace App\Exports;

use App\Exports\Sheets\ConsultationSheets;
use App\Models\ConsultationThreadModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ConsultationExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        $sheets = [];
        

        // $sheets[] = new ConsultationSheets(DB::select('SELECT * FROM v_report_consultation UNION ALL SELECT * FROM v_report_replies_consultation ORDER BY id ASC'), 'SEMUA KONSULTASI & BALASAN');
        $sheets[] = new ConsultationSheets(DB::select('SELECT * FROM v_report_consultation ORDER BY id ASC'), 'SEMUA KONSULTASI');
        $sheets[] = new ConsultationSheets(DB::select('SELECT * FROM v_report_consultation WHERE type = ? ORDER BY id ASC', ['public']), 'KONSULTASI PUBLIK');
        $sheets[] = new ConsultationSheets(DB::select('SELECT * FROM v_report_consultation WHERE type = ? ORDER BY id ASC', ['private']), 'KONSULTASI PRIVAT');
        $sheets[] = new ConsultationSheets(DB::select('SELECT * FROM v_report_replies_consultation ORDER BY id ASC'), 'BALASAN KONSULTASI');

        return $sheets;
    }
}
