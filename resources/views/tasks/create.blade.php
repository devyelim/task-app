@extends('layouts.app')

@section('content')

    <h1>Criar tarefa</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @include('tasks._form', ['buttonText' => 'Criar tarefa'])
    </form>

@endsection
