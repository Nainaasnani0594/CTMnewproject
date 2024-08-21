<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json($task);
    }
}
