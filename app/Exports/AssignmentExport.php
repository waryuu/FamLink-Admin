<?php

namespace App\Exports;

use App\Exports\Sheets\AssignmentSheets;
use App\Models\AssignmentModel;
use App\Models\TrAssignmentModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssignmentExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $assignment_all = AssignmentModel::all();

        $sheets[] = new AssignmentSheets(DB::select('SELECT * FROM v_report_assignment'), 'SEMUA');

        foreach($assignment_all as $item) {
            $sheets[] = new AssignmentSheets(DB::select('SELECT * FROM v_report_assignment WHERE id_assignment = ?', [$item->id]), $item->title);
        }
        return $sheets;
    }
}
