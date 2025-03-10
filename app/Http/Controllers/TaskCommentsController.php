<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskComments;

class TaskCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function comment($comment, $taskId, $userId){
        return TaskComments::create($comment, $taskId, $userId);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskComments $taskComments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComments $taskComments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskComments $taskComments)
    {
        //
    }
}
