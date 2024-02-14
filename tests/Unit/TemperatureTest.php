<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ThermostatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemperatureNotification;
use Illuminate\Http\JsonResponse;

class TemperatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->dataGoodTemperature = [
            'device_id' => fake()->isbn10(),
            'temperature' => fake()->numberBetween(15, 100),
            'date' => fake()->date('d-m-Y H:i:s')
        ];

        $this->dataBadTemperature = [
            'device_id' => fake()->isbn10(),
            'temperature' => fake()->numberBetween(-40, 14),
            'date' => fake()->date('d-m-Y H:i:s')
        ];
    }

    public function test_that_data_from_thermostat_is_stored_to_the_database(): void
    {
        $thermostatService = new ThermostatService();
        $thermostatService->saveData($this->dataGoodTemperature);

        $castedDate = Carbon::createFromFormat('d-m-Y H:i:s', $this->dataGoodTemperature['date'])
                        ->format('Y-m-d H:i:s');

        $this->assertDatabaseCount('temperatures', 1);

        $this->assertDatabaseHas('temperatures', [
            'device_id' => $this->dataGoodTemperature['device_id'],
            'temperature' => $this->dataGoodTemperature['temperature'],
            'date' => $castedDate,
        ]);
    }

    public function test_that_email_is_not_sent_when_temperature_is_under_15_degrees(): void
    {
        Mail::fake();
        $data = $this->dataGoodTemperature;

        $thermostatService = new ThermostatService();
        $response = $thermostatService->saveData($data);
        $this->assertInstanceOf(JsonResponse::class, $response);

        Mail::assertNothingQueued();
    }

    public function test_that_email_is_sent_when_temperature_is_below_15_degrees(): void
    {
        Mail::fake();
        $data = $this->dataBadTemperature;

        $thermostatService = new ThermostatService();
        $response = $thermostatService->saveData($data);
        $this->assertInstanceOf(JsonResponse::class, $response);

        Mail::assertQueued(TemperatureNotification::class, function ($mail) use ($data) {
            return $mail->deviceId === $data['device_id'] &&
                $mail->temperature === $data['temperature'];
        });
    }
}
