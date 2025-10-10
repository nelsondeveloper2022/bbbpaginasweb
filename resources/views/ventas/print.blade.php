<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta #{{ $venta->idVenta }} - {{ $empresa->nombre }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ddd;
        }

        .company-info h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .company-info p {
            margin: 2px 0;
            color: #666;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-date {
            color: #666;
            margin-bottom: 3px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-completada { background: #d4edda; color: #155724; }
        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-procesando { background: #cce5ff; color: #004085; }
        .status-cancelada { background: #f8d7da; color: #721c24; }

        /* Main Content */
        .content {
            display: flex;
            gap: 30px;
            margin-bottom: 25px;
        }

        .left-column {
            flex: 2;
        }

        .right-column {
            flex: 1;
        }

        /* Client Info */
        .client-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .client-section h3 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .client-info p {
            margin: 3px 0;
        }

        .client-info strong {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Products Table */
        .products-section h3 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .products-table th {
            background: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
        }

        .products-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        .products-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Totals */
        .totals-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px 10px;
            border: none;
        }

        .totals-table .subtotal-row {
            border-bottom: 1px solid #ddd;
        }

        .totals-table .total-row {
            font-weight: bold;
            font-size: 14px;
            color: #2c3e50;
            background: #e9ecef;
        }

        .totals-table .total-row td {
            padding: 10px;
        }

        /* Sale Info */
        .sale-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .sale-info h3 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 3px 0;
        }

        .info-row:not(:last-child) {
            border-bottom: 1px dotted #ddd;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value {
            color: #666;
        }

        /* Observations */
        .observations {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .observations h4 {
            color: #856404;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .observations p {
            color: #856404;
            margin: 0;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }

        /* Print Styles */
        @media print {
            @page {
                size: letter;
                margin: 0.5in;
            }
            
            body {
                margin: 0;
                font-size: 11px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .container {
                margin: 0;
                max-width: none;
                width: 100%;
            }
            
            .no-print {
                display: none !important;
            }
            
            .header {
                page-break-inside: avoid;
                margin-bottom: 15px;
            }
            
            .content {
                gap: 20px;
            }
            
            .products-table {
                page-break-inside: avoid;
                font-size: 10px;
            }
            
            .products-table th,
            .products-table td {
                padding: 6px;
            }
            
            .totals-section {
                page-break-inside: avoid;
                margin-top: 15px;
            }
            
            .client-section,
            .sale-info {
                break-inside: avoid;
                font-size: 10px;
            }
            
            .observations {
                break-inside: avoid;
                margin-top: 15px;
            }
            
            .footer {
                margin-top: 20px;
                font-size: 9px;
            }
        }

        /* Screen only styles */
        @media screen {
            .print-actions {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            }
            
            .print-btn {
                background: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                margin: 0 5px;
                text-decoration: none;
                display: inline-block;
                font-size: 14px;
            }
            
            .print-btn:hover {
                background: #0056b3;
            }
            
            .back-btn {
                background: #6c757d;
            }
            
            .back-btn:hover {
                background: #545b62;
            }
        }
    </style>
</head>
<body>
    <!-- Print Actions (only visible on screen) -->
    <div class="print-actions no-print">
        <button onclick="window.print()" class="print-btn">
            🖨️ Imprimir
        </button>
        <a href="{{ route('admin.ventas.show', $venta) }}" class="print-btn back-btn">
            ← Volver
        </a>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $empresa->nombre }}</h1>
                @if($empresa->email)
                    <p><strong>Email:</strong> {{ $empresa->email }}</p>
                @endif
                @if($empresa->movil)
                    <p><strong>Teléfono:</strong> {{ $empresa->movil }}</p>
                @endif
                @if($empresa->direccion)
                    <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>
                @endif
            </div>
            <div class="invoice-info">
                <div class="invoice-number">Venta #{{ $venta->idVenta }}</div>
                <div class="invoice-date">{{ format_colombian_datetime($venta->fecha) }}</div>
                <div class="status-badge status-{{ $venta->estado }}">
                    {{ ucfirst($venta->estado) }}
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="left-column">
                <!-- Products -->
                <div class="products-section">
                    <h3>📦 Productos ({{ $venta->detalles->count() }})</h3>
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center" width="80">Cant.</th>
                                <th class="text-right" width="100">Precio Unit.</th>
                                <th class="text-right" width="100">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venta->detalles as $detalle)
                                <tr>
                                    <td>
                                        <strong>{{ $detalle->producto->nombre }}</strong>
                                        @if($detalle->producto->descripcion)
                                            <br><small style="color: #666;">{{ Str::limit($detalle->producto->descripcion, 60) }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-right">{{ format_cop_price($detalle->precio_unitario) }}</td>
                                    <td class="text-right"><strong>{{ format_cop_price($detalle->subtotal) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="totals-section">
                    <table class="totals-table">
                        <tr class="subtotal-row">
                            <td><strong>Subtotal:</strong></td>
                            <td class="text-right">{{ format_cop_price($venta->detalles->sum('subtotal')) }}</td>
                        </tr>
                        <tr class="subtotal-row">
                            <td><strong>Envío:</strong></td>
                            <td class="text-right">
                                @if($venta->totalEnvio && $venta->totalEnvio > 0)
                                    {{ format_cop_price($venta->totalEnvio) }}
                                @else
                                    <span style="color: #28a745;">Gratis</span>
                                @endif
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td><strong>TOTAL:</strong></td>
                            <td class="text-right"><strong>{{ format_cop_price($venta->total) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="right-column">
                <!-- Client Info -->
                <div class="client-section">
                    <h3>👤 Cliente</h3>
                    <div class="client-info">
                        <p><strong>Nombre:</strong><br>{{ $venta->cliente->nombre }}</p>
                        <p><strong>Email:</strong><br>{{ $venta->cliente->email }}</p>
                        @if($venta->cliente->telefono)
                            <p><strong>Teléfono:</strong><br>{{ $venta->cliente->telefono }}</p>
                        @endif
                        @if($venta->cliente->direccion)
                            <p><strong>Dirección:</strong><br>{{ $venta->cliente->direccion }}</p>
                        @endif
                        <p><strong>Registrado:</strong><br>{{ format_colombian_date($venta->cliente->created_at) }}</p>
                    </div>
                </div>

                <!-- Sale Info -->
                <div class="sale-info">
                    <h3>📄 Información de Venta</h3>
                    <div class="info-row">
                        <span class="info-label">Método de Pago:</span>
                        <span class="info-value">{{ ucfirst($venta->metodo_pago ?? 'No especificado') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Productos:</span>
                        <span class="info-value">{{ $venta->detalles->sum('cantidad') }} unidades</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado:</span>
                        <span class="info-value">{{ ucfirst($venta->estado) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Observations -->
        @if($venta->observaciones)
        <div class="observations">
            <h4>📝 Observaciones</h4>
            <p>{{ $venta->observaciones }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }} | {{ $empresa->nombre }}</p>
            @if($empresa->website)
                <p>{{ $empresa->website }}</p>
            @endif
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
        
        // Print function for the button
        function printInvoice() {
            window.print();
        }
    </script>
</body>
</html>