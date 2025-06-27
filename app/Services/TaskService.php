<?php
namespace App\Services;

use App\Models\Task;
use App\Jobs\DeleteCompletedTask;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    protected const CACHE_TAG = 'tasks';

    public function all()
    {
        return Cache::tags([self::CACHE_TAG])->remember('tasks.all', 60, function () {
            return Task::whereNull('deleted_at')->latest()->get();
        });
    }

    public function find(int $id): Task
    {
        return Cache::tags([self::CACHE_TAG])->remember("tasks.{$id}", 60, function () use ($id) {
            return Task::findOrFail($id);
        });
    }

    public function create(array $data): Task
    {
        $task = Task::create($data);
        $this->invalidateCache();
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        $this->invalidateCache($task->id);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
        $this->invalidateCache($task->id);
    }

    public function toggle(Task $task): Task
    {
        $task->finalizado = !$task->finalizado;
        $task->save();

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        $this->invalidateCache($task->id);
        return $task;
    }

    protected function invalidateCache(int $taskId = null): void
    {
        Cache::tags([self::CACHE_TAG])->flush();
    }
}
