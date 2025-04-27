$(document).ready(function() {
    $('#formGantiPassword').submit(function(e) {     
        e.preventDefault(); 
        const newPassword = $('#newPw').val();
        const confirmPassword = $('#confirmPw').val();

        const submitButton = $('#submitGantiPassword');
        const originalButtonText = submitButton.html(); 

        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');

        $('#alert-area').html(''); 

        if (newPassword !== confirmPassword) {
            let errorHtml = `
                <div class="alert alert-danger">
                    Kata sandi baru dan konfirmasi kata sandi tidak cocok.
                </div>
            `;
            $('#alert-area').html(errorHtml);
        } else {
            this.submit(); 
        }
    });
});
