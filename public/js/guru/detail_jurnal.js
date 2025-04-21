$(document).ready(function () {
    $('.form-validasi').submit(function (e) {
        console.log('Submit form jalan');
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let jurnal_id = url.split('/').pop();

        if (jurnal_id === undefined) {
            console.error("jurnal_id is undefined");
            return;
        }

        console.log('jurnal_id:', jurnal_id);

        let data = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (response) {
                console.log(response); // Debug
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            },
        
            error: function (xhr) {
                let errorMessage = '';
            
                if (xhr.status === 403 && xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorMessage += `${value[0]}<br>`;
                    });
                } else {
                    errorMessage = 'Terjadi kesalahan. Coba lagi nanti.';
                }
            
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessage,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
            
        });
    });
});
