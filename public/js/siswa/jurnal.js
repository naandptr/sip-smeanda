$(document).ready(function() {
    // ===== Summernote di Modal Jurnal =====
    $("#modalJurnal").on("shown.bs.modal", function () {
        console.log("Modal Jurnal Dibuka!");
        $("#summernote").summernote({
            height: 200,
            tabsize: 2,
            placeholder: "Jurnal kegiatan hari ini adalah..."
        });
    });

    $("#tambahJurnal").click(function(e) {
        let mode = $(this).data("mode");
        let id = $(this).data("id");
        let tanggal = $(this).data("tanggal");
        let deskripsi = $(this).data("deskripsi");
    
        $("#modalJurnal").modal("show");
    
        if (mode === "lihat") {
            $("#tglJurnal").val(tanggal).prop("disabled", true);
    
            if ($("#summernote").next(".note-editor").length) {
                $("#summernote").summernote("destroy");
            }
    
            $("#summernote").replaceWith(`
                <textarea id="deskripsiView" class="readonly-box" readonly>${deskripsi}</textarea>
            `);
    
            $("#modalFooter").hide();
        } else {
            $("#tglJurnal").val(tanggal || "").prop("disabled", false);
    
            if ($("#deskripsiView").length) {
                $("#deskripsiView").replaceWith(`<textarea id="summernote" name="content"></textarea>`);
            }
            
            // Inisialisasi Summernote kembali setelah elemen dibuat ulang
            $("#summernote").summernote({ height: 200 });
            
    
            if (!$("#summernote").next(".note-editor").length) {
                $("#summernote").summernote({ height: 200 });
            }
    
            $("#summernote").summernote("code", deskripsi || "");
    
            $("#modalFooter").show();
        }
    });

    // ==== Form Jurnal ====
    $("#formAbsen").submit(function(e) {
        e.preventDefault(); 
    
        let form = $(this);
        let formData = new FormData(this);
        formData.set("content", $("#summernote").summernote("code")); // Ambil data Summernote

        let mode = $(".btn-submit").data("mode"); 
    
        $.ajax({
            url: "/jurnal",
            type: "POST",
            data: formData,
            processData: false,  
            contentType: false,  
            success: function (response) {
                let successTitle = mode === "edit"
                    ? "Sukses! Jurnal Kegiatan telah berhasil diedit!"
                    : "Sukses! Jurnal Kegiatan telah berhasil ditambahkan!";
                
                Swal.fire({
                    imageUrl: "/img/success-icon.png",
                    title: successTitle,
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Gagal Menyimpan Jurnal",
                    text: "Terjadi kesalahan, coba lagi!"
                });
            }
        });
    });
    
    $("#modalJurnal").on("hidden.bs.modal", function () {
        console.log("Modal Jurnal Ditutup, Summernote di-destroy!");
        $("#summernote").summernote("destroy");
    });
});
