<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Survei Kepuasan Pengguna Lulusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <form id="formSurvei" method="POST" action="{{ url('/jawaban') }}">
                    @csrf
                    <fieldset class="mb-4">
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-tie me-2"></i>Identitas Responden
                        </legend>

                        <div class="row g-3">
                            <input type="hidden" name="alumni_id" value="{{ $alumni->alumni_id }}">
                            <input type="hidden" name="atasan_id" value="{{ $atasan->atasan_id ?? '' }}">
                            <input type="hidden" name="nama_atasan" value="{{ $atasan->nama_atasan ?? '' }}">
                            <input type="hidden" name="email_atasan" value="{{ $atasan->email_atasan ?? '' }}">
                            <input type="hidden" name="nama_instansi" value="{{ $atasan->nama_instansi ?? '' }}">
                            <input type="hidden" name="jabatan_atasan" value="{{ $atasan->jabatan ?? '' }}">
                            <input type="hidden" name="prodi" value="{{ $alumni->prodi }}">
                            <input type="hidden" name="tahun_lulus" value="{{ $alumni->formatted_tanggal_lulus }}">

                            <div class="col-md-12">
                                <label class="form-label">Nama Alumni</label>
                                <input type="text" class="form-control" value="{{ $alumni->nama_alumni }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Atasan</label>
                                <input type="text" class="form-control" value="{{ $atasan->nama_atasan ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Atasan</label>
                                <input type="email" class="form-control" value="{{ $atasan->email_atasan ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instansi</label>
                                <input type="text" class="form-control" value="{{ $atasan->nama_instansi ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" value="{{ $atasan->jabatan ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Program Studi</label>
                                <input type="text" class="form-control" value="{{ $alumni->prodi }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="text" class="form-control" value="{{ $alumni->formatted_tanggal_lulus }}" readonly>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-4">
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-star me-2"></i>Penilaian Kompetensi Alumni
                        </legend>
                        <p class="text-muted mb-4">Berikan penilaian dengan skala: 1 (Kurang) - 4 (Sangat Baik)</p>
                        <div id="questions-container"></div>
                    </fieldset>

                    <fieldset>
                        <legend class="h5 text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-comment me-2"></i>Saran dan Masukan
                        </legend>
                        <div class="mb-3">
                            <label for="kompetensi_tambahan" class="form-label">Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
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
                        <button type="button" class="btn btn-outline-secondary me-3" id="resetForm">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $.get('{{ url('/survei') }}', function (getPertanyaan) {
            let html = '';
            getPertanyaan.forEach(function (q, idx) {
                const idPertanyaan = q.id ?? idx + 1;
                const options = ['Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
                html += `
                    <div class="question-item">
                        <div class="mb-3 row align-items-center">
                            <label class="col-md-4 col-form-label">${idx + 1}. ${q.pertanyaan}</label>
                            <div class="col-md-8 d-flex gap-3 flex-wrap">
                                ${options.map((label, i) => `
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="jawaban[${idPertanyaan}]"
                                            id="nilai_${idPertanyaan}_${i}"
                                            value="${label}" required>
                                        <label class="form-check-label" for="nilai_${idPertanyaan}_${i}">
                                            ${label}
                                        </label>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#questions-container').html(html);
        });

        $('#resetForm').on('click', function () {
            $('#formSurvei')[0].reset();
            $('#questions-container input[type=radio]').prop('checked', false);
        });

        $('#formSurvei').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Mengirim...');

            $.ajax({
                url: "{{ url('/jawaban') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Terima kasih telah mengisi survei.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ url('/landingpage') }}";
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat mengirim survei.',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Kirim Survei');
                }
            });
        });
    });
</script>
</body>

</html>
