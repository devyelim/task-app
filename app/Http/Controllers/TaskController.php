<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Enums\TaskStatus;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = Task::orderBy('created_at')
        ->get()
        ->groupBy(fn ($task) => $task->status->value);

        $columns = [
            'pending' => '🕓 Pendente',
            'doing' => '⚙️ Em andamento',
            'done' => '✅ Concluída',
        ];

        $prioritys = [
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
        ];

        return view('tasks.index', compact('tasks', 'columns', 'prioritys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => 'nullable|date'
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => 'nullable|date'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa removida com sucesso');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => ['required', Rule::enum(TaskStatus::class)]
        ]);

        $task->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }
}
