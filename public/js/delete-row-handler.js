function deleteRow(tableSelector, deleteUrl, onSuccess = null, onError = null) {
    document.querySelector(tableSelector + ' tbody').addEventListener('click', function(e){
        if(e.target && e.target.matches('.deleteBtn')){
            const id = e.target.getAttribute('data-id');
            if(!confirm("Are you sure you want to delete this item?")) return;

            axios.delete(deleteUrl.replace(':id', id))
                .then(res => {
                    if(typeof onSuccess === 'function') onSuccess(res.data);
                })
                .catch(err => {
                    const errorMsg = err.response?.data?.message || "Failed to delete.";
                    if(typeof onError === 'function') onError(errorMsg);
                    else alert(errorMsg);
                });
        }
    });
}