$(document).ready(function () {
    $('#formGantiPassword').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: routeGantiPassword, 
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = response.redirect_to; 
                });
                $('#formGantiPassword')[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let messages = Object.values(errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: messages,
                    });
                } else if (xhr.status === 400) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Coba lagi nanti.',
                    });
                }
            }
        });
    });
});