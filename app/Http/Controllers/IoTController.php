<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\DustSensor;
use App\Models\Iot;
use App\Models\TemperatureSensor;
use Illuminate\Http\Request;

class IoTController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dustDensity1' => 'numeric',
            'dustDensity2' => 'numeric',
            'temperature' => 'numeric',
            'humidity' => 'numeric',
        ]);

        Iot::create([
            'dust_1' => $validated['dustDensity1'],
            'dust_2' => $validated['dustDensity2'],
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
        ]);

        return response()->json(['Data sensors successfully stored']);
    }

    public function getCurrentSensorsData()
    {
        $sensorsData = Iot::latest()->first();

        return response()->json($sensorsData);
    }

    public function getAllSensorsData(Request $request)
    {
        // Ambil filter berdasarkan menit, jam, atau hari dari query parameter
        $filter = $request->query('filter', 'jam'); // Default ke 'jam' jika tidak ada filter
        $iotQuery = Iot::query();

        if ($filter === 'menit') {
            // Grup berdasarkan menit
            $sensorsData = $iotQuery
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:00") as time_group, 
                         AVG(temperature) as temperature, 
                         AVG(humidity) as humidity, 
                         AVG(dust_1) as dust_1, 
                         AVG(dust_2) as dust_2')
                ->groupBy('time_group')
                ->orderBy('time_group', 'desc')
                ->get();
        } elseif ($filter === 'jam') {
            // Grup berdasarkan jam
            $sensorsData = $iotQuery
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as time_group, 
                         AVG(temperature) as temperature, 
                         AVG(humidity) as humidity, 
                         AVG(dust_1) as dust_1, 
                         AVG(dust_2) as dust_2')
                ->groupBy('time_group')
                ->orderBy('time_group', 'desc')
                ->get();
        } elseif ($filter === 'hari') {
            // Grup berdasarkan hari
            $sensorsData = $iotQuery
                ->selectRaw('DATE(created_at) as time_group, 
                         AVG(temperature) as temperature, 
                         AVG(humidity) as humidity, 
                         AVG(dust_1) as dust_1, 
                         AVG(dust_2) as dust_2')
                ->groupBy('time_group')
                ->orderBy('time_group', 'desc')
                ->get();
        } else {
            // Tetap mengembalikan data dengan time_group tetapi tanpa pengelompokan
            $sensorsData = $iotQuery
                ->selectRaw('created_at as time_group, 
                         temperature, 
                         humidity, 
                         dust_1, 
                         dust_2')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json($sensorsData);
    }
}
