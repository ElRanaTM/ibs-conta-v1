<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Contable IBS - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">
    @auth
        <div class="flex h-screen">
            @include('layout.sidebar')
            
            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                @include('layout.header')
                
                <!-- Page content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-4 bg-gray-800 text-white px-4 py-3 rounded-lg shadow-md">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 bg-gray-900 text-white px-4 py-3 rounded-lg shadow-md border-l-4 border-gray-700">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-4 bg-gray-900 text-white px-4 py-3 rounded-lg shadow-md border-l-4 border-gray-700">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Page Header -->
                    @hasSection('page-header')
                        <div class="mb-6">
                            @yield('page-header')
                        </div>
                    @endif
                    
                    <!-- Page Content -->
                    @yield('content')
                </main>
                
                @include('layout.footer')
            </div>
        </div>
    @else
        @yield('content')
    @endauth
    
    @stack('scripts')
</body>
</html>

