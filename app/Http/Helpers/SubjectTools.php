<?php

namespace App\Http\Helpers;

use  App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class SubjectTools
{


    public static function ValidateData(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|string|exists:users,id',
                'subject' => 'required|string|exists:subject,id',
                'activity' => 'required|string',
                'file' => 'required|file|mimes:jpeg,png,pdf,rar,zip',
            ]);

            $user = $request->input('user');
            $subject = $request->input('subject');
            $activity = $request->input('activity');
            $hashedUser = hash('sha256', $user);
            $hashedSubject = hash('sha256', $subject);
            $hashedActivity = hash('sha256', $activity);
            return [true, $hashedActivity, $hashedSubject, $hashedUser];
        } catch (\Throwable $th) {
            return [false];
        }
    }

    public static function codeSubject($name)
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()`~';


        do {
            $code = substr(str_shuffle($name), 0, 5) . substr(str_shuffle($caracteres), 0, 10);

            $code = substr_replace($code, (string) mt_rand(1, 9), mt_rand(0, 14), 1);

            $exist = Subject::where('code', $code)->exists();
        } while ($exist);
        return $code;
    }

    public static function insertLN($relatedCourseId, $courseId, $table)
    {
        $relatedCourse = Subject::find($relatedCourseId);
    
        return DB::table($table)->insertGetId([
            'subject_next' => $relatedCourse['id'],
            'subject' => $courseId
        ]);
    }
    

    public static function insertTC($tc, $subject_id, $tab)
    {   

        foreach($tc as $a){
            $exists = DB::table($tab)->where($tab, $a)->exists();

            if ($exists) {
                $tagId =  DB::table($tab)->where($tab, $a)->value('id');
            } else {
                $tagId = DB::table($tab)->insertGetId([
                    $tab => $a
                ]);
            }
            DB::table('subject_'.$tab)->insert([
                $tab.'_id' => $tagId,
                'subject_id' => $subject_id
            ]);
        }

    }



 }
