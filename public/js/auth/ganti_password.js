$(document).ready(function() {
    $('#formGantiPassword').submit(function(e) {     
        e.preventDefault(); 

        const submitButton = $('#submitGantiPassword');
        const originalButtonText = submitButton.html(); 
        const alertArea = $('#alert-area');

        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');
        alertArea.html(''); 

        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = response.redirect; 
                }
            },
            
            error: function(xhr) {
                let response = xhr.responseJSON;
                let firstError = 'Terjadi kesalahan. Silakan coba lagi.'; 
            
                if (response && response.errors) {
                    const errorsArray = Object.values(response.errors).flat();
                    if (errorsArray.length > 0) {
                        firstError = errorsArray[0]; 
                    }
                }
            
                let errorHtml = `<div class="alert alert-danger">${firstError}</div>`;
            
                $('#alert-area').html(errorHtml);
                submitButton.prop('disabled', false).html(originalButtonText);
            }
            
        });
    });
});

