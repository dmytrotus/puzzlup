<?php

namespace App\Interfaces;

interface TemperatureObserverInterface
{
    public function sendNotification(): void;
}
