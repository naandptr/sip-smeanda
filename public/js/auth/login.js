$(document).ready(function() {
    $('#loginForm').submit(function(e) {       
        const submitBtn = $('#submitLogin');
        
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
    });
});
