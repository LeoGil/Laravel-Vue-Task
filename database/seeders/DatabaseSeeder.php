<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Leonardo Gil',
            'email' => 'leogilc@gmail.com',
        ]);

        Task::factory(100)->create([
            'user_id' => $user->id,
        ]);
    }
}
