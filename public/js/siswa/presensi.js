$(document).ready(function () {
    const buttons = document.querySelectorAll('.show-detail-presensi');
    const image = document.getElementById('previewImage');
    const pdf = document.getElementById('previewPDF');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const fileUrl = this.getAttribute('data-file-url');
            const fileExtension = fileUrl.split('.').pop().toLowerCase();

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

    $("#modalPresensi").on("shown.bs.modal", function () {
        let now = new Date();
        let yyyy = now.getFullYear();
        let mm = String(now.getMonth() + 1).padStart(2, '0');
        let dd = String(now.getDate()).padStart(2, '0');
        let hh = String(now.getHours()).padStart(2, '0');
        let min = String(now.getMinutes()).padStart(2, '0');
        let ss = String(now.getSeconds()).padStart(2, '0');

        let displayDate = `${dd}/${mm}/${yyyy}`;
        $("#tglPresensiView").val(displayDate);


        let localDateTime = `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
        $("#tglPresensiFormatted").val(localDateTime);

    });

    $("#jenisPresensi").change(function () {
        let jenis = $(this).val();

        if (jenis === "Presensi Datang") {
            $("#statusPresensi").prop("disabled", false).prop("required", true);
            $("#ketPresensi").prop("required", false);
        } else if (jenis === "Presensi Pulang") {
            $("#statusPresensi").prop("disabled", true).val("-");
            $("#ketPresensi").prop("required", false);
        }
    });

    FilePond.registerPlugin(FilePondPluginImagePreview);

    let pond = FilePond.create(document.querySelector('#filePresensi'), {
        storeAsFile: true,
        allowMultiple: false,
        maxFileSize: '2MB',
        server: null,
        fileValidateTypeDetectType: (source, type) => new Promise((resolve) => resolve(type)),
        labelIdle: `
            <div class="filepond-label-wrapper">
                <img src="/img/add-icon.png" alt="Upload Icon" class="filepond-icon">
                <h1 class="filepond-title">Seret berkas Anda di sini</h1>
                
                <div class="filepond-link-description-wrapper">
                <span class="filepond-link">Pilih berkas</span>
                    <p class="filepond-description">dari perangkat Anda</p>
                </div>
                <p class="filepond-note"><i>Unggah foto dengan format PNG, JPG, JPEG, PDF dengan ukuran maksimal 2MB</i></p>
            </div>
        `,
        styleItemPanelAspectRatio: 1,
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
                text: "Hanya boleh unggah gambar (PNG, JPG, JPEG) dan PDF!",
            });
        }
    });

    pond.on('error', (error) => {
        if (error.body && error.body.includes("Max size")) {
            Swal.fire({
                icon: "error",
                title: "Ukuran berkas terlalu besar",
                text: "Ukuran maksimum adalah 2MB.",
            });
        }
    });

    $("#formPresensi").submit(function (e) {
        e.preventDefault();
    
        let jenis = $("#jenisPresensi").val();
        let status = $("#statusPresensi").val();
        let filePresensi = pond.getFiles();
    
        if (!jenis) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Jenis presensi harus dipilih",
            });
            return;
        }
    
        if (jenis === "Presensi Datang" && !status) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Status presensi harus dipilih",
            });
            return;
        }
    
        if (filePresensi.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Bukti presensi harus diunggah",
            });
            return;
        }
    
        let formData = new FormData($("#formPresensi")[0]);
        formData.append('filePresensi', filePresensi[0].file);
    
        $.ajax({
            url: $("#formPresensi").attr("action"),
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: res.message || "Presensi berhasil dikirim!",
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                let msg = "Terjadi kesalahan. Silakan coba lagi.";
    
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    msg = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
    
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
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
