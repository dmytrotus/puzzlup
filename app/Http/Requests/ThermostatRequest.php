<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThermostatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'device_id' => 'required|string|max:255',
            'temperature' => 'required|numeric|integer|between:-40,100',
            'date' => 'required|date_format:d-m-Y H:i:s'
        ];
    }
}
