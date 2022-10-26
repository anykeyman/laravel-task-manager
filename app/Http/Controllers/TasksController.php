<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class TasksController extends Controller
{
    public function markComplete(int $id, Request $request): \Illuminate\Http\RedirectResponse
    {
        Task::query()->where('id', $id)->update([
            'is_completed' => true,
        ]);

        return redirect()->back()->with('message', 'Successfully complete');
    }

    public function createTask(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => ['file', File::types(['doc', 'txt', 'xls'])]
        ]);

        $tasksCount = Task::query()->where('user_id', auth()->id())
            ->where('start_time', $data['start_date'])
            ->where('end_time', $data['end_date'])
            ->count();

        if ($tasksCount >= 4) {
            return redirect()->back()->with('error', 'Много пересакающихся задач');
        }

        $path = $request->file('file')->store('files');

        $task = new Task();
        $task->user_id = auth()->id();
        $task->theme = $data['title'];
        $task->description = $data['description'];
        $task->start_time = $data['start_date'];
        $task->end_time = $data['end_date'];
        $task->file = $path;
        $task->save();

        return redirect()->back()->with('message', 'Задача успешно создана');
    }
}
