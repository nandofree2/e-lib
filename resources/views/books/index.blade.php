@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Book List</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Cover</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->name }}</td>
                <td>
                    @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}" alt="" width="60">
                    @endif
                </td>
                <td>{{ $book->stock }}</td>
                <td>{{ ucfirst($book->status_book) }}</td>
                <td>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this book?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
