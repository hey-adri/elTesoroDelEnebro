<?php

namespace Database\Factories\Clue;

use App\Models\TreasureHunt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clue\Clue>
 */
class ClueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attributes = new Collection([
            'title'=>ucwords($this->faker->words(4,true)),

            'body'=>$this->faker->paragraphs(3,true),
            'footNote'=>$this->faker->sentence(),
            'treasure_hunt_id'=>TreasureHunt::factory(),
            'help'=>$this->faker->paragraphs(2,true),
        ]);
        if($this->faker->boolean()){
            //Locking the clue
            $unlockKey = $this->faker->sentence(3,true);
            $attributes = $attributes->merge([
                'unlockHint'=> "The unlock key is '$unlockKey'",
                'unlockKey'=>$unlockKey
            ]);
        }
        return $attributes->toArray();
    }
}
