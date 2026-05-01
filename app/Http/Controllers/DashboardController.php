<?php

namespace App\Http\Controllers;

use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        $data = SensorData::latest()->first();

        return view('dashboard', compact('data'));
    }
}