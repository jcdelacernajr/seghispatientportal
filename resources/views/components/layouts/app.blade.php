<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Auth System' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> {{-- For AJAX --}}
</head>
<body class="bg-light">

    @if(auth()->check())
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                Patient Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('doctor')))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile-patient-management') }}">
                                Profile Patient Management
                            </a>
                        </li>
                    @endif

                    <li class="nav-item"><a class="nav-link" href="{{ route('medical-records') }}">Medical Records</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('appointments') }}">Appointments</a></li>
                </ul>

                {{-- Right side links --}}
                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Profile</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @endif

    {{-- Flash messages --}}
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        {{-- Main content --}}
        {{ $slot }}
    </div>

    <script src="{{ asset('js/datatable-loader.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/delete-row-handler.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Scripts stack --}}
    @stack('scripts')
</body>
</html>
