/**
 * Reusable DataTable Loader using Axios
 *
 * Usage:
 * loadDataTable('#profilePatientTable', '/api/url', [
 *   { data: 'id', name: 'id' },
 *   ...
 * ]);
 */

function loadDataTable(tableSelector, ajaxUrl, columns) {
    return $(tableSelector).DataTable({
        processing: true,
        serverSide: true,

        ajax: function(data, callback) {
            axios.get(ajaxUrl, { params: data })
                .then(response => {
                    callback(response.data);
                })
                .catch(error => {
                    console.error("DataTable Axios Error:", error);
                });
        },

        columns: columns
    });
}
