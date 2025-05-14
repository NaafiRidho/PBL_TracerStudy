<?php

namespace App\Http\Controllers;

use App\Models\Kategori_porfesiModel;
use App\Models\profesiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProfesiController extends Controller
{
    public function index()
    {
        return view('layoutAdmin.profesi');
    }
    public function list()
    {
        $profesi = profesiModel::select('kategori_profesi_id', 'profesi', 'profesi_id')->with('kategori_profesi');

        return DataTables::of($profesi)
            ->addIndexColumn()
            ->addColumn('kategori_profesi', function ($row) {
                return $row->kategori_profesi->kategori_profesi ?? '-';
            })
            ->addColumn('aksi', function ($profesi) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/' . $profesi->profesi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $profesi->profesi_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }
    public function create_ajax()
    {
        $kategori_profesi = Kategori_porfesiModel::select('kategori_profesi_id', 'kategori_profesi')->get();
        return view('layoutAdmin.create', compact('kategori_profesi'));
    }

    public function store(Request $request)
    {
        // Cek apakah request adalah AJAX atau menginginkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi data yang dikirim
            $validator = Validator::make($request->all(), [
                'kategori_profesi_id' => 'required|exists:kategori_profesi,kategori_profesi_id',
                'profesi' => 'required|string|max:100',
            ]);

            // Jika validasi gagal, kirim respons error dalam format JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors() // Kirimkan pesan error untuk setiap field
                ]);
            }

            try {
                // Menyimpan data profesi
                profesiModel::create([
                    'kategori_profesi_id' => $request->kategori_profesi_id,
                    'profesi' => $request->profesi,
                ]);

                // Jika berhasil disimpan, kirim respons sukses dalam format JSON
                return response()->json([
                    'status' => true,
                    'message' => 'Data profesi berhasil ditambahkan.'
                ]);
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat menyimpan, kirim respons error dalam format JSON
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.',
                ]);
            }
        }

        // Jika bukan request AJAX, lakukan redirect ke halaman yang sesuai (misalnya admin)
        return redirect('/admin');
    }

    public function edit_ajax(string $id)
    {
        $profesi = profesiModel::find($id);
        $kategori_profesi = Kategori_porfesiModel::select('kategori_profesi_id', 'kategori_profesi')->get();
        return view('layoutAdmin.edit', compact('profesi', 'kategori_profesi'));
    }
    public function update_ajax(Request $request, string $id)
    {
        // Cek apakah request adalah AJAX atau menginginkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi data yang dikirim
            $validator = Validator::make($request->all(), [
                'kategori_profesi_id' => 'required|exists:kategori_profesi,kategori_profesi_id',
                'profesi' => 'required|string|max:100',
            ]);

            // Jika validasi gagal, kirim respons error dalam format JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                // Update data berdasarkan ID
                $profesi = profesiModel::findOrFail($id);
                $profesi->update([
                    'kategori_profesi_id' => $request->kategori_profesi_id,
                    'profesi' => $request->profesi,
                ]);

                // Jika berhasil diupdate, kirim respons sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data profesi berhasil diperbarui.'
                ]);
            } catch (\Exception $e) {
                // Jika terjadi error saat update
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.'
                ]);
            }
        }

        // Jika bukan request AJAX, redirect ke halaman admin
        return redirect('/admin');
    }

    public function confirm_ajax(string $id)
    {
        $profesi = profesiModel::find($id);
        return view('layoutAdmin.confirmProfesi', compact('profesi'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $profesi = profesiModel::find($id);
            if (!$profesi) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            } else {
                $profesi->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        }
        return redirect('/');
    }
}
