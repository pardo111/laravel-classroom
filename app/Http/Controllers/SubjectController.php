<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Controllers\FileController;
use App\Http\Helpers\SubjectTools;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{

    public static function createSubject(Request $request){

    }

    public static function uploadTask(Request $request)
    {
        [$valid,$hashedActivity,$hashedSubject,$hashedUser] = SubjectTools::ValidateData($request);
        if($valid){
            $file = $request->file('file');

            if (!$file) {
                return response()->json('error No se ha enviado ningún archivo',400);
            }            
            $hashedPath = $hashedUser . '/' . $hashedSubject . '/' . $hashedActivity;
            $result = FileController::upload($file,$hashedPath);        
            if ($result==true){
                return response()->json('archivo guardado',200);
            }
            return response()->json($result[1], 500);
        }
        return response()->json('error', 500);
 
    }
    public static function getData(Request $request)
    {
        try {
            // Validación de los datos de entrada
            $request->validate([
                'user' => 'required|string',
                'subject' => 'required|string',
                'activity' => 'required|string',
                'filename' => 'required|string', // Se necesita el nombre del archivo
            ]);
        
            // Recopilación de los datos validados
            $user = $request->input('user');
            $subject = $request->input('subject');
            $activity = $request->input('activity');
            $filename = $request->input('filename');
        
            // Hasheado de los parámetros
            $hashedUser = hash('sha256', $user);
            $hashedSubject = hash('sha256', $subject);
            $hashedActivity = hash('sha256', $activity);
            $filePath = $hashedUser . '/' . $hashedSubject . '/' . $hashedActivity.'/'.$filename;

            // Verificación de existencia del archivo
            if (!Storage::exists($filePath)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }
        
               // Aquí rediriges la solicitud al controlador FileController
               $fileController = new FileController();
               return $fileController->getFile($filePath);  // Llamamos al método getFile de FileController
   
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura los errores de validación y devuelve una respuesta adecuada
            return response()->json([
                'error' => 'Datos de entrada inválidos',
                'messages' => $e->errors()
            ], 422);
        
        } catch (\Throwable $th) {
            // Si ocurre otro tipo de error, lo retornamos
            return response()->json(["errores" => $th->getMessage()], 500);
        }
    }
    
}
