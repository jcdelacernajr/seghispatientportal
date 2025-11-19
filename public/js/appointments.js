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

    const modal = new bootstrap.Modal(document.getElementById('addAppointmentModal')); 
    const btnAddAppointment = document.getElementById('btnAddAppointment');
    if(btnAddAppointment) {
        btnAddAppointment.addEventListener('click', () => {
            clearForm();
            modal.show();
        });
    }
    ajaxFormSubmit(
        "#addAppointmentForm",
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

    const editModal = new bootstrap.Modal(document.getElementById('editAppointmentModal'));

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.editAppointment')){
            let userId = e.target.getAttribute('data-id');
            axios.get(appointmentRoutes.appointment.replace(':id', userId))
                .then(res => {
                    const appointment = res.data;
                    document.getElementById('edit_appointment_id').value = appointment.id; 
                    document.getElementById('edit_title').value = appointment.title;
                    document.getElementById('edit_appointment_date').value = appointment.appointment_date;
                    document.getElementById('edit_appointment_time').value = appointment.appointment_time;
                    document.getElementById('edit_notes').value = appointment.notes;

                    editModal.show();
                });
        }
    });

    ajaxFormSubmit(
        "#editAppointmentForm",
        appointmentRoutes.update,
        "POST",
        function (response) {
            editModal.hide();
            table.ajax.reload();
        },
        function (error) {  
            const errorDiv = document.getElementById('editAppointmentErrorMsg');
            errorDiv.classList.remove('d-none');
            errorDiv.innerHTML = error;

            // Fade out after 3 seconds
            setTimeout(() => {
                errorDiv.classList.add('d-none');
                errorDiv.innerText = '';
            }, 3000);
        }
    );

    deleteRow(
        '#appointmentsTable', 
        appointmentRoutes.delete,
        function(data){
            table.ajax.reload();
        },
        function(errorMsg){
            alert(errorMsg);
        }
    );

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.cancelAppointment')){
            let userId = e.target.getAttribute('data-id');
            axios.post(appointmentRoutes.cancel.replace(':id', userId), {
                _method: 'PUT'
            })
            .then(response => {
                alert(response.data.message);
                table.ajax.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Failed to cancel appointment.');
            });
        }
    });

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.confirmAppointment')){
            let userId = e.target.getAttribute('data-id');
            axios.post(appointmentRoutes.confirm.replace(':id', userId), {
                _method: 'PUT'
            })
            .then(response => {
                alert(response.data.message);
                table.ajax.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Failed to confirm appointment.');
            });
        }
    });

});

function clearForm() {
    appointment_id.value = '';
    title.value = '';
    appointment_date.value = '';
    appointment_time.value = '';
    notes.value = '';
}
