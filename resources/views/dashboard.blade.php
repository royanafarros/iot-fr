<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard IoT Monitoring</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="10">

    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: white; }
        .header { padding: 25px; text-align: center; background: #1e293b; font-size: 26px; font-weight: bold; border-bottom: 2px solid #334155; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .container { display: flex; justify-content: center; gap: 20px; margin-top: 40px; flex-wrap: wrap; padding: 0 20px; }
        
        /* Card Styling */
        .card { background: #1e293b; padding: 25px; border-radius: 20px; width: 200px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); transition: all 0.3s ease; border: 1px solid #334155; position: relative; overflow: hidden; }
        .card:hover { transform: translateY(-8px); border-color: #38bdf8; box-shadow: 0 15px 30px rgba(56, 189, 248, 0.2); }
        
        .value { font-size: 36px; margin-top: 10px; font-weight: bold; color: #38bdf8; }
        .label { font-size: 13px; opacity: 0.6; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }

        /* Progress Bar for Soil */
        .progress-container { width: 100%; background-color: #334155; border-radius: 10px; margin-top: 15px; height: 8px; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, #38bdf8, #818cf8); border-radius: 10px; transition: width 1s ease-in-out; }

        /* Pump Status Badge */
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 50px; font-size: 12px; font-weight: bold; margin-top: 10px; }
        .status-active { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; animation: pulse 2s infinite; }
        .status-inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444; }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        /* Controls */
        .control-section { text-align: center; margin: 50px auto; background: #1e293b; padding: 30px; max-width: 450px; border-radius: 24px; border: 1px solid #334155; }
        .btn-group { display: flex; justify-content: center; gap: 15px; margin-top: 25px; }
        .btn { flex: 1; padding: 15px; border: none; border-radius: 15px; color: white; font-size: 15px; font-weight: bold; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-on { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
        .btn-on:hover { transform: scale(1.05); filter: brightness(1.1); }
        .btn-off { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .btn-off:hover { transform: scale(1.05); filter: brightness(1.1); }

        .time { margin-top: 30px; text-align: center; opacity: 0.4; font-size: 12px; font-style: italic; }
    </style>
</head>
<body>

<div class="header">MONITORING IOT POMPA</div>

<div class="container">
    <div class="card">
        <div class="label">Suhu Udara</div>
        <div class="value">{{ $data->temperature ?? 0 }}°C</div>
    </div>

    <div class="card">
        <div class="label">Kelembapan Udara</div>
        <div class="value">{{ $data->humidity ?? 0 }}%</div>
    </div>

    <div class="card">
        <div class="label">Kelembapan Tanah</div>
        @php 
            $soilPercent = isset($data->soil_moisture) ? round(($data->soil_moisture / 4095) * 100) : 0;
            // Membalikkan logika jika 4095 = kering, 0 = basah
            $soilPercentReal = 100 - $soilPercent; 
        @endphp
        <div class="value">{{ $soilPercentReal }}%</div>
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $soilPercentReal }}%"></div>
        </div>
    </div>

    <div class="card">
        <div class="label">Status Pompa</div>
        <div class="value" style="font-size: 20px; margin-top: 15px;">
            @if(($lastCommand->command ?? '') == 'PUMP_ON')
                <span class="status-badge status-active">PUMPING... 🌊</span>
            @else
                <span class="status-badge status-inactive">STANDBY 🛑</span>
            @endif
        </div>
    </div>
</div>

<div class="control-section">
    <div class="label">Manual Control Center</div>
    <div class="btn-group">
        <button class="btn btn-on" onclick="sendPumpCommand('PUMP_ON')">
            <span>NYALAKAN</span> 💧
        </button>
        <button class="btn btn-off" onclick="sendPumpCommand('PUMP_OFF')">
            <span>MATIKAN</span> 🛑
        </button>
    </div>
</div>

<div class="time">
    Last Sync: {{ $data->created_at ?? '-' }} | Device: ESP32_AGRO_01
</div>

<script>
function sendPumpCommand(cmd) {
    const url = 'https://iot-tester-production.up.railway.app/api/command';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Ubah text tombol saat loading
    const btns = document.querySelectorAll('.btn');
    btns.forEach(b => b.style.opacity = '0.5');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ device_id: 'esp32_1', command: cmd })
    })
    .then(async (res) => {
        if (!res.ok) throw await res.json();
        // Refresh otomatis agar UI terupdate dengan status terbaru dari DB
        setTimeout(() => location.reload(), 500);
    })
    .catch(err => {
        console.error("FAIL:", err);
        alert("Gagal terhubung ke server!");
        btns.forEach(b => b.style.opacity = '1');
    });
}
</script>

</body>
</html>