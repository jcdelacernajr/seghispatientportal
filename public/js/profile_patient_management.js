document.addEventListener("DOMContentLoaded", function () {
    // Initialize DataTable
    let table = loadDataTable(
        "#profilePatientTable",
        profilePatientRoutes.list,
        [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "email", name: "email" },
            {
                data: "roles",
                name: "roles",
                orderable: false,
                searchable: false,
            },
            { data: "created_at", name: "created_at" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ]
    );

    // Add User Form (Modal)
    ajaxFormSubmit(
        "#addProfileForm",
        profilePatientRoutes.store,
        "POST",
        function (response) {
            const form = document.querySelector("#addProfileForm"); // select the form
            form.reset(); // reset the form fields

            const msgDiv = document.getElementById('responseAddMsg');
            msgDiv.classList.remove('d-none', 'alert-danger');
            msgDiv.classList.add('alert-success');
            msgDiv.innerText = response.message;
            table.ajax.reload();

            // Fade out after 3 seconds
            setTimeout(() => {
                msgDiv.classList.add('d-none');
                msgDiv.classList.remove('alert-success');
                msgDiv.innerText = '';
            }, 3000);
        },
        function (errorMsg) {  
            const msgDiv = document.getElementById('responseAddMsg');
            msgDiv.classList.remove('d-none', 'alert-success');
            msgDiv.classList.add('alert-danger');
            msgDiv.innerText = errorMsg;

            // Fade out after 3 seconds
            setTimeout(() => {
                msgDiv.classList.add('d-none');
                msgDiv.classList.remove('alert-danger');
                msgDiv.innerText = '';
            }, 3000);
        }
    );

    document.querySelector('#profilePatientTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.editProfilePatient')){
            let userId = e.target.getAttribute('data-id');
            axios.get(profilePatientRoutes.patient.replace(':id', userId))
                .then(res => {
                    const user = res.data;
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_name').value = user.patient?.name || "";
                    document.getElementById('edit_phone_no').value = user.patient?.phone || "";
                    document.getElementById('edit_address').value = user.patient?.address || "";
                    document.getElementById('edit_email').value = user.patient?.email || "";
                    document.getElementById('edit_role_id').value = user.roles[0]?.id || '';
                });
        }
    });

     ajaxFormSubmit(
        "#editProfileForm",
        profilePatientRoutes.update,
        "POST",
        function (response) {
            const msgDiv = document.getElementById('responseEditMsg');
            msgDiv.classList.remove('d-none', 'alert-danger');
            msgDiv.classList.add('alert-success');
            msgDiv.innerText = response.message;
            table.ajax.reload();

            // Fade out after 3 seconds
            setTimeout(() => {
                msgDiv.classList.add('d-none');
                msgDiv.classList.remove('alert-success');
                msgDiv.innerText = '';
            }, 3000);
        },
        function (errorMsg) {  
            const msgDiv = document.getElementById('responseEditMsg');
            msgDiv.classList.remove('d-none', 'alert-success');
            msgDiv.classList.add('alert-danger');
            msgDiv.innerText = errorMsg;

            // Fade out after 3 seconds
            setTimeout(() => {
                msgDiv.classList.add('d-none');
                msgDiv.classList.remove('alert-danger');
                msgDiv.innerText = '';
            }, 3000);
        }
    );

    deleteRow(
        '#profilePatientTable', 
        profilePatientRoutes.delete,
        function(data){
            table.ajax.reload();
        },
        function(errorMsg){
            alert(errorMsg);
        }
    );

});
