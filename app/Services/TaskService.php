<?php

namespace App\Services;

use app\Traits\ApiResponseTrait;
use App\Models\Task;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class TaskService
{
    use ApiResponseTrait;

    /**
     * Get paginated list of tasks, with optional status filter.
     *
     * @param int $per_page Number of tasks per page.
     * @param string|null $status Optional status filter.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedTasks($per_page, $status)
    {
        $tasks = Task::query();

        if (!empty($status)) {
            $tasks = $tasks->status($status);
        }

        return $tasks->paginate($per_page);
    }

    /**
     * Create a new task.
     *
     * @param array $data Task data to be saved.
     * @return Task
     * @throws HttpResponseException if the task creation fails.
     */
    public function createTask(array $data)
    {
        try {
            return Task::create($data);
        } catch (\Throwable $th) {
            // Log the error message for debugging purposes
            Log::error('Task create failed: ' . $th->getMessage());
            // Throw an HTTP response exception with a failure message
            throw new HttpResponseException($this->errorResponse('Task create failed', 500));
        }
    }

    /**
     * Update the specified task with new data.
     *
     * @param array $data The updated task data.
     * @param Task $task The task instance to be updated.
     * @return Task Returns the updated task instance.
     * @throws HttpResponseException if the update operation fails.
     */
    public function updateTask(array $data, Task $task)
    {
        try {
            $task->update(array_filter($data));
            return $task;
        } catch (\Throwable $th) {
            // Log the error message for debugging purposes
            Log::error('Task update failed: ' . $th->getMessage());
            // Throw an HTTP response exception with a failure message
            throw new HttpResponseException($this->errorResponse('Task update failed', 500));
        }
    }
}
