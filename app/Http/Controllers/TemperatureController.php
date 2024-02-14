<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThermostatRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ThermostatService;

class TemperatureController extends Controller
{
    public function __construct(
        private ThermostatService $thermostatService
    ) {
    }

    public function saveTemperature(ThermostatRequest $request): JsonResponse
    {
        return $this->thermostatService->saveData($request->validated());
    }
}
