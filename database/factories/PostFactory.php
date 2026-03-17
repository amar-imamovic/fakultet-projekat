<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory\<Post>
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
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'title' => fake()->sentence(6),
            'body' => fake()->paragraphs(3, true),
            'is_pinned' => false,
            'is_locked' => false,
        ];
    }

    public function pinned(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
        ]);
    }

    public function locked(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_locked' => true,
        ]);
    }
}
