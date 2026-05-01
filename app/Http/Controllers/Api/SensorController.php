<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorController extends Controller
{
    public function store(Request $request)
    {
    $data = SensorData::create([
        'device_id' => $request->device_id,
        'temperature' => $request->temperature,
        'humidity' => $request->humidity,
        'soil_moisture' => $request->soil_moisture // ← tambahin ini
    ]);

    return response()->json([
        'message' => 'Data berhasil disimpan',
        'data' => $data
    ]);
    }

    public function latest()
    {
    return response()->json(
        \App\Models\SensorData::latest()->take(20)->get()
    );
    }

}