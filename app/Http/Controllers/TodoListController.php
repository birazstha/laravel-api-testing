<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $todoList;
    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function index()
    {
        $lists = $this->todoList->get();
        return response($lists);
    }

    public function create()
    {
        //
    }

    public function store(TodoRequest $request)
    {
        $data = $request->all();
        $list = $this->todoList->create($data);
        return response($list, 201);
    }

    public function show(string $id)
    {
        $lists =  $this->todoList->findOrFail($id);
        return response($lists);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, string $id)
    {
        $data = $request->all();
        $todo = $this->todoList->findOrFail($id);
        return $todo->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->todoList->findOrFail($id);
        $data->delete();
        return response('', 204);
    }
}
