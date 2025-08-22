<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'   => $this->faker->sentence(3),  // 랜덤 제목
            'content' => $this->faker->paragraph(4), // 랜덤 본문
            'author'  => $this->faker->name(),       // 랜덤 작성자
        ];
    }
}
