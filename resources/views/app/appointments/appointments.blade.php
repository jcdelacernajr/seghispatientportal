<x-layouts.app title="Appointments">

<h2 class="mb-3">Patient Appointments</h2>

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
