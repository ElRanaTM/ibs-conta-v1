<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Redirección principal
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth', 'contador'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Asientos Contables
    Route::prefix('contabilidad/asientos')->name('contabilidad.asientos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AsientoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\AsientoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\AsientoController::class, 'store'])->name('store');
        Route::post('/{id}/toggle', [\App\Http\Controllers\AsientoController::class, 'toggle'])->name('toggle');
        Route::get('/libro/diario/export/csv', [\App\Http\Controllers\AsientoController::class, 'exportCsv'])->name('diario.export.csv');
        Route::get('/libro/diario/print', [\App\Http\Controllers\AsientoController::class, 'exportPrint'])->name('diario.export.print');
        Route::get('/libro/diario', [\App\Http\Controllers\AsientoController::class, 'diario'])->name('diario');
        Route::get('/{id}', [\App\Http\Controllers\AsientoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\AsientoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\AsientoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\AsientoController::class, 'destroy'])->name('destroy');
    });
    
    // Plan de Cuentas
    Route::prefix('contabilidad/cuentas')->name('cuentas.')->group(function () {
        Route::get('/plan-cuentas', [\App\Http\Controllers\PlanCuentasController::class, 'planCuentas'])->name('plan-cuentas');
        Route::get('/plan-cuentas/manage', [\App\Http\Controllers\PlanCuentasController::class, 'planCuentasManage'])->name('plan-cuentas.manage');
        Route::get('/create', [\App\Http\Controllers\CuentaController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\CuentaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\CuentaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\CuentaController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\CuentaController::class, 'destroy'])->name('destroy');
    });
    
    // Alumnos
    Route::prefix('alumnos')->name('alumnos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AlumnoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\AlumnoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\AlumnoController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\AlumnoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\AlumnoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\AlumnoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\AlumnoController::class, 'destroy'])->name('destroy');
    });
    
    // Apoderados
    Route::prefix('apoderados')->name('apoderados.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ApoderadoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ApoderadoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ApoderadoController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\ApoderadoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\ApoderadoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\ApoderadoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\ApoderadoController::class, 'destroy'])->name('destroy');
    });
    
    // Pagos
    Route::prefix('ingresos/pagos')->name('pagos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PagoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\PagoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\PagoController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\PagoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\PagoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\PagoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\PagoController::class, 'destroy'])->name('destroy');
    });
    
    // Egresos
    Route::prefix('egresos')->name('egresos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\EgresoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\EgresoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\EgresoController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\EgresoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\EgresoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\EgresoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\EgresoController::class, 'destroy'])->name('destroy');
    });
    
    // Reportes
    Route::prefix('contabilidad/reportes')->name('reportes.')->group(function () {
        Route::get('/balance-comprobacion', [\App\Http\Controllers\ReportesController::class, 'balanceComprobacion'])->name('balance-comprobacion');
        Route::get('/balance-comprobacion/pdf', [\App\Http\Controllers\ReportesController::class, 'balanceComprobacionPdf'])->name('balance-comprobacion.pdf');
        Route::get('/mayor-general', [\App\Http\Controllers\ReportesController::class, 'mayorGeneral'])->name('mayor-general');
        Route::get('/mayor-general/pdf', [\App\Http\Controllers\ReportesController::class, 'mayorGeneralPdf'])->name('mayor-general.pdf');
        Route::get('/libro-diario/pdf', [\App\Http\Controllers\ReportesController::class, 'libroDiarioPdf'])->name('libro-diario.pdf');
    });
    
    // Catálogos
    Route::prefix('catalogos')->name('catalogos.')->group(function () {
        // Proveedores
        Route::prefix('proveedores')->name('proveedores.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\ProveedorController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\ProveedorController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\ProveedorController::class, 'destroy'])->name('destroy');
        });
        
        // Categorías de Egreso
        Route::prefix('categorias-egreso')->name('categorias-egreso.')->group(function () {
            Route::get('/', [\App\Http\Controllers\CategoriaEgresoController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\CategoriaEgresoController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\CategoriaEgresoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\CategoriaEgresoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\CategoriaEgresoController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\CategoriaEgresoController::class, 'destroy'])->name('destroy');
        });
        
        // Conceptos de Ingreso
        Route::prefix('conceptos-ingreso')->name('conceptos-ingreso.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ConceptoIngresoController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\ConceptoIngresoController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\ConceptoIngresoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\ConceptoIngresoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\ConceptoIngresoController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\ConceptoIngresoController::class, 'destroy'])->name('destroy');
        });
        
        // Períodos Académicos
        Route::prefix('periodos-academicos')->name('periodos-academicos.')->group(function () {
            Route::get('/', [\App\Http\Controllers\PeriodoAcademicoController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\PeriodoAcademicoController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\PeriodoAcademicoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\PeriodoAcademicoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\PeriodoAcademicoController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\PeriodoAcademicoController::class, 'destroy'])->name('destroy');
        });
        
        // Métodos de Pago
        Route::prefix('metodos-pago')->name('metodos-pago.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MetodoPagoController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\MetodoPagoController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\MetodoPagoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\MetodoPagoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\MetodoPagoController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\MetodoPagoController::class, 'destroy'])->name('destroy');
        });
        
        // Monedas
        Route::prefix('monedas')->name('monedas.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MonedaController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\MonedaController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\MonedaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\MonedaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\MonedaController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\MonedaController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/tipo-cambio', [\App\Http\Controllers\TipoCambioController::class, 'store'])->name('tipo-cambio.store');
        });
    });
    
    // API Routes
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/tipos-cambio', [\App\Http\Controllers\TipoCambioController::class, 'index'])->name('tipos-cambio');
    });
    
    // Sumas y Saldos
    Route::get('/contabilidad/sumas-saldos', [\App\Http\Controllers\SumasSaldosController::class, 'index'])->name('sumas-saldos');
    Route::get('/contabilidad/sumas-saldos/export/csv', [\App\Http\Controllers\SumasSaldosController::class, 'exportCsv'])->name('sumas-saldos.export.csv');
    Route::get('/contabilidad/sumas-saldos/print', [\App\Http\Controllers\SumasSaldosController::class, 'exportPrint'])->name('sumas-saldos.export.print');

    // testing// En web.php, agrega una ruta de debug temporal:
Route::post('/debug/asiento', function(Request $request) {
    Log::info('DEBUG Asiento:', $request->all());
    dd([
        'request_data' => $request->all(),
        'headers' => $request->headers->all(),
        'route_name' => Route::currentRouteName(),
        'url' => $request->url(),
        'full_url' => $request->fullUrl()
    ]);
});
});

