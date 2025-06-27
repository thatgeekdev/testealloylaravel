<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_limite' => 'nullable|date',
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($this->service->find($task->id));
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_limite' => 'nullable|date',
        ]);

        return response()->json($this->service->update($task, $data));
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->service->delete($task);
        return response()->json(['message' => 'Tarefa excluída.']);
    }

    public function toggle(Task $task): JsonResponse
    {
        return response()->json($this->service->toggle($task));
    }
}
