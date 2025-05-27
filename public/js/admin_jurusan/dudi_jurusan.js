$(document).ready(function() {
    $("#tambahDudiJurusan").click(function () {
        $("#modalDudiJurusan form")[0].reset(); 
        $("#updateDudiJurusan").hide(); 
        $("#submitDudiJurusan").show(); 
        $("#modalDudiJurusan").modal("show");
    });

    $(".editDudiJurusan").click(function () {
        let id = $(this).data("id");

        $.get(`/kelola-dudi-jurusan/${id}/edit`, function (data) {
            $('#lokasiDudi').val(data.dudi_id);
            $('#namaPembimbing').val(data.pembimbing_id); 
            $('#tahunAjar').val(data.tahun_ajar_id);
            $("#submitDudiJurusan").hide(); 
            $("#updateDudiJurusan").show().data("id", id); 
            $('#modalDudiJurusan').modal('show');
        });
    });

    $("#submitDudiJurusan").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
        $.ajax({
            url: "/kelola-dudi-jurusan",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                dudi_id: $("#lokasiDudi").val(),
                pembimbing_id: $("#namaPembimbing").val(),
                tahun_ajar_id: $("#tahunAjar").val(),
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    const errors = response.errors;

                    if (errors) {
                        if (errors.dudi_id) {
                            Swal.fire("Gagal!", errors.dudi_id[0], "error");
                        } else if (errors.pembimbing_id) {
                            Swal.fire("Gagal!", errors.pembimbing_id[0], "error");
                        } else if (errors.tahun_ajar_id) {
                            Swal.fire("Gagal!", errors.tahun_ajar_id[0], "error");
                        }
                    } else {
                        Swal.fire("Gagal!", response.message || "Terjadi kesalahan.", "error");
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

    $("#updateDudiJurusan").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
        $.ajax({
            url: `/kelola-dudi-jurusan/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                dudi_id: $("#lokasiDudi").val(),
                pembimbing_id: $("#namaPembimbing").val(),
                tahun_ajar_id: $("#tahunAjar").val(),
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    const errors = response.errors;

                    if (errors) {
                        if (errors.dudi_id) {
                            Swal.fire("Gagal!", errors.dudi_id[0], "error");
                        } else if (errors.pembimbing_id) {
                            Swal.fire("Gagal!", errors.pembimbing_id[0], "error");
                        } else if (errors.tahun_ajar_id) {
                            Swal.fire("Gagal!", errors.tahun_ajar_id[0], "error");
                        }
                    } else {
                        Swal.fire("Gagal!", response.message || "Terjadi kesalahan.", "error");
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

    $(".deleteDudiJurusan").click(function () {
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
                    url: `/kelola-dudi-jurusan/${id}/delete`, 
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
                        Swal.fire("Gagal!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });
});