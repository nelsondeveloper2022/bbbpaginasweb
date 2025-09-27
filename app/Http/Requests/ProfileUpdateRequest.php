<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Solo campos personales del usuario
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(Auth::id()),
            ],
            'movil' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.string' => 'El nombre completo debe ser texto válido.',
            'name.max' => 'El nombre completo no puede tener más de 255 caracteres.',
            'email.required' => 'El email personal es obligatorio.',
            'email.string' => 'El email personal debe ser texto válido.',
            'email.lowercase' => 'El email personal debe estar en minúsculas.',
            'email.email' => 'El email personal debe tener un formato válido.',
            'email.max' => 'El email personal no puede tener más de 255 caracteres.',
            'email.unique' => 'Este email ya está registrado en el sistema.',
            'movil.string' => 'El teléfono móvil debe ser texto válido.',
            'movil.max' => 'El teléfono móvil no puede tener más de 20 caracteres.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre completo',
            'email' => 'email personal',
            'movil' => 'teléfono móvil',
        ];
    }
}
