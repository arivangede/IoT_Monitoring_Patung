<?php

namespace App\Http\Controllers;

use App\Models\Iot;
use App\Services\DustAlertService;
use Illuminate\Http\Request;

class IoTController extends Controller
{
    protected $dustAlertService;

    public function __construct(DustAlertService $dustAlertService)
    {
        $this->dustAlertService = $dustAlertService;
    }

    // method for api route
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




        $this->dustAlertService->checkAndSendEmail();


        return response()->json(['Data sensors successfully stored']);
    }

    // method for website to display current/latest sensor data
    public function getCurrentSensorsData()
    {
        $sensorsData = Iot::latest()->first();

        return response()->json($sensorsData);
    }

    // method for get all sensor data and filter minute, hours, days function
    public function getAllSensorsData(Request $request)
    {
        // get filter from query params
        $filter = $request->query('filter', 'jam'); // default data by hours when filter is null
        $iotQuery = Iot::query();

        if ($filter === 'menit') {
            // group data by minutes
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
            // group data by hours
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
            // group data by days
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
            // return all data when filter selected to be "all"
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
