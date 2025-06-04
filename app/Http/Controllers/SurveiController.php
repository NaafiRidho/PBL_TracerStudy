<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use App\Models\JawabanSurveiModel;
use App\Models\AlumniModel;
use App\Models\AtasanModel;

class SurveiController extends Controller
{
    public function create()
    {
        $alumni = AlumniModel::all(); // atau pakai model: Alumni::all()
        return view('layoutAtasan.index', compact('alumni'));
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

    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'instansi' => 'required',
            'jabatan' => 'required',
            'jawaban' => 'required|array',
            // validasi data atasan
            'nama_atasan' => 'required',
            'nama_instansi' => 'required',
            'jabatan_atasan' => 'required',
            'email_atasan' => 'required|email',
            'no_hp_atasan' => 'required',
        ]);

        // Simpan data atasan ke tabel atasan
        $atasan = AtasanModel::create([
            'nama_atasan' => $request->nama_atasan,
            'nama_instansi' => $request->nama_instansi,
            'jabatan' => $request->jabatan_atasan,
            'email_atasan' => $request->email_atasan,
            'no_hp_atasan' => $request->no_hp_atasan,
            // tambahkan user_id jika perlu
        ]);

        // Simpan jawaban survei
        foreach ($request->jawaban as $id_pertanyaan => $nilai) {
            JawabanSurveiModel::create([
                'pertanyaan_id' => $id_pertanyaan,
                'alumni_id' => $request->alumni_id,
                'atasan_id' => $atasan->atasan_id, // gunakan id hasil insert
                'jawaban' => $nilai,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Survei berhasil disimpan!']);
    }

}
