<?php

namespace Database\Factories;

use App\Models\ProfilePicture;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfilePicture>
 */
class ProfilePictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

//    protected $model = ProfilePicture::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image' => $this->faker->imageUrl(200,200,'cats', true),
        ];
    }
}
