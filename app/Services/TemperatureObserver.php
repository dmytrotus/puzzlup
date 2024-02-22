<?php

namespace App\Services;

use App\Mail\TemperatureNotification;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\TemperatureObserverInterface;

class TemperatureObserver implements TemperatureObserverInterface
{
    private $minTemp = 15;
    private $adminMail = 'myemail@example.com';
    private string $deviceId;
    private int $temperature;


    public function observe(array $data)
    {
        $this->deviceId = $data['device_id'];
        $this->temperature = (int) $data['temperature'];

        if ($this->temperature < $this->minTemp) {
            $this->sendNotification();
        }
    }

    public function sendNotification(): void
    {
        Mail::to($this->adminMail)
            ->queue(new TemperatureNotification($this->deviceId, $this->temperature));
    }
}