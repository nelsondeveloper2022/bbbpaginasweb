<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'movil' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/',
            'empresa_nombre' => 'required|string|max:255|min:2',
            'empresa_email' => 'required|string|email|max:255',
            'empresa_direccion' => 'nullable|string|max:500',
            'plan_id' => 'required|exists:bbbplan,idPlan',
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
            'name.required' => 'El nombre de contacto es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            
            'email.required' => 'El email personal es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado. ¿Ya tienes cuenta?',
            
            'movil.required' => 'El número móvil es obligatorio.',
            'movil.regex' => 'El número móvil debe tener un formato válido.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.',
            
            'empresa_nombre.required' => 'El nombre de la empresa es obligatorio.',
            'empresa_nombre.min' => 'El nombre de la empresa debe tener al menos 2 caracteres.',
            'empresa_nombre.max' => 'El nombre de la empresa no puede exceder 255 caracteres.',
            
            'empresa_email.required' => 'El email corporativo es obligatorio.',
            'empresa_email.email' => 'El email corporativo debe tener un formato válido.',
            
            'empresa_direccion.max' => 'La dirección no puede exceder 500 caracteres.',
            
            'plan_id.required' => 'Debes seleccionar un plan.',
            'plan_id.exists' => 'El plan seleccionado no es válido.',
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
            'name' => 'nombre de contacto',
            'email' => 'email personal',
            'movil' => 'número móvil',
            'password' => 'contraseña',
            'empresa_nombre' => 'nombre de la empresa',
            'empresa_email' => 'email corporativo',
            'empresa_direccion' => 'dirección',
            'plan_id' => 'plan',
        ];
    }
}