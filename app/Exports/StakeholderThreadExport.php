<?php

namespace App\Exports;

use App\Exports\Sheets\StakeholderThreadSheets;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StakeholderThreadExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        $sheets = [];
     
        $sheets[] = new StakeholderThreadSheets(DB::select('SELECT * FROM v_report_stakeholder_threads UNION ALL SELECT * FROM v_report_replies_stakeholder_threads ORDER BY id ASC'), 'SEMUA DISKUSI & BALASAN');
        $sheets[] = new StakeholderThreadSheets(DB::select('SELECT * FROM v_report_stakeholder_threads ORDER BY id ASC'), 'SEMUA DISKUSI');
        $sheets[] = new StakeholderThreadSheets(DB::select('SELECT * FROM v_report_replies_stakeholder_threads ORDER BY id ASC'), 'BALASAN DISKUSI');

        return $sheets;
    }
}
