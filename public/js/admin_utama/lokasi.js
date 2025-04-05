$(document).ready(function() {
    // =========== CRUD LOKASI PRAKERIN ============
    // Memastikan form kosong saat klik tombol tambah lokasi
    $("#tambahLokasi").click(function () {
        $("#modalLokasi form")[0].reset(); // Kosongkan form
        $("#updateLokasi").hide(); // Sembunyikan tombol Update
        $("#submitLokasi").show(); // Tampilkan tombol Simpan
        $("#modalLokasi").modal("show");
    });

    $(".editLokasi").click(function () {
        let id = $(this).data("id");
        
        $.get(`/kelola-lokasi/${id}/edit`, function (data) {
            $("#namaDudi").val(data.nama_dudi);
            $("#alamatDudi").val(data.alamat);
            $("#bidangDudi").val(data.bidang_usaha);
            $("#telpDudi").val(data.telp);
            $("#emailDudi").val(data.email);
    
            $("#submitLokasi").hide(); // Sembunyikan tombol Simpan
            $("#updateLokasi").show().data("id", id); // Tampilkan tombol Update dengan ID
            $("#modalLokasi").modal("show");
        });
    });

    $("#submitLokasi").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit
        $.ajax({
            url: "/kelola-lokasi",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                nama_dudi: $("#namaDudi").val(),
                alamat: $("#alamatDudi").val(),
                bidang_usaha: $("#bidangDudi").val(),
                telp: $("#telpDudi").val(),
                email: $("#emailDudi").val()
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

    $("#updateLokasi").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit
        $.ajax({
            url: `/kelola-lokasi/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: { 
                nama_dudi: $("#namaDudi").val(),
                alamat: $("#alamatDudi").val(),
                bidang_usaha: $("#bidangDudi").val(),
                telp: $("#telpDudi").val(),
                email: $("#emailDudi").val()
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

    $(".deleteLokasi").click(function () {
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
                    url: `/kelola-lokasi/${id}/delete`, // Perbaiki URL
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