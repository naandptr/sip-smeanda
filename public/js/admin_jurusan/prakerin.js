$(document).ready(function() {
    // =========== CRUD KELAS ============
    // Memastikan form kosong saat klik tombol tambah kelas
    $("#tambahPrakerin").click(function () {
        $("#modalPrakerin form")[0].reset(); 
        $("#updatePrakerin").hide(); 
        $("#submitPrakerin").show(); 
        $("#modalPrakerin").modal("show");
    });

    // Klik tombol edit
    $(".editPrakerin").click(function () {
        let id = $(this).data("id");

        $.get(`/kelola-prakerin/${id}/edit`, function (data) {
            $('#namaSiswa').val(data.siswa_id);
            $('#dudiSiswa').val(data.dudi_jurusan_id); 
            $('#tahunAjar').val(data.tahun_ajar_id);
            $('#tglMulai').val(data.tanggal_mulai);
            $('#tglSelesai').val(data.tanggal_selesai);
            $("#submitPrakerin").hide(); 
            $("#updatePrakerin").show().data("id", id); 
            $('#modalPrakerin').modal('show');
        });
    });

    // Simpan Kelas (Tambah)
    $("#submitPrakerin").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
        $.ajax({
            url: "/kelola-prakerin",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                siswa_id: $("#namaSiswa").val(),
                dudi_jurusan_id: $("#dudiSiswa").val(),
                tahun_ajar_id: $("#tahunAjar").val(),
                tanggal_mulai: $("#tglMulai").val(),
                tanggal_selesai: $("#tglSelesai").val(),
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

    $("#updatePrakerin").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
        $.ajax({
            url: `/kelola-prakerin/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                siswa_id: $("#namaSiswa").val(),
                dudi_jurusan_id: $("#dudiSiswa").val(),
                tahun_ajar_id: $("#tahunAjar").val(),
                tanggal_mulai: $("#tglMulai").val(),
                tanggal_selesai: $("#tglSelesai").val(),
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

    $(".deletePrakerin").click(function () {
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
                    url: `/kelola-prakerin/${id}/delete`, 
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