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
];


    public function project()
{
    return $this->belongsTo(\App\Models\Project::class);
}

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
   public function assignee()
{
    return $this->belongsTo(\App\Models\User::class, 'assigned_user_id');
}


}
