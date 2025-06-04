{{-- {{ dd($alumni) }} cek apakah variabel alumni sudah dibuat dan database alumni tidak empty --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei Kepuasan Pengguna Lulusan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
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

        .card-header.bg-light {
            background-color: #f8f9fa !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid,
        .was-validated .form-check-input:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .was-validated .form-select:invalid~.invalid-feedback,
        .was-validated .form-check-input:invalid~.invalid-feedback {
            display: block;
        }

        .question-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed #eee;
        }

        .question-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Survei Kepuasan Pengguna Lulusan</h1>
        <div class="card mb-4">
            <div class="card-header bg-light">
                <i class="fas fa-poll me-1"></i> Form Survei Kepuasan
            </div>
            <div class="card-body">
                <form id="form-survei" method="POST" action="/jawaban">
                    @csrf
                    <!-- Section 1: Identitas Responden -->
                    <fieldset class="mb-4">
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-tie me-2"></i>Identitas Responden
                        </legend>
                        <div class="row g-3">
                            <!-- Nama Alumni (dropdown) -->
                            <div class="col-md-12">
                                <label for="alumni_id" class="form-label">Nama Alumni</label>
                                <select id="alumni_id" name="alumni_id" class="form-select" required>
                                    <option value="">-- Pilih Alumni --</option>
                                    @foreach($alumni as $a)
                                        <option value="{{ $a->alumni_id }}" data-nama="{{ $a->atasan->nama ?? '' }}"
                                            data-email="{{ $a->atasan->email ?? '' }}"
                                            data-instansi="{{ $a->atasan->instansi ?? '' }}"
                                            data-jabatan="{{ $a->atasan->jabatan ?? '' }}" data-prodi="{{ $a->prodi }}"
                                            data-tahun_lulus="{{ $a->tanggal_lulus ?? '' }}">
                                            {{ $a->nama_alumni }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Form Fields -->
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama_atasan" class="form-control" required>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email_atasan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="instansi" class="form-label">Instansi/Perusahaan</label>
                                <input type="text" id="instansi" name="nama_instansi" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" id="jabatan" name="jabatan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <input type="text" id="prodi" name="prodi" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                <input type="text" id="tahun_lulus" name="tahun_lulus" class="form-control" readonly>
                            </div>
                        </div>

                    </fieldset>

                    <!-- Section 2: Penilaian Kompetensi (Dynamic Questions) -->
                    <fieldset class="mb-4">
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-star me-2"></i>Penilaian Kompetensi Alumni
                        </legend>
                        <p class="text-muted mb-4">Berikan penilaian dengan skala: 1 (Kurang) - 4 (Sangat Baik)</p>
                        <div id="questions-container"></div>
                    </fieldset>

                    <!-- Section 3: Saran -->
                    <fieldset>
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-comment me-2"></i>Saran dan Masukan
                        </legend>
                        <div class="mb-3">
                            <label for="kompetensi_tambahan" class="form-label">Kompetensi yang dibutuhkan tapi belum
                                dapat dipenuhi</label>
                            <textarea id="kompetensi_tambahan" name="kompetensi_tambahan" class="form-control" rows="3"
                                placeholder="Tuliskan kompetensi yang menurut Anda perlu ditingkatkan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="saran_kurikulum" class="form-label">Saran untuk kurikulum program studi</label>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('alumni_id').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama').value = selected.getAttribute('data-nama') || '';
            document.getElementById('email').value = selected.getAttribute('data-email') || '';
            document.getElementById('instansi').value = selected.getAttribute('data-instansi') || '';
            document.getElementById('jabatan').value = selected.getAttribute('data-jabatan') || '';
            document.getElementById('prodi').value = selected.getAttribute('data-prodi') || '';
            document.getElementById('tahun_lulus').value = selected.getAttribute('data-tahun_lulus') || '';
        });

        $(document).ready(function () {
            // Ambil pertanyaan dari database via AJAX
            $.get('/survei', function (getPertanyaan) {
                console.log(getPertanyaan); // Debug: pastikan data valid dan id ada

                let html = '';
                getPertanyaan.forEach(function (q, idx) {
                    // Validasi: cek apakah q.id tersedia
                    const idPertanyaan = q.id ?? idx + 1;

                    // Jika pertanyaan ke 1–7 (idx 0–6)
                    if (idx < 7) {
                        html += `
                <div class="question-item">
                    <div class="mb-3 row align-items-center">
                        <label class="col-md-4 col-form-label">${idx + 1}. ${q.pertanyaan}</label>
                        <div class="col-md-8 d-flex gap-3 flex-wrap">
                            ${[1, 2, 3, 4].map(val => `
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" 
                                        name="jawaban[${idPertanyaan}]" 
                                        id="nilai_${idPertanyaan}_${val}" 
                                        value="${val}" required>
                                    <label class="form-check-label" for="nilai_${idPertanyaan}_${val}">
                                        ${val} (${['Kurang', 'Cukup', 'Baik', 'Sangat Baik'][val - 1]})
                                    </label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
                    }
                });

                $('#questions-container').html(html);
            });


            // Validasi dan submit survei via AJAX
            $('#form-survei').on('submit', function (e) {
                e.preventDefault();
                console.log('Form submit intercepted');
                let form = this;
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                let formData = $(form).serialize();

                $.ajax({
                    url: '/jawaban',
                    type: 'POST',  // ganti method jadi type, untuk kompatibilitas
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            alert(res.message);
                            form.reset();
                            form.classList.remove('was-validated');
                            $('#questions-container').empty();
                        } else {
                            alert('Gagal menyimpan survei.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat mengirim survei.');
                    }
                });
            });

        });
    </script>
</body>

</html>