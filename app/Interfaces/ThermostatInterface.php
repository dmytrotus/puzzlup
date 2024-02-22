<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface ThermostatInterface
{
    public function saveData(array $data): bool;
}
