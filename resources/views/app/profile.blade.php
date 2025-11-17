<x-layouts.app title="Profile">

    <h2 class="mb-4">Welcome!</h2>
    <p>Your email: {{ auth()->user()->email }}</p>
    <p>Your role: {{ auth()->user()->roles[0]->name }}</p>

    <p>Here is your profile information. You can update it below:</p>

    {{-- Profile Update Form --}}
    <form id="profile-form">
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

</x-layouts.app>
