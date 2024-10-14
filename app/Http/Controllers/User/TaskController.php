<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::where('owner_id', Auth::user()->id)->orderByDesc('id')->paginate(15));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules());
        $request->merge(['owner_id' => Auth::user()->id]);
        $task = Task::create($request->all());
        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->validate($request, $this->rules($task->id));
        $task->update($request->only([
            'assigned_to',
            'parent_id',
            'priority',
            'title',
            'desc',
            'status',
            'estimated_time'
        ]));
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    // Validation rules
    protected function rules($id = null)
    {
        return [
            'assigned_to' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:tasks,id',
            'priority' => 'required|integer|min:1|max:3',
            'title' => 'required|string|max:50',
            'desc' => 'required|string|max:500',
            'status' => 'required|integer',
            'estimated_time' => 'required|date',
        ];
    }
}
