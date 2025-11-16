<x-layouts.app title="Register">
    <h2 class="mb-4">Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Register</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('login') }}">Already have an account?</a>
    </div>
</x-layouts.app>
