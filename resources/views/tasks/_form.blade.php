@csrf
@php
    $currentStatus = old(
        'status',
        isset($task) ? $task->status->value : 'pending'
    );
@endphp

<div class="form-group">
    <label for="title">Título</label>
    <input type="text" name="title" id="title"
           value="{{ old('title', $task->title ?? '') }}" required>
</div>

<div class="form-group">
    <label for="description">Descrição</label>
    <textarea name="description" id="description" rows="4">
        {{ old('description', $task->description ?? '') }}
    </textarea>
</div>

<div class="form-group">
    <label>Prioridade</label>
    <select name="priority">
        @php $priority = old('priority', $task->priority ?? 'medium'); @endphp
        <option value="low" {{ $priority === 'low' ? 'selected' : '' }}>Baixa</option>
        <option value="medium" {{ $priority === 'medium' ? 'selected' : '' }}>Média</option>
        <option value="high" {{ $priority === 'high' ? 'selected' : '' }}>Alta</option>
    </select>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" id="status">
        <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>
            Pendente
        </option>
        <option value="doing" {{ $currentStatus === 'doing' ? 'selected' : '' }}>
            Em andamento
        </option>
        <option value="done" {{ $currentStatus === 'done' ? 'selected' : '' }}>
            Concluída
        </option>
    </select>
</div>

<div class="form-group">
    <label for="due_date">Data limite</label>
    <input type="date" name="due_date" id="due_date"
           value="{{ old('due_date', isset($task->due_date) ? $task->due_date->format('Y-m-d') : '') }}">
</div>

<button class="btn btn-primary" type="submit">
    <i class="bi bi-check-lg"></i>
    {{ $buttonText ?? 'Salvar tarefa' }}
</button>

<a class="btn btn-secondary" href="{{ route('tasks.index') }}">Voltar</a>

