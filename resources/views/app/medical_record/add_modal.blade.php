<div class="modal fade" id="addMedicalRecordModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addMedicalRecorForm">
                @csrf
                <input type="hidden" id="medical_record_id">

                <div class="modal-header">
                    <h5 class="modal-title">Add Medical Record</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                </div>

                <div class="modal-body">
                    <div id="medicalrecordErrorMsg" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label>Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->patient->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Record Type</label>
                        <input type="text" name="record_type" id="record_type" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Record Date</label>
                        <input type="date" name="record_date" id="record_date" class="form-control"></input>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>