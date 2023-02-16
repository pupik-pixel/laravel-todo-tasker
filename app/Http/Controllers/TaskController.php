<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    function getTasks()
    {
        $tasks = Task::all([
            'id',
            'title',
            'description',
            'staging_date',
            'deadline',
            'status',
            'file_name'
        ]);
        return view(
            'tasks',
            [
                'tasks' => $tasks
            ]
        );
    }

    function saveTask(Request $request)
    {
        $this->validateRequest($request);

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

        if ($request->exists('file')) {
            $file = $request->file('file');
            Storage::disk('local')->put('/public\/' . $file->getClientOriginalName(), $file->getContent());
            $task->file_name = $file->getClientOriginalName();
        } else {
            $task->file_name = '';
        }
        $task->save();

        return redirect('/');
    }

    function updateTask(Request $request)
    {
        $this->validateRequest($request);

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

        if ($request->exists('file')) {
            $file = $request->file('file');
            if (!$this->fileIsInSeveralTasks($task->file_name)) {
                Storage::disk('local')->delete('/public\/' . $task->file_name);
                Storage::disk('local')->put('/public\/' . $file->getClientOriginalName(), $file->getContent());
            }                        
            $task->file_name = $file->getClientOriginalName();
        } else {
            $task->file_name = '';
        }
        $task->save();

        return redirect('/');
    }

    function deleteTask(Request $request) {
        $request->input('id');

        $task = Task::find($request->id);
        if (!$this->fileIsInSeveralTasks($task->file_name)) {
            Storage::disk('local')->delete('/public\/' . $task->file_name);            
        }                 
        $task->delete();
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'staging_date' => [
                'required',
                'date_format:Y-m-d\TH:i'
            ],
            'deadline' => [
                'required',
                'date_format:Y-m-d\TH:i'
            ],
            'status' => [
                'required',
                Rule::in([
                    'Активная',
                    'Отложена',
                    'Завершена'
                ])
            ],
            'file' => ['file']
        ]);
    }

    private function fileIsInSeveralTasks($filename) {        
        $task = Task::where('file_name', $filename);
        if ($task->count() > 1) {
            return true;
        }
        else {
            return false;
        }
    }
}