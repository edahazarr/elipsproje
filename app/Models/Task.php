<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
    'project_id',
    'title',
    'description',
    'status',
    'assigned_user_id',
    'due_date',
    'is_active',
    'priority',
'tag',

];


    public function project()
{
    return $this->belongsTo(\App\Models\Project::class);
}

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
public function assignees()
{
    return $this->belongsToMany(User::class)
        ->withPivot(['assigned_by_user_id', 'can_assign', 'assigned_at'])
        ->withTimestamps();
}


}
