<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Command;
// --- TAMBAHKAN BARIS INI ---
use App\Models\SensorData; 
// ---------------------------
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    /**
     * Menampilkan Dashboard (Web)
     */
    public function index() 
    {
        // Mengambil data sensor terakhir
        $data = SensorData::latest()->first(); 
        
        // Mengambil perintah terakhir untuk indikator status di web
        $lastCommand = Command::where('device_id', 'esp32_1')
                              ->orderBy('id', 'desc')
                              ->first(); 

        return view('dashboard', compact('data', 'lastCommand'));
    }

    /**
     * Menerima Command dari Tombol Web (API)
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'device_id' => 'required',
                'command' => 'required|in:PUMP_ON,PUMP_OFF,LED_ON,LED_OFF',
            ]);

            $cmd = Command::create([
                'device_id' => $request->device_id,
                'command' => $request->command,
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Command ' . $request->command . ' sent!',
                'data' => $cmd
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * ESP32 mengambil command terakhir (API)
     */
    public function getCommand($device_id)
    {
        try {
            $cmd = Command::where('device_id', $device_id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if (!$cmd) {
                return response()->json(['command' => null]);
            }

            // Tandai sudah diambil agar tidak dikirim ulang ke ESP32
            $cmd->update(['status' => 'done']);

            return response()->json(['command' => $cmd->command]);

        } catch (\Exception $e) {
            \Log::error("GET COMMAND ERROR: " . $e->getMessage());
            return response()->json(['command' => null, 'error' => 'internal error'], 500);
        }
    }
}