@extends('layouts.app')

@section('title', 'Edit Todo')
@section('page-title', 'Edit Todo')

@section('content')

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('todos.index') }}">Semua Todo</a></li>
            <li class="breadcrumb-item"><a href="{{ route('todos.show', $todo) }}">{{ Str::limit($todo->judul, 30) }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<form action="{{ route('todos.update', $todo) }}" method="POST" novalidate>
    @csrf
    @method('PUT')
    @include('todos._form')
</form>

@endsection
