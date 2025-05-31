<?php

namespace App\Http\Controllers;

use App\Models\alumniModel;
use App\Models\atasanModel;
use App\Models\instansiModel;
use App\Models\Kategori_porfesiModel;
use App\Models\profesiModel;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index($id)
    {
        $alumni = alumniModel::find($id);
        $profesi = profesiModel::all();
        $kategori_profesi = Kategori_porfesiModel::all();
        $jenis_instansi = instansiModel::all();

        return view('layoutAlumni.index', compact('profesi', 'kategori_profesi', 'jenis_instansi', 'alumni'));
    }
    public function list($id)
    {
        $alumni = alumniModel::findOrFail($id);
        return response()->json([
        'alumni' => $alumni
    ]);
    }
    public function byKategori($kategori_profesi_id)
    {
        $profesi = profesiModel::where('kategori_profesi_id', $kategori_profesi_id)->get();
        return response()->json($profesi);
    }
    public function update(Request $request, $id)
    {
        // Validasi server-side (sesuaikan rules)
        $validated = $request->validate([
            'tanggal_kerja_pertama' => 'required|date',
            'masa_tunggu' => 'required|integer|min:0',
            'tanggal_mulai_instansi' => 'required|date',
            'nama_instansi' => 'required|string|max:255',
            'skala_instansi' => 'required|in:international,nasional,wirausaha',
            'lokasi_instansi' => 'required|string|max:255',
            'jenis_instansi_id' => 'required|exists:jenis_instansi,jenis_instansi_id',
            'kategori_profesi_id' => 'required|exists:kategori_profesi,kategori_profesi_id',
            'profesi_id' => 'required|exists:profesi,profesi_id',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $alumni = alumniModel::findOrFail($id);

        // Update data alumni
        $alumni->tanggal_kerja_pertama = $request->tanggal_kerja_pertama;
        $alumni->masa_tunggu = $request->masa_tunggu;
        $alumni->tanggal_mulai_instansi = $request->tanggal_mulai_instansi;
        $alumni->nama_instansi = $request->nama_instansi;
        $alumni->skala_instansi = $request->skala_instansi;
        $alumni->lokasi_instansi = $request->lokasi_instansi;
        $alumni->jenis_instansi_id = $request->jenis_instansi_id;
        $alumni->kategori_profesi_id = $request->kategori_profesi_id;
        $alumni->profesi_id = $request->profesi_id;
        $alumni->no_hp = $request->no_hp;
        $alumni->email = $request->email;

        $alumni->save();

        // Simpan data atasan baru
        if ($request->nama_atasan || $request->jabatan || $request->email_atasan || $request->no_hp_atasan) {
            $atasan = new atasanModel();
            $atasan->nama_atasan = $request->nama_atasan;
            $atasan->jabatan = $request->jabatan;
            $atasan->nama_instansi = $request->nama_instansi;
            $atasan->email_atasan = $request->email_atasan;
            $atasan->no_hp_atasan = $request->no_hp_atasan;

            $atasan->save();

            $alumni->atasan_id = $atasan->atasan_id;
            $alumni->save();
        }

        return response()->json(['message' => 'Data alumni berhasil diperbarui']);
    }
}
