<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use App\Models\JawabanSurveiModel;
use App\Models\AlumniModel;
use App\Models\AtasanModel;

class SurveiController extends Controller
{
    public function create($alumni_id)
    {
        $alumni = AlumniModel::with('atasan')->findOrFail($alumni_id);
        $atasan = $alumni->atasan; // satu objek atasan, bukan collection
        return view('layoutAtasan.index', compact('alumni', 'atasan'));
    }

    // Mengambil semua pertanyaan
    public function getPertanyaan()
    {
        $pertanyaan = PertanyaanModel::select('id', 'pertanyaan')->get();
        return response()->json($pertanyaan);
    }

    public function surveiPertanyaan()
    {
        return response()->json(PertanyaanModel::all());
    }

    // Menyimpan jawaban survei


    // Menyimpan jawaban survei
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'alumni_id' => 'required|exists:alumni,alumni_id',
            'atasan_id' => 'required|exists:atasan,atasan_id', // gunakan atasan_id, bukan data atasan lain
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|in:1,2,3,4',
            'kompetensi_tambahan' => 'nullable|string',
            'saran_kurikulum' => 'nullable|string',
        ]);

        try {
            $atasanId = $request->atasan_id; // ambil atasan_id yang sudah ada

            // Simpan setiap jawaban survei
            foreach ($request->jawaban as $pertanyaan_id => $nilai) {
                JawabanSurveiModel::create([
                    'pertanyaan_id' => $pertanyaan_id,
                    'alumni_id' => $request->alumni_id,
                    'atasan_id' => $atasanId,
                    'jawaban' => $nilai,
                    'kompetensi_tambahan' => $request->kompetensi_tambahan,
                    'saran_kurikulum' => $request->saran_kurikulum,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Survei berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan survei: ' . $e->getMessage()
            ], 500);
        }
    }
}
