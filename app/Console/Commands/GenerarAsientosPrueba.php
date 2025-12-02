<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\AsientosRealistasSeeder;

class GenerarAsientosPrueba extends Command
{
    protected $signature = 'asientos:generar-prueba 
                            {--clear : Eliminar todos los asientos existentes primero}
                            {--meses=12 : Número de meses a generar (hacia atrás desde hoy)}
                            {--test : Solo mostrar lo que se generaría sin guardar}';
    
    protected $description = 'Genera asientos contables realistas para pruebas';

    public function handle()
    {
        $this->info('🚀 GENERADOR DE ASIENTOS CONTABLES REALISTAS 🚀');
        
        if ($this->option('test')) {
            $this->info('🔍 MODO TEST: No se guardarán datos');
            return 0;
        }
        
        if ($this->option('clear')) {
            if ($this->confirm('¿Estás seguro de eliminar TODOS los asientos y detalles existentes?')) {
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                \App\Models\DetalleAsiento::truncate();
                \App\Models\Asiento::truncate();
                \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                $this->info('✅ Datos anteriores eliminados.');
            }
        }
        
        $seeder = new AsientosRealistasSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info("\n🎉 ¡Asientos de prueba generados exitosamente!");
        $this->info("📊 Puedes ahora probar todos tus reportes:");
        $this->info("   • Balance General");
        $this->info("   • Estado de Resultados");
        $this->info("   • Sumas y Saldos");
        $this->info("   • Libro Diario");
        $this->info("   • Mayor General");
        
        return 0;
    }
}