<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Activity; 
class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with('assignees')
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

            'priority'     => ['required', 'in:low,medium,high'],
            'tag'          => ['nullable', 'in:bug,feature,urgent'],

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

        $task = Task::create([
            'project_id'   => $project->id,
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'status'       => $data['status'],
            'due_date'     => $data['due_date'] ?? null,
            'priority'     => $data['priority'],
            'tag'          => $data['tag'] ?? null,
            'is_active'    => true,
        ]);

        $task->assignees()->sync($userIds->all());

        // ✅ ACTIVITY LOG
        log_activity('task_created', $task, [
            'title' => $task->title,
            'priority' => $task->priority,
            'tag' => $task->tag,
            'assignees' => $userIds->all(),
        ]);

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Görev oluşturuldu.');
    }

    public function edit(Project $project, Task $task)
{
    abort_unless($task->project_id === $project->id, 404);

    $task->load(['assignees', 'comments.user']);

    $users = $project->users()->orderBy('name')->get();

    $activities = Activity::with('user')
        ->where('subject_type', Task::class)
        ->where('subject_id', $task->id)
        ->latest()
        ->get();

    return view('tasks.edit', compact('project', 'task', 'users', 'activities'));
}

    public function update(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'status'       => ['required', 'in:todo,doing,done'],
            'due_date'     => ['nullable', 'date'],

            'user_ids'     => ['nullable', 'array'],
            'user_ids.*'   => ['integer', 'exists:users,id'],

            'priority'     => ['required', 'in:low,medium,high'],
            'tag'          => ['nullable', 'in:bug,feature,urgent'],
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
            'priority' => $data['priority'],
            'tag' => $data['tag'] ?? null,
        ]);

        $task->assignees()->sync($userIds->all());

        // ✅ ACTIVITY LOG
        log_activity('task_updated', $task, [
            'title' => $task->title,
            'priority' => $task->priority,
            'tag' => $task->tag,
            'assignees' => $userIds->all(),
        ]);

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Görev güncellendi.');
    }

    public function toggle(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $task->update(['is_active' => !$task->is_active]);

        // ✅ ACTIVITY LOG
        log_activity('task_toggled', $task, [
            'is_active' => $task->is_active,
        ]);

        return back()->with('success', 'Görev durumu güncellendi.');
    }

    public function move(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->update(['status' => $data['status']]);

        // ✅ ACTIVITY LOG
        log_activity('task_moved', $task, [
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Görev durumu güncellendi.');
    }

    public function destroy(Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        // yorumlar FK bağlıysa önce sil
        $task->comments()->delete();

        // çoklu atamalar
        $task->assignees()->detach();

        // ✅ ACTIVITY LOG (silmeden önce)
        log_activity('task_deleted', $task, [
            'title' => $task->title,
        ]);

        $task->delete();

        return back()->with('success', 'Görev silindi.');
    }
}
