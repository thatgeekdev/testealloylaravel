<?php


namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraph,
            'finalizado' => $this->faker->boolean(30),
            'data_limite' => $this->faker->optional()->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}

