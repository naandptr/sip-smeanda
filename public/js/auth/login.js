$(document).ready(function () {
    $('#loginForm').submit(function (e) {
        e.preventDefault(); 

        const submitButton = $('#submitLogin');
        const alertError = $('#alert-error');
        
        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');
        alertError.hide().empty(); 

        $.ajax({
            url: $(this).attr('action'), 
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                window.location.href = response.redirect || "{{ route('dashboard') }}";
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        alertError.append('<div>' + value[0] + '</div>');
                    });
                } else {
                    alertError.append('<div>Terjadi kesalahan. Silakan coba lagi.</div>');
                }

                alertError.show();
                submitButton.prop('disabled', false).html('Masuk');
            }
        });
    });
});
