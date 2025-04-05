$(document).ready(function () {
    // Handle form submission
    $('#setupForm').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#submitSetup');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    html: 'Tautan konfirmasi telah dikirim ke email Anda. Silakan cek email Anda untuk mengaktifkan akun.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login';
                    }
                });
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                submitBtn.html('Kirim Tautan');
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    
                    for (const key in errors) {
                        errorMessage += errors[key][0] + '<br>';
                    }
                    
                    Swal.fire({
                        title: 'Gagal Setup Akun',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses setup akun',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
