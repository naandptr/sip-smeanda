$(document).ready(function() {
    $("#tambahKelas").click(function () {
        $("#modalKelas form")[0].reset();
        $("#updateKelas").hide(); 
        $("#submitKelas").show(); 
        $("#modalKelas").modal("show");
    });

    $(".editKelas").click(function () {
        let id = $(this).data("id");

        $.get(`/kelola-kelas/${id}/edit`, function (data) {
            $('#namaKelas').val(data.nama_kelas);
            $('#namaJurusan').val(data.jurusan_id); 
            $('#tahunAjarKelas').val(data.tahun_ajar_id);
            $("#submitKelas").hide(); 
            $("#updateKelas").show().data("id", id); 
            $('#modalKelas').modal('show');
        });
    });

    $("#submitKelas").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
        $.ajax({
            url: "/kelola-kelas",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                nama_kelas: $("#namaKelas").val(),
                jurusan_id: $("#namaJurusan").val(),  
                tahun_ajar_id: $("#tahunAjarKelas").val() 
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText); 
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });

    // Update Kelas
    $("#updateKelas").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true);
        $.ajax({
            url: `/kelola-kelas/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                nama_kelas: $("#namaKelas").val(),
                jurusan_id: $("#namaJurusan").val(), 
                tahun_ajar_id: $("#tahunAjarKelas").val() 
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText); 
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });

    $(".deleteKelas").click(function () {
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
                    url: `/kelola-kelas/${id}/delete`,
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
                        Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });
});