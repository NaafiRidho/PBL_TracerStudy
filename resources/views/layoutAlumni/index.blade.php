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

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_alumni" class="form-label">Nama Alumni</label>
                    <input type="text" name="nama_alumni" id="nama_alumni" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <input type="text" name="prodi" id="prodi" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="tanggal_lulus" class="form-label">Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" id="tanggal_lulus" class="form-control" readonly>
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
                        <option value="international">International</option>
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

                <div class="mb-3">
                    <label for="kategori_profesi_id" class="form-label">Kategori Profesi</label>
                    <select name="kategori_profesi_id" class="form-select" id="kategori_profesi_id">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori_profesi as $item)
                            <option value="{{ $item->kategori_profesi_id }}">{{ $item->kategori_profesi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profesi_id" class="form-label">Profesi</label>
                    <select name="profesi_id" class="form-select" id="profesi_id">
                        <option value="">-- Pilih Profesi --</option>
                        @foreach($profesi as $item)
                            <option value="{{ $item->profesi_id }}">{{ $item->profesi }}</option>
                        @endforeach
                    </select>
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
                    <label for="nama_atasan" class="form-label">Nama Atasan</label>
                    <input type="text" name="nama_atasan" id="nama_atasan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email_atasan" class="form-label">Email Atasan</label>
                    <input type="email" name="email_atasan" id="email_atasan" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="no_hp_atasan" class="form-label">No Hp Atasan</label>
                    <input type="text" name="no_hp_atasan" id="no_hp_atasan" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Simpan</button>
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
                $('#kategori_profesi_id').val(data.kategori_profesi_id);

                // Setelah kategori profesi di-set, panggil fungsi load profesi untuk set profesi yg sesuai
                loadProfesi(data.kategori_profesi_id, data.profesi_id);

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

    // Fungsi untuk load profesi berdasar kategori profesi yg dipilih
    function loadProfesi(kategoriId, selectedProfesiId = null) {
        if (kategoriId) {
            @php
            $baseUrl = url('/profesi/by-kategori');
            @endphp
            
            const fullUrl = "{{ $baseUrl }}/" + kategoriId;

            $.ajax({
                url: fullUrl,
                type: 'GET',
                success: function(profesiList) {
                    let options = '<option value="">-- Pilih Profesi --</option>';
                    profesiList.forEach(function(profesi) {
                        const selected = (profesi.profesi_id == selectedProfesiId) ? 'selected' : '';
                        options += `<option value="${profesi.profesi_id}" ${selected}>${profesi.profesi}</option>`;
                    });
                    $('#profesi_id').html(options);
                },
                error: function() {
                    alert('Gagal mengambil data profesi');
                    $('#profesi_id').html('<option value="">-- Pilih Profesi --</option>');
                }
            });
        } else {
            $('#profesi_id').html('<option value="">-- Pilih Profesi --</option>');
        }
    }

    // Event saat kategori profesi diubah manual oleh user
    $('#kategori_profesi_id').on('change', function() {
        const kategoriId = $(this).val();
        loadProfesi(kategoriId);
    });

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
