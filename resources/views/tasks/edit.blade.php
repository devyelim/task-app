@extends('layouts.app')

@section('content')

    <h1>Editar tarefa</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @method('PUT')
        @include('tasks._form', ['buttonText' => 'Atualizar tarefa'])
    </form>

    <a href="{{ route('tasks.index') }}">Voltar</a>

@endsection
