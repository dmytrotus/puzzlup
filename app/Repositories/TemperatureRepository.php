<?php

namespace App\Repositories;

use App\Models\Temperature;

class TemperatureRepository
{
    public function create(array $data): void
    {
        Temperature::create([
            'device_id' => $data['device_id'],
            'temperature' => (int) $data['temperature'],
            'date' => $data['date']
        ]);
    }
}
