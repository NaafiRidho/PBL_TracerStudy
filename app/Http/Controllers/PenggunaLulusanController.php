<?php

namespace App\Http\Controllers;
use App\Models\AlumniModel; // Pastikan model ini ada

use Illuminate\Http\Request;

class PenggunaLulusanController extends Controller
{
    public function index()
    {
        $alumniList = AlumniModel::all(); // Untuk dropdown
        return view('layoutPenggunaLulusan.penggunaLulusan', compact('alumniList'));
    }
}
