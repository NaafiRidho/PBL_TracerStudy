<?php

namespace App\Http\Controllers;

use App\Models\alumniModel;
use App\Models\userModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManajemenAlumniController extends Controller
{
    public function list()
    {
        $alumni = alumniModel::select('prodi', 'nim', 'nama_alumni', 'alumni_id', 'tanggal_lulus');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->editColumn('tanggal_lulus', function ($alumni) {
                return $alumni->tanggal_lulus ? $alumni->tanggal_lulus->format('d-m-Y') : '';
            })
            ->addColumn('aksi', function ($alumni) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/alumni/' . $alumni->alumni_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/alumni/' . $alumni->alumni_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }
    public function import()
    {
        return view('layoutAdmin.manajemenAlumni.importAlumni'); // TANPA layout, hanya isi modal!
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = $sheet->toArray(null, false, true, true);

            $insert_alumni = [];
            $failed_rows = [];

            if (count($data) > 1) {
                try {
                    foreach ($data as $rowNumber => $row) {
                        if ($rowNumber == 1) continue; // skip header

                        $programStudi = trim($row['A']);
                        $nim = trim($row['B']);
                        $nama = trim($row['C']);
                        $tanggalLulusExcel = $row['D'];
                        $email = trim($row['E']);

                        // Validasi dasar
                        if (empty($nim) || empty($nama)) {
                            $failed_rows[] = "Baris $rowNumber: NIM/Nama kosong";
                            continue;
                        }

                        // Cek duplikat user
                        $existingUser = alumniModel::where('nim', $nim)->first();
                        if ($existingUser) {
                            $failed_rows[] = "Baris $rowNumber: NIM $nim sudah ada";
                            continue;
                        }

                        // Konversi tanggal
                        $tanggalLulus = null;
                        if (!empty($tanggalLulusExcel)) {
                            if (is_numeric($tanggalLulusExcel)) {
                                $tanggalLulus = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggalLulusExcel));
                            } else {
                                $tanggalLulus = date('Y-m-d', strtotime($tanggalLulusExcel));
                            }
                        }

                        // Insert user
                        $user = userModel::create([
                            'role_id' => 2,
                            'username' => $nim,
                            'password' => Hash::make($nim),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $insert_alumni[] = [
                            'user_id' => $user->user_id,
                            'prodi' => $programStudi,
                            'nim' => $nim,
                            'nama_alumni' => $nama,
                            'tanggal_lulus' => $tanggalLulus,
                            'email' => $email,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (count($insert_alumni) > 0) {
                        alumniModel::insert($insert_alumni);
                    }


                    return response()->json([
                        'status' => true,
                        'message' => 'Import selesai. ' . count($insert_alumni) . ' data berhasil ditambahkan.',
                        'skipped' => $failed_rows
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal import: ' . $e->getMessage()
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang ditemukan di file'
                ]);
            }
        }

        return redirect('/admin/alumni');
    }

    public function create_ajax()
    {
        return view('layoutAdmin.manajemenAlumni.createAlumni');
    }
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'prodi'          => 'required|in:D-IV TI,D-IV SIB',
            'nim'            => 'required|min:5|unique:alumni,nim',
            'nama_alumni'    => 'required|min:3',
            'tanggal_lulus'  => 'required|date',
            'email'          => 'required|email|unique:alumni,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validasi gagal!',
                'msgField'  => $validator->errors(),
            ]);
        }

        try {
            $user = userModel::create([
                'role_id'  => 2, // contoh: role alumni
                'username' => $request->nim,
                'password' => Hash::make($request->nim),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            alumniModel::create([
                'user_id'       => $user->user_id,
                'prodi'         => $request->prodi,
                'nim'           => $request->nim,
                'nama_alumni'   => $request->nama_alumni,
                'tanggal_lulus' => $request->tanggal_lulus,
                'email'         => $request->email
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Data alumni berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $e->getMessage(),
            ]);
        }
    }
    public function edit($id)
    {
        $alumni = alumniModel::find($id);
        return view('layoutAdmin.manajemenAlumni.edit_ajax', compact('alumni'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'prodi'          => 'required|in:D-IV TI,D-IV SIB',
            'nim'            => 'required|min:5|unique:alumni,nim,' . $id . ',alumni_id',
            'nama_alumni'    => 'required|min:3',
            'tanggal_lulus'  => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validasi gagal!',
                'msgField'  => $validator->errors(),
            ]);
        }

        try {
            $alumni = alumniModel::findOrFail($id);
            if ($alumni->nim !== $request->nim) {
                $user = userModel::find($alumni->user_id);
                if (!$user) {
                    return response()->json([
                        'status' => false,
                        'message' => 'User terkait tidak ditemukan.'
                    ]);
                }

                $user->update([
                    'username' => $request->nim,
                    'password' => Hash::make($request->nim),
                ]);
            }
            $alumni->update([
                'prodi'         => $request->prodi,
                'nim'           => $request->nim,
                'nama_alumni'   => $request->nama_alumni,
                'tanggal_lulus' => $request->tanggal_lulus,
                'email'         => $request->email
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data alumni berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'error'   => $e->getMessage(),
            ]);
        }
    }
    public function confirm_ajax(string $id)
    {
        $alumni = alumniModel::find($id);
        return view('layoutAdmin.manajemenAlumni.confirm', compact('alumni'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $alumni = alumniModel::find($id);
            $user = userModel::find($alumni->user_id);
            if (!$alumni && !$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            } else {
                $alumni->delete();
                $user->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        }
        return redirect('/');
    }
}
