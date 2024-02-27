<?php

namespace App\Services;

use App\Repositories\TemperatureRepository;
use App\Interfaces\ThermostatInterface;
use Illuminate\Support\Facades\Event;

final class ThermostatService implements ThermostatInterface
{
    public function __construct(
        private TemperatureRepository $temperatureRepository
    ) {
    }

    public function saveData(array $data): bool
    {
        $this->temperatureRepository->create($data);
        Event::dispatch('temperature.saved', [$data]);

        return true;
    }
}
