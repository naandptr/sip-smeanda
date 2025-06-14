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
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.kode_jurusan) {
                        Swal.fire("Gagal!", errors.kode_jurusan[0], "error");
                    } else if (errors.nama_jurusan) {
                        Swal.fire("Gagal!", errors.nama_jurusan[0], "error");
                    } else if (errors.status) {
                        Swal.fire("Gagal!", errors.status[0], "error");
                    } else {
                        Swal.fire("Gagal!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                } else {
                    Swal.fire("Gagal!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                }
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
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.kode_jurusan) {
                        Swal.fire("Gagal!", errors.kode_jurusan[0], "error");
                    } else if (errors.nama_jurusan) {
                        Swal.fire("Gagal!", errors.nama_jurusan[0], "error");
                    } else if (errors.status) {
                        Swal.fire("Gagal!", errors.status[0], "error");
                    } else {
                        Swal.fire("Gagal!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                } else {
                    Swal.fire("Gagal!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                }
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
                        Swal.fire("Gagal!", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
});
