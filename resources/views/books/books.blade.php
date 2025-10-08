@extends('layouts.app')

@section('content')
<h2>Add Book</h2>
<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Cover</label>
        <input type="file" name="cover" class="form-control">
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status_book" class="form-control">
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Synopsis</label>
        <textarea name="synopsis" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
