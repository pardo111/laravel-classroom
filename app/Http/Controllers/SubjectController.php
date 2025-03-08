<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Http\Helpers\SubjectTools;
use Illuminate\Support\Facades\Storage;
use App\Models\Subject;
use App\Http\Helpers\Tools;
 use Illuminate\Support\Facades\Validator;



class SubjectController extends Controller
{

    public static function createSubject(Request $request)
    {
        try {
            $data_cleaned = Tools::cleanData($request, [
                'name',
                'owner',
                'description',
                'duration',
                'price',
                'next_course',
                'last_course'
            ]);

            $validator = Validator::make($data_cleaned, [
                'name' => 'required|string|max:50',
                'owner' => 'required',
                'description' => 'required|max:1000',
                'duration' => 'required|time',
                'price' => 'required|numeric|decimal:2|min:0',
                'price' => 'required|numeric|decimal:2|min:0',
            ]);

            $data_cleaned['code']=SubjectTools::codeSubject($data_cleaned['name']);
            if ($validator->fails()) {
                return response()->json(["datos invalidos: " => $validator->erros(), 400]);
            }
            $subject = Subject::create($data_cleaned);

            return  response()->json(["creado exitosamente: " => $subject], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th]);
        }
    }

    public static function uploadTask(Request $request)
    {
        [$valid, $hashedActivity, $hashedSubject, $hashedUser] = SubjectTools::ValidateData($request);
        if ($valid) {
            $file = $request->file('file');

            if (!$file) {
                return response()->json('error No se ha enviado ningún archivo', 400);
            }
            $hashedPath = $hashedUser . '/' . $hashedSubject . '/' . $hashedActivity;
            $result = FileController::upload($file, $hashedPath);
            if ($result == true) {
                return response()->json('archivo guardado', 200);
            }
            return response()->json($result[1], 500);
        }
        return response()->json('error', 500);
    }
    public static function getData(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|string',
                'subject' => 'required|string',
                'activity' => 'required|string',
                'filename' => 'required|string',
            ]);

            $user = $request->input('user');
            $subject = $request->input('subject');
            $activity = $request->input('activity');
            $filename = $request->input('filename');

            $hashedUser = hash('sha256', $user);
            $hashedSubject = hash('sha256', $subject);
            $hashedActivity = hash('sha256', $activity);
            $filePath = $hashedUser . '/' . $hashedSubject . '/' . $hashedActivity . '/' . $filename;

            if (!Storage::exists($filePath)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }

            $fileController = new FileController();
            return $fileController->getFile($filePath);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos de entrada inválidos',
                'messages' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json(["errores" => $th->getMessage()], 500);
        }
    }
}
