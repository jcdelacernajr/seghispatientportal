<x-layouts.app title="Profile">
    
    <!--
    <p>Your email: {{ auth()->user()->email }}</p>
    <p>Your role: {{ auth()->user()->roles[0]->name }}</p>

    @if(auth()->check() && (auth()->user()->hasRole('patient')))
    <p>Name: {{ auth()->user()->patient->name }}</p>
    @endif
    -->

    <div class="d-flex justify-content-center mt-5">
        <div class="w-100" style="max-width: 600px;">
            <h2 class="mb-4">Welcome!</h2>
            <p>Here is your profile information. You can update it below:</p>
            {{-- Profile Update Form --}}
            <form hidden id="profile-form">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control" required>
                </div>

                <!-- <div class="mb-3"> 
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone ?? '' }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control">{{ auth()->user()->address ?? '' }}</textarea>
        </div> -->

                <button type="submit" class="btn btn-success">Update Profile</button>
            </form>

            <form id="updateProfileForm">
                @csrf
                <div class="body">
                    <div id="updateUserResponseMsg" class="alert alert-danger d-none"></div>

                    @if(auth()->check() && (auth()->user()->hasRole('patient')))
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->patient->name }}" class="form-control" required>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label>Email/Username</label>
                        <input type="text" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="...">
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label> 
                        <input type="password" name="password_confirmation" class="form-control" placeholder="...">
                    </div>

                </div>

                <div class="footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        window.profileRoutes = {
            update: "{{ route('profile.update') }}",
        };
    </script>
    <script src="{{ asset('js/profile.js') }}"></script>
    @endpush


</x-layouts.app>