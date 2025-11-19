document.addEventListener("DOMContentLoaded", function () {
    // Function to get filter values
    function getFilters() {
        return {
            start_date: document.getElementById('startDate')?.value || null,
            end_date: document.getElementById('endDate')?.value || null,
            record_type: document.getElementById('recordTypeFilter')?.value || null,
        };
    }

    // Initialize DataTable
    let table = loadDataTable(
        "#patienMedicalRecordsTable",
        medicalRecordsRoutes.list,
        [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "record_type", name: "record_type" },
            { data: "description", name: "description" },
            { data: "record_date", name: "record_date" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ]
    );

    // Override the internal Axios request to include filters
    table.on('preXhr.dt', function (e, settings, data) {
        const filters = getFilters();
        data.start_date = filters.start_date;
        data.end_date = filters.end_date;
        data.record_type = filters.record_type;
    });

    // Reload table when filters change
    ['startDate', 'endDate', 'recordTypeFilter'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', () => table.ajax.reload());
    });

    const addModal = new bootstrap.Modal(document.getElementById('addMedicalRecordModal'));
    document.getElementById('btnAddMedicalRecord').addEventListener('click', () => {
        clearForm();
        addModal.show();
    });

    ajaxFormSubmit(
        "#addMedicalRecorForm",
        medicalRecordsRoutes.store,
        "POST",
        function (response) {
            addModal.hide();
            table.ajax.reload();

            const successDiv = document.getElementById('medicalrecordSuccessMsg');
            successDiv.classList.remove('d-none');
            successDiv.innerHTML = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                successDiv.classList.add('d-none');
                successDiv.innerText = '';
            }, 3000);
        },
        function (error) {  
            const errorDiv = document.getElementById('medicalrecordErrorMsg');
            errorDiv.classList.remove('d-none');
            errorDiv.innerHTML = error;

            // Fade out after 3 seconds
            setTimeout(() => {
                errorDiv.classList.add('d-none');
                errorDiv.innerText = '';
            }, 3000);
        }
    );
    
    const editModal = new bootstrap.Modal(document.getElementById('editMedicalRecordModal'));

    document.querySelector('#patienMedicalRecordsTable tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.editMedicalRecord')){
            let userId = e.target.getAttribute('data-id');
            axios.get(medicalRecordsRoutes.show.replace(':id', userId))
                .then(res => {
                    const medicalRecord = res.data;
                    document.getElementById('edit_medical_record_id').value = medicalRecord.id; 
                    document.getElementById('edit_patient_id').value = medicalRecord.patient_id;
                    document.getElementById('edit_record_type').value = medicalRecord.record_type;
                    document.getElementById('edit_description').value = medicalRecord.description;
                    document.getElementById('edit_record_date').value = medicalRecord.record_date;

                    editModal.show();
                });
        }
    });

    ajaxFormSubmit(
        "#editMedicalRecorForm",
        medicalRecordsRoutes.update,
        "POST",
        function (response) {
            editModal.hide();
            table.ajax.reload();

            const successDiv = document.getElementById('medicalrecordSuccessMsg');
            successDiv.classList.remove('d-none');
            successDiv.innerHTML = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                successDiv.classList.add('d-none');
                successDiv.innerText = '';
            }, 3000);
        },
        function (error) {  
            const errorDiv = document.getElementById('medicalrecordErrorMsg');
            errorDiv.classList.remove('d-none');
            errorDiv.innerHTML = error;

            // Fade out after 3 seconds
            setTimeout(() => {
                errorDiv.classList.add('d-none');
                errorDiv.innerText = '';
            }, 3000);
        }
    );
});

function clearForm() {
   // TODO
}
