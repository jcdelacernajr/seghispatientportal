document.addEventListener('DOMContentLoaded', function () {
    var pdfModal = document.getElementById('pdfModal');
    var iframe = pdfModal.querySelector('#pdfFrame');

    pdfModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var pdfUrl = button.getAttribute('data-pdf');
        var notificationId = button.getAttribute('data-id');

        // Load PDF
        iframe.src = pdfUrl;

        // Mark as read via AJAX
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(res => res.json())
        .then(data => {
            console.log('Notification marked as read:', data);
            // Optionally, remove "Unread" badge
            button.classList.remove('badge', 'bg-primary');
        })
        .catch(err => console.error(err));
    });

    pdfModal.addEventListener('hidden.bs.modal', function () {
        iframe.src = ''; // Clear iframe
    });
});
