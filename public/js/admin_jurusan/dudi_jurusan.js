$(document).ready(function() {
    // =========== CRUD KELAS ============
    // Memastikan form kosong saat klik tombol tambah kelas
    $("#tambahDudiJurusan").click(function () {
        $("#modalDudiJurusan form")[0].reset(); 
        $("#updateDudiJurusan").hide(); 
        $("#submitDudiJurusan").show(); 
        $("#modalDudiJurusan").modal("show");
    });

    // Klik tombol edit
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

    // Simpan Kelas (Tambah)
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
                console.log(xhr.responseText); 
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });

    // Update Kelas
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
                console.log(xhr.responseText); 
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
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
                        Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });
});