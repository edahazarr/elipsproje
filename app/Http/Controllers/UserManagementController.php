<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;
class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('company')->orderByDesc('id')->get();
        return view('users.index', compact('users'));
    }

    public function toggle(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);
        return redirect()->route('users.index')->with('success', 'Kullanıcı durumu güncellendi.');
    }
    public function edit(User $user)
{
    $roles = Role::pluck('name');
    $companies = Company::pluck('name', 'id');

    return view('users.edit', compact('user', 'roles', 'companies'));
}

public function update(Request $request, User $user)
{
    $data = $request->validate([
        'company_id' => ['nullable', 'exists:companies,id'],
        'role' => ['required', 'string'],
        'is_active' => ['required', 'boolean'],
    ]);

    $user->update([
        'company_id' => $data['company_id'],
        'is_active' => $data['is_active'],
    ]);

    $user->syncRoles([$data['role']]);

    return redirect()->route('users.index')->with('success', 'Kullanıcı güncellendi.');
}

}
