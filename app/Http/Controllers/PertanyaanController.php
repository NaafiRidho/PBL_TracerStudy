<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanController extends Controller
{
    public function index()
    {

        return view('layoutAdmin.pertanyaan.index'); // Buat file Blade ini
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = PertanyaanModel::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalEdit(\'' . url('/admin/pertanyaan/' . $row->pertanyaan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalDelete(\'' . url('/admin/pertanyaan/' . $row->pertanyaan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                    return $btn;
                })

                ->rawColumns(['aksi']) // Kolom aksi berisi HTML
                ->make(true);
        }

        // Jika bukan AJAX, jangan return view atau HTML di sini
        return response()->json(['message' => 'Bukan permintaan AJAX'], 400);
    }
    public function create_ajax()
    {
        return view('layoutAdmin.pertanyaan.create'); // Buat file Blade ini
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'pertanyaan' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PertanyaanModel::create([
                'pertanyaan' => $request->pertanyaan
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pertanyaan berhasil ditambahkan.'
            ]);
        }

        return redirect('/admin');
    }

    public function edit_ajax(string $id)
    {
        $data = PertanyaanModel::find($id);
        return view('layoutAdmin.pertanyaan.edit', compact('data')); // Buat file Blade ini
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'pertanyaan' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $data = PertanyaanModel::findOrFail($id);
            $data->update([
                'pertanyaan' => $request->pertanyaan
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pertanyaan berhasil diperbarui.'
            ]);
        }

        return redirect('/admin');
    }
    public function confirm_ajax(string $id)
    {
        $pertanyaan = PertanyaanModel::find($id);
        return view('layoutAdmin.pertanyaan.confirm', compact('pertanyaan')); // Buat file Blade ini
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = PertanyaanModel::find($id);
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }

            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return redirect('/');
    }
}
