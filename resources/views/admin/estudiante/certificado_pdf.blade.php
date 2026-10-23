<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        @page { margin: 0px; }
        body {
            margin: 0px;
            /* La imagen sí se queda en public/imagenes/plantilla_certificado.png */
            background-image: url('{{ public_path("imagenes/plantilla_certificado.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Arial', sans-serif;
        }
        .contenedor {
            position: relative;
            width: 100%;
            height: 100%;
        }
      
        .nombre-usuario {
            position: absolute;
            top: 52%; 
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 55px;
            font-family: 'Georgia', serif;
            color: #003366; 
            font-style: italic;
        }
        /* Aquí irá el nombre del área/curso */
        .datos-curso {
            position: absolute;
            top: 68%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18px;
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <!-- Nombre dinámico del estudiante -->
        <div class="nombre-usuario">
            {{ $nombre_usuario }}
        </div>
        
        <div class="datos-curso">
            <p style="margin: 5px 0;">CC. {{ $documento }}</p>
            <p style="margin: 5px 0;"><strong>Por aprobar con éxito el curso/área:</strong></p>
            <!-- Nombre dinámico del curso/área -->
            <p style="margin: 5px 0; font-size: 22px; color: #003366;">{{ $curso_nombre }}</p>
            <p style="margin: 5px 0;">Empleamos Temporales S.A.S - Fecha: {{ $fecha }}</p>
            <p style="margin: 5px 0; font-size: 12px;">Código de verificación: {{ $codigo }}</p>
        </div>
    </div>
</body>
</html>