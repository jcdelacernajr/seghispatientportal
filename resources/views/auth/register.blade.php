<x-layouts.app title="Register">
    <div class="d-flex justify-content-center mt-5">
        <div class="w-100" style="max-width: 400px;"> 
            <h2 class="mb-4 text-center">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label> 
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                </div>

                <button class="btn btn-primary w-100">Register</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div>
        </div>
    </div>
</x-layouts.app>
