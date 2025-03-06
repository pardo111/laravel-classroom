<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Validator;
use  App\Models\Subject;
use Illuminate\Http\Request;



class SubjectTools
{

    public static function ValidateData( Request $request)
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
            $hashedUser = hash('sha256', $user);
            $hashedSubject = hash('sha256', $subject);
            $hashedActivity = hash('sha256', $activity);
            return [true , $hashedActivity,$hashedSubject,$hashedUser];
        } catch (\Throwable $th) {
            return [false];
        }

    }

 
}
