$(document).ready(function () {
    const buttons = document.querySelectorAll('[data-file-url]');
    const image = document.getElementById('previewImage');
    const pdf = document.getElementById('previewPDF');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const fileUrl = this.getAttribute('data-file-url');
            const fileExtension = fileUrl.split('.').pop().toLowerCase();

            image.style.display = 'none';
            pdf.style.display = 'none';

            if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                image.src = fileUrl;
                image.style.display = 'block';
            } else if (fileExtension === 'pdf') {
                pdf.src = fileUrl;
                pdf.style.display = 'block';
            }

            const modalElement = document.getElementById('modalDetailPresensi');
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
        });
    });
});