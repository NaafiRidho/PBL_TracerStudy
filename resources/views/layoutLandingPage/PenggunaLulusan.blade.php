@extends('layoutPenggunaLulusan.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Survei Kepuasan Pengguna Lulusan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Form Survei</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <i class="fas fa-poll me-1"></i> Form Survei Kepuasan
        </div>
        <div class="card-body">
            <form action="{{ url('survei') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                
                <!-- Section 1: Identitas Responden -->
                <fieldset class="mb-4">
                    <legend class="h5 text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-user-tie me-2"></i>Identitas Responden
                    </legend>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $userAlumni->nama ?? '') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="instansi" class="form-label">Instansi/Perusahaan</label>
                            <input type="text" id="instansi" name="instansi" class="form-control" value="{{ old('instansi', $userAlumni->instansi ?? '') }}" required>
                            <div class="invalid-feedback">Harap isi nama instansi</div>
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" value="{{ old('jabatan', $userAlumni->jabatan ?? '') }}" required>
                            <div class="invalid-feedback">Harap isi jabatan</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $userAlumni->email ?? '') }}" readonly>
                        </div>
                        <div class="col-md-12">
                            <label for="alumni_id" class="form-label">Alumni yang Dinilai</label>
                            <select id="alumni_id" name="alumni_id" class="form-select select2-alumni" required>
                                <option value="" disabled>Pilih alumni...</option>
                                @foreach($alumniList as $alumni)
                                    <option value="{{ $alumni->id }}" {{ (old('alumni_id', $selectedAlumniId ?? '') == $alumni->id) ? 'selected' : '' }}>
                                        {{ $alumni->nama }} - {{ $alumni->program_studi }} ({{ $alumni->tahun_lulus }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Harap pilih alumni</div>
                        </div>
                    </div>
                </fieldset>
                
                <!-- Section 2: Penilaian Kompetensi -->
                <fieldset class="mb-4">
                    <legend class="h5 text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-star me-2"></i>Penilaian Kompetensi Alumni
                    </legend>
                    <p class="text-muted mb-4">Berikan penilaian dengan skala: 1 (Kurang) - 4 (Sangat Baik)</p>
                    
                    @php
                        $questions = [
                            1 => 'Kerjasama Tim',
                            2 => 'Keahlian di bidang TI',
                            3 => 'Kemampuan berbahasa asing',
                            4 => 'Kemampuan berkomunikasi',
                            5 => 'Pengembangan diri',
                            6 => 'Kepemimpinan',
                            7 => 'Etos Kerja'
                        ];
                    @endphp
                    
                    @foreach($questions as $number => $question)
                    <div class="mb-3 row align-items-center">
                        <label class="col-md-4 col-form-label">{{ $number }}. {{ $question }}</label>
                        <div class="col-md-8 d-flex gap-3 flex-wrap">
                            @foreach([1 => 'Kurang', 2 => 'Cukup', 3 => 'Baik', 4 => 'Sangat Baik'] as $value => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" 
                                       name="nilai_{{ strtolower(str_replace(' ', '_', $question)) }}" 
                                       id="nilai_{{ $number }}_{{ $value }}" 
                                       value="{{ $value }}" required>
                                <label class="form-check-label" for="nilai_{{ $number }}_{{ $value }}">
                                    {{ $value }} ({{ $label }})
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </fieldset>
                
                <!-- Section 3: Saran -->
                <fieldset>
                    <legend class="h5 text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-comment me-2"></i>Saran dan Masukan
                    </legend>
                    
                    <div class="mb-3">
                        <label for="kompetensi_tambahan" class="form-label">8. Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
                        <textarea id="kompetensi_tambahan" name="kompetensi_tambahan" class="form-control" rows="3" 
                                  placeholder="Tuliskan kompetensi yang menurut Anda perlu ditingkatkan"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="saran_kurikulum" class="form-label">9. Saran untuk kurikulum program studi</label>
                        <textarea id="saran_kurikulum" name="saran_kurikulum" class="form-control" rows="3" 
                                  placeholder="Berikan saran untuk pengembangan kurikulum"></textarea>
                    </div>
                </fieldset>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-undo me-1"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Survei
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Menyamakan styling dengan data alumni */
    fieldset {
        border: 1px solid #dee2e6;
        padding: 1rem 1.5rem 1.5rem;
        border-radius: 0.375rem;
        background-color: #f8f9fc;
        margin-bottom: 2rem;
    }
    legend {
        width: auto;
        padding: 0 0.5rem;
        font-weight: 600;
    }
    .form-check-inline {
        margin-right: 1.5rem;
    }
</style>
@endpush

@push('js')
<script>
    // Form validation
    (function () {
      'use strict'

      var forms = document.querySelectorAll('.needs-validation')

      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })();

    // Initialize Select2 for alumni search
    $(document).ready(function() {
        $('.select2-alumni').select2({
            placeholder: "Cari nama alumni...",
            allowClear: true,
            theme: 'bootstrap-5' // kalau kamu pakai bootstrap 5
        });
    });
</script>
@endpush
@endsection