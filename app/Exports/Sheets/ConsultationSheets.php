<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;


class ConsultationSheets implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithColumnFormatting, WithMapping, WithStrictNullComparison
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
        $reply_from = null;
        if (isset($row->reply_from)) {
            $reply_from = $row->reply_from;
        }

        return [
            $row->id,
            $row->nama_lengkap,
            $row->name_stakeholder,
            $row->type,
            $row->title,
            strip_tags($row->content),
            $reply_from,
            $row->state,
            $row->open_to_all,
            $row->status,
            $row->role_who_closed,
            $row->created_at,
            $row->closed_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAMA LENGKAP',
            'LEMBAGA JEJARING',
            'TIPE KONSULTASI',
            'JUDUL',
            'ISI',
            'BALASAN DARI',
            'STATUS',
            'TERBUKA UNTUK UMUM?',
            'DIHAPUS?',
            'DITUTUP OLEH',
            'TANGGAL DIBUAT',
            'TANGGAL DITUTUP',
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
