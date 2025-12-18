<aside class="w-64 bg-gray-900 text-gray-100 flex flex-col shadow-lg">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-800">
        <h1 class="text-xl font-bold text-white">Sistema Contable</h1>
        <p class="text-xs text-gray-400 mt-1">IBS</p>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-home w-5 mr-3"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Contabilidad -->
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Contabilidad</p>
            </li>
            <li>
                <a href="{{ route('contabilidad.asientos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('asientos.index') || request()->routeIs('asientos.create') || request()->routeIs('asientos.show') || request()->routeIs('asientos.edit') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-file-alt w-5 mr-3"></i>
                    Asientos Contables
                </a>
            </li>
            <li>
                <a href="{{ route('contabilidad.asientos.diario') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('asientos.diario') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-book w-5 mr-3"></i>
                    Libro Diario
                </a>
            </li>
            <li>
                <a href="{{ route('cuentas.plan-cuentas') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('cuentas.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-sitemap w-5 mr-3"></i>
                    Plan de Cuentas
                </a>
            </li>
            <li>
                <a href="{{ route('sumas-saldos') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('sumas-saldos') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-calculator w-5 mr-3"></i>
                    Sumas y Saldos
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.balance-comprobacion') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reportes.balance-comprobacion') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    Reportes Balance
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.mayor-general') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reportes.mayor-general') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    Mayor General
                </a>
            </li>
            
            <!-- Alumnos -->
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Académico</p>
            </li>
            <li>
                <a href="{{ route('alumnos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('alumnos.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-user-graduate w-5 mr-3"></i>
                    Alumnos
                </a>
            </li>
            <li>
                <a href="{{ route('apoderados.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('apoderados.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-user-tie w-5 mr-3"></i>
                    Apoderados
                </a>
            </li>
            
            <!-- Ingresos -->
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Ingresos</p>
            </li>
            <li>
                <a href="{{ route('pagos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pagos.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                    Pagos
                </a>
            </li>
            
            <!-- Egresos -->
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Egresos</p>
            </li>
            <li>
                <a href="{{ route('egresos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('egresos.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-arrow-down w-5 mr-3"></i>
                    Egresos
                </a>
            </li>
            
            <!-- Catálogos -->
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Catálogos</p>
            </li>
            <li>
                <button onclick="toggleCatalogosMenu()" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:bg-gray-800 hover:text-white">
                    <i class="fas fa-list w-5 mr-3"></i>
                    Catálogos
                    <i class="fas fa-chevron-down w-4 ml-auto transition-transform" id="catalogos-icon"></i>
                </button>
                <ul id="catalogos-menu" class="space-y-1 px-6 mt-2 hidden">
                    <li>
                        <a href="{{ route('catalogos.proveedores.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.proveedores.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-briefcase w-4 mr-2"></i>
                            Proveedores
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogos.categorias-egreso.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.categorias-egreso.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-folder-open w-4 mr-2"></i>
                            Categorías Egreso
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogos.conceptos-ingreso.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.conceptos-ingreso.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-file-invoice-dollar w-4 mr-2"></i>
                            Conceptos Ingreso
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogos.periodos-academicos.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.periodos-academicos.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-calendar-alt w-4 mr-2"></i>
                            Períodos Académicos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogos.metodos-pago.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.metodos-pago.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-credit-card w-4 mr-2"></i>
                            Métodos Pago
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catalogos.monedas.index') }}" class="flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('catalogos.monedas.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-100' }}">
                            <i class="fas fa-coins w-4 mr-2"></i>
                            Monedas
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Administración -->
             <!--
            @if($currentUser && $currentUser->hasRole(['admin', 'administrador']))
            <li class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administración</p>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('administracion.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    Usuarios
                </a>
            </li>
            @endif
        </ul>
    </nav>
    -->
    
    <!-- User Info -->
    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-sm font-medium text-white">{{ $currentUser->name ?? 'Usuario' }}</p>
                <p class="text-xs text-gray-400">{{ $userRole ?? 'Sin rol' }}</p>
            </div>
        </div>
    </div>
</aside>

<script>
function toggleCatalogosMenu() {
    const menu = document.getElementById('catalogos-menu');
    const icon = document.getElementById('catalogos-icon');
    
    menu.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}

// Verificar si algún elemento del menú de catálogos está activo
document.addEventListener('DOMContentLoaded', function() {
    const catalogosLinks = document.querySelectorAll('#catalogos-menu a');
    const isAnyCatalogActive = Array.from(catalogosLinks).some(link => 
        link.classList.contains('bg-gray-700')
    );
    
    if (isAnyCatalogActive) {
        document.getElementById('catalogos-menu').classList.remove('hidden');
        document.getElementById('catalogos-icon').classList.add('rotate-180');
    }
});
</script>