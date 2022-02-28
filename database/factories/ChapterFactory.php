<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $formation = $this->faker->randomElement(Formation::all());
        for($i = 0;$i<5;$i++){
            return [
                'title'=>$this->faker->sentence(1),
                'num'=>$i,
                'formation_id'=>$formation->id
            ];
        }
    }
}
