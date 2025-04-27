$(document).ready(function () {
    $('#formLupaPassword').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);

        const submitButton = $('#submitLupaPassword');
        const originalButtonText = submitButton.html(); 

        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    html: 'Tautan pemulihan kata sandi telah dikirim ke email Anda.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login';
                    }
                });
            },
            error: function(xhr) {       
                let errorHtml = '<div class="alert alert-danger">';
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    
                    for (const key in errors) {
                        errorHtml += `<div>${errors[key][0]}</div>`;
                    }
                } else {
                    errorHtml += '<div>Terjadi kesalahan saat mengirim email.</div>';
                }

                errorHtml += '</div>';

                $('#alert-area').html(errorHtml);
            },
            complete: function() {
                submitButton.prop('disabled', false).html(originalButtonText);
            }
        });
    });
});
