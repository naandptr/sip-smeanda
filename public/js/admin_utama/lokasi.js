$(document).ready(function() {
    $("#tambahLokasi").click(function () {
        $("#modalLokasi form")[0].reset(); 
        $("#updateLokasi").hide(); 
        $("#submitLokasi").show(); 
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
    
            $("#submitLokasi").hide();
            $("#updateLokasi").show().data("id", id);
            $("#modalLokasi").modal("show");
        });
    });

    $("#submitLokasi").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
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
                console.log(xhr.responseText);
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
            }
        });
    });

    $("#updateLokasi").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); 
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
                console.log(xhr.responseText); 
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); 
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
                    url: `/kelola-lokasi/${id}/delete`, 
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