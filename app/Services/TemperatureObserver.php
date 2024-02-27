<?php

namespace App\Services;

use App\Mail\TemperatureNotification;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\TemperatureObserverInterface;

class TemperatureObserver implements TemperatureObserverInterface
{
    private const MIN_TEMP = 15;
    private const ADMIN_EMAIL = 'myemail@example.com';
    private readonly string $deviceId;
    private readonly int $temperature;


    public function observe(array $data)
    {
        $this->deviceId = $data['device_id'];
        $this->temperature = (int) $data['temperature'];

        if ($this->temperature < TemperatureObserver::MIN_TEMP) {
            $this->sendNotification();
        }
    }

    public function sendNotification(): void
    {
        Mail::to(TemperatureObserver::ADMIN_EMAIL)
            ->queue(new TemperatureNotification($this->deviceId, $this->temperature));
    }
}
