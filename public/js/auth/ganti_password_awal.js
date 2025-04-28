$(document).ready(function () {
    $('#formGantiPasswordAwal').submit(function(e) {
        e.preventDefault(); 
        
        const submitButton = $('#submitGantiPasswordAwal');
        
        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');

        const formData = $(this).serialize();      

        $.ajax({
            url: $(this).attr('action'), 
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = "{{ route('dashboard') }}";
                }
            },
            error: function(xhr) {
                let alertError = $('#errorAlert');
                alertError.html(''); 
                
                if (xhr.status === 422) {
                    let response = xhr.responseJSON;
                    if (!response) {
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            console.error("Parsing JSON gagal", e);
                        }
                    }

                    if (response && response.errors) {
                        let firstError = response.errors[0];
                        alertError.append('<div class="alert alert-danger">' + firstError + '</div>');
                    } else {
                        alertError.append('<div class="alert alert-danger">Terjadi kesalahan validasi. Silakan coba lagi.</div>');
                    }
                } else {
                    alertError.append('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                }
                alertError.show();
                submitButton.prop('disabled', false).html('Atur Kata Sandi');
            }
        });
    });
});
