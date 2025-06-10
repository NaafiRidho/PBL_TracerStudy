<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Carbon;
use App\Models\alumniModel;
use App\Models\AtasanModel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportController extends Controller
{

    public function showAlumniBelumMengisi()
    {
        $alumni = alumniModel::where('isOTP', 0)->get();
        return view('layoutAdmin.rekap.export_rekap_alumni_belum_mengisi', compact('alumni'));
    }
    public function showAlumni()
    {
        $alumni = alumniModel::where('isOTP', 1)->get();
        return view('layoutAdmin.rekap.export_rekap_alumni', compact('alumni'));
    }

    // Tambahkan ini
    public function collection()
    {
        return alumniModel::where('isOTP', 0)
            ->select('prodi as program_studi', 'nim', 'nama_alumni as nama', 'tanggal_lulus')
            ->get();
    }

    // Tambahkan ini
    public function headings(): array
    {
        return [
            'Program Studi',
            'NIM',
            'Nama',
            'Tanggal Lulus',
        ];
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $headings = $this->headings();
        foreach ($headings as $col => $heading) {
            $columnLetter = Coordinate::stringFromColumnIndex($col + 1); // Ubah angka ke huruf (1 => A, 2 => B, dst)
            $sheet->setCellValue($columnLetter . '1', $heading); // Misal: A1, B1, C1, ...
        }

        // Heading bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Atur lebar kolom agar tidak terlalu mepet
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);

        // Ambil data dari database
        $data = $this->collection();
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->program_studi);
            $sheet->setCellValue("B$row", $item->nim);
            $sheet->setCellValue("C$row", $item->nama);
            $sheet->setCellValue("D$row", \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y'));
            $row++;
        }

        // Terapkan rata kiri ke semua kolom dari A2 sampai D<lastRow>
        $sheet->getStyle("A2:D" . ($row - 1))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Siapkan file untuk download
        $writer = new Xlsx($spreadsheet);
        $filename = 'alumni_belum_mengisi.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    public function exportExcelLulusan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $headings = [
            'Program Studi',
            'NIM',
            'Nama Alumni',
            'No HP',
            'Email',
            'Tanggal Lulus',
            'Tahun Lulus',
            'Tanggal Kerja Pertama',
            'Masa Tunggu (hitung)',
            'Masa Tunggu (tersimpan)',
            'Tanggal Mulai Instansi',
            'Jenis Instansi',
            'Nama Instansi',
            'Skala Instansi',
            'Lokasi Instansi',
            'Kategori Profesi',
            'Profesi',
            'Nama Atasan',
            'Jabatan Atasan',
            'No HP Atasan',
            'Email Atasan'
        ];

        foreach ($headings as $col => $heading) {
            $columnLetter = Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $heading);
        }

        $sheet->getStyle('A1:U1')->getFont()->setBold(true);

        // Atur lebar kolom
        foreach (range(1, count($headings)) as $index) {
            $colLetter = Coordinate::stringFromColumnIndex($index);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Query data
        $data = DB::table('alumni as al')
            ->join('jenis_instansi as ji', 'ji.jenis_instansi_id', '=', 'al.jenis_instansi_id')
            ->join('kategori_profesi as kp', 'kp.kategori_profesi_id', '=', 'al.kategori_profesi_id')
            ->join('profesi as p', 'p.profesi_id', '=', 'al.profesi_id')
            ->join('atasan as at', 'at.atasan_id', '=', 'al.atasan_id')
            ->where('al.isOTP', 1)
            ->orderBy('al.alumni_id')
            ->selectRaw('
            al.prodi,
            al.nim,
            al.nama_alumni,
            al.no_hp,
            al.email,
            al.tanggal_lulus,
            YEAR(al.tanggal_lulus) as tahunLulus,
            al.tanggal_kerja_pertama,
            ROUND(DATEDIFF(al.tanggal_kerja_pertama, al.tanggal_lulus) / 30.0) as masa_tunggu_bulan_hitung,
            al.masa_tunggu as masa_tunggu_tersimpan,
            al.tanggal_mulai_instansi,
            ji.jenis_instansi,
            al.nama_instansi,
            al.skala_instansi,
            al.lokasi_instansi,
            kp.kategori_profesi,
            p.profesi,
            at.nama_atasan,
            at.jabatan,
            at.no_hp_atasan,
            at.email_atasan
        ')
            ->get();

        // Isi data ke Excel
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->prodi);
            $sheet->setCellValue("B$row", $item->nim);
            $sheet->setCellValue("C$row", $item->nama_alumni);
            $sheet->setCellValue("D$row", $item->no_hp);
            $sheet->setCellValue("E$row", $item->email);
            $sheet->setCellValue("F$row", \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y'));
            $sheet->setCellValue("G$row", $item->tahunLulus);
            $sheet->setCellValue("H$row", $item->tanggal_kerja_pertama ? \Carbon\Carbon::parse($item->tanggal_kerja_pertama)->format('d-m-Y') : '');
            $sheet->setCellValue("I$row", $item->masa_tunggu_bulan_hitung);
            $sheet->setCellValue("J$row", $item->masa_tunggu_tersimpan);
            $sheet->setCellValue("K$row", $item->tanggal_mulai_instansi ? \Carbon\Carbon::parse($item->tanggal_mulai_instansi)->format('d-m-Y') : '');
            $sheet->setCellValue("L$row", $item->jenis_instansi);
            $sheet->setCellValue("M$row", $item->nama_instansi);
            $sheet->setCellValue("N$row", $item->skala_instansi);
            $sheet->setCellValue("O$row", $item->lokasi_instansi);
            $sheet->setCellValue("P$row", $item->kategori_profesi);
            $sheet->setCellValue("Q$row", $item->profesi);
            $sheet->setCellValue("R$row", $item->nama_atasan);
            $sheet->setCellValue("S$row", $item->jabatan);
            $sheet->setCellValue("T$row", $item->no_hp_atasan);
            $sheet->setCellValue("U$row", $item->email_atasan);
            $row++;
        }

        // Rata kiri semua isi data
        $sheet->getStyle("A2:U" . ($row - 1))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Download
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_alumni_sudah_mengisi.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }


    // --Export Data Pengguna Lulusan  --
    public function showAtasanBelumMengisi()
    {
        // Ambil data atasan yang alumni-nya belum mengisi (isOTP = 0)
        $atasan = atasanModel::where('isOtp', 0)->with('alumni')->get();

        return view('layoutAdmin.rekap.export_rekap_atasan_belum_mengisi', compact('atasan'));
    }
    public function showAtasan()
    {
        // Ambil data atasan yang alumni-nya belum mengisi (isOTP = 0)
        $atasan = AtasanModel::where('isOtp', 1)->with('alumni')->get();

        return view('layoutAdmin.rekap.export_rekap_atasan', compact('atasan'));
    }

    public function exportExcelAtasanBelumMengisi()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $headings = [
            'Nama Atasan',
            'Instansi',
            'Jabatan',
            'No HP',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus',
        ];
        foreach ($headings as $col => $heading) {
            $columnLetter = Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $heading);
        }

        // Heading bold
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        // Set lebar kolom
        $columnWidths = [20, 25, 20, 15, 25, 25, 20, 15];
        foreach ($columnWidths as $index => $width) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($index + 1))->setWidth($width);
        }

        // Ambil data atasan yang alumni-nya belum mengisi
        $atasanList = AtasanModel::where('isOtp', 0)->with('alumni')->get();

        $row = 2;
        foreach ($atasanList as $item) {
            $sheet->setCellValue("A$row", $item->nama_atasan ?? '-');
            $sheet->setCellValue("B$row", $item->nama_instansi ?? '-');
            $sheet->setCellValue("C$row", $item->jabatan ?? '-');
            $sheet->setCellValue("D$row", $item->no_hp_atasan ?? '-');
            $sheet->setCellValue("E$row", $item->email_atasan ?? '-');
            $sheet->setCellValue("F$row", $item->alumni->nama_alumni ?? '-');
            $sheet->setCellValue("G$row", $item->alumni->prodi ?? '-');
            $sheet->setCellValue("H$row", $item->alumni ? Carbon::parse($item->alumni->tanggal_lulus)->format('Y') : '-');
            $row++;
        }

        // Rata kiri semua data dari A2 ke bawah
        $sheet->getStyle("A2:H" . ($row - 1))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Simpan dan download
        $writer = new Xlsx($spreadsheet);
        $filename = 'atasan_belum_mengisi_survey.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    public function exportExcelPenggunaSudahMengisi()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $headings = [
            'Nama Atasan',
            'Instansi',
            'Jabatan',
            'Email Atasan',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus',
            'Kerjasama Tim',
            'Keahlian di bidang TI',
            'Kemampuan berbahasa asing',
            'Kemampuan berkomunikasi',
            'Pengembangan diri',
            'Kepemimpinan',
            'Etos Kerja',
            'Kompetensi belum terpenuhi',
            'Saran untuk kurikulum'
        ];

        // Set header di baris pertama
        foreach ($headings as $col => $heading) {
            $columnLetter = Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $heading);
        }

        $sheet->getStyle('A1:P1')->getFont()->setBold(true);

        // Atur lebar kolom otomatis
        foreach (range(1, count($headings)) as $index) {
            $colLetter = Coordinate::stringFromColumnIndex($index);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Query data atasan + jawaban dalam satu baris per alumni
        $data = DB::table('atasan as at')
            ->join('alumni as al', 'at.atasan_id', '=', 'al.atasan_id')
            ->join('jawaban as j', 'j.alumni_id', '=', 'al.alumni_id')
            ->join('pertanyaan as p', 'p.pertanyaan_id', '=', 'j.pertanyaan_id')
            ->where('at.isOtp', 1)
            ->selectRaw('
            at.nama_atasan,
            at.nama_instansi,
            at.jabatan,
            at.email_atasan,
            al.nama_alumni,
            al.prodi,
            YEAR(al.tanggal_lulus) as tahun_lulus,
            MAX(CASE WHEN p.pertanyaan_id = 1 THEN j.jawaban END) as `kerjasama_tim`,
            MAX(CASE WHEN p.pertanyaan_id = 2 THEN j.jawaban END) as `keahlian_ti`,
            MAX(CASE WHEN p.pertanyaan_id = 3 THEN j.jawaban END) as `bahasa_asing`,
            MAX(CASE WHEN p.pertanyaan_id = 4 THEN j.jawaban END) as `komunikasi`,
            MAX(CASE WHEN p.pertanyaan_id = 5 THEN j.jawaban END) as `pengembangan_diri`,
            MAX(CASE WHEN p.pertanyaan_id = 6 THEN j.jawaban END) as `kepemimpinan`,
            MAX(CASE WHEN p.pertanyaan_id = 7 THEN j.jawaban END) as `etos_kerja`,
            MAX(CASE WHEN p.pertanyaan_id = 8 THEN j.jawaban END) as `kompetensi_kurang`,
            MAX(CASE WHEN p.pertanyaan_id = 9 THEN j.jawaban END) as `saran_kurikulum`
        ')
            ->groupBy(
                'at.nama_atasan',
                'at.nama_instansi',
                'at.jabatan',
                'at.email_atasan',
                'al.nama_alumni',
                'al.prodi',
                DB::raw('YEAR(al.tanggal_lulus)')
            )
            ->get();

        // Isi data mulai dari baris ke-2
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->nama_atasan);
            $sheet->setCellValue("B$row", $item->nama_instansi);
            $sheet->setCellValue("C$row", $item->jabatan);
            $sheet->setCellValue("D$row", $item->email_atasan);
            $sheet->setCellValue("E$row", $item->nama_alumni);
            $sheet->setCellValue("F$row", $item->prodi);
            $sheet->setCellValue("G$row", $item->tahun_lulus);
            $sheet->setCellValue("H$row", $item->kerjasama_tim);
            $sheet->setCellValue("I$row", $item->keahlian_ti);
            $sheet->setCellValue("J$row", $item->bahasa_asing);
            $sheet->setCellValue("K$row", $item->komunikasi);
            $sheet->setCellValue("L$row", $item->pengembangan_diri);
            $sheet->setCellValue("M$row", $item->kepemimpinan);
            $sheet->setCellValue("N$row", $item->etos_kerja);
            $sheet->setCellValue("O$row", $item->kompetensi_kurang);
            $sheet->setCellValue("P$row", $item->saran_kurikulum);
            $row++;
        }

        // Rata kiri semua isi data
        $sheet->getStyle("A2:P" . ($row - 1))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Download file
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_pengguna_sudah_mengisi.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
