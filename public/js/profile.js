document.addEventListener("DOMContentLoaded", () => {
    ajaxFormSubmit(
        "#updateProfileForm",
        profileRoutes.update,
        "POST",
        function (response) {
            const msgSuccessDiv = document.getElementById('updateUserResponseMsg');
            msgSuccessDiv.classList.remove('d-none', 'alert-danger');
            msgSuccessDiv.classList.add('alert-success');
            msgSuccessDiv.innerText = response.message;

            // Fade out after 3 seconds
            setTimeout(() => {
                msgSuccessDiv.classList.add('d-none');
                msgSuccessDiv.classList.remove('alert-success');
                msgSuccessDiv.innerText = '';
            }, 3000);
        },
        function (errorMsg) {
            const msgErrorDiv = document.getElementById('updateUserResponseMsg');
            msgErrorDiv.classList.remove('d-none', 'alert-success');
            msgErrorDiv.classList.add('alert-danger');
            msgErrorDiv.innerText = errorMsg;

            // Fade out after 3 seconds
            setTimeout(() => {
                msgErrorDiv.classList.add('d-none');
                msgErrorDiv.classList.remove('alert-danger');
                msgErrorDiv.innerText = '';
            }, 3000);
        }
    );
});
