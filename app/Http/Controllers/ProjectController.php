<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('company')
            ->orderByDesc('id')
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $data['company_id'] = auth()->user()->company_id;
        $data['is_active'] = true;

        Project::create($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proje oluşturuldu.');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $project->update($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proje güncellendi.');
    }

    public function toggle(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);

        return back()->with('success', 'Proje durumu güncellendi.');
    }

    // Projeye kullanıcı atama
    public function assignUser(Project $project, Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $project->users()->syncWithoutDetaching([$data['user_id']]);

        return back()->with('success', 'Kullanıcı projeye eklendi.');
    }
    public function show(Project $project)
{
    return redirect()->route('projects.tasks.index', $project);
}


    // Projeden kullanıcı çıkarma
    public function removeUser(Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return back()->with('success', 'Kullanıcı projeden çıkarıldı.');
    }
    

}
