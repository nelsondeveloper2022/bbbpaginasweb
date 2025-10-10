<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasarelaRequest extends FormRequest
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
            'nombre_pasarela' => 'required|string|in:wompi,payu,stripe,mercadopago,paypal',
            'public_key' => 'required|string|max:500',
            'private_key' => 'required|string|max:500',
            'activo' => 'boolean',
            
            // Campos específicos para Wompi
            'sandbox' => 'nullable|boolean',
            'webhook_url' => 'nullable|url|max:500',
            
            // Campos específicos para otras pasarelas (se pueden expandir)
            'merchant_id' => 'nullable|string|max:200',
            'api_key' => 'nullable|string|max:500',
            'secret_key' => 'nullable|string|max:500'
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
            'nombre_pasarela.required' => 'Debe seleccionar una pasarela de pago.',
            'nombre_pasarela.in' => 'La pasarela seleccionada no es válida.',
            'public_key.required' => 'La clave pública es obligatoria.',
            'public_key.max' => 'La clave pública no puede exceder 500 caracteres.',
            'private_key.required' => 'La clave privada es obligatoria.',
            'private_key.max' => 'La clave privada no puede exceder 500 caracteres.',
            'activo.boolean' => 'El estado debe ser activo o inactivo.',
            'sandbox.boolean' => 'El modo sandbox debe ser verdadero o falso.',
            'webhook_url.url' => 'La URL del webhook debe ser válida.',
            'webhook_url.max' => 'La URL del webhook no puede exceder 500 caracteres.',
            'merchant_id.max' => 'El ID del comerciante no puede exceder 200 caracteres.',
            'api_key.max' => 'La API key no puede exceder 500 caracteres.',
            'secret_key.max' => 'La clave secreta no puede exceder 500 caracteres.'
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
            'nombre_pasarela' => 'pasarela de pago',
            'public_key' => 'clave pública',
            'private_key' => 'clave privada',
            'activo' => 'estado',
            'sandbox' => 'modo sandbox',
            'webhook_url' => 'URL del webhook',
            'merchant_id' => 'ID del comerciante',
            'api_key' => 'API key',
            'secret_key' => 'clave secreta'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convertir checkboxes a boolean
        $this->merge([
            'activo' => $this->boolean('activo', true),
            'sandbox' => $this->boolean('sandbox', false)
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validaciones específicas según la pasarela
            $pasarela = $this->input('nombre_pasarela');
            
            switch ($pasarela) {
                case 'wompi':
                    $this->validateWompi($validator);
                    break;
                    
                case 'payu':
                    $this->validatePayU($validator);
                    break;
                    
                case 'stripe':
                    $this->validateStripe($validator);
                    break;
                    
                case 'mercadopago':
                    $this->validateMercadoPago($validator);
                    break;
                    
                case 'paypal':
                    $this->validatePayPal($validator);
                    break;
            }
        });
    }

    /**
     * Validate Wompi specific fields.
     */
    private function validateWompi($validator)
    {
        // Validar formato de clave pública de Wompi
        $publicKey = $this->input('public_key');
        if ($publicKey && !str_starts_with($publicKey, 'pub_')) {
            $validator->errors()->add('public_key', 'La clave pública de Wompi debe comenzar con "pub_"');
        }

        // Validar formato de clave privada de Wompi
        $privateKey = $this->input('private_key');
        if ($privateKey && !str_starts_with($privateKey, 'prv_')) {
            $validator->errors()->add('private_key', 'La clave privada de Wompi debe comenzar con "prv_"');
        }
    }

    /**
     * Validate PayU specific fields.
     */
    private function validatePayU($validator)
    {
        // Validaciones específicas para PayU
        if (!$this->filled('merchant_id')) {
            $validator->errors()->add('merchant_id', 'El ID del comerciante es requerido para PayU.');
        }
    }

    /**
     * Validate Stripe specific fields.
     */
    private function validateStripe($validator)
    {
        // Validar formato de clave pública de Stripe
        $publicKey = $this->input('public_key');
        if ($publicKey && !str_starts_with($publicKey, 'pk_')) {
            $validator->errors()->add('public_key', 'La clave pública de Stripe debe comenzar con "pk_"');
        }

        // Validar formato de clave privada de Stripe
        $privateKey = $this->input('private_key');
        if ($privateKey && !str_starts_with($privateKey, 'sk_')) {
            $validator->errors()->add('private_key', 'La clave privada de Stripe debe comenzar con "sk_"');
        }
    }

    /**
     * Validate MercadoPago specific fields.
     */
    private function validateMercadoPago($validator)
    {
        // Validaciones específicas para MercadoPago
        // La public_key es el Access Token
        // La private_key es el Client Secret
    }

    /**
     * Validate PayPal specific fields.
     */
    private function validatePayPal($validator)
    {
        // Validaciones específicas para PayPal
        // La public_key es el Client ID
        // La private_key es el Client Secret
    }
}