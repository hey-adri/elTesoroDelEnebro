<?php

namespace Database\Factories\Clue;

use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clue\ClueImage>
 */
class ClueImageFactory extends Factory
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
                'https://www.pngall.com/wp-content/uploads/2016/04/Beach-Download-PNG.png',
                'https://nt.global.ssl.fastly.net/binaries/content/gallery/website/national/library/our-cause/on-the-shore-borrowdale-and-derwent-water-1518851.jpg',
                'https://t3.ftcdn.net/jpg/05/35/47/38/360_F_535473874_OWCa2ohzXXNZgqnlzF9QETsnbrSO9pFS.jpg',
                'https://whc.unesco.org/uploads/thumbs/activity_725-2148-704-20220308132126.jpg',
                'https://images.unsplash.com/photo-1672106157109-056c567e3833?w=420&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxjb2xsZWN0aW9uLXRodW1ibmFpbHx8MjAyNDc2Mnx8ZW58MHx8fHx8'
            ]),
            'title'=>ucwords($this->faker->words(2,true)),
            'caption'=>$this->faker->sentence()
        ];
    }
}
