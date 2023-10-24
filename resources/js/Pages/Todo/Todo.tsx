import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { ITodo, PageProps } from '@/types';
import { useEffect, useState } from 'react';
import axios from 'axios';

export default function Todo({ auth, todos }: PageProps) {
    const [todoList, setTodoList] = useState(todos);
    const [description, setDescription] = useState("");


    const toggleChecked = async (index:number)=>{
        todoList[index].is_complete = todoList[index].is_complete == 1 ? 0:1;
        setTodoList([...todoList]);
        router.put(`/todos/${todoList[index].id}`,{"is_complete": todoList[index].is_complete});
    }

    const removeTodo = async (todo:ITodo)=>{
        const newList = todoList.filter((item) => item.id !== todo.id);
        setTodoList(newList);
        router.delete(`/todos/${todo.id}`);
    }

    const addTodo = async (e:React.FormEvent<HTMLFormElement>)=>{
        router.post('todos', {"description":description},{
            preserveScroll:true,
            onSuccess:(data=>{
            setTodoList(data.props.todos as ITodo[]);
            setDescription('');
        })});
        
        e.preventDefault();
    }

    const handleDescChanged = (e:React.ChangeEvent<HTMLInputElement>)=>{
        setDescription(e.target.value);
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Todo</h2>}
        >
            <Head title="Todos" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div>
                            <h1 className="p-6 text-gray-900 dark:text-gray-100">Todo List</h1>
                            <form onSubmit={addTodo}>
                                <div className="pr-6 pl-6 flex">
                                    <input className="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker" onChange={handleDescChanged} value={description} placeholder="Add Todo" />
                                    <input type="submit" className="flex-no-shrink p-2 border-2 rounded text-white hover:text-white hover:bg-teal-600" value="Add"/>
                                </div>
                            </form>
                        </div>
                        {
                            todoList.map((todo,index) =>
                                <div key={todo.id} className='pr-6 pl-6 mt-4 mb-2'>
                                    <div className="flex items-center">
                                        <input value={index} id={todo.id.toString()} checked={todo.is_complete == 1 ? true : false} type="checkbox" onChange={()=>toggleChecked(index)} className="w-4 h-4 text-teal-600 bg-gray-100 rounded dark:bg-gray-700" />
                                        <label className={todo.is_complete == 1 ? "flex-1 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 line-through" : "flex-1 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"}>{todo.description}</label>
                                        <button onClick={()=>removeTodo(todo)} className="flex-no-shrink p-1 ml-2 border-2 rounded text-white border-red hover:text-white hover:bg-red-600">Remove</button>
                                    </div>
                                </div>
                            )
                        }
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
