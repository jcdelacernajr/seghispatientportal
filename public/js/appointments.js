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

    // Function to get filter values
    function getFilters() {
        return {
            start_date: document.getElementById('startDate')?.value || null,
            end_date: document.getElementById('endDate')?.value || null,
            status: document.getElementById('statusFilter')?.value || null,
        };
    }

    // Override the internal Axios request to include filters
    table.on('preXhr.dt', function (e, settings, data) {
        const filters = getFilters();
        data.start_date = filters.start_date;
        data.end_date = filters.end_date;
        data.status = filters.status;
    });

    // Reload table when filters change
    ['startDate', 'endDate', 'statusFilter'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', () => table.ajax.reload());
    });

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

            const successDiv = document.getElementById('appointmentSuccessMsg');
            successDiv.classList.remove('d-none');
            successDiv.innerHTML = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                successDiv.classList.add('d-none');
                successDiv.innerText = '';
            }, 3000);
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

            const successDiv = document.getElementById('appointmentSuccessMsg');
            successDiv.classList.remove('d-none');
            successDiv.innerHTML = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                successDiv.classList.add('d-none');
                successDiv.innerText = '';
            }, 3000);
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
        function(response){
            table.ajax.reload();

            const successDiv = document.getElementById('appointmentSuccessMsg');
            successDiv.classList.remove('d-none');
            successDiv.innerHTML = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                successDiv.classList.add('d-none');
                successDiv.innerText = '';
            }, 3000);

        },
        function(errorMsg){
            alert(errorMsg);
        }
    );

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.cancelAppointment')){

            if (confirm('Are you sure you want to Cancel your appointment?')) {
                let userId = e.target.getAttribute('data-id');
                axios.post(appointmentRoutes.cancel.replace(':id', userId), {
                    _method: 'PUT'
                })
                .then(response => {
                    // alert(response.data.message);
                    table.ajax.reload();

                    const successDiv = document.getElementById('appointmentSuccessMsg');
                    successDiv.classList.remove('d-none');
                    successDiv.innerHTML = response.data.message;

                    // Fade out after 3 seconds
                    setTimeout(() => {
                        successDiv.classList.add('d-none');
                        successDiv.innerText = '';
                    }, 3000);
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to cancel appointment.');
                });
            }
        }
    });

    document.querySelector('#appointmentsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.confirmAppointment')){
            if (confirm('Are you sure you want to Confirm this appointment?')) {
                let userId = e.target.getAttribute('data-id');
                axios.post(appointmentRoutes.confirm.replace(':id', userId), {
                    _method: 'PUT'
                })
                .then(response => {
                    //alert(response.data.message);
                    table.ajax.reload();

                    const successDiv = document.getElementById('appointmentSuccessMsg');
                    successDiv.classList.remove('d-none');
                    successDiv.innerHTML = response.data.message;

                    // Fade out after 3 seconds
                    setTimeout(() => {
                        successDiv.classList.add('d-none');
                        successDiv.innerText = '';
                    }, 3000);
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to confirm appointment.');
                });
            }
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
