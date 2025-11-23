<x-layouts.app title="Login">
    <div class="d-flex justify-content-center mt-5">
        <div class="w-100" style="max-width: 400px;">
            <h2 class="mb-4 text-center">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Passwrod" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <button class="btn btn-primary w-100">Login</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </div>
</x-layouts.app>
