@extends('layouts.app')

@section('title', 'Tambah Todo')
@section('page-title', 'Tambah Todo Baru')

@section('content')

<form action="{{ route('todos.store') }}" method="POST" novalidate>
    @csrf
    @include('todos._form')
</form>

@endsection
