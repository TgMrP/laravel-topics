<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(50),
            'user_id' => User::inRandomOrder()->first(),
            'image' => 'topics/'.$this->faker->image(storage_path('app/public/topics'),100,100, null, false),
        ];
    }
}

// $table->id();
// $table->string('name');
// $table->string('image');
// $table->foreignIdFor(User::class, 'user_id')->nullable();
// $table->timestamps();
