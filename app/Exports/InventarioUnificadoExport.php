<?php

namespace App\Exports;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ComputadorController;
use App\Http\Controllers\CelularController;
use App\Http\Controllers\PlanDatosController;
use App\Http\Controllers\OtroActivoController;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InventarioUnificadoExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // Empleados
            new class(app(EmpleadoController::class)->export(true)) implements 
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithColumnWidths 
            {
                use \Maatwebsite\Excel\Concerns\Exportable;

                public function __construct(private $export) {}
                public function collection()       { return $this->export->collection(); }
                public function headings(): array  { return $this->export->headings(); }
                public function columnWidths(): array { return $this->export->columnWidths(); }
                public function title(): string    { return '⭐ Empleados'; }
            },

            // Computadores
            new class(app(ComputadorController::class)->export(true)) implements 
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithColumnWidths 
            {
                use \Maatwebsite\Excel\Concerns\Exportable;

                public function __construct(private $export) {}
                public function collection()       { return $this->export->collection(); }
                public function headings(): array  { return $this->export->headings(); }
                public function columnWidths(): array { return $this->export->columnWidths(); }
                public function title(): string    { return '💻 Computadores'; }
            },

            // Celulares
            new class(app(CelularController::class)->export(true)) implements 
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\FromArray,
                \Maatwebsite\Excel\Concerns\WithColumnWidths 
            {
                use \Maatwebsite\Excel\Concerns\Exportable;

                public function __construct(private $export) {}
                public function array(): array         { return $this->export->array(); }
                public function columnWidths(): array  { return $this->export->columnWidths(); }
                public function title(): string        { return '📱 Celulares'; }
            },

            // Planes de Datos
            new class(app(PlanDatosController::class)->export(true)) implements 
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithColumnWidths 
            {
                use \Maatwebsite\Excel\Concerns\Exportable;

                public function __construct(private $export) {}
                public function collection()       { return $this->export->collection(); }
                public function headings(): array  { return $this->export->headings(); }
                public function columnWidths(): array { return $this->export->columnWidths(); }
                public function title(): string    { return '📶 Planes de Datos'; }
            },

            // Otros Activos
            new class(app(OtroActivoController::class)->export(true)) implements 
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithColumnWidths 
            {
                use \Maatwebsite\Excel\Concerns\Exportable;

                public function __construct(private $export) {}
                public function collection()       { return $this->export->collection(); }
                public function headings(): array  { return $this->export->headings(); }
                public function columnWidths(): array { return $this->export->columnWidths(); }
                public function title(): string    { return '📦 Otros Activos'; }
            },
        ];
    }
}
