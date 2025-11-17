<x-layouts.app title="Profile Patient Management">

    <h2 class="mb-4">Profile Patient Management</h2>
    <!-- Button to trigger modal -->
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProfileModal">
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
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-m">

            <!-- Add User Form -->
            <form id="addProfileForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProfileModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Success Message -->
                        <div id="successMsg" class="alert alert-success d-none"></div>

                        @csrf
                        <div class="col-md mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md mb-2">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md mb-2">
                            <select name="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md mb-2">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md mb-2">
                                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {

                // Initialize DataTable
                let table = loadDataTable('#profilePatientTable',
                    "{{ route('profile-patient-management.list') }}",
                    [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'roles',
                            name: 'roles',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        }
                    ]
                );

                // Add User Form Submission
                ajaxFormSubmit(
                    '#addProfileForm',
                    "{{ route('profile-patient-management.store') }}",
                    function(response) {
                        $('#successMsg').removeClass('d-none').text(response.message);
                        table.ajax.reload();
                        $('#addUserModal').modal('hide');
                    }
                );

            });
        </script>
        @endpush

</x-layouts.app>