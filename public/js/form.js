function ajaxFormSubmit(formSelector, url, method = 'POST', onSuccess, onError = null) {

    document.addEventListener('submit', function(event) {
        if (!event.target.matches(formSelector)) return;
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        axios({
            method: method.toLowerCase(), // 'post', 'put', 'patch'
            url: url,
            data: formData
        })
        .then(response => {
            if (typeof onSuccess === "function") {
                onSuccess(response.data);
            }
        })
        .catch(error => {
            if (typeof onError === "function") {
                const errorMsg = error.response?.data?.error || error.response?.data?.message || "An error occurred.";
                onError(errorMsg);
            } else {
                alert(error.response?.data?.message || "An error occurred.");
            }
        });
    });
}
