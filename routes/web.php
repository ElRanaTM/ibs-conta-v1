<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    // Asientos Contables
    Route::prefix('contabilidad/asientos')->name('asientos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AsientoController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\AsientoController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\AsientoController::class, 'store'])->name('store');
        Route::get('/libro/diario', [\App\Http\Controllers\AsientoController::class, 'diario'])->name('diario');
        Route::get('/{id}', [\App\Http\Controllers\AsientoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\AsientoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\AsientoController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\AsientoController::class, 'destroy'])->name('destroy');
    });
    
    // Plan de Cuentas
    Route::prefix('contabilidad/cuentas')->name('cuentas.')->group(function () {
        Route::get('/plan-cuentas', [\App\Http\Controllers\PlanCuentasController::class, 'planCuentas'])->name('plan-cuentas');
        Route::post('/', [\App\Http\Controllers\CuentaController::class, 'store'])->name('store');
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
        Route::get('/balance-comprobacion', function () {
            return view('contabilidad.reportes.balance-comprobacion');
        })->name('balance-comprobacion');
        Route::get('/mayor-general', function () {
            return view('contabilidad.reportes.mayor-general');
        })->name('mayor-general');
    });
    
    // Catálogos
    Route::prefix('catalogos')->name('catalogos.')->group(function () {
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
});

