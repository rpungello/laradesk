<?php

namespace Database\Factories;

use App\Enums\Priority;
use App\Models\Company;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(),
            'billable' => $this->faker->boolean(),
            'priority' => $this->faker->randomElement(Priority::cases()),
            'due_date' => Carbon::now(),
            'type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'assigned_user_id' => User::factory(),
            'product_id' => Product::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
