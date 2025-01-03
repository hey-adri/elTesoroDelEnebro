<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Controllers\Helpers\HelperController;
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

        //Creating Admin User
        $admin = User::create([
            'name' => env('DEFAULT_ADMIN'),
            'username'=>env('DEFAULT_ADMIN'),
            'email' => env('DEFAULT_ADMIN_MAIL'),
            'password' => env('DEFAULT_ADMIN_PASSWORD'),
            'isAdmin'=>true
        ]);
        //Creating Demo clues
        HelperController::generateLocalizedDemoClues($admin);

    }

    private static function createTestBench(){
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'username'=>'testUser',
            'email' => 'test@example.com',
            'password' => 'testuser'
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


        for ($i = 0; $i<2; $i++){
            $testUser = User::factory()->create([
                'name' => "Test User $i",
                'username'=>"testuser$i",
                'email' => "test$i@example.com",
                'password' => "testuser$i",
                'isAdmin'=>true
            ]);

            $testTreasureHunts = TreasureHunt::factory(10)->create([
                'user_id' => $testUser->id,
            ]);

            foreach ($testTreasureHunts as $treasureHunt){
                $clues = Clue::factory(20)->create([
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

        User::factory(20)->create();
        Clue::factory(30)->create();
        TreasureHunt::factory(10)->create();
    }
}
