<?php

namespace App\Console\Commands;

use App\Models\Recordatorio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioAlertaMail;
use Carbon\Carbon;

class EnviarAlertasRecordatorios extends Command
{
    protected $signature = 'recordatorios:alertas';
    protected $description = 'Envía alertas por correo según los días antes configurados';

public function handle()
{
    $horaActual = now()->format('H'); // Hora actual en formato 24h

    // Solo continuar si la hora es 08, 12 o 16
    if (!in_array($horaActual, [ '12'])) {
        $this->info("⏰ No es una hora programada ($horaActual). No se ejecuta el envío.");
        return 0;
    }

    $this->info("⚙️ Ejecutando recordatorios a las $horaActual:00");

    $hoy = Carbon::today();

    $recordatorios = Recordatorio::where('activo', true)
        ->where('estado', 'pendiente')
        ->get();

    foreach ($recordatorios as $recordatorio) {
        $fechaProgramada = Carbon::parse($recordatorio->fecha_programada);
        $diasRestantes = $hoy->diffInDays($fechaProgramada, false);

        if ($diasRestantes < 0) {
            continue;
        }

        $alertas = $recordatorio->alertas ?? [];

        if (in_array($diasRestantes, $alertas)) {
            $correos = array_map('trim', explode(',', $recordatorio->correos));

            foreach ($correos as $correo) {
                if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($correo)->send(new RecordatorioAlertaMail($recordatorio));
                    $this->info("📧 Correo enviado a: $correo para recordatorio: {$recordatorio->titulo} (faltan $diasRestantes días)");
                } else {
                    $this->warn("❌ Correo inválido: $correo en recordatorio ID {$recordatorio->id}");
                }
            }
        }
    }

    return 0;
}

}
