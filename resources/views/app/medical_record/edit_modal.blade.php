<div class="modal fade" id="editMedicalRecordModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMedicalRecorForm">
                @csrf
                <input type="hidden" name="medical_record_id" id="edit_medical_record_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Medical Record</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                </div>

                <div class="modal-body">
                    <div id="medicalrecordErrorMsg" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label>Patient</label>
                        <select name="patient_id" id="edit_patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->patient->id }}">{{ $patient->patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Record Type</label>
                        <select name="record_type" id="edit_record_type" class="form-select">
                            <option value="">All</option>
                            <option value="X-ray">X-ray</option>
                            <option value="Physical Exam">Physical Exam</option>
                            <option value="Lab Result">Lab Result</option>
                            <option value="Vaccination">Vaccination</option>
                            <option value="Ultrasound">Ultrasound</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Record Date</label>
                        <input type="date" name="record_date" id="edit_record_date" class="form-control"></input>
                    </div>
                    <div class="mb-3">
                        <label>Upload PDF <small class="text-muted">(Only PDF files allowed.)</small></label>
                        <input type="file" name="medical_record_file" id="edit_medical_record_file" class="form-control" accept="application/pdf">
                        
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