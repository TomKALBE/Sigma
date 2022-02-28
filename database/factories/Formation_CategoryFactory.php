<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Formation;
use App\Models\Formation_Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class Formation_CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formation_Category::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $formation = $this->faker->randomElement(Formation::all());
        $category= $this->faker->randomElement(Category::all());
        return [
            "formations_id"=>$formation->id,
            "chapter_id"=>$category->id
        ];
    }
}
