<?php

namespace App\Http\Controllers;

use App\Models\NumeracionDocumentos;
use Illuminate\Http\Request;

class NumeracionDocumentosController extends Controller
{
    public function index()
    {
        $numeraciones = NumeracionDocumentos::all();
        return response()->json($numeraciones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'serie' => 'required|string|max:10',
            'descripcion' => 'required|string',
            'ultimo_numero' => 'integer|min:0',
            'activo' => 'boolean',
        ]);

        $request->validate([
            'tipo_documento' => 'unique:numeracion_documentos,tipo_documento,NULL,id,serie,' . $request->serie,
        ]);

        $numeracion = NumeracionDocumentos::create($request->all());
        return response()->json($numeracion, 201);
    }

    public function show($id)
    {
        $numeracion = NumeracionDocumentos::findOrFail($id);
        return response()->json($numeracion);
    }

    public function update(Request $request, $id)
    {
        $numeracion = NumeracionDocumentos::findOrFail($id);
        
        $request->validate([
            'tipo_documento' => 'required|string',
            'serie' => 'required|string|max:10',
            'descripcion' => 'required|string',
            'ultimo_numero' => 'integer|min:0',
            'activo' => 'boolean',
        ]);

        $numeracion->update($request->all());
        return response()->json($numeracion);
    }

    public function destroy($id)
    {
        $numeracion = NumeracionDocumentos::findOrFail($id);
        $numeracion->delete();
        return response()->json(null, 204);
    }
}

