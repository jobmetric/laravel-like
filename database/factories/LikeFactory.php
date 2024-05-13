<?php

namespace JobMetric\Like\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Like\Models\Like;

/**
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'likeable_id' => null,
            'likeable_type' => null,
            'type' => $this->faker->boolean
        ];
    }

    /**
     * set user id
     *
     * @param int $user_id
     *
     * @return static
     */
    public function setUserId(int $user_id): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user_id
        ]);
    }

    /**
     * set likeable
     *
     * @param int $likeable_id
     * @param string $likeable_type
     *
     * @return static
     */
    public function setLikeable(int $likeable_id, string $likeable_type): static
    {
        return $this->state(fn(array $attributes) => [
            'likeable_id' => $likeable_id,
            'likeable_type' => $likeable_type
        ]);
    }

    /**
     * set type
     *
     * @param bool $type
     *
     * @return static
     */
    public function setType(bool $type = true): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type
        ]);
    }
}
