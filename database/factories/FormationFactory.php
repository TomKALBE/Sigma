<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $formationName = ['Laravel','GitHub','React','Python','Symfony'];
        $user = $this->faker->randomElement(User::all());

        return [
            'name'=>$formationName[array_rand($formationName)],
            'type'=>$this->faker->word,
            'description'=>$this->faker->sentence(15),
            'price'=>random_int(5,59),
            'picture'=>random_int(1,10).'.jpg',
            'user_id'=>$user->id
        ];
    }
}
