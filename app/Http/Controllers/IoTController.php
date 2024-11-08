<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\DustSensor;
use App\Models\TemperatureSensor;
use Illuminate\Http\Request;

class IoTController extends Controller
{
    public function getAllTemperatureData()
    {
        $data = TemperatureSensor::get();

        return response()->json($data, 200);
    }

    public function writeNewTemperatureData(Request $request)
    {
        $validatedData = $request->validate([
            "temperature" => "required|numeric"
        ]);

        TemperatureSensor::create([
            "temperature" => $validatedData["temperature"]
        ]);

        return response()->json("Successfully add new temperature data", 200);
    }

    public function getAllDustData()
    {
        $data = DustSensor::get();

        return response()->json($data, 200);
    }

    public function writeNewDustData(Request $request)
    {
        $validateData = $request->validate([
            'dust1' => "required|numeric",
            'dust2' => "required|numeric"
        ]);

        DustSensor::create([
            "sensor_1" => $validateData['dust1'],
            "sensor_2" => $validateData['dust2']
        ]);

        return response()->json('Successfully add new dust data', 200);
    }

    public function getAllCommand()
    {
        $data = Command::get();

        return response()->json($data, 200);
    }

    public function writeNewCommand(Request $request)
    {
        $validatedData = $request->validate([
            "command" => "required|boolean"
        ]);

        Command::create([
            'lamp' => $validatedData['command']
        ]);

        return response()->json("Successfully add new command data", 200);
    }
}
