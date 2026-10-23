<x-mail::message>

{{-- ENCABEZADO CORPORATIVO PERSONALIZADO --}}
<div style="text-align: center; margin: 0 auto 20px auto;">
    <h2 style="color: #1e3a8a; margin: 0; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; text-transform: uppercase; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">EMPLEAMOS TEMPORALES</h2>
    <p style="color: #64748b; font-size: 11px; margin: 4px 0 0 0; text-transform: uppercase; letter-spacing: 2px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Soluciones en Talento Humano</p>
</div>

<x-mail::panel>
{{-- Saludo --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('¡Atención!')
@else
# @lang('¡Hola!')
@endif
@endif

{{-- Líneas de introducción --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach
</x-mail::panel>

{{-- Botón de acción --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<div style="text-align: center; margin: 30px 0;">
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
</div>
@endisset

{{-- Líneas secundarias --}}
@foreach ($outroLines as $line)
<span style="color: #64748b; font-size: 13px; line-height: 1.5; display: block; margin-bottom: 8px;">{{ $line }}</span>

@endforeach

<div style="margin-top: 25px; color: #0f172a; font-size: 14px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
<p style="margin: 0; color: #64748b;">Atentamente,</p>
<p style="margin: 4px 0 0 0; font-weight: bold; color: #1e3a8a;">Equipo de Empleamos Temporales</p>
</div>

{{-- Subcopy / Enlace de respaldo en el pie --}}
@isset($actionText)
<x-slot:subcopy>
<div style="text-align: center; font-size: 12px; color: #94a3b8; margin-top: 25px; line-height: 1.5;">
@lang(
    "Si tienes problemas para hacer clic en el botón \":actionText\", copia y pega la siguiente URL\n".
    'en tu navegador web:',
    [
        'actionText' => $actionText,
    ]
) <br>
<a href="{{ $actionUrl }}" style="color: #2563eb; text-decoration: underline; word-break: break-all;">{{ $actionUrl }}</a>
</div>

<div style="text-align: center; font-size: 11px; color: #cbd5e1; margin-top: 15px;">
    &copy; {{ date('Y') }} Empleamos Temporales. Todos los derechos reservados.
</div>
</x-slot:subcopy>
@endisset

</x-mail::message>