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
}
