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

    public static function lastCourse($lastCourseId, $courseId)
    {
        $next_course = Subject::find($lastCourseId);

        $next =  DB::table('subject_last')->insertGetId([
            'subject_last' => $next_course['id'],
            'subject' => $courseId
        ]);
        return $next;
    }

    public static function nextCourse($nextCourseId, $courseId)
    {
        $last_course = Subject::find($nextCourseId);
        $last = DB::table('subject_next')->insertGetId([
            'subject_next' => $last_course['id'],
            'subject' => $courseId
        ]);

        return $last;
    }

    public static function insertTags($tc, $subject_id, $tab)
    {
        $exists = DB::table($tab)->where($tab, $tc)->exists();

        if ($exists) {
            $tagId =  DB::table($tab)->where($tab, $tc)->value('id');
        } else {
            $tagId = DB::table($tab)->insertGetId([
                $tab => $tc
            ]);
        }
        $insert = DB::table('subject_'.$tab)->insertGetId([
            $tab.'_id' => $tagId,
            'subject_id' => $subject_id
        ]);

        $subjectTag = DB::table('subject_'.$tab)->insertGetId([
            $tab.'_id' => $tagId,
            'subject_id' => $subject_id
        ]);
        dd($subjectTag);
        return $insert ? $subjectTag : false ;
    }

    public static function insertCategory($category) {}
}
