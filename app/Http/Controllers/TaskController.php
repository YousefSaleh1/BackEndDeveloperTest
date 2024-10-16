<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use app\Services\TaskService;
use app\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Trait used to standardize API responses
    use ApiResponseTrait;

    protected $TaskService;

    /**
     * TaskController constructor.
     *
     * Initializes the TaskService instance, which handles the business logic for task operations.
     *
     * @param TaskService $TaskService The service responsible for managing tasks.
     */
    public function __construct(TaskService $TaskService)
    {
        $this->TaskService = $TaskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request Contains query parameters like per_page and status.
     * @return JsonResponse Returns paginated list of tasks with status filter.
     */
    public function index(Request $request)
    {
        $tasks = $this->TaskService->getPaginatedTasks($request->input('per_page'), $request->input('status'));
        return $this->resourcePaginated($tasks, 'Tasks retrieved successfully');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->TaskService->createTask($request->validated());
        return $this->successResponse($task, 'Task created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->successResponse($task, 'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->TaskService->updateTask($request->validated(), $task);
        return $this->successResponse($task, 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->successResponse(null, 'Task deleted successfully');
    }
}
