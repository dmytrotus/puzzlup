<?php

namespace App\Services;

use App\Services\TemperatureObserver;
use App\Repositories\TemperatureRepository;
use App\Interfaces\ThermostatInterface;

final class ThermostatService implements ThermostatInterface
{
    public function __construct(
        private TemperatureObserver $temperatureObserver,
        private TemperatureRepository $temperatureRepository
    ) {
    }

    public function saveData(array $data): bool
    {
        $this->temperatureObserver->observe($data);
        $this->temperatureRepository->create($data);

        return true;
    }
}
