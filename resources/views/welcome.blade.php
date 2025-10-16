@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Books</h2>
        <form method="GET" action="{{ route('home') }}" class="d-flex">
            <select name="status_book" class="form-select me-2" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </form>
    </div>

    <div class="row">
        @foreach ($books as $book)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="{{ asset('storage/'.$book->cover) }}" class="card-img-top" alt="{{ $book->name }}" style="height: 200px; object-fit: cover;">
                    <span class="badge bg-{{ $book->status_book == 'available' ? 'success' : 'secondary' }} position-absolute top-0 end-0 m-2">
                        {{ ucfirst($book->status_book) }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $book->name }}</h5>
                    <p class="card-text text-truncate" style="max-height: 1.5em; overflow: hidden;" id="synopsis-{{ $book->id }}">
                        {{ $book->synopsis }}
                    </p>
                    <button class="btn btn-link p-0" onclick="toggleSynopsis({{ $book->id }})">Read more</button>
                    <p class="mt-2 mb-0"><strong>Stock:</strong> {{ $book->stock }}</p>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>

<script>
function toggleSynopsis(id) {
    const el = document.getElementById('synopsis-' + id);
    el.classList.toggle('text-truncate');
}
</script>
@endsection
