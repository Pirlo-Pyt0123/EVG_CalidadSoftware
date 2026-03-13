<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function create()
    {
        return view('personas');
    }

    public function store(Request $request)
    {
        $acceptHeader = (string) $request->header('Accept', '');

        $request->merge([
            'nombres' => $request->input('nombres', $request->input('nombre')),
            'correo' => $request->input('correo', $request->input('fechanacimiento')),
        ]);

        $data = $request->validate([
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string',
            'correo'    => 'required|email',
            'sexo'      => 'required|string|in:M,F',
        ]);

        $persona = Persona::create([
            'nombres'   => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'correo'    => $data['correo'],
            'sexo'      => $data['sexo'],
        ]);

        if (
            $request->expectsJson()
            || $request->is('api/*')
            || $acceptHeader === ''
            || $acceptHeader === '*/*'
        ) {
            return response()->json([
                'message' => 'Persona registrada correctamente.',
                'data' => $persona,
            ], 201);
        }

        return redirect()
            ->route('personas.create')
            ->with('success', 'Persona registrada correctamente.');
    }
}
