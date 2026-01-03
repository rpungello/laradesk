<?php

namespace Database\Factories;

use App\Enums\Visibility;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'visibility' => $this->faker->randomElement(Visibility::cases()),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(),
        ];
    }
}
