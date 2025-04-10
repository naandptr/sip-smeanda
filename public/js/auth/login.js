$(document).ready(function() {
    // Handle form submission
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#submitLogin');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Redirect to the intended page
                window.location.href = response.redirectUrl; // Pastikan server mengembalikan URL ini
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                submitBtn.html('Login');
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    
                    for (const key in errors) {
                        errorMessage += errors[key][0] + '<br>';
                    }
                    
                    Swal.fire({
                        title: 'Gagal Login',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses login',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
