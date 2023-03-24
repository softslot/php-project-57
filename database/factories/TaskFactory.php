<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $taskStatusesIds = TaskStatus::get('id')->pluck('id');
        $usersIds = User::get('id')->pluck('id');

        return [
            'name' => fake()->unique()->text(30),
            'status_id' => $taskStatusesIds->random(),
            'description' => fake()->paragraph(),
            'created_by_id' => $usersIds->random(),
            'assigned_to_id' => $usersIds->random(),
        ];
    }
}
