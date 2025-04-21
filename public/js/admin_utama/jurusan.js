$(document).ready(function() {
    $("#tambahJurusan").click(function () {
        $("#modalJurusan form")[0].reset();
        $('#status').val('Aktif');
        $("#updateJurusan").hide(); 
        $("#submitJurusan").show(); 
        $("#modalJurusan").modal("show");
    });

    $(".editJurusan").click(function () {
        let id = $(this).data("id");
        
        $.get(`/kelola-jurusan/${id}/edit`, function (data) {
            $("#kodeJurusan").val(data.kode_jurusan);
            $("#namaJurusan").val(data.nama_jurusan);
            $("#statusJurusan").val(data.status);
    
            $("#submitJurusan").hide();
            $("#updateJurusan").show().data("id", id);
            $("#modalJurusan").modal("show");
        });
    });

    $("#submitJurusan").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true);
        $.ajax({
            url: "/kelola-jurusan",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                kode_jurusan: $("#kodeJurusan").val(),
                nama_jurusan: $("#namaJurusan").val(),
                status: $("#statusJurusan").val()
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();                    
                });
            },
            error: function (xhr) {
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });
    
    $("#updateJurusan").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true);

        $.ajax({
            url: `/kelola-jurusan/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: { 
                kode_jurusan: $("#kodeJurusan").val(),
                nama_jurusan: $("#namaJurusan").val(),
                status: $("#statusJurusan").val()
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Debugging
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });
    
    $(".deleteJurusan").click(function () {
        let id = $(this).data("id");
    
        Swal.fire({
            title: "Yakin?",
            text: "Data ini akan dihapus secara permanen",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/kelola-jurusan/${id}/delete`,
                    method: "DELETE", 
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        Swal.fire("Berhasil!", response.message, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); 
                        Swal.fire("Error!", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
});
