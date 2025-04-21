$(document).ready(function() {
    function validateFile(input, label) {
        let file = input.files[0];
        if (file) {
            let fileName = file.name;
            let fileSize = file.size;
            let fileType = file.type;
            let validExtensions = ['.pdf'];
            let fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();

            if ((!fileType || fileType !== 'application/pdf') && !validExtensions.includes(fileExtension)) {
                alert('Hanya file PDF yang diperbolehkan!');
                $(input).val('');
                $(label).text('No file chosen');
                return;
            }

            if (fileSize > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                $(input).val('');
                $(label).text('No file chosen');
                return;
            }

            $(label).text(fileName);
        } else {
            $(label).text('No file chosen');
        }
    }

    let fileInputs = [
        { inputId: '#cvInput', labelId: '#cvName' },
        { inputId: '#portofolioInput', labelId: '#portofolioName' },
        { inputId: '#laporanInput', labelId: '#laporanName' },
        { inputId: '#sertifikatInput', labelId: '#sertifikatName' }
    ];

    fileInputs.forEach(({ inputId, labelId }) => {
        $(inputId).on("change", function () {
            validateFile(this, labelId);
        });
    });

    $(".form-dokumen").submit(function(e) {
        e.preventDefault();
    
        const form = $(this);
        const jenis = form.data("jenis"); 
        const fileInput = form.find("input[name='dokumen']")[0];
        const file = fileInput.files[0];
    
        if (!file) {
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
                const formData = new FormData();
                formData.append("dokumen", file);
    
                $.ajax({
                    url: "/dokumen-prakerin/upload/" + jenis,
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message || "File berhasil diunggah.",
                        });
                    
                        const labelId = "#" + jenis + "Name"; 
                        const fileLink = `<a href="${response.file_url}" target="_blank">${response.file_name}</a>`;
                        $(labelId).html(fileLink);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: xhr.responseJSON?.message || "Terjadi kesalahan saat upload.",
                        });
                    }
                });
            }
        });
    });
    
});
