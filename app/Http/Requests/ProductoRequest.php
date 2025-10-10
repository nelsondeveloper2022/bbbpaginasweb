<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
        $rules = [
            'nombre' => 'required|string|max:200',
            'referencia' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string|max:5000',
            'precio' => 'required|numeric|min:0|max:999999999.99',
            'costo' => 'nullable|numeric|min:0|max:999999999.99',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            'galeria.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ];

        // Si es creación, la imagen puede ser requerida
        if ($this->isMethod('post')) {
            // Hacer opcional la imagen en creación también
            $rules['imagen'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre del producto no puede exceder 200 caracteres.',
            'referencia.max' => 'La referencia no puede exceder 200 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio excede el límite permitido.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp.',
            'imagen.max' => 'La imagen no puede exceder 5MB.',
            'galeria.*.image' => 'Todos los archivos de la galería deben ser imágenes válidas.',
            'galeria.*.mimes' => 'Las imágenes de la galería deben ser de tipo: jpeg, png, jpg, gif o webp.',
            'galeria.*.max' => 'Cada imagen de la galería no puede exceder 5MB.'
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
            'nombre' => 'nombre del producto',
            'descripcion' => 'descripción',
            'precio' => 'precio',
            'costo' => 'costo',
            'stock' => 'stock',
            'estado' => 'estado',
            'imagen' => 'imagen principal',
            'galeria' => 'galería de imágenes'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar el precio y costo de caracteres especiales si vienen formateados
        if ($this->filled('precio')) {
            $precio = str_replace(['.', ','], ['', '.'], $this->input('precio'));
            $this->merge([
                'precio' => $precio
            ]);
        }

        if ($this->filled('costo')) {
            $costo = str_replace(['.', ','], ['', '.'], $this->input('costo'));
            $this->merge([
                'costo' => $costo
            ]);
        }
    }
}