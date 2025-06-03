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
            <div class="card mb-4 equal-height-card"> {{-- Added equal-height-card for consistency --}}
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>Grafik Sebaran Jenis Instansi
                </div>
                <div class="card-body">
                    <canvas id="instansiChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        {{-- Grafik Sebaran Profesi Lulusan --}}
        <div class="col-xl-6">
            <div class="card mb-4 equal-height-card">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>Grafik Sebaran Profesi Lulusan
                </div>
                <div class="card-body">
                    <canvas id="profesiChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- This div was mistakenly closing the row div, moved below --}}


    {{-- Tabel Sebaran Profesi --}}
    <div class="row"> {{-- Wrap tables in their own row for proper layout --}}
        <div class="col-xl-12 mt-4">
            <div class="card mb-4 equal-height-card">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>Tabel Sebaran Profesi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tabelAlumni">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">Tahun Lulus</th>
                                    <th rowspan="2" class="text-center align-middle">Jumlah Lulusan</th>
                                    <th rowspan="2" class="text-center align-middle">Jumlah Lulusan yang terlacak</th>
                                    <th colspan="2" class="text-center">Profesi Kerja</th>
                                    <th colspan="3" class="text-center">Lingkup Tempat Kerja</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Bidang Infokom</th>
                                    <th class="text-center">Bidang Non Infokom</th>
                                    <th class="text-center">Multinasional/Internasional</th>
                                    <th class="text-center">Nasional</th>
                                    <th class="text-center">Wirausaha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Rata-rata Masa Tunggu --}}
        <div class="col-xl-12 mt-4">
            <div class="card mb-4 equal-height-card">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>Tabel Rata-rata Masa Tunggu
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tabelAverageWaitingTime">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Tahun Lulus</th>
                                    <th>Jumlah Lulusan</th>
                                    <th>Jumlah Lulusan yang Terlacak</th>
                                    <th>Rata-rata Waktu Tunggu (Bulan)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Penilaian Kepuasan Pengguna Lulusan --}}
        <div class="col-xl-12 mt-4">
            <div class="card mb-4 equal-height-card">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>Tabel Penilaian Kepuasan Pengguna Lulusan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tabelAlumniSatisfaction">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Jenis Kemampuan</th>
                                    <th colspan="4" class="text-center">Tingkat Kepuasan Pengguna (%)</th>
                                </tr>
                                <tr>
                                    <th>Sangat Baik</th>
                                    <th>Baik</th>
                                    <th>Cukup</th>
                                    <th>Kurang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- Close the row div that contains all tables --}}
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
    .equal-height-card .card-body {
        flex-grow: 1; /* Allow card body to grow and fill available space */
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script>
$(document).ready(function () {
    // --- AJAX CALL 1: Grafik dan Tabel Sebaran Jenis Instansi ---
    $.ajax({
        url: "{{ url('admin/dashboard/instansi-chart') }}", // Ensure this URL exists and returns data for instansi chart
        method: 'GET',
        success: function(response) {
            console.log("Instansi Chart Response:", response);

            // Chart data for Instansi
            const labelsInstansi = response.map(item => item.jenis_instansi);
            const valuesInstansi = response.map(item => item.total);

            const ctxInstansi = document.getElementById('instansiChart').getContext('2d');
            new Chart(ctxInstansi, {
                type: 'pie',
                data: {
                    labels: labelsInstansi,
                    datasets: [{
                        data: valuesInstansi,
                        backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545', '#6610f2', '#fd7e14', '#20c997'] // More colors for potentially more categories
                    }]
                },
                options: {
                    responsive: true,
                    legend: { display: true, position: 'bottom' }
                }
            });

            // Table data for Instansi (Assuming you have a table with id="instansiTable")
            // Note: Your HTML snippet for tables did not include a specific table for "Instansi",
            // only for "Alumni", "Average Waiting Time", and "Satisfaction".
            // If you need a table for Instansi data, you'll need to add its HTML structure.
            // For now, I'm commenting out the table population part to avoid errors if the table doesn't exist.
            /*
            let tableBodyInstansi = '';
            response.forEach((item, index) => {
                tableBodyInstansi += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jenis_instansi}</td>
                        <td>${item.total}</td>
                    </tr>
                `;
            });
            $('#instansiTable tbody').html(tableBodyInstansi);
            */
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error for Instansi Chart:', status, error);
            // alert('Gagal memuat data grafik instansi'); // Alert might be annoying in production
        }
    });

    // --- AJAX CALL 2: Grafik dan Tabel Sebaran Profesi Lulusan ---
    $.ajax({
        url: "{{ url('admin/dashboard/profesi-chart') }}", // Ensure this URL exists and returns data for profesi chart
        method: 'GET',
        success: function(response) {
            console.log("Profesi Chart Response:", response);

            // Chart data for Profesi
            const labelsProfesi = response.map(p => p.profesi);
            const valuesProfesi = response.map(p => p.total);

            const ctxProfesi = document.getElementById('profesiChart').getContext('2d');
            new Chart(ctxProfesi, {
                type: 'pie',
                data: {
                    labels: labelsProfesi,
                    datasets: [{
                        data: valuesProfesi,
                        backgroundColor: [
                            '#007bff', '#ffc107', '#28a745', '#dc3545',
                            '#6610f2', '#fd7e14', '#20c997', '#6f42c1',
                            '#e83e8c', '#17a2b8', '#adb5bd', '#343a40' // Added more colors
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    legend: { display: true, position: 'bottom' }
                }
            });

            // Table data for Profesi (Assuming you have a table with id="profesiTable")
            // Similar to Instansi, commenting out table population if the HTML table structure is missing.
            /*
            let tableBodyProfesi = '';
            response.forEach((p, i) => {
                tableBodyProfesi += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${p.profesi}</td>
                        <td>${p.total}</td>
                    </tr>
                `;
            });
            $('#profesiTable tbody').html(tableBodyProfesi);
            */
        },
        error: function(err) {
            console.error("AJAX Error for Profesi Chart:", err);
            // alert("Gagal memuat data profesi.");
        }
    });

    // --- AJAX CALL 3: Tabel Sebaran Profesi Alumni (main table) ---
    $.ajax({
        url: "{{ url('/admin/dashboard/rekap-alumni') }}", // This should call your getRekapAlumni function
        method: 'GET',
        success: function(response) {
            console.log("Rekap Alumni Response:", response); // Log the raw response

            // The PHP backend (getRekapAlumni) should already provide aggregated data per year.
            // So, no need for client-side aggregation (summarizedData logic removed).
            let finalTableData = response; // Directly use the response

            // Sort by tahunlulus to ensure correct order
            finalTableData.sort((a, b) => a.tahunlulus - b.tahunlulus);

            let tbody = '';
            let totalJumlahlulusan = 0;
            let totalTerlacaklulusan = 0;
            let totalInfokom = 0;
            let totalNonInfokom = 0;
            let totalMultinasional = 0;
            let totalNasional = 0;
            let totalWirausaha = 0;

            finalTableData.forEach(function(item) {
                tbody += `
                    <tr>
                        <td>${item.tahunlulus}</td>
                        <td>${item.jumlahlulusan}</td>
                        <td>${item.terlacaklulusan}</td>
                        <td>${item.infokom}</td>
                        <td>${item.noninfokom}</td>
                        <td>${item.multinasional}</td>
                        <td>${item.nasional}</td>
                        <td>${item.wirausaha}</td>
                    </tr>
                `;
                totalJumlahlulusan += parseInt(item.jumlahlulusan) || 0;
                totalTerlacaklulusan += parseInt(item.terlacaklulusan) || 0;
                totalInfokom += parseInt(item.infokom) || 0;
                totalNonInfokom += parseInt(item.noninfokom) || 0;
                totalMultinasional += parseInt(item.multinasional) || 0;
                totalNasional += parseInt(item.nasional) || 0;
                totalWirausaha += parseInt(item.wirausaha) || 0;
            });

            // Add the "Jumlah" row
            tbody += `
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td>Jumlah</td>
                    <td>${totalJumlahlulusan}</td>
                    <td>${totalTerlacaklulusan}</td>
                    <td>${totalInfokom}</td>
                    <td>${totalNonInfokom}</td>
                    <td>${totalMultinasional}</td>
                    <td>${totalNasional}</td>
                    <td>${totalWirausaha}</td>
                </tr>
            `;

            $('#tabelAlumni tbody').html(tbody);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error for Tabel Sebaran Profesi:", status, error);
            // Handle error appropriately
        }
    });

    // --- AJAX CALL 4: Tabel Rata-rata Masa Tunggu ---
    $.ajax({
        url: "{{ url('/admin/dashboard/average-waiting-time') }}",
        method: 'GET',
        success: function(response) {
            console.log("Average Waiting Time Response:", response);

            let tbody = '';
            let totalJumlahlulusan = 0;
            let totalTerlacaklulusan = 0;
            let totalWeightedWaitingTime = 0; // Sum of (avg_time * count)
            let totalWeightedWaitingCount = 0; // Sum of counts that contributed to avg_time

            response.forEach(function(item) {
                tbody += `
                    <tr>
                        <td>${item.tahunlulus}</td>
                        <td>${item.jumlahlulusan}</td>
                        <td>${item.terlacaklulusan}</td>
                        <td>${item.rata_rata_waktu_tunggu_bulan}</td>
                    </tr>
                `;
                totalJumlahlulusan += parseInt(item.jumlahlulusan) || 0;
                totalTerlacaklulusan += parseInt(item.terlacaklulusan) || 0;

                // For overall average: use raw numerical values from PHP if available
                const avgTime = parseFloat(item.rata_rata_waktu_tunggu_bulan);
                const trackedCount = parseInt(item.terlacaklulusan) || 0;

                if (!isNaN(avgTime) && trackedCount > 0) {
                    totalWeightedWaitingTime += avgTime * trackedCount;
                    totalWeightedWaitingCount += trackedCount;
                }
            });

            let overallAverageWaitingTime = 'N/A';
            if (totalWeightedWaitingCount > 0) {
                overallAverageWaitingTime = (totalWeightedWaitingTime / totalWeightedWaitingCount).toFixed(2);
            }

            // Add the "Jumlah" row
            tbody += `
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td>Jumlah</td>
                    <td>${totalJumlahlulusan}</td>
                    <td>${totalTerlacaklulusan}</td>
                    <td>${overallAverageWaitingTime}</td>
                </tr>
            `;

            $('#tabelAverageWaitingTime tbody').html(tbody);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error for Average Waiting Time:", status, error);
            // Handle error appropriately
        }
    });

    // --- AJAX CALL 5: Tabel Penilaian Kepuasan Pengguna Lulusan ---
    $.ajax({
        url: "{{ url('/admin/dashboard/alumni-satisfaction') }}",
        method: 'GET',
        success: function(response) {
            console.log("Alumni Satisfaction Response:", response);

            let tbody = '';
            let no = 1;

            let totalSangatBaikRaw = 0;
            let totalBaikRaw = 0;
            let totalCukupRaw = 0;
            let totalKurangRaw = 0;
            let skillCount = response.length;

            response.forEach(function(item) {
                tbody += `
                    <tr>
                        <td>${no++}</td>
                        <td>${item.jenis_kemampuan}</td>
                        <td>${item.sangat_baik_persen}</td>
                        <td>${item.baik_persen}</td>
                        <td>${item.cukup_persen}</td>
                        <td>${item.kurang_persen}</td>
                    </tr>
                `;
                totalSangatBaikRaw += item.sangat_baik_raw;
                totalBaikRaw += item.baik_raw;
                totalCukupRaw += item.cukup_raw;
                totalKurangRaw += item.kurang_raw;
            });

            // Calculate overall averages for satisfaction percentages
            let avgSangatBaik = (skillCount > 0) ? (totalSangatBaikRaw / skillCount).toFixed(2) + '%' : '0.00%';
            let avgBaik = (skillCount > 0) ? (totalBaikRaw / skillCount).toFixed(2) + '%' : '0.00%';
            let avgCukup = (skillCount > 0) ? (totalCukupRaw / skillCount).toFixed(2) + '%' : '0.00%';
            let avgKurang = (skillCount > 0) ? (totalKurangRaw / skillCount).toFixed(2) + '%' : '0.00%';

            // Add the "Jumlah" row
            tbody += `
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td></td> <td>Jumlah</td>
                    <td>${avgSangatBaik}</td>
                    <td>${avgBaik}</td>
                    <td>${avgCukup}</td>
                    <td>${avgKurang}</td>
                </tr>
            `;

            $('#tabelAlumniSatisfaction tbody').html(tbody);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error for Alumni Satisfaction:", status, error);
            // Handle error appropriately
        }
    });
});
</script>
@endpush