<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Input Data Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .logo {
            width: 200px;
            display: block;
            margin: 20px auto 10px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <img src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/Logo-Polinema.png') }}" alt="Logo Alumni" class="logo" />

            <h3 class="text-center mb-4">Input Data Alumni</h3>
            <form id="alumniForm" action="{{ url('/alumni/update/' . $alumni->alumni_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <div class="mb-4">
                    <h5 class="bg-light p-2 text-primary border-start border-primary border-3 ps-3">
                        📋 Data Pribadi
                    </h5>
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_alumni" class="form-label">Nama Alumni</label>
                    <input type="text" name="nama_alumni" id="nama_alumni" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" name="prodi" id="prodi" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_lulus" class="form-label">Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" id="tanggal_lulus" class="form-control" readonly>
                </div>

                <!-- Informasi Pekerjaan -->
                <div class="mb-4">
                    <h5 class="bg-light p-2 text-primary border-start border-primary border-3 ps-3">
                        💼 Informasi Pekerjaan
                    </h5>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kerja_pertama" class="form-label">Tanggal Kerja Pertama</label>
                    <input type="date" name="tanggal_kerja_pertama" id="tanggal_kerja_pertama" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="masa_tunggu" class="form-label">Masa Tunggu (bulan)</label>
                    <input type="number" name="masa_tunggu" id="masa_tunggu" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="kategori_profesi_id" class="form-label">Kategori Profesi</label>
                    <select name="kategori_profesi_id" class="form-select" id="kategori_profesi_id">
                        <option value="">-- Pilih Kategori Profesi --</option>
                        <option value="infokom">Bidang Infokom</option>
                        <option value="non_infokom">Bidang Non Infokom</option>
                        <option value="belum_bekerja">Belum Bekerja</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profesi_id" class="form-label">Profesi</label>
                    <select name="profesi_id" class="form-select" id="profesi_id" disabled>
                        <option value="">-- Pilih Kategori Profesi Terlebih Dahulu --</option>
                    </select>
                </div>

                <div id="profesi-lainnya" class="mb-3" style="display: none;">
                    <label for="profesi_lainnya" class="form-label">Sebutkan Profesi Lainnya</label>
                    <input type="text" name="profesi_lainnya" id="profesi_lainnya" class="form-control" placeholder="Masukkan profesi Anda...">
                </div>

                <!-- Informasi Instansi -->
                <div class="mb-4">
                    <h5 class="bg-light p-2 text-primary border-start border-primary border-3 ps-3">
                        🏢 Informasi Instansi
                    </h5>
                </div>

                <div class="mb-3">
                    <label for="tanggal_mulai_instansi" class="form-label">Tanggal Mulai di Instansi</label>
                    <input type="date" name="tanggal_mulai_instansi" id="tanggal_mulai_instansi" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="nama_instansi" class="form-label">Nama Instansi</label>
                    <input type="text" name="nama_instansi" id="nama_instansi" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="skala_instansi" class="form-label">Skala Instansi</label>
                    <select name="skala_instansi" id="skala_instansi" class="form-select">
                        <option value="">-- Pilih Skala --</option>
                        <option value="international">Multinasional/International</option>
                        <option value="nasional">Nasional</option>
                        <option value="wirausaha">Wirausaha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lokasi_instansi" class="form-label">Lokasi Instansi</label>
                    <input type="text" name="lokasi_instansi" id="lokasi_instansi" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="jenis_instansi_id" class="form-label">Jenis Instansi</label>
                    <select name="jenis_instansi_id" class="form-select" id="jenis_instansi_id">
                        <option value="">-- Pilih Jenis Instansi --</option>
                        @foreach($jenis_instansi as $item)
                            <option value="{{ $item->jenis_instansi_id }}">{{ $item->jenis_instansi }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Informasi Kontak -->
                <div class="mb-4">
                    <h5 class="bg-light p-2 text-primary border-start border-primary border-3 ps-3">
                        📞 Informasi Kontak
                    </h5>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                </div>

                <!-- Informasi Atasan -->
                <div class="mb-4">
                    <h5 class="bg-light p-2 text-primary border-start border-primary border-3 ps-3">
                        👤 Informasi Atasan
                    </h5>
                </div>

                <div class="mb-3">
                    <label for="nama_atasan" class="form-label">Nama Atasan</label>
                    <input type="text" name="nama_atasan" id="nama_atasan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email_atasan" class="form-label">Email Atasan</label>
                    <input type="email" name="email_atasan" id="email_atasan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="no_hp_atasan" class="form-label">No Hp Atasan</label>
                    <input type="text" name="no_hp_atasan" id="no_hp_atasan" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">📄 Simpan Data Alumni</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    const pathParts = window.location.pathname.split("/");
    const alumniId = pathParts[4]; // sesuaikan jika struktur URL berbeda

    @php
        $baseUrl = url('/alumni/list');
    @endphp

    const fullUrl = "{{ $baseUrl }}/" + alumniId;

    // Data profesi berdasarkan kategori
    const profesiData = {
        'infokom': [
            { id: 'dev_programmer', nama: 'Developer/Programmer/Software Engineer' },
            { id: 'it_support', nama: 'IT Support/IT Administrator' },
            { id: 'infrastructure', nama: 'Infrastructure Engineer' },
            { id: 'digital_marketing', nama: 'Digital Marketing Specialist' },
            { id: 'graphic_designer', nama: 'Graphic Designer/Multimedia Designer' },
            { id: 'business_analyst', nama: 'Business Analyst' },
            { id: 'qa_engineer', nama: 'QA Engineer/Tester' },
            { id: 'it_entrepreneur', nama: 'IT Entrepreneur' },
            { id: 'trainer_it', nama: 'Trainer/Guru/Dosen (IT)' },
            { id: 'mahasiswa_it', nama: 'Mahasiswa' },
            { id: 'lainnya_it', nama: 'Lainnya...' }
        ],
        'non_infokom': [
            { id: 'procurement', nama: 'Procurement & Operational Team' },
            { id: 'wirausaha_non_it', nama: 'Wirausahawan (Non IT)' },
            { id: 'trainer_non_it', nama: 'Trainer/Guru/Dosen (Non IT)' },
            { id: 'mahasiswa_non_it', nama: 'Mahasiswa' },
            { id: 'lainnya_non_it', nama: 'Lainnya...' }
        ],
        'belum_bekerja': []
    };

    // Event handler untuk perubahan kategori profesi
    $('#kategori_profesi_id').on('change', function() {
        const kategoriValue = $(this).val();
        const profesiSelect = $('#profesi_id');
        const profesiLainnyaDiv = $('#profesi-lainnya');
        
        // Reset profesi select
        profesiSelect.html('<option value="">-- Pilih Profesi --</option>');
        profesiLainnyaDiv.hide();
        
        if (kategoriValue === '') {
            profesiSelect.prop('disabled', true);
            profesiSelect.html('<option value="">-- Pilih Kategori Profesi Terlebih Dahulu --</option>');
            return;
        }
        
        if (kategoriValue === 'belum_bekerja') {
            profesiSelect.prop('disabled', true);
            profesiSelect.html('<option value="belum_bekerja">Belum Bekerja</option>');
            profesiSelect.val('belum_bekerja');
            return;
        }
        
        // Enable profesi select dan populate dengan data
        profesiSelect.prop('disabled', false);
        
        if (profesiData[kategoriValue]) {
            profesiData[kategoriValue].forEach(function(profesi) {
                profesiSelect.append(`<option value="${profesi.id}">${profesi.nama}</option>`);
            });
        }
    });

    // Event handler untuk perubahan profesi
    $('#profesi_id').on('change', function() {
        const profesiValue = $(this).val();
        const profesiLainnyaDiv = $('#profesi-lainnya');
        
        if (profesiValue === 'lainnya_it' || profesiValue === 'lainnya_non_it') {
            profesiLainnyaDiv.show();
            $('#profesi_lainnya').prop('required', true);
        } else {
            profesiLainnyaDiv.hide();
            $('#profesi_lainnya').prop('required', false);
        }
    });

    // Fungsi untuk load data alumni dan isi form
    if (alumniId && /^\d+$/.test(alumniId)) {
        $.ajax({
            url: fullUrl,
            type: 'GET',
            success: function (response) {
                const data = response.alumni;

                $('#nim').val(data.nim);
                $('#nama_alumni').val(data.nama);
                $('#prodi').val(data.prodi);
                $('#tanggal_lulus').val(data.tanggal_lulus.substring(0, 10));

                $('#jenis_instansi_id').val(data.jenis_instansi_id);
                
                // Set kategori profesi terlebih dahulu
                if (data.kategori_profesi_id) {
                    $('#kategori_profesi_id').val(data.kategori_profesi_id).trigger('change');
                    
                    // Set profesi setelah kategori di-load
                    setTimeout(function() {
                        $('#profesi_id').val(data.profesi_id);
                    }, 100);
                }

                // Set field lainnya jika ada
                $('#tanggal_kerja_pertama').val(data.tanggal_kerja_pertama ? data.tanggal_kerja_pertama.substring(0, 10) : '');
                $('#masa_tunggu').val(data.masa_tunggu);
                $('#tanggal_mulai_instansi').val(data.tanggal_mulai_instansi ? data.tanggal_mulai_instansi.substring(0, 10) : '');
                $('#nama_instansi').val(data.nama_instansi);
                $('#skala_instansi').val(data.skala_instansi);
                $('#lokasi_instansi').val(data.lokasi_instansi);
                $('#no_hp').val(data.no_hp);
                $('#email').val(data.email);
                $('#nama_atasan').val(data.nama_atasan);
                $('#jabatan').val(data.jabatan);
                $('#email_atasan').val(data.email_atasan);
                $('#no_hp_atasan').val(data.no_hp_atasan);
            },
            error: function (xhr) {
                console.error('Gagal ambil data alumni:', xhr.responseText);
            }
        });
    }

    $('#alumniForm').on('submit', function(e){
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data alumni berhasil diperbarui!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @php
                        $baseUrl = url('/login/email');
                        @endphp
                        const fullUrl = "{{ $baseUrl }}";
                        window.location.href = fullUrl;
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memperbarui data alumni: ' + xhr.responseText,
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
</body>
</html>