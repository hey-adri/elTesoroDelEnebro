<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Clue\Clue;
use App\Models\Clue\ClueImage;
use App\Models\Clue\ClueEmbeddedVideo;
use App\Models\TreasureHunt;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $testUser = User::factory()->create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $testTreasureHunts = TreasureHunt::factory(3)->create([
            'user_id' => $testUser->id,
        ]);

        foreach ($testTreasureHunts as $treasureHunt){
            $clues = Clue::factory(5)->create([
                'treasure_hunt_id'=>$treasureHunt->id
            ]);
            foreach ($clues as $clue){
                ClueImage::factory()->create([
                    'clue_id'=>$clue->id
                ]);
                ClueEmbeddedVideo::factory()->create([
                    'clue_id'=>$clue->id
                ]);
            }
        }
    }
}
