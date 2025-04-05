$(document).ready(function() {
    // ==== Modal Absen Handling ====
    $("#modalAbsen").on("shown.bs.modal", function () {
        console.log("Modal Absen Dibuka!");
        let today = new Date();
        let formattedDate = today.toLocaleDateString("id-ID", { day: "2-digit", month: "2-digit", year: "numeric" });

        $("#tglAbsenFormatted").val(formattedDate);
    });

    // ==== Jenis Absen ====
    $("#jenisAbsen").change(function () {
        let jenisAbsen = $(this).val();
        
        if (jenisAbsen === "absen-datang") {
            $("#statusAbsen").prop("disabled", false).prop("required", true);
            $("#ketAbsen").prop("required", false);
        } else if (jenisAbsen === "absen-pulang") {
            $("#statusAbsen").prop("disabled", true).val("-");
            $("#ketAbsen").prop("required", false);
        }
    });  

    // ===== FilePond  =====
    FilePond.registerPlugin(FilePondPluginImagePreview);

    let pond = FilePond.create($(".filepond")[0], {
        allowMultiple: true,
        maxFileSize: '2MB',
        fileValidateTypeDetectType: (source, type) => new Promise((resolve) => {
            resolve(type);
        }),
        labelIdle: `
            <div style="text-align: center;">
                <img src="/img/add-icon.png" alt="Upload Icon">
                <h1>Drop your files here</h1>
                <span style="color: blue; cursor: pointer;">Browse file </span>
                <p>from your computer</p>
            </div>
        `
    });

    // ===== Validasi File untuk FilePond =====
    pond.on('addfile', (error, file) => {
        let allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
        let fileExtension = file.filename.slice(file.filename.lastIndexOf('.')).toLowerCase();

        if (!allowedTypes.includes(file.fileType) && fileExtension !== '.pdf') {
            pond.removeFile(file);
            alert('Hanya boleh upload gambar (PNG, JPG, JPEG) dan PDF!');
        }
    });

    // ==== Form Absen ====
    $("#formAbsen").submit(function(e) {
        let jenisAbsen = $("#jenisAbsen").val();
            let statusAbsen = $("#statusAbsen").val();
            let ketAbsen = $("#ketAbsen").val();
            let fileAbsen = pond.getFiles().length > 0;
    
            if (!jenisAbsen) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Validasi Gagal",
                    text: "Silakan pilih jenis absen!",
                });
                return;
            }
            
            if (jenisAbsen === "absen-datang") {
                if (!statusAbsen) {
                    Swal.fire({
                        imageUrl: "/img/error-icon.png",
                        title: "Validasi Gagal",
                        text: "Silakan pilih status kehadiran!",
                    });
                    return;
                }
                if (!fileAbsen) {
                    Swal.fire({
                        imageUrl: "/img/error-icon.png",
                        title: "Validasi Gagal",
                        text: "Silakan upload foto absen!",
                    });
                    return;
                }
            }
            
            if (jenisAbsen === "absen-pulang") {
                if (!fileAbsen) {
                    Swal.fire({
                        imageUrl: "/img/error-icon.png",
                        title: "Validasi Gagal",
                        text: "Silakan upload foto absen!",
                        icon: "error"
                    });
                    return;
                }
            }            
    
            Swal.fire({
                imageUrl: "/img/success-icon.png",
                title: "Sukses! Absen harian telah berhasil diproses",
                confirmButtonText: "OK"
            }).then(() => {
                form.off("submit").submit();
            });
    });

    $("#modalId").on("shown.bs.modal", function () {
        pond.destroy();
        pond = FilePond.create($(".filepond")[0]);
    });
});
