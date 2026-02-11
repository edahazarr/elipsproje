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
            ->with('assignees') // ✅ çoklu
            ->orderByDesc('id')
            ->get();

        $todoTasks  = $tasks->where('status', 'todo');
        $doingTasks = $tasks->where('status', 'doing');
        $doneTasks  = $tasks->where('status', 'done');

        return view('tasks.index', compact('project', 'todoTasks', 'doingTasks', 'doneTasks'));
    }

    public function create(Project $project)
    {
        $users = $project->users()
    ->orderBy('name')
    ->get();


        return view('tasks.create', compact('project', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'status'       => ['required', 'in:todo,doing,done'],
            'due_date'     => ['nullable', 'date'],

            // ✅ çoklu atama
            'user_ids'     => ['nullable', 'array'],
            'user_ids.*'   => ['integer', 'exists:users,id'],
        ]);

        // Seçilen kullanıcılar
        $userIds = collect($request->input('user_ids', []))
            ->filter()
            ->unique()
            ->values();

        // Proje üyeleri
        $projectUserIds = $project->users()->pluck('users.id');

        // Proje üyesi olmayan seçildiyse engelle
        $invalidUserIds = $userIds->diff($projectUserIds);
        if ($invalidUserIds->isNotEmpty()) {
            return back()->withErrors([
                'user_ids' => 'Seçtiğin kullanıcı(lar) projeye atanmadığı için görev atanamaz.'
            ])->withInput();
        }

        // Task oluştur
        $task = Task::create([
            'project_id'   => $project->id,
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'status'       => $data['status'],
            'due_date'     => $data['due_date'] ?? null,
            'is_active'    => true,
            // varsa:
            // 'created_by_user_id' => auth()->id(),
        ]);

        // Pivot atama (basit)
        $task->assignees()->sync($userIds->all());

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Görev oluşturuldu.');
    }

    public function edit(Project $project, Task $task)
{
    abort_unless($task->project_id === $project->id, 404);

    $task->load('assignees');
$users = $project->users()
    ->orderBy('name')
    ->get();

    return view('tasks.edit', compact('project', 'task', 'users'));
}

    public function update(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'status'       => ['required', 'in:todo,doing,done'],
            'due_date'     => ['nullable', 'date'],

            // ✅ çoklu atama
            'user_ids'     => ['nullable', 'array'],
            'user_ids.*'   => ['integer', 'exists:users,id'],
        ]);

        $userIds = collect($request->input('user_ids', []))
            ->filter()
            ->unique()
            ->values();

        $projectUserIds = $project->users()->pluck('users.id');

        $invalidUserIds = $userIds->diff($projectUserIds);
        if ($invalidUserIds->isNotEmpty()) {
            return back()->withErrors([
                'user_ids' => 'Seçtiğin kullanıcı(lar) projeye atanmadığı için görev atanamaz.'
            ])->withInput();
        }

        $task->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'due_date' => $data['due_date'] ?? null,
        ]);

        // Pivot güncelle
        $task->assignees()->sync($userIds->all());

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

