<?php

namespace App\Exports;

use App\Exports\Sheets\AssessmentNativeSheets;
use App\Exports\Sheets\AssessmentSheets;
use App\Models\AssessmentModel;
use App\Models\TrAssessmentModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssessmentNativeExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $assessment_all = AssessmentModel::all();

        foreach($assessment_all as $item) {
            $sheets[] = new AssessmentNativeSheets(DB::select('SELECT * FROM v_report_assessment_native WHERE id_assessment = ?', [$item->id]), $item->title);
        }
        return $sheets;
    }
}
