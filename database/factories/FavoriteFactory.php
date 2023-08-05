<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['album', 'artist']),
            'artist_name' => $this->faker->name,
            'album_name' => $this->faker->word,
            'mbid' => $this->faker->uuid,
            'image' => $this->faker->imageUrl(),
            'listeners' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
