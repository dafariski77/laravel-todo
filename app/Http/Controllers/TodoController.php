<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $todos = Todo::with('day', 'user')->where("user_id", "=", $user_id)->get();

        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $validated = $request->validated();

        $todo = Todo::create([
            "activity" => $validated['activity'],
            "day_id" => $validated['day_id'],
            "user_id" => auth()->user()->id,
            "status" => "Incompleted"
        ]);

        return new TodoResource($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_id = auth()->user()->id;

        $todo = Todo::with('day', 'user')->where("user_id", "=", $user_id)->find($id);

        if(!$todo) {
            return response()->json([
                "message" => "Todo not found!"
            ], 404);
        }

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $user_id = auth()->user()->id;

        $todo = Todo::where("user_id", "=", $user_id)->find($id);

        if(!$todo) {
            return response()->json([
                "message" => "Todo not found!"
            ], 404);
        }

        $validated = $request->validated();

        $todo->update([
            "activity" => $validated['activity'],
            "day_id" => $validated['day_id'],
            "user_id" => auth()->user()->id,
            "status" => $validated['status']
        ]);

        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_id = auth()->user()->id;

        $todo = Todo::where("user_id", "=", $user_id)->find($id);

        if(!$todo) {
            return response()->json([
                "message" => "Todo not found!"
            ], 404);
        }

        $todo->delete($id);

        return response()->json([
            "message" => "Todo Deleted!"
        ], 200);
    }
}
