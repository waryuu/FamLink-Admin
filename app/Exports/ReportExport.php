<?php

namespace App\Exports;

use App\CovidResumeLogModelRev;
use App\KasusCutoffModel;
use App\PantauanKecamatanRev;
use Illuminate\Support\Facades\DB;

use App\Exports\Sheets\KecamatanKonfirmasiSheet;
use App\Exports\Sheets\KonfirmasiByDateSheet;
use App\Exports\Sheets\KonfirmasiGenderSheet;
use App\Exports\Sheets\KonfirmasiUsiaSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;


class ReportExport implements FromCollection
{
	use Exportable;

	public function sheets(): array
	{
		$sheets = [];

		// konfirmasi kecamatan
		$konfirmasi_kecamatan = PantauanKecamatanRev::select("nm_kec as nama_kecamatan", "konfirmasi_meninggal", "konfirmasi_sembuh", "konfirmasi_perawatan", "konfirmasi_total")->orderBy('nama_kecamatan', 'asc')->get();
		$konfirmasi_kecamatan = $konfirmasi_kecamatan->toArray();

		$sheets[] = new KecamatanKonfirmasiSheet($konfirmasi_kecamatan);

		// konfirmasi by date
		$konfirmasi_by_date_sheet = CovidResumeLogModelRev::select("konfirmasi_perawatan", "konfirmasi_sembuh", "konfirmasi_meninggal", "konfirmasi_total", DB::raw("DATE(created_at) as tanggal"))
		->orderBy("created_at", "desc")->get();
		$konfirmasi_by_date_sheet = $konfirmasi_by_date_sheet->toArray();
		$sheets[] = new KonfirmasiByDateSheet($konfirmasi_by_date_sheet);

		// konfirmasi by gender
		$konfirmasi_gender = KasusCutoffModel::select("jenis_kelamin", DB::raw("count(jenis_kelamin) as jumlah"))
		->groupBy('jenis_kelamin')
		->orderBy("created_at", "desc")->get();
		$konfirmasi_gender = $konfirmasi_gender->toArray();
		$sheets[] = new KonfirmasiGenderSheet($konfirmasi_gender);

		// konfirmasi by usia
		$konfirmasi_usia[] = DB::select("select CONCAT('0 - 5') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 0 and 5")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('6 - 19') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 6 and 19")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('20 - 29') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 20 and 29")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('30 - 39') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 30 and 39")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('40 - 49') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 40 and 49")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('50 - 59') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 50 and 59")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('60 - 60') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 60 and 69")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('70 - 79') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia BETWEEN 70 and 79")[0];
		$konfirmasi_usia[] = DB::select("select CONCAT('> 80') as title, count(usia) as usia from m_kasus_cutoff where visible = 1 and usia > 80")[0];

		$sheets[] = new KonfirmasiUsiaSheet($konfirmasi_usia);
		return $sheets;
	}

}
