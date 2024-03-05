<?php

namespace Database\Factories\Clue;

use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clue\ClueImage>
 */
class ClueEmbeddedVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clue_id'=>Clue::factory(),
            'src'=>$this->faker->randomElement([
                'https://www.youtube.com/watch?v=LXb3EKWsInQ&t=15s',
                'https://youtu.be/KJwYBJMSbPI?si=4EMMqBgzdl2GxA1W',
                'https://youtube.com/watch?v=RzVvThhjAKw',
                'https://www.youtube.com/watch?v=KLuTLF3x9sA'
            ]),
            'type'=>'youtube',
            'title'=>ucwords($this->faker->words(2,true)),
            'caption'=>$this->faker->sentence()
        ];
    }
}
