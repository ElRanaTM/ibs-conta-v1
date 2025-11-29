<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] min-h-screen">
    <nav class="bg-white dark:bg-[#161615] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ config('app.name', 'Sistema de Contabilidad') }}
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                    @if($currentUser)
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $currentUser->name }}</span>
                            @if($userRole)
                                <span class="ml-2 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded text-xs">
                                    {{ $userRole }}
                                </span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit"
                                class="px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded hover:bg-[#f5f5f5] dark:hover:bg-[#2a2a28] transition-colors"
                            >
                                Cerrar Sesión
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Bienvenido, {{ $currentUser->name ?? 'Usuario' }}
            </h2>
            <p class="text-[#706f6c] dark:text-[#A1A09A]">
                Panel de control del sistema de contabilidad
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tarjeta de Resumen -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-6">
                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    Resumen General
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Estado:</span>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">
                            {{ $currentUser->estado ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Rol:</span>
                        <span class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $userRole ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Accesos Rápidos -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-6">
                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    Accesos Rápidos
                </h3>
                <div class="space-y-2">
                    <a href="#" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Gestión de Pagos
                    </a>
                    <a href="#" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Gestión de Egresos
                    </a>
                    <a href="#" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Asientos Contables
                    </a>
                </div>
            </div>

            <!-- Tarjeta de Información -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-6">
                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    Información del Sistema
                </h3>
                <div class="space-y-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    <p>Sistema de Contabilidad IBS</p>
                    <p>Versión 1.0</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>



