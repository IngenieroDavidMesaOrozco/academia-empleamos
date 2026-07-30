<?php

namespace App\Mail;

use App\Models\Recordatorio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioAlertaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recordatorio;

    public function __construct(Recordatorio $recordatorio)
    {
        $this->recordatorio = $recordatorio;
    }

    public function build()
    {
        return $this->subject('Alerta de Recordatorio: ' . $this->recordatorio->titulo)
                    ->view('emails.recordatorio_alerta');
    }
}
