<x-layouts.app title="Medical records">

    <h2 class="mb-4">Patient Medical Records</h2>
    <div id="medicalrecordSuccessMsg" class="alert alert-success d-none"></div>

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
        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('doctor')))
        <div class="col-md-3 d-flex flex-column">
            <button class="btn btn-primary" id="btnAddMedicalRecord">Add Medical Record</button> 
        </div>
        @endif
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
    
    <!-- PDF Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Medical Record PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfFrame" src="" frameborder="0" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>

    @include('app.medical_record.add_modal')
    @include('app.medical_record.edit_modal') 

    @push('scripts')
    <script>
        window.medicalRecordsRoutes = {
            list: "{{ route('medical-records.list') }}",
            store: "{{ route('medical-records.store') }}",
            show: "{{ route('medical-records.show', ':id') }}",
            update: "{{ route('medical-records.update') }}",
            delete: "{{ route('medical-records.delete', ':id') }}",
        };
    </script>
    <script src="{{ asset('js/medical_records.js') }}"></script>
    @endpush

</x-layouts.app>