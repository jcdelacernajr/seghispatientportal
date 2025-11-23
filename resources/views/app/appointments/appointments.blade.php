<x-layouts.app title="Appointments">

    <h2 class="mb-3">Patient Appointments</h2>
    <div id="appointmentSuccessMsg" class="alert alert-success d-none"></div>

    <div class="row mb-3 align-items-end">
        <div class="col-md-3 d-flex flex-column">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" class="form-control">
        </div>
        <div class="col-md-3 d-flex flex-column">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" class="form-control">
        </div>
        <div class="col-md-3 d-flex flex-column">
            <label for="statusFilter">Status:</label>
            <select id="statusFilter" class="form-select">
                <option value="">All</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        @if(auth()->check() && (auth()->user()->hasRole('patient')))
        <div class="col-md-3 d-flex flex-column">
            <button class="btn btn-primary" id="btnAddAppointment">Add Appointment</button>
        </div>
        @endif
    </div>

    <table class="table table-bordered" id="appointmentsTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th width="150px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    @include('app.appointments.add_modal')
    @include('app.appointments.edit_modal')

    @push('scripts')
    <script>
        window.appointmentRoutes = {
            list: "{{ route('appointments.list') }}",
            store: "{{ route('appointments.store') }}",
            appointment: "{{ route('appointments.show', ':id') }}",
            update: "{{ route('appointments.update') }}",
            delete: "{{ route('appointments.delete', ':id') }}",
            cancel: "{{ route('appointments.cancel', ':id') }}",
            confirm: "{{ route('appointments.confirm', ':id') }}",
        };
    </script>
    <script src="{{ asset('js/appointments.js') }}"></script>
    @endpush

</x-layouts.app>