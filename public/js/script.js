$(document).ready(function () {
    console.log("DOM Loaded!");


    $(".pass-wrapper input").on("input", function () {
        $(this).siblings(".toggle-password").toggle($(this).val().length > 0);
    });

    $(".toggle-password").click(function () {
        let target = $("#" + $(this).data("target"));
        let type = target.attr("type") === "password" ? "text" : "password";

        target.attr("type", type);

        
        let imgSrc = type === "password" ? "/img/hidden-icon.png" : "/img/show-icon.png";
        $(this).attr("src", imgSrc);
    });

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

    $(".btn-submit").click(function (event) {
        event.preventDefault(); 
    
        let form = $(this).closest("form"); 
        let formId = form.attr("id");
    
        console.log(`🖱️ Tombol submit diklik untuk form: ${formId || "form-dokumen"}`);
    
    
        // ===== LOGIN FORM =====
        if (formId === "loginForm") {
            let username = $("#username").val();
            let password = $("#password").val();
    
            if (!username || !password) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Login Gagal",
                    text: "Username dan password harus diisi!",
                });
                return;
            }
    
            // Simulasi cek login 
            $.ajax({
                url: "/cek-login",
                method: "POST",
                data: { username, password },
                success: function (response) {
                    if (!response.valid) {
                        Swal.fire({
                            imageUrl: "/img/error-icon.png",
                            title: "Login Gagal",
                            text: "Username atau password salah!",
                        });
                    } else {
                        form.off("submit").submit(); 
                    }
                },
                error: function () {
                    Swal.fire({
                        imageUrl: "/img/error-icon.png",
                        title: "Oops! Terjadi kesalahan, silakan coba lagi",
                    });
                }
            });
    
        // ===== FORM GANTI PASSWORD =====
        } else if (formId === "changeFirstPassForm" || formId === "changePassForm") {
            let oldPw = formId === "changePassForm" ? $("#oldPw").val() : null;
            let newPw = formId === "changeFirstPassForm" ? $("#newPwFirst").val() : $("#newPw").val();
            let confirmPw = formId === "changeFirstPassForm" ? $("#confirmPwFirst").val() : $("#confirmPw").val();
    
            if ((!oldPw && formId === "changePassForm") || !newPw || !confirmPw) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Gagal Mengubah Password",
                    text: "Semua field harus diisi!",
                });
                return;
            }
    
            if (newPw !== confirmPw) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Password Tidak Cocok",
                    text: "Konfirmasi password tidak sesuai!",
                });
                return;
            }
    
            if (formId === "changePassForm") {
                // Simulasi pengecekan password lama 
                $.ajax({
                    url: "/cek-password-lama",
                    method: "POST",
                    data: { oldPassword: oldPw },
                    success: function (response) {
                        if (!response.valid) {
                            Swal.fire({
                                imageUrl: "/img/error-icon.png",
                                title: "Password Lama Salah",
                                text: "Silakan coba lagi!",
                            });
                        } else {
                            form.off("submit").submit(); 
                        }
                    },
                    error: function () {
                        Swal.fire({
                            imageUrl: "/img/error-icon.png",
                            title: "Oops! Terjadi kesalahan, silakan coba lagi",
                        });
                    }
                });
            } else {
                form.off("submit").submit();
            }
    
        // ===== FORM ABSEN =====
        } else if (formId === "formAbsen") {
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
    
        // ===== FORM UNGGAH DOKUMEN =====
        } else {
            let fileInput = form.find("input[type='file']");
            let fileName = fileInput.val().split("\\").pop();
    
            if (!fileName) {
                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "File belum dipilih!",
                    text: "Silakan pilih file terlebih dahulu.",
                });
                return;
            }
    
            Swal.fire({
                imageUrl: "/img/confirm-icon.png",
                title: "Apakah kamu yakin ingin submit file ini?",
                text: "Pastikan data sudah benar sebelum melanjutkan",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Submit",
                reverseButtons: true 
            }).then((result) => {
                if (result.isConfirmed) {
                    form.off("submit").submit(); 
                }
            });
        }
    });

    $(document).on("submit", "#formJurnal", function (e) {
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
    

    $(document).on("click", ".btn-open-jurnal", function () {
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
    
    
    $(document).on("click", ".btn-hapus-jurnal", function () {
        let jurnalId = $(this).data("id");
        Swal.fire({
            title: "Apakah kamu yakin ingin menghapus jurnal ini?",
            text: "Jurnal ini akan dihapus secara permanen",
            imageUrl: "/img/confirm-icon.png",
            showCancelButton: true,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("/jurnal/hapus", { id: jurnalId }, function () {
                    Swal.fire("Terhapus!", "Jurnal telah dihapus.", "success").then(() => {
                        location.reload(); 
                    });
                });
            }
        });
    });
    
    
    
    
    
    
    // ===== Toggle Sidebar =====
    $(".toggle-btn").on("click", function () {
        $(".layout").toggleClass("collapsed");
    });

    // ===== Modal Absen Handling =====
    $("#modalAbsen").on("shown.bs.modal", function () {
        console.log("Modal Absen Dibuka!");
        let today = new Date();
        let formattedDate = today.toLocaleDateString("id-ID", { day: "2-digit", month: "2-digit", year: "numeric" });

        $("#tglAbsenFormatted").val(formattedDate);
    });

    // ===== Summernote di Modal Jurnal =====
    $("#modalJurnal").on("shown.bs.modal", function () {
        console.log("Modal Jurnal Dibuka!");
        $("#summernote").summernote({
            height: 200,
            tabsize: 2,
            placeholder: "Jurnal kegiatan hari ini adalah..."
        });
    });

    $("#modalJurnal").on("hidden.bs.modal", function () {
        console.log("Modal Jurnal Ditutup, Summernote di-destroy!");
        $("#summernote").summernote("destroy");
    });

    // ===== Validasi PDF  =====
    function validateFile(input, label) {
        let file = input.files[0];
        if (file) {
            let fileName = file.name;
            let fileSize = file.size;
            let fileType = file.type;

            // Cek ekstensi manual 
            let validExtensions = ['.pdf'];
            let fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();

            if ((!fileType || fileType !== 'application/pdf') && !validExtensions.includes(fileExtension)) {
                alert('Hanya file PDF yang diperbolehkan!');
                $(input).val(''); // Reset input file
                $(label).text('No file chosen');
                return;
            }

            // Validasi ukuran file (maksimal 2MB)
            if (fileSize > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                $(input).val(''); // Reset input file
                $(label).text('No file chosen');
                return;
            }

            // Jika valid, tampilkan nama file
            $(label).text(fileName);
        } else {
            $(label).text('No file chosen');
        }
    }

    // ===== Event Listener untuk Input File =====
    let fileInputs = [
        { inputId: '#cvInput', labelId: '#cvName' },
        { inputId: '#portoInput', labelId: '#portoName' },
        { inputId: '#laporanInput', labelId: '#laporanName' },
        { inputId: '#sertifikatInput', labelId: '#sertifikatName' }
    ];

    fileInputs.forEach(({ inputId, labelId }) => {
        $(inputId).on("change", function () {
            validateFile(this, labelId);
        });
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

    $("#modalId").on("shown.bs.modal", function () {
        pond.destroy();
        pond = FilePond.create($(".filepond")[0]);
    });

});
