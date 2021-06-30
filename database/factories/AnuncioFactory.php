<?php

namespace Database\Factories;

use App\Models\Anuncio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnuncioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Anuncio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->sentence(15),
            'precio' => $this->faker->randomFloat(2, 100, 500)
        ];
    }
}
