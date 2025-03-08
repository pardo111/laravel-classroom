<?php






namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
 
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
         $filePath = storage_path('app/private/' . $fileName);

         if (!File::exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

         $fileContent = File::get($filePath);

         $mimeType = File::mimeType($filePath);

         return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
