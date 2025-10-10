<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->empresa;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pago_online' => 'boolean',
            'moneda' => 'required|string|in:COP,USD,EUR,MXN,PEN,CLP,ARS'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'pago_online.boolean' => 'El campo de pagos online debe ser verdadero o falso.',
            'moneda.required' => 'La moneda es obligatoria.',
            'moneda.in' => 'La moneda debe ser una de las opciones válidas: COP, USD, EUR, MXN, PEN, CLP, ARS.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'pago_online' => 'recepción de pagos online',
            'moneda' => 'moneda'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convertir el checkbox a boolean
        $this->merge([
            'pago_online' => $this->boolean('pago_online', false)
        ]);
    }
}