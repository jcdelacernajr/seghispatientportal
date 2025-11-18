document.addEventListener('DOMContentLoaded', () => {
    // Initialize DataTable
    let table = loadDataTable(
        "#appointmentsTable",
        appointmentRoutes.list,
        [
            { data: "name", name: "name" },
            { data: "title", name: "title" },
            { data: "appointment_date", name: "appointment_date" },
            { data: "appointment_time", name: "appointment_time" },
            { data: "status", name: "status" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ]
    );

    const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));

    document.getElementById('btnAddAppointment').addEventListener('click', () => {
        clearForm();
        modal.show();
    });

    ajaxFormSubmit(
        "#appointmentForm",
        appointmentRoutes.store,
        "POST",
        function (response) {
            modal.hide();
            table.ajax.reload();
        },
        function (error) {  
            const errorDiv = document.getElementById('appointmentErrorMsg');
            errorDiv.classList.remove('d-none');
            errorDiv.innerHTML = error;

            // Fade out after 3 seconds
            setTimeout(() => {
                errorDiv.classList.add('d-none');
                errorDiv.innerText = '';
            }, 3000);
        }
    );

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.editAppointment')){
            let userId = e.target.getAttribute('data-id');
            axios.get(appointmentRoutes.appointment.replace(':id', userId))
                .then(res => {
                    const appointment = res.data;
                    document.getElementById('edit_appointment_id').value = appointment.id; 
                    document.getElementById('edit_title').value = appointment?.title || "";
                    document.getElementById('edit_appointment_date').value = appointment?.appointment_date;
                    document.getElementById('edit_appointment_time').value = appointment?.appointment_time;
                    document.getElementById('edit_notes').value = appointment?.notes;
                });
        }
    });


});

// Load 1 record
function editAppointment(id) {
    axios.get(`/appointments/${id}`).then(res => {
        let d = res.data;
        appointment_id.value = d.id;
        title.value = d.title;
        appointment_date.value = d.appointment_date;
        appointment_time.value = d.appointment_time;
        notes.value = d.notes;

        new bootstrap.Modal(document.getElementById('appointmentModal')).show();
    });
}

// Delete
function deleteAppointment(id) {
    if (confirm("Are you sure?")) {
        axios.delete(`/appointments/${id}`).then(() => {
            loadAppointments();
        });
    }
}

function clearForm() {
    appointment_id.value = '';
    title.value = '';
    appointment_date.value = '';
    appointment_time.value = '';
    notes.value = '';
}
