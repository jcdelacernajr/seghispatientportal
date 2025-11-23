<x-layouts.app title="Profile Patient Management">

    <h2 class="mb-4">Profile Patient Management</h2>
    <!-- Button to trigger modal -->
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProfileModal">
            Add User
        </button>
    </div>

    <!-- Users Table -->
    <table class="table table-bordered" id="profilePatientTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal -->
    <!-- Add Form -->
    <form id="addProfileForm">
        <div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProfileModalLabel">Add New Profile Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    <!-- Success Message -->
                    <div id="responseAddMsg" class="alert d-none"></div>
                        @csrf
                        <div class="col-md mb-3">
                            <label>Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md mb-3">
                            <label>Phone No.</label>
                            <input type="text" name="phone_no" class="form-control" placeholder="Phone No" required>
                        </div>
                        <div class="col-md mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                        </div>
                        <div class="col-md mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="row">
                            <div class="col-md mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="text-end mt-3">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Edit Form -->
    <form id="editProfileForm">
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Patient Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    <!-- Success Message -->
                    <div id="responseEditMsg" class="alert d-none"></div>
                        @csrf
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="col-md mb-3">
                            <label>Role</label>
                            <select name="role_id" id="edit_role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md mb-3">
                            <label>Phone No.</label>
                            <input type="text" name="phone_no"  id="edit_phone_no" class="form-control" placeholder="Phone No" required>
                        </div>
                        <div class="col-md mb-3">
                            <label>Address</label>
                            <textarea name="address" id="edit_address" class="form-control" placeholder="Address" required></textarea>
                        </div>
                        <div class="col-md mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="row">
                            <div class="col-md mb-3">
                                <label>Password</label>
                                <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="text-end mt-3">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        window.profilePatientRoutes = {
            list: "{{ route('profile-patient-management.list') }}",
            store: "{{ route('profile-patient-management.store') }}",
            update: "{{ route('profile-patient-management.update') }}",
            patient: "{{ route('profile-patient-management.patient', ':id') }}",
            delete: "{{ route('profile-patient-management.delete', ':id') }}",
        };
    </script>
    <script src="{{ asset('js/profile_patient_management.js') }}"></script>
    @endpush

</x-layouts.app> 