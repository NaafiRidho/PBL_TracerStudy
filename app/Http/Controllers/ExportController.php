<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Carbon;
use App\Models\alumniModel;
use App\Models\AtasanModel;

class ExportController extends Controller
{

    public function showAlumniBelumMengisi()
    {
        $alumni = alumniModel::where('isOTP', 0)->get();
        return view('layoutAdmin.rekap.export_rekap_alumni_belum_mengisi', compact('alumni'));
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

    // --Export Data Pengguna Lulusan  --
    public function showAtasanBelumMengisi()
    {
        // Ambil data atasan yang alumni-nya belum mengisi (isOTP = 0)
        $atasan = AtasanModel::where('isOtp', 0)->with('alumni')->get();

        return view('layoutAdmin.rekap.export_rekap_atasan_belum_mengisi', compact('atasan'));
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
}