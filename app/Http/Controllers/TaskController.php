<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Inertia\Inertia;
class TaskController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return redirect()->route('projects.show', $task->group->project_id);
    }
    public function show(Task $task)
    {
        //
    }
    public function edit(Task $task)
    {
        //
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }
    public function destroy(Task $task)
    {
        //
    }
}
