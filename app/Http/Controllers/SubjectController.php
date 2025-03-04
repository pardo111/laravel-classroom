<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public static function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Obtener el archivo
            $file = $request->file('file');
            // Almacenar el archivo en el disco configurado (por defecto, 'public')
            $path = $file->store('uploads', 'public');

            return back()->with('success', 'Archivo subido exitosamente!')->with('path', $path);
        }

        return back()->with('error', 'No se pudo subir el archivo');
    }
}
