<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    function getTasks() {
        $tasks = Task::all([
            'id',
            'title',
            'description',
            'staging_date',
            'deadline',
            'status'
        ]);
        return view(
            'tasks', 
            [
                'tasks' => $tasks
            ]
        );
    }

    function saveTask(Request $request) {
        $request->input('title');
        $request->input('description');
        $request->input('staging_date');
        $request->input('deadline');
        $request->input('status');

        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->staging_date = $request->staging_date;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->save();
    }

    function updateTask(Request $request) {
        $request->input('id');
        $request->input('title');
        $request->input('description');
        $request->input('staging_date');
        $request->input('deadline');
        $request->input('status');
        
        $task = Task::find($request->id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->staging_date = $request->staging_date;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->save();
    }
}
