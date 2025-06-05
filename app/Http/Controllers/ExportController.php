<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use App\Models\alumniModel;

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

}
