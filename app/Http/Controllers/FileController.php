<?php






namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    public static function upload($file, $path, )
    {
        try {

            if ($file->isValid()) {
                $filePath = $file->storeAs($path, $file->getClientOriginalName(), 'local');
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            return[false , $th->getMessage()];
        }
    }

    public function getFile($fileName)
    {
        // Definir la ruta completa del archivo
        $filePath = storage_path('app/private/' . $fileName);

        // Verificar si el archivo existe
        if (!File::exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        // Obtener el contenido del archivo
        $fileContent = File::get($filePath);

        // Obtener el tipo MIME del archivo
        $mimeType = File::mimeType($filePath);

        // Retornar el archivo como una respuesta
        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
