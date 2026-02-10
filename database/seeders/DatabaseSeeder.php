<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Spatie\Permission\Models\Role; // bunu ekle

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
{
    $this->call(CompanySeeder::class);

    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'User']);

    $user = User::firstOrCreate(
        ['email' => 'test@example.com'],
        ['name' => 'Test User', 'password' => bcrypt('password')]
    );

    $user->assignRole('Admin');
}

}
