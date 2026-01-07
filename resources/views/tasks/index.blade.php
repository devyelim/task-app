@extends('layouts.app')

@section('title', 'Painel de tarefas')

@section('content')
    <div class="header-painel">
        <h1>Painel de Tarefas</h1>
    </div>
    {{-- Todas as tasks --}}
    <div class="board">
        @foreach ($columns as $status => $label)
            <div class="column" data-status="{{ $status }}">
                <div class="column-header">
                    <span>{{ $label }}</span>
                    <button class="btn btn-ghost btn-primary" onclick="openCreateCard(this)" data-tooltip="Nova tarefa">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="column-body">
                    <p class="empty-column">Sem tarefas</p>
                    @forelse($tasks[$status] ?? [] as $task)
                        <div class="card" draggable="true" data-id="{{ $task->id }}">
                            <span class="badge badge-{{ $task->priority }}" data-status="{{ $prioritys[$task->priority] }}">
                                {{ ucfirst($prioritys[$task->priority]) }}
                            </span>
                            <div class="card-body">
                                {{-- Card da Tarefa --}}
                                <div class="card-view">
                                    <div class="card-title">{{ $task->title }}</div>
                                    @if ($task->due_date)
                                        <div class="card-date">
                                            <i class="bi bi-clock"></i> Até {{ $task->due_date->format('d/m/Y') }}
                                        </div>
                                    @else
                                        <div class="card-date no-date">
                                            <i class="bi bi-clock"></i> Sem data limite
                                        </div>
                                    @endif
                                    <div class="card-description">
                                        <p>{{ $task->description }}</p>
                                    </div>
                                    <div class="card-actions">
                                        <button class="btn btn-ghost" data-tooltip="Editar" onclick="toggleEdit(this)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="submit" class="btn btn-ghost" data-tooltip="Excluir"
                                            onclick="confirmDelete({{ $task->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $task->id }}"
                                            action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>

                                {{-- Card de edição --}}
                                <form class="card-edit" method="POST" action="{{ route('tasks.update', $task) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $task->status->value }}"
                                        data-status-hidden>

                                    <label>Nome</label>
                                    <input type="text" name="title" value="{{ $task->title }}">

                                    <label>Descrição</label>
                                    <textarea name="description">{{ $task->description }}</textarea>

                                    <label>Prioridade</label>
                                    <select name="priority">
                                        <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Baixa
                                        </option>
                                        <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Média
                                        </option>
                                        <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>Alta
                                        </option>
                                    </select>

                                    <label>Status</label>
                                    <select name="status" data-status-select>
                                        <option value="pending" {{ $task->status->value === 'pending' ? 'selected' : '' }}>
                                            Pendente
                                        </option>
                                        <option value="doing" {{ $task->status->value === 'doing' ? 'selected' : '' }}>
                                            Em andamento
                                        </option>
                                        <option value="done" {{ $task->status->value === 'done' ? 'selected' : '' }}>
                                            Concluída
                                        </option>
                                    </select>

                                    <label>Data limite</label>
                                    <input type="date" name="due_date"
                                        value="{{ optional($task->due_date)->format('Y-m-d') }}">
                                    <div class="card-edit-actions">
                                        <button class="btn btn-primary">
                                            <i class="bi bi-check-lg"></i> Salvar
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="toggleEdit(this)">
                                            <i class="bi bi-x-lg"></i> Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
    {{-- Card de criação --}}
    <template id="create-card-template">
        <div class="card creating">
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <input type="hidden" name="status" value="pending">

                    <label>Nome</label>
                    <input type="text" name="title" placeholder="Título da tarefa" required>

                    <label>Descrição</label>
                    <textarea name="description" placeholder="Descrição"></textarea>

                    <label>Prioridade</label>
                    <select name="priority">
                        <option value="low">Baixa</option>
                        <option value="medium" selected>Média</option>
                        <option value="high">Alta</option>
                    </select>

                    <label>Data limite</label>
                    <input type="date" name="due_date">

                    <div class="card-edit-actions">
                        <button class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Criar
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="cancelCreate(this)">
                            <i class="bi bi-x-lg"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
@endsection
