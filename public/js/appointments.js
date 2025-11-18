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

    document.getElementById('appointmentForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let id = document.getElementById('appointment_id').value;
        let url = id ? `/appointments/${id}` : '/appointments';
        let method = id ? 'PUT' : 'POST';

        axios({
            url: url,
            method: method,
            data: {
                title: title.value,
                appointment_date: appointment_date.value,
                appointment_time: appointment_time.value,
                notes: notes.value
            }
        }).then(res => {
            loadAppointments();
            modal.hide();
        });
    });
});

// function loadAppointments() {
//     axios.get('/api/appointments-list').then(res => {
//         let tbody = document.querySelector('#appointmentsTable tbody');
//         tbody.innerHTML = '';

//         res.data.forEach(item => {
//             tbody.innerHTML += `
//                 <tr>
//                     <td>${item.title}</td>
//                     <td>${item.appointment_date}</td>
//                     <td>${item.appointment_time}</td>
//                     <td>${item.status}</td>
//                     <td>
//                         <button class="btn btn-sm btn-warning" onclick="editAppointment(${item.id})">Edit</button>
//                         <button class="btn btn-sm btn-danger" onclick="deleteAppointment(${item.id})">Delete</button>
//                     </td>
//                 </tr>
//             `;
//         });
//     });
// }

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
