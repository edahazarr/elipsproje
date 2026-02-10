<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with('assignee')
            ->orderByDesc('id')
            ->get();

        $todoTasks  = $tasks->where('status', 'todo');
        $doingTasks = $tasks->where('status', 'doing');
        $doneTasks  = $tasks->where('status', 'done');

        return view('tasks.index', compact('project', 'todoTasks', 'doingTasks', 'doneTasks'));
    }

public function create(Project $project)
{
    $companyId = Auth::user()->company_id;

    $users = User::where('company_id', $companyId)
        ->orderBy('name')
        ->get();

    return view('tasks.create', compact('project', 'users'));
}


    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'status'           => ['required', 'in:todo,doing,done'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'due_date'         => ['nullable', 'date'],
        ]);

        // Atanan kullanıcı proje üyesi mi?
        if (!empty($data['assigned_user_id'])) {
            $isMember = $project->users()
                ->where('users.id', $data['assigned_user_id'])
                ->exists();

            if (!$isMember) {
                return back()->withErrors([
                    'assigned_user_id' => 'Bu kullanıcı projeye atanmadığı için görev atanamaz.'
                ])->withInput();
            }
        }

        $data['project_id'] = $project->id;
        $data['is_active']  = true;

        Task::create($data);

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Görev oluşturuldu.');
    }

    public function edit(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $users = User::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->get();

        return view('tasks.edit', compact('project', 'task', 'users'));
    }

    public function update(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'status'           => ['required', 'in:todo,doing,done'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'due_date'         => ['nullable', 'date'],
        ]);

        if (!empty($data['assigned_user_id'])) {
            $isMember = $project->users()
                ->where('users.id', $data['assigned_user_id'])
                ->exists();

            if (!$isMember) {
                return back()->withErrors([
                    'assigned_user_id' => 'Bu kullanıcı projeye atanmadığı için görev atanamaz.'
                ])->withInput();
            }
        }

        $task->update($data);

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Görev güncellendi.');
    }

    public function toggle(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->update(['is_active' => !$task->is_active]);

        return back()->with('success', 'Görev durumu güncellendi.');
    }

    public function move(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->update(['status' => $data['status']]);

        return back()->with('success', 'Görev durumu güncellendi.');
    }
    
}
