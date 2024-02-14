<?php

namespace App\Services;

use App\Mail\TemperatureNotification;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\TemperatureObserverInterface;

class TemperatureObserver implements TemperatureObserverInterface
{
    private $adminMail = 'myemail@example.com';

    public function __construct(
        private string $deviceId,
        private int $temperature
    ) {
    }

    public function sendNotification(): void
    {
        Mail::to($this->adminMail)
            ->queue(new TemperatureNotification($this->deviceId, $this->temperature));
    }
}