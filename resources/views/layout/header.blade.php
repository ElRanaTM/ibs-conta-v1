<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
        <div class="flex items-center">
            <h2 class="text-lg font-semibold text-gray-900">
                @yield('page-title', 'Dashboard')
            </h2>
        </div>
        
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-bell"></i>
            </button>
            
            <!-- User Menu -->
            <div class="relative">
                <button class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                            {{ strtoupper(substr($currentUser->name ?? 'U', 0, 1)) }}
                        </span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</header>

