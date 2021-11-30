<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;


class AssessmentSheets implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithColumnFormatting, WithMapping, WithStrictNullComparison
{
    protected $rows;
    protected $title;

    public function __construct(array $rows, string $title)
    {
        $this->rows = $rows;
        $this->title = $title;
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->title,
            $row->nama_lengkap,
            $row->kabupaten_ket,
            $row->provinsi_ket,
            $row->result,
            $row->saran
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'ASSESSMENT',
            'NAMA LENGKAP',
            'KABUPATEN',
            'PROVINSI',
            'INDEX',
            'KETERANGAN'
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function columnFormats(): array
    {

        return [
        ];
    }
}
?>
