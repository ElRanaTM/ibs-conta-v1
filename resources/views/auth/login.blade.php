<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - {{ config('app.name', 'Laravel') }}</title>
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg p-8 border border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    -
                </h1>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    -
                </p>
            </div>

            @if (session('error'))
                <div class="mb-4 p-3 bg-[#fff2f2] dark:bg-[#1D0002] border border-[#F53003] dark:border-[#F61500] rounded text-sm text-[#F53003] dark:text-[#FF4433]">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded text-sm text-green-700 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-[#fff2f2] dark:bg-[#1D0002] border border-[#F53003] dark:border-[#F61500] rounded text-sm text-[#F53003] dark:text-[#FF4433]">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="correo@ejemplo.com"
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="rounded border-[#e3e3e0] dark:border-[#3E3E3A] text-blue-600 focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Recordarme
                        </span>
                    </label>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] py-2 px-4 rounded font-medium hover:bg-[#2b2b28] dark:hover:bg-[#d0d0ce] transition-colors"
                >
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>



