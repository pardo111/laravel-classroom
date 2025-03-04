<?php






namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public static function upload(Request $request)
    {
        dd($request->all());
        try {
             $request->validate([
                'user' => 'required|string',
                'subject' => 'required|string',
                'activity' => 'required|string',
                'file' => 'required|file|mimes:jpeg,png,pdf,rar,zip',
            ]);
            $user = $request->input('user');
            $subject = $request->input('subject');
            $activity = $request->input('activity');
            $file = $request->file('file');
            $hashedUser = hash('sha256', $user);
            $hashedSubject = hash('sha256', $subject);

            if (!$file) {
                return back()->with('error', 'No se ha enviado ningún archivo');
            }            $path = storage_path('app/private/' . $hashedUser . '/' . $hashedSubject . '/' . $activity);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            if ($file->isValid()) {
                $filePath = $file->storeAs($user . '/' . $subject . '/' . $activity, $file->getClientOriginalName(), 'local');
                return back()->with('success', 'Archivo subido exitosamente!');
            }

            return back()->with('error', 'No se pudo subir el archivo');
        } catch (\Throwable $th) {
            return response()->json(["error:" => $th->getMessage()]);
        }
    }
}
