<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ChartController extends Controller
{
    public function getChartData(Request $request)
    {
        // Simulasi query database SQLite berdasarkan filter hari
        $days = $request->get('days', 7);
        
        // Dummy Data Generator
        $data = [];
        $categories = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $categories[] = $date->format('D'); // Nama hari: Sen, Sel, dsb
            $data[] = rand(20, 150); // Simulasi jumlah task/aktivitas
        }

        return Response::json([
            'series' => [[
                'name' => 'Aktivitas',
                'data' => $data
            ]],
            'categories' => $categories
        ]);
    }
}
