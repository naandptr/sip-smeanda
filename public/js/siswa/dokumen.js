$(document).ready(function() {
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

    $(".formDokumen").submit(function(e) {
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
        return;
    });
});