<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">Book</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @if(Auth::check())
                    <div class="d-flex align-items-center">
                        <span class="me-2">Hello, {{ Auth::user()->name }}</span>

                        @if(!Auth::user()->email_verified_at)
                            <button id="verifyBtn" class="btn btn-warning btn-sm">Verify Account</button>
                        @else
                            <span class="badge bg-success">Verified</span>
                        @endif

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm ms-2">Logout</a>
                    </div>
                @else
                    <div class="d-flex justify-content-end m-3">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                    </div>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

{{-- ✅ LOGIN MODAL --}}
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Login</h5></div>
            <div class="modal-body">
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary w-100">Login</button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ REGISTER MODAL --}}
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Register</h5></div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Register</button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ VERIFY MODAL --}}
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('verify') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalLabel">Verify Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="email" value="{{ Auth::user()->email ?? '' }}">
                <div class="mb-3">
                    <label for="code">Verification Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">Verify</button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Handle registration via AJAX
document.querySelector('#registerModal form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;

    const response = await fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: form.name.value,
            email: form.email.value,
            password: form.password.value
        })
    });

    const result = await response.json().catch(() => ({}));

    if (result.success) {
        bootstrap.Modal.getInstance(document.getElementById('registerModal')).hide();
        alert(result.message || 'Registration successful!');
    } else {
        alert(result.message || 'Registration failed!');
    }
});

// Handle verification button click
document.getElementById('verifyBtn')?.addEventListener('click', function() {
    fetch('{{ route('send.code') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            let modal = new bootstrap.Modal(document.getElementById('verifyModal'));
            modal.show();
        } else {
            alert('Failed to send verification code.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred while sending verification code.');
    });
});
</script>

</body>
</html>
