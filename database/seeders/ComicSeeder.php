<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comic;
use Carbon\Carbon;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        for ($i = 0; $i < 100; $i++) {
            Comic::factory()->create([
                'created_at' => $now->copy()->subSeconds(100 - $i),
                'updated_at' => $now->copy()->subSeconds(100 - $i),
            ]);
        }
    }
}
