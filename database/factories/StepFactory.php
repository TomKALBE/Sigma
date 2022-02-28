<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $chapter = $this->faker->randomElement(Chapter::all());

        for($i = 0;$i<5;$i++){
            return [
                'chapter_id' => $chapter->id,
                "name"=>$this->faker->sentence(5),
                "num"=>$i,
                "content"=>$this->faker->sentence(200),
            ];
        }

    }
}
