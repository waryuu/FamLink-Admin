<?php

namespace App\Exports;

use App\Exports\Sheets\UserAppsSheets;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserAppsExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new UserAppsSheets(DB::select('SELECT * FROM v_report_pengguna'), 'PENGGUNA');

        return $sheets;
    }
}
