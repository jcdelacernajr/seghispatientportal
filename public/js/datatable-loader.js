/**
 * Reusable DataTable Loader using Axios
 */
function loadDataTable(tableSelector, ajaxUrl, columns) {
    return $(tableSelector).DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
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
