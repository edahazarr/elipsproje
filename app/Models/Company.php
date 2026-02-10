<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;
    public function users()
{
    return $this->hasMany(User::class);
}

    protected $fillable = [
        'name',
        'is_active',
    ];
    public function projects()
{
    return $this->hasMany(Project::class);
}

}

