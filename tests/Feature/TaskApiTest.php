<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertOk()
                 ->assertJsonCount(3);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_task()
    {
        $data = [
            'nome' => 'Nova tarefa',
            'descricao' => 'Descrição simples',
            'data_limite' => now()->addDays(5)->toDateTimeString(),
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertCreated()
                 ->assertJsonFragment(['nome' => 'Nova tarefa']);

        $this->assertDatabaseHas('tasks', ['nome' => 'Nova tarefa']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertOk()
                 ->assertJsonFragment(['nome' => $task->nome]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $data = ['nome' => 'Atualizado'];

        $response = $this->putJson("/api/tasks/{$task->id}", $data + [
            'descricao' => $task->descricao,
            'data_limite' => optional($task->data_limite)->toDateTimeString(),
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['nome' => 'Atualizado']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'nome' => 'Atualizado']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_toggle_a_task()
    {
        $task = Task::factory()->create(['finalizado' => false]);

        $response = $this->patchJson("/api/tasks/{$task->id}/toggle");

        $response->assertOk()
                 ->assertJsonFragment(['finalizado' => true]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'finalizado' => true]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertOk()
                 ->assertJson(['message' => 'Tarefa excluída.']);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
