$(document).ready(function() {
    // =========== CRUD KELAS ============
    // Memastikan form kosong saat klik tombol tambah kelas
    $("#tambahKelas").click(function () {
        $("#modalKelas form")[0].reset(); // Kosongkan form
        $("#updateKelas").hide(); // Sembunyikan tombol Update
        $("#submitKelas").show(); // Tampilkan tombol Simpan
        $("#modalKelas").modal("show");
    });

    // Klik tombol edit
    $(".editKelas").click(function () {
        let id = $(this).data("id");

        $.get(`/kelola-kelas/${id}/edit`, function (data) {
            $('#namaKelas').val(data.nama_kelas);
            $('#namaJurusan').val(data.jurusan_id); // Pastikan select option diisi dengan value
            $('#tahunAjarKelas').val(data.tahun_ajar_id);
            $("#submitKelas").hide(); // Sembunyikan tombol Simpan
            $("#updateKelas").show().data("id", id); // Tampilkan tombol Update dengan ID
            $('#modalKelas').modal('show');
        });
    });

    // Simpan Kelas (Tambah)
    $("#submitKelas").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit
        $.ajax({
            url: "/kelola-kelas",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                nama_kelas: $("#namaKelas").val(),
                jurusan_id: $("#namaJurusan").val(),  // Ambil ID jurusan dari select
                tahun_ajar_id: $("#tahunAjarKelas").val() // Ambil ID tahun ajar
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
                submitBtn.prop('disabled', false); // Aktifkan kembali tombol submit
            }
        });
    });

    // Update Kelas
    $("#updateKelas").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit
        $.ajax({
            url: `/kelola-kelas/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                nama_kelas: $("#namaKelas").val(),
                jurusan_id: $("#namaJurusan").val(), // Ambil ID jurusan dari select
                tahun_ajar_id: $("#tahunAjarKelas").val() // Ambil ID tahun ajar
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
                submitBtn.prop('disabled', false); // Aktifkan kembali tombol submit
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
                    url: `/kelola-kelas/${id}/delete`, // Perbaiki URL
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
                        console.log(xhr.responseText); // Debugging
                        Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });
});