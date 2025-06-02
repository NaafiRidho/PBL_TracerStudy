@extends('layoutAdmin.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    {{-- Kartu Informasi --}}
    <div class="row mb-4">
        {{-- Card Primary --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        {{-- Card Warning --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        {{-- Card Success --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        {{-- Card Danger --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik dan Tabel --}}
    <div class="row">
        {{-- Grafik Sebaran Jenis Instansi --}}
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>Grafik Sebaran Jenis Instansi
                </div>
                <div class="card-body">
                    <canvas id="instansiChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        {{-- Tabel Sebaran Jenis Instansi --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>Tabel Sebaran Jenis Instansi
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="instansiTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Instansi</th>
                                <th>Jumlah Alumni</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Akan diisi dengan JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
    <div class="card mb-4 equal-height-card">
        <div class="card-header">
            <i class="fas fa-chart-pie me-1"></i>Grafik Sebaran Profesi Lulusan
        </div>
        <div class="card-body">
            <canvas id="profesiChart" width="100%" height="100"></canvas>
        </div>
    </div>
</div>

<div class="col-xl-6">
    <div class="card mb-4  equal-height-card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>Tabel Sebaran Profesi
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="profesiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Profesi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card-header {
        background-color: #f4f6f9;
    }
    .btn {
        transition: all 0.3s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    table.dataTable thead th {
        border-top: 2px solid #dee2e6;
    }
    .equal-height-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
</style>
@endpush

@push('scripts')
<!-- Load Chart.js dan jQuery dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Ambil data dari endpoint dan buat grafik serta tabel
    $.ajax({
        url: "{{ url('admin/dashboard/instansi-chart') }}",
        method: 'GET',
        success: function(response) {
            // Siapkan label dan data untuk chart
            const labels = response.map(item => item.jenis_instansi);
            const values = response.map(item => item.total);

            // Buat grafik pie
            const ctx = document.getElementById('instansiChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
            });

            // Isi tabel dengan data
            let tableBody = '';
            response.forEach((item, index) => {
                tableBody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jenis_instansi}</td>
                        <td>${item.total}</td>
                    </tr>
                `;
            });
            $('#instansiTable tbody').html(tableBody);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            alert('Gagal memuat data grafik instansi');
        }
    });
    $.ajax({
    url: "{{ url('admin/dashboard/profesi-chart') }}",
    method: 'GET',
    success: function(response) {
        const labels = response.map(p => p.profesi);
        const values = response.map(p => p.total);

        const ctx = document.getElementById('profesiChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        '#007bff', '#ffc107', '#28a745', '#dc3545',
                        '#6610f2', '#fd7e14', '#20c997', '#6f42c1',
                        '#e83e8c', '#17a2b8', '#adb5bd' // max 11 (termasuk "Lainnya")
                    ],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        });

        // Isi tabel
        let tableBody = '';
        response.forEach((p, i) => {
            tableBody += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${p.profesi}</td>
                    <td>${p.total}</td>
                </tr>
            `;
        });
        $('#profesiTable tbody').html(tableBody);
    },
    error: function(err) {
        alert("Gagal memuat data profesi.");
    }
});

});
</script>
@endpush