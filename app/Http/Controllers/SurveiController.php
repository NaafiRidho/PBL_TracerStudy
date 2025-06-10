<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use App\Models\JawabanSurveiModel;
use App\Models\AlumniModel;
use App\Models\AtasanModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveiController extends Controller
{
    public function create($atasan_id)
    {
        $atasan = AtasanModel::with('alumni')->findOrFail($atasan_id);
        $alumni = AlumniModel::where('atasan_id', $atasan_id)->first();

        if (!$alumni) {
            abort(404, 'Data alumni tidak ditemukan.');
        }

        return view('layoutAtasan.index', compact('atasan', 'alumni'));
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
            'jawaban.*' => 'required|in:Kurang,Cukup,Baik,Sangat Baik',
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
            // Simpan kompetensi_tambahan sebagai jawaban pertanyaan_id 8
            if ($request->kompetensi_tambahan) {
                JawabanSurveiModel::create([
                    'pertanyaan_id' => 8,
                    'alumni_id' => $request->alumni_id,
                    'atasan_id' => $atasanId,
                    'jawaban' => $request->kompetensi_tambahan, // isi dari textarea
                ]);
            }

            // Simpan saran_kurikulum sebagai jawaban pertanyaan_id 9
            if ($request->saran_kurikulum) {
                JawabanSurveiModel::create([
                    'pertanyaan_id' => 9,
                    'alumni_id' => $request->alumni_id,
                    'atasan_id' => $atasanId,
                    'jawaban' => $request->saran_kurikulum, // isi dari textarea
                ]);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
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
