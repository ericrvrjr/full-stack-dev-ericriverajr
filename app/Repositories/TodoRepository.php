<?php

namespace App\Repositories;

use App\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface{
    public function getAllTodos(){
        return Todo::all();
    }
    public function getTodoById($todoId){
        return Todo::findOrFail($todoId);
    }
    public function deleteTodo($todoId){
        return Todo::destroy($todoId);
    }
    public function createTodo(array $todoDetails){
        return Todo::create($todoDetails);
    }
    public function updateTodo($todoId, array $newTodoDetails){
        return Todo::whereId($todoId)->update($newTodoDetails);
    }
    public function getCompletedTodos(){
        return Todo::where('is_complete', true);
    }
    public function getDeletedTodos(){
        return Todo::whereNotNull('deleted_at');
    }
}