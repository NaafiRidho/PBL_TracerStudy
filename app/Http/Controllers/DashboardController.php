<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getInstansiChartData()
    {
        $data = DB::table('alumni as a')
            ->join('jenis_instansi as j', 'j.jenis_instansi_id', '=', 'a.jenis_instansi_id')
            ->select('j.jenis_instansi', DB::raw('COUNT(j.jenis_instansi) as total'))
            ->groupBy('j.jenis_instansi')
            ->get();

        return response()->json($data);
    }
    public function getProfesiChart()
    {
        $data = DB::table('alumni as a')
            ->join('profesi as p', 'p.profesi_id', '=', 'a.profesi_id')
            ->select('p.profesi', DB::raw('count(*) as total'))
            ->groupBy('p.profesi')
            ->orderByDesc('total')
            ->get();

        $top10 = $data->take(10);

        $lainnyaTotal = $data->slice(10)->sum('total');

        if ($lainnyaTotal > 0) {
            $top10->push((object)[
                'profesi' => 'Lainnya',
                'total' => $lainnyaTotal,
            ]);
        }

        return response()->json($top10);
    }

    public function getRekapAlumni()
    {
        $results = DB::select("
            SELECT
                YEAR(a.tanggal_lulus) AS tahunlulus,
                COUNT(a.nama_alumni) AS jumlahlulusan,
                SUM(CASE WHEN a.isOtp = 1 THEN 1 ELSE 0 END) AS terlacaklulusan,
                SUM(CASE WHEN kp.kategori_profesi = 'Infokom' THEN 1 ELSE 0 END) AS infokom,
                SUM(CASE WHEN kp.kategori_profesi != 'Infokom' THEN 1 ELSE 0 END) AS noninfokom,
                SUM(CASE WHEN a.skala_instansi = 'International' THEN 1 ELSE 0 END) AS multinasional,
                SUM(CASE WHEN a.skala_instansi = 'Nasional' THEN 1 ELSE 0 END) AS nasional,
                SUM(CASE WHEN a.skala_instansi = 'Wirausaha' THEN 1 ELSE 0 END) AS wirausaha
            FROM
                alumni AS a
            LEFT JOIN
                kategori_profesi AS kp ON kp.kategori_profesi_id = a.kategori_profesi_id
            GROUP BY
                tahunlulus
            ORDER BY
                tahunlulus;
        ");

        return response()->json($results);
    }

    public function getAverageWaitingTime()
    {
        $results = DB::select("
            SELECT
                YEAR(a.tanggal_lulus) AS tahunlulus,
                COUNT(a.nama_alumni) AS jumlahlulusan,
                SUM(CASE WHEN a.isOtp = 1 THEN 1 ELSE 0 END) AS terlacaklulusan,
                -- Calculate average waiting time in months
                AVG(
                    CASE
                        WHEN a.tanggal_kerja_pertama IS NOT NULL AND a.tanggal_lulus IS NOT NULL THEN
                            -- Calculate difference in days, then convert to months (approx. 30.44 days per month)
                            DATEDIFF(a.tanggal_kerja_pertama, a.tanggal_lulus) / 30.44
                        ELSE NULL
                    END
                ) AS rata_rata_waktu_tunggu_bulan
            FROM
                alumni AS a
            WHERE
                -- Only consider alumni with a start date for average calculation
                a.tanggal_kerja_pertama IS NOT NULL AND a.tanggal_lulus IS NOT NULL
            GROUP BY
                tahunlulus
            ORDER BY
                tahunlulus;
        ");

        // Format the average waiting time to two decimal places
        foreach ($results as $result) {
            if ($result->rata_rata_waktu_tunggu_bulan !== null) {
                $result->rata_rata_waktu_tunggu_bulan = number_format((float)$result->rata_rata_waktu_tunggu_bulan, 2, '.', '');
            } else {
                $result->rata_rata_waktu_tunggu_bulan = 'N/A'; // Or 0, or leave as null based on preference
            }
        }

        return response()->json($results);
    }
    public function getAlumniSatisfaction()
    {
        $results = DB::select("
            SELECT
                p.pertanyaan AS jenis_kemampuan,
                SUM(CASE WHEN j.jawaban = 'Sangat Baik' THEN 1 ELSE 0 END) AS sangat_baik_count,
                SUM(CASE WHEN j.jawaban = 'Baik' THEN 1 ELSE 0 END) AS baik_count,
                SUM(CASE WHEN j.jawaban = 'Cukup' THEN 1 ELSE 0 END) AS cukup_count,
                SUM(CASE WHEN j.jawaban = 'Kurang' THEN 1 ELSE 0 END) AS kurang_count,
                COUNT(j.jawaban_id) AS total_responses -- Count total responses for this question
            FROM
                jawaban AS j
            JOIN
                pertanyaan AS p ON p.pertanyaan_id = j.pertanyaan_id
            WHERE p.pertanyaan_id NOT IN (8,9)
            GROUP BY
                p.pertanyaan_id, p.pertanyaan -- Group by both ID and text to ensure correct grouping and ordering
            ORDER BY
                p.pertanyaan_id; -- Order by ID to maintain a consistent order if you add new questions
        ");

        // Calculate percentages and format them
        $formattedResults = [];
        foreach ($results as $item) {
            $total = (int)$item->total_responses; // Ensure total is an integer for division

            $sangat_baik_persen = ($total > 0) ? ($item->sangat_baik_count / $total) * 100 : 0;
            $baik_persen = ($total > 0) ? ($item->baik_count / $total) * 100 : 0;
            $cukup_persen = ($total > 0) ? ($item->cukup_count / $total) * 100 : 0;
            $kurang_persen = ($total > 0) ? ($item->kurang_count / $total) * 100 : 0;

            $formattedResults[] = (object) [
                'jenis_kemampuan' => $item->jenis_kemampuan,
                'sangat_baik_persen' => number_format($sangat_baik_persen, 2, '.', '') . '%',
                'baik_persen' => number_format($baik_persen, 2, '.', '') . '%',
                'cukup_persen' => number_format($cukup_persen, 2, '.', '') . '%',
                'kurang_persen' => number_format($kurang_persen, 2, '.', '') . '%',
                'sangat_baik_raw' => $sangat_baik_persen, // Keep raw for total calculation
                'baik_raw' => $baik_persen,
                'cukup_raw' => $cukup_persen,
                'kurang_raw' => $kurang_persen,
            ];
        }

        return response()->json($formattedResults);
    }
    public function getKerjaSama()
    {
        $results = DB::select("
        SELECT
    p.pertanyaan AS jenis_kemampuan,
    j.jawaban AS tingkat_kepuasan,
    COUNT(j.jawaban_id) AS jumlah_responden_per_tingkat
FROM
    jawaban AS j
JOIN
    pertanyaan AS p ON j.pertanyaan_id = p.pertanyaan_id
WHERE
	p.pertanyaan_id = 1 
  AND j.jawaban IN ('Sangat Baik', 'Baik', 'Cukup', 'Kurang') -- Ensure only valid satisfaction levels are counted
GROUP BY
    p.pertanyaan,
    j.jawaban
ORDER BY
    p.pertanyaan,
    CASE j.jawaban
        WHEN 'Sangat Baik' THEN 1
        WHEN 'Baik' THEN 2
        WHEN 'Cukup' THEN 3
        WHEN 'Kurang' THEN 4
        ELSE 5
    END;");
        return response()->json($results);
    }

    public function keahlianChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select('p.pertanyaan as jenis_kemampuan', 'j.jawaban as tingkat_kepuasan', DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat'))
            ->where('p.pertanyaan_id', 2)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
    public function kemampuanBahasaChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select('p.pertanyaan as jenis_kemampuan', 'j.jawaban as tingkat_kepuasan', DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat'))
            ->where('p.pertanyaan_id', 3)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
    public function kemampuanKomunikasiChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select('p.pertanyaan as jenis_kemampuan', 'j.jawaban as tingkat_kepuasan', DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat'))
            ->where('p.pertanyaan_id', 4)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
    public function pengembanganDiriChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select('p.pertanyaan as jenis_kemampuan', 'j.jawaban as tingkat_kepuasan', DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat'))
            ->where('p.pertanyaan_id', 5)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
    public function kepemimpinanChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select('p.pertanyaan as jenis_kemampuan', 'j.jawaban as tingkat_kepuasan', DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat'))
            ->where('p.pertanyaan_id', 6)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
    public function etosKerjaChart()
    {
        $data = DB::table('jawaban as j')
            ->join('pertanyaan as p', 'j.pertanyaan_id', '=', 'p.pertanyaan_id')
            ->select(
                'p.pertanyaan as jenis_kemampuan',
                'j.jawaban as tingkat_kepuasan',
                DB::raw('COUNT(j.jawaban_id) as jumlah_responden_per_tingkat')
            )
            ->where('p.pertanyaan_id', 7)
            ->whereIn('j.jawaban', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])
            ->groupBy('p.pertanyaan', 'j.jawaban')
            ->orderByRaw("
            CASE j.jawaban
                WHEN 'Sangat Baik' THEN 1
                WHEN 'Baik' THEN 2
                WHEN 'Cukup' THEN 3
                WHEN 'Kurang' THEN 4
                ELSE 5
            END
        ")
            ->get();

        return response()->json($data);
    }
}
