<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }
        .container {
            background: #fff;
            padding: 20px 30px;
            margin: auto;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            max-width: 600px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        td {
            padding: 8px 5px;
            vertical-align: top;
        }
        td.label {
            font-weight: bold;
            width: 40%;
            color: #555;
        }
        .footer {
            margin-top: 25px;
            font-size: 0.9em;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📌 Recordatorio programado</h2>

    <table>
        <tr>
            <td class="label">Título:</td>
            <td>{{ $recordatorio->titulo }}</td>
        </tr>

            <tr>
            <td class="label">Empresa:</td>
            <td>{{ $recordatorio->empresa }}</td>
        </tr>

        <tr>
            <td class="label">Descripción:</td>
            <td>{{ $recordatorio->descripcion }}</td>
        </tr>
        <tr>
            <td class="label">Fecha programada:</td>
            <td>{{ $recordatorio->fecha_programada->format('Y-m-d') }}</td>
        </tr>
        @if ($recordatorio->fecha_limite)
        <tr>
            <td class="label">Fecha límite:</td>
            <td>{{ $recordatorio->fecha_limite->format('Y-m-d') }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Estado:</td>
            <td>{{ ucfirst($recordatorio->estado) }}</td>
        </tr>
        <tr>
            <td class="label">Frecuencia:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $recordatorio->frecuencia)) }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">⏰ Este es un aviso automático, ya que se aproxima la fecha del evento programado. Por favor, asegúrate de tomar acción si corresponde.</p>

    <div class="footer">
        Este correo fue generado automáticamente por el sistema de recordatorios de tecnología.<br>
        No respondas a este mensaje. Si tienes dudas, comunícate con el área de soporte.
    </div>
</div>
</body>
</html>
