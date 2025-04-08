$(document).ready(function () {
    const buttons = document.querySelectorAll('.show-detail-absen');
    const image = document.getElementById('previewImage');
    const pdf = document.getElementById('previewPDF');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const fileUrl = this.getAttribute('data-file-url');
            const fileExtension = fileUrl.split('.').pop().toLowerCase();

            // Reset semua preview dulu
            image.style.display = 'none';
            pdf.style.display = 'none';

            if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                image.src = fileUrl;
                image.style.display = 'block';
            } else if (fileExtension === 'pdf') {
                pdf.src = fileUrl;
                pdf.style.display = 'block';
            }
        });
    });

    // ==== Tanggal Otomatis Saat Modal Dibuka ====
    $("#modalAbsen").on("shown.bs.modal", function () {
        console.log("Modal Absen Dibuka!");
        let now = new Date();
        let yyyy = now.getFullYear();
        let mm = String(now.getMonth() + 1).padStart(2, '0');
        let dd = String(now.getDate()).padStart(2, '0');
        let hh = String(now.getHours()).padStart(2, '0');
        let min = String(now.getMinutes()).padStart(2, '0');
        let ss = String(now.getSeconds()).padStart(2, '0');

        // buat tampilan
        let displayDate = `${dd}/${mm}/${yyyy}`;
        $("#tglAbsenView").val(displayDate);

        // buat server
        let localDateTime = `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
        $("#tglAbsenFormatted").val(localDateTime);

    });

    // ==== Jenis Absen Handling ====
    $("#jenisAbsen").change(function () {
        let jenis = $(this).val();

        if (jenis === "Absen Datang") {
            $("#statusAbsen").prop("disabled", false).prop("required", true);
            $("#ketAbsen").prop("required", false);
        } else if (jenis === "Absen Pulang") {
            $("#statusAbsen").prop("disabled", true).val("-");
            $("#ketAbsen").prop("required", false);
        }
    });

    // ==== FilePond Init ====
    FilePond.registerPlugin(FilePondPluginImagePreview);


    let pond = FilePond.create(document.querySelector('#fileAbsen'), {
        storeAsFile: true,
        allowMultiple: false,
        maxFileSize: '2MB',
        server: null,
        fileValidateTypeDetectType: (source, type) => new Promise((resolve) => resolve(type)),
        labelIdle: `
            <div style="text-align: center;">
                <img src="/img/add-icon.png" alt="Upload Icon">
                <h1>Drop your files here</h1>
                <span style="color: blue; cursor: pointer;">Browse file </span>
                <p>from your computer</p>
            </div>
        `
    });


    FilePond.setOptions({
        server: {
            process: null,
            revert: null,
        }
    });

    pond.on('addfile', (error, file) => {
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
        const allowedExtensions = ['.png', '.jpg', '.jpeg', '.pdf'];

        const fileType = file.fileType || '';
        const fileExtension = file.filename.slice(file.filename.lastIndexOf('.')).toLowerCase();

        if (!allowedTypes.includes(fileType) && !allowedExtensions.includes(fileExtension)) {
            pond.removeFile(file.id);
            Swal.fire({
                icon: "error",
                title: "Format tidak didukung",
                text: "Hanya boleh upload gambar (PNG, JPG, JPEG) dan PDF!",
            });
        }
    });

    pond.on('error', (error) => {
        if (error.body && error.body.includes("Max size")) {
            Swal.fire({
                icon: "error",
                title: "Ukuran file terlalu besar",
                text: "Ukuran maksimum adalah 2MB.",
            });
        }
    });

 
    $("#formAbsen").submit(function (e) {
        e.preventDefault();
        let jenis = $("#jenisAbsen").val();
        let status = $("#statusAbsen").val();
        let fileAbsen = pond.getFiles().length > 0;

        if (!jenis) {
            Swal.fire({
                imageUrl: "/img/error-icon.png",
                title: "Validasi Gagal",
                text: "Silakan pilih jenis absen!",
            });
            return;
        }

        if (jenis === "Absen Datang") {
            if (!status) {
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

        if (jenis === "Absen Pulang" && !fileAbsen) {
            Swal.fire({
                imageUrl: "/img/error-icon.png",
                title: "Validasi Gagal",
                text: "Silakan upload foto absen!",
            });
            return;
        }

        $.ajax({
            url: $("#formAbsen").attr("action"),
            method: "POST",
            data: new FormData($("#formAbsen")[0]),
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message || "Absen berhasil dikirim!",
                }).then(() => {
                    location.reload(); // atau reset form
                });
            },
            error: function (xhr) {
                let msg = "Terjadi kesalahan. Silakan coba lagi.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: msg,
                });
            }
        });
        
    });

   
    $("#modalId").on("shown.bs.modal", function () {
        pond.destroy();
        FilePond.registerPlugin(FilePondPluginImagePreview);
        pond = FilePond.create($(".filepond")[0], {
            allowMultiple: false,
            maxFileSize: '2MB',
        });
    });
});
