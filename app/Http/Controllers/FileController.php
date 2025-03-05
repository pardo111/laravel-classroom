<?php






namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    // file, pathHashed
    public static function upload(Request $request)
    {
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
            $hashedActivity = hash('sha256', $activity);

            if (!$file) {
                return response()->json('error No se ha enviado ningún archivo',400);
            }            
            $path = storage_path('app/private/' . $hashedUser . '/' . $hashedSubject . '/' . $hashedActivity);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            if ($file->isValid()) {
                $filePath = $file->storeAs($hashedUser . '/' . $hashedSubject . '/' . $hashedActivity, $file->getClientOriginalName(), 'local');
                return response()->json('success path', 200);
            }

            return back()->with('error', 'No se pudo subir el archivo');
        } catch (\Throwable $th) {
            return response()->json(["error:" => $th->getMessage()]);
        }
    }
}
