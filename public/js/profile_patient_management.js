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
        function (response) {
            document.getElementById('successMsg').classList.remove('d-none');
            document.getElementById('successMsg').innerText = response.message;
            table.ajax.reload();
        }
    );
});
