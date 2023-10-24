<?php

namespace App\Http\Controllers;

use App\Interfaces\TodoRepositoryInterface;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

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

        return Inertia::render('Todo/Todo', ['todos'=>$this->todoRepository->getAllTodos()]);
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
        $todo = $this->todoRepository->createTodo($todoDetails);
        return redirect()->back()->with(['todos'=>$this->todoRepository->getAllTodos()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
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
        $this->todoRepository->updateTodo($todoId, $todoDetails);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $todoId = $request->route('id');
        $this->todoRepository->deleteTodo($todoId);
        return redirect()->back();
    }
}
