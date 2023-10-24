<?php

namespace App\Http\Controllers;

use App\Interfaces\TodoRepositoryInterface;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository) 
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => $this->todoRepository->getAllTodos()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $todoDetails = $request->only([
            'description',
        ]);

        return response()->json(
            [
                'data' => $this->todoRepository->createTodo($todoDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $todoId = $request->route('id');

        return response()->json([
            'data' => $this->todoRepository->getTodoById($todoId)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request)
    {
        $todoId = $request->route('id');
        $todoDetails = $request->only([
            'description',
            'is_complete'
        ]);

        return response()->json([
            'data' => $this->todoRepository->updateTodo($todoId, $todoDetails)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $todoId = $request->route('id');
        $this->todoRepository->deleteTodo($todoId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
