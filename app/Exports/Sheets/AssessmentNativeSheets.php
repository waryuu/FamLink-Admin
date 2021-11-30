<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;


class AssessmentNativeSheets implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithColumnFormatting, WithMapping, WithStrictNullComparison
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
            $row->nama_lengkap,
            $row->title,
            $row->category,
            $row->question,
            $row->value,
            $row->tanggal_lahir,
            $row->kabupaten_ket,
            $row->provinsi_ket,
            $row->jenis_kelamin,
            $row->education,
            $row->pekerjaan,
            $row->pendapatan,
            $row->result,
            $row->saran,
            $row->tanggal
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAMA LENGKAP',
            'ASSESSMENT',
            'KATEGORI',
            'PERTANYAAN/INSTRUMENT',
            'JAWABAN',
            'TANGGAK LAHIR',
            'KABUPATEN',
            'PROVINSI',
            'JENIS KELAMIN',
            'PENDIDIKAN',
            'PEKERJAAN',
            'PENDAPATAN',
            'INDEX',
            'KETERANGAN',
            'TANGGAL ASSESSMENT'
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
