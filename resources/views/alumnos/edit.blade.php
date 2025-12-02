@extends('layout.app')

@section('title', 'Editar Alumno')

@section('page-title', 'Editar Alumno')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Editar Alumno: {{ $alumno->nombre_completo }}</h1>
    <p class="text-gray-600 mt-1">Modifica la información del alumno</p>
</div>
@endsection

@section('content')
<form action="{{ route('alumnos.update', $alumno->id_alumno) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Alumno</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nombres" class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $alumno->nombres) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>

            <div>
                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 mb-2">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ old('apellido_paterno', $alumno->apellido_paterno) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>

            <div>
                <label for="apellido_materno" class="block text-sm font-medium text-gray-700 mb-2">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno" value="{{ old('apellido_materno', $alumno->apellido_materno) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">CI</label>
                <input type="text" name="ci" id="ci" value="{{ old('ci', $alumno->ci) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="celular" class="block text-sm font-medium text-gray-700 mb-2">Celular</label>
                <input type="text" name="celular" id="celular" value="{{ old('celular', $alumno->celular) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div class="md:col-span-2">
                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $alumno->direccion) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="estado" id="estado"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="activo" {{ old('estado', $alumno->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado', $alumno->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label for="observacion" class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                <textarea name="observacion" id="observacion" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">{{ old('observacion', $alumno->observacion) }}</textarea>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Apoderados</h3>
        <div class="mb-3">
            <input type="text" id="search-apoderado" placeholder="Buscar por CI, nombres, apellidos o dirección..." class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="space-y-2 max-h-64 overflow-y-auto" id="apoderados-list">
            @forelse($apoderados as $apoderado)
            <?php $fullName = trim(($apoderado->nombres ?? $apoderado->nombre_completo ?? '') . ' ' . ($apoderado->apellido_paterno ?? '') . ' ' . ($apoderado->apellido_materno ?? '')); ?>
            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer apoderado-row" data-ci="{{ $apoderado->ci ?? '' }}" data-nombres="{{ $apoderado->nombres ?? $apoderado->nombre_completo }}" data-apellidos="{{ ($apoderado->apellido_paterno ?? '') . ' ' . ($apoderado->apellido_materno ?? '') }}" data-direccion="{{ $apoderado->direccion ?? '' }}">
                <input type="checkbox" name="apoderados[]" value="{{ $apoderado->id_apoderado }}" {{ $alumno->apoderados->contains($apoderado->id_apoderado) ? 'checked' : '' }} class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $fullName }}</p>
                    <p class="text-xs text-gray-500">CI: {{ $apoderado->ci }} - {{ $apoderado->relacion_legal }}</p>
                </div>
            </label>
            @empty
            <p class="text-sm text-gray-500">No hay apoderados registrados.</p>
            @endforelse
        </div>
    </div>

@push('scripts')
<script>
document.getElementById('search-apoderado').addEventListener('input', function(e){
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('.apoderado-row').forEach(row => {
        const text = (row.dataset.ci + ' ' + row.dataset.nombres + ' ' + row.dataset.apellidos + ' ' + row.dataset.direccion).toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
    });
});
</script>
@endpush
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('alumnos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Actualizar Alumno
        </button>
    </div>
</form>
@endsection

