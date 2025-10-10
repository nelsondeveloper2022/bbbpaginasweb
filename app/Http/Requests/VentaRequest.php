<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
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
            'idCliente' => 'required|exists:bbbclient,idCliente',
            'estado' => 'required|in:pendiente,procesando,completada,cancelada',
            'metodo_pago' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'totalEnvio' => 'nullable|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.idProducto' => 'required|exists:bbbproductos,idProducto',
            'productos.*.cantidad' => 'required|integer|min:1|max:1000',
            
            // Campos del cliente si no existe
            'cliente_nombre' => 'required_if:idCliente,null|string|max:200',
            'cliente_email' => 'required_if:idCliente,null|email|max:200',
            'cliente_telefono' => 'nullable|string|max:20',
            'cliente_direccion' => 'nullable|string|max:500'
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
            'idCliente.exists' => 'El cliente seleccionado no es válido.',
            'estado.required' => 'El estado de la venta es obligatorio.',
            'estado.in' => 'El estado debe ser: pendiente, procesando, completada o cancelada.',
            'metodo_pago.max' => 'El método de pago no puede exceder 100 caracteres.',
            'observaciones.max' => 'Las observaciones no pueden exceder 1000 caracteres.',
            'productos.required' => 'Debe seleccionar al menos un producto.',
            'productos.array' => 'Los productos deben ser una lista válida.',
            'productos.min' => 'Debe seleccionar al menos un producto.',
            'productos.*.idProducto.required' => 'Cada producto debe tener un ID válido.',
            'productos.*.idProducto.exists' => 'Uno o más productos seleccionados no son válidos.',
            'productos.*.cantidad.required' => 'La cantidad es obligatoria para cada producto.',
            'productos.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad mínima es 1.',
            'productos.*.cantidad.max' => 'La cantidad máxima es 1000.',
            
            // Mensajes del cliente
            'cliente_nombre.required_if' => 'El nombre del cliente es obligatorio.',
            'cliente_nombre.max' => 'El nombre del cliente no puede exceder 200 caracteres.',
            'cliente_email.required_if' => 'El email del cliente es obligatorio.',
            'cliente_email.email' => 'El email del cliente debe ser válido.',
            'cliente_email.max' => 'El email del cliente no puede exceder 200 caracteres.',
            'cliente_telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'cliente_direccion.max' => 'La dirección no puede exceder 500 caracteres.'
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
            'idCliente' => 'cliente',
            'estado' => 'estado',
            'metodo_pago' => 'método de pago',
            'observaciones' => 'observaciones',
            'productos' => 'productos',
            'productos.*.idProducto' => 'producto',
            'productos.*.cantidad' => 'cantidad',
            'cliente_nombre' => 'nombre del cliente',
            'cliente_email' => 'email del cliente',
            'cliente_telefono' => 'teléfono del cliente',
            'cliente_direccion' => 'dirección del cliente'
        ];
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
            // Validar que todos los productos pertenezcan a la empresa del usuario
            if ($this->has('productos')) {
                $user = auth()->user();
                $empresa = $user->empresa;
                
                if ($empresa) {
                    foreach ($this->productos as $index => $productoData) {
                        if (isset($productoData['idProducto'])) {
                            $producto = \App\Models\BbbProducto::find($productoData['idProducto']);
                            if ($producto && $producto->idEmpresa !== $empresa->idEmpresa) {
                                $validator->errors()->add(
                                    "productos.{$index}.idProducto",
                                    'El producto no pertenece a tu empresa.'
                                );
                            }
                        }
                    }
                }
            }

            // Validar que el cliente pertenezca a la empresa del usuario (si se selecciona uno)
            if ($this->filled('idCliente')) {
                $user = auth()->user();
                $empresa = $user->empresa;
                
                if ($empresa) {
                    $cliente = \App\Models\BbbCliente::find($this->idCliente);
                    if ($cliente && $cliente->idEmpresa !== $empresa->idEmpresa) {
                        $validator->errors()->add('idCliente', 'El cliente no pertenece a tu empresa.');
                    }
                }
            }
        });
    }
}