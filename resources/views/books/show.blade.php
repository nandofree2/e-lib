@extends('layouts.app')

@section('content')
<h2>{{ $book->name }}</h2>

@if($book->cover)
    <img src="{{ asset('storage/'.$book->cover) }}" width="200" class="mb-3">
@endif

<p><strong>Stock:</strong> {{ $book->stock }}</p>
<p><strong>Status:</strong> {{ ucfirst($book->status_book) }}</p>
<p><strong>Synopsis:</strong><br>{{ $book->synopsis }}</p>

<a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
@endsection
