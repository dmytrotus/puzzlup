<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Models\Temperature;
use App\Mail\TemperatureNotification;
use Illuminate\Support\Facades\Mail;
use App\Services\TemperatureObserver;
use App\Interfaces\ThermostatInterface;

class ThermostatService implements ThermostatInterface
{
    private $minTemp = 15;

    public function saveData(array $data): JsonResponse
    {
        $deviceId = $data['device_id'];
        $temperature = (int) $data['temperature'];
        $date = $data['date'];

        if ($temperature < $this->minTemp) {
            $this->observer = new TemperatureObserver($deviceId, $temperature);
            $this->observer->sendNotification();
        }

        Temperature::create([
            'device_id' => $deviceId,
            'temperature' => $temperature,
            'date' => $date
        ]);

        return response()->json([
            'message' => __('the_temperature_is_saved')
        ]);
    }
}
