$(document).ready(function () { 
    $('#formGantiPasswordAwal').submit(function() {
        const submitButton = $('#submitGantiPasswordAwal');

        submitButton.prop('disabled', true).html('<span class="spinner"></span> Memproses...');
    });
});
