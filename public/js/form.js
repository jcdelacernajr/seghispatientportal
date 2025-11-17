/**
 * Reusable AJAX Form Submitter using Axios
 *
 * Usage:
 * ajaxFormSubmit('#addProfileForm', '/store/url', (response) => { ... });
 */

function ajaxFormSubmit(formSelector, url, onSuccess, onError = null) {
    
    document.addEventListener('submit', function(event) {
        if (!event.target.matches(formSelector)) return;
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        axios.post(url, formData)
            .then(response => {
                //console.log(response);
                if (typeof onSuccess === "function") {
                    onSuccess(response.data);
                }

                // Reset the form
                form.reset();
            })
            .catch(error => {
                if (typeof onError === "function") {
                    onError(error);
                } else {
                    alert(
                        error.response?.data?.message ||
                        "An error occurred."
                    );
                }
            });
    });
}
