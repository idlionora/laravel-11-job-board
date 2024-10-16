<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\JobApplication;
use App\Models\Placement;
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
        User::factory()->create([
            'name' => 'Nurul Azizah',
            'email' => 'nuruaizaa_pmrfi@mailsac.com',
        ]);
        
        User::factory(300)->create();

        $users = User::all()->shuffle();

        for ($i = 0; $i < 20; $i++)
        {
            Employer::factory()->create([
                'user_id' => $users->pop()->id
            ]);
        }

        $employers = Employer::all();

        for ($i = 0; $i < 100; $i++) {
            Placement::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
        }

        foreach ($users as $user) {
            $placements = Placement::inRandomOrder()->take(rand(0, 4))->get();

            foreach($placements as $placement) {
                JobApplication::factory()->create([
                    'placement_id' => $placement->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
