<div class="modal fade" id="appointmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="appointmentForm">
                @csrf
                <input type="hidden" id="appointment_id">

                <div class="modal-header">
                    <h5 class="modal-title">Appointment</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                </div>

                <div class="modal-body">
                    <div id="appointmentErrorMsg" class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Time</label>
                        <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
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
