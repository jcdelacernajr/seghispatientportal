<x-layouts.app title="Appointments">

<h2 class="mb-3">Appointments</h2>
<div class="d-flex justify-content-end">
    <button class="btn btn-primary mb-3" id="btnAddAppointment">Add Appointment</button>
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

@include('app.appointments.modal')

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.appointmentRoutes = {
        list: "{{ route('appointments.list') }}",
    };
</script>
<script src="{{ asset('js/appointments.js') }}"></script>
@endpush

</x-layouts.app>
