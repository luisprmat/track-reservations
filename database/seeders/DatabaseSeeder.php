<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $tracks = [
            'Track 1',
            'Track 2',
            'Track 3',
            'Track 4',
            'Track 5',
        ];
        foreach ($tracks as $track) {
            Track::create(['title' => $track]);
        }
    }
}
