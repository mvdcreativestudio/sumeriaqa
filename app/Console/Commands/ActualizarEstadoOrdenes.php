<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contabilidad\Contabilidad;
use Carbon\Carbon;

class ActualizarEstadoOrdenes extends Command
{
    protected $signature = 'orden:actualizar-estado';
    protected $description = 'Actualiza el estado de las órdenes según la fecha de vencimiento';

    public function handle()
    {
        // Obtener todas las órdenes con estado "Impago"
        $ordenes = Contabilidad::where('estado', 'Impago')->get();

        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        foreach ($ordenes as $orden) {

            // Obtener la fecha de vencimiento del contabilidad
            $fechaVencimiento = Carbon::parse($orden->fecha_vencimiento);

            // Obtener la diferencia en días entre la fecha de vencimiento y la fecha actual
            $diasRestantes = $fechaActual->diffInDays($fechaVencimiento, false);

            // Actualizar el estado según los días restantes
            if ($diasRestantes > 0) {
                $orden->estado_vencimiento = 'Vigente';
            } elseif ($diasRestantes === 0) {
                $orden->estado_vencimiento = 'Por Vencer';
            } else {
                $orden->estado_vencimiento = 'Vencida';
            }

            $orden->save();
        }

        $this->info('Tarea programada finalizada. Estado de las órdenes actualizado exitosamente.');
    }
}
