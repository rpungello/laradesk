<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition(): array
    {
        return [
            'disk' => $this->faker->word(),
            'path' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'content_type' => $this->faker->word(),
            'client_filename' => $this->faker->file(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'comment_id' => Comment::factory(),
        ];
    }
}
