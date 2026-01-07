<x-layouts.app title="Register">
    <div class="d-flex justify-content-center mt-5">
        <div class="w-100" style="max-width: 400px;"> 
            <h2 class="mb-4 text-center">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                </div>

                <div class="mb-3">
                    <label>Password 
                         <span 
                            class="bi bi-info-circle" 
                            data-bs-toggle="tooltip" 
                            title="Must be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character."
                            style="cursor: pointer; color: #0d6efd;" >
                      </span>
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label> 
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                </div>

                <div class="mb-3 d-flex flex-column align-items-end">
                    <button class="btn btn-primary">Register</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div>
        </div>
    </div>
</x-layouts.app>
