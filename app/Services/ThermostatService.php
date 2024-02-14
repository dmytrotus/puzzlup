<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Models\Temperature;
use App\Mail\TemperatureNotification;
use Mail;

class ThermostatService
{
    private $minTemp = 15;
    private $adminMail = 'myemail@example.com';

    public function saveData(array $data): JsonResponse
    {
        $deviceId = $data['device_id'];
        $temperature = (int) $data['temperature'];
        $date = $data['date'];

        if ($temperature < $this->minTemp) {
            Mail::to($this->adminMail)
            ->queue(new TemperatureNotification($deviceId, $temperature));
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
