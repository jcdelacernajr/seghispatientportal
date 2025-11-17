<x-layouts.app title="Medical records">

    <h2 class="mb-4">Patient Medical Records</h2>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="recordTypeFilter">Record Type:</label>
            <select id="recordTypeFilter" class="form-select">
                <option value="">All</option>
                <option value="X-ray">X-ray</option>
                <option value="Physical Exam">Physical Exam</option>
                <option value="Lab Result">Lab Result</option>
                <option value="Vaccination">Vaccination</option>
                <option value="Ultrasound">Ultrasound</option>
            </select>
        </div>
    </div>
    
    <table class="table table-bordered" id="patienMedicalRecordsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Record Type</th>
                <th>Description</th>
                <th>Record Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.medicalRecordsRoutes = {
            list: "{{ route('medical-records.list') }}",
        };
    </script>
    <script src="{{ asset('js/medical_records.js') }}"></script>
    @endpush

</x-layouts.app>