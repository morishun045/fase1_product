<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comic;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comics>
 */
class ComicFactory extends Factory
{
    protected $model =Comic::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(20),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'description' => $this->faker->realText(100),
            'image' => null,
        ];
    }
}
