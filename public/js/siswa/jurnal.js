$(document).ready(function () {
    $("#modalJurnal").on("shown.bs.modal", function () {
        console.log("Modal Jurnal Dibuka!");
        initSummernote();
    });

    function initSummernote() {
        $('#summernote').summernote({
            height: 200,
            fontNames: ['Nunito Sans'],
            fontSizes: ['14'],
            fontNamesIgnoreCheck: ['Nunito Sans'],
            defaultFontName: 'Nunito Sans',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['height', ['height']],
                ['view', ['fullscreen']]
            ],
            callbacks: {
                onInit: function() {
                    $('.note-editable').css({
                      'font-size': '14px',
                      'line-height': '1.6',
                      'font-family': 'Nunito Sans, sans-serif',
                      'color': '#64748B'
                    });

                    $('.note-editable').on('keyup', function () {
                        $(this).find('*').each(function () {
                            const tag = this.tagName.toLowerCase();
                            if (tag !== 'b' && tag !== 'strong' && tag !== 'i' && tag !== 'u') {
                                $(this).removeAttr('style');
                            }
                        });
                    });
                    
                    const target = document.querySelector('.note-editable');
                    const observer = new MutationObserver(() => {
                        $('.note-editable *').each(function () {
                        $(this).css({
                            'font-size': '14px',
                            'line-height': '1.6',
                            'font-family': 'Nunito Sans, sans-serif'
                        });
                        });
                    });

                    observer.observe(target, {
                        childList: true,
                        subtree: true
                    });
                  },
                onPaste: function (e) {
                  e.preventDefault();
                  const clipboard = e.originalEvent.clipboardData || window.clipboardData;
                  const html = clipboard.getData('text/html') || clipboard.getData('text/plain');
                  const cleaned = cleanHtmlStyle(html);
                  document.execCommand('insertHTML', false, cleaned);
                }
            }  
              
              
        });
    }

    $("#tambahJurnal").click(function () {
        const mode = $(this).data("mode");
        const tanggal = $(this).data("tanggal");
        const deskripsi = $(this).data("deskripsi");

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
            const today = new Date();
            const formattedToday = `${String(today.getDate()).padStart(2, '0')}/${String(today.getMonth() + 1).padStart(2, '0')}/${today.getFullYear()}`;

            $("#tglJurnal").val(tanggal || formattedToday).prop("disabled", false);

            if ($("#deskripsiView").length) {
                $("#deskripsiView").replaceWith(`<textarea id="summernote" name="content"></textarea>`);
            }

            initSummernote();
            $("#summernote").summernote("code", cleanHtmlStyle(deskripsi || ""));
            $("#modalFooter").show();
        }
    });

    $("#formJurnal").submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.set("content", $("#summernote").summernote("code"));

        $.ajax({
            url: "/jurnal-prakerin",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    imageUrl: "/img/success-icon.png",
                    title: "Sukses!",
                    text: response.message,
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                let message = "Terjadi kesalahan, coba lagi!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    imageUrl: "/img/error-icon.png",
                    title: "Gagal Menyimpan Jurnal",
                    text: message
                });
            }
        });
    });

    $(".deleteJurnal").click(function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "Yakin ingin menghapus jurnal ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/jurnal-prakerin/${id}/delete`,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function () {
                        Swal.fire("Terhapus!", "Jurnal berhasil dihapus.", "success")
                            .then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire("Gagal", "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });

    $("#modalJurnal").on("hidden.bs.modal", function () {
        console.log("Modal Jurnal Ditutup, Summernote di-destroy!");
        if ($("#summernote").next(".note-editor").length) {
            $("#summernote").summernote("destroy");
        }
    });

    function cleanHtmlStyle(html) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
    
        const comments = tempDiv.querySelectorAll('*');
        comments.forEach(el => {
            el.removeAttribute('style');
            el.removeAttribute('class');
            el.removeAttribute('id');
            el.removeAttribute('cellspacing');
            el.removeAttribute('cellpadding');
            el.removeAttribute('align');
    
            if (['SPAN', 'DIV'].includes(el.tagName)) {
                const frag = document.createDocumentFragment();
                while (el.firstChild) frag.appendChild(el.firstChild);
                el.replaceWith(frag);
            }
    
            if (el.tagName === 'P') {
                const newEl = document.createElement('div');
                newEl.innerHTML = el.innerHTML;
                el.replaceWith(newEl);
            }
    
            if (['TABLE', 'TR', 'TD', 'TBODY'].includes(el.tagName)) {
                el.remove();
            }
        });
    
        let cleanHTML = tempDiv.innerHTML;
        cleanHTML = cleanHTML.replace(/<!--[\s\S]*?-->/g, ''); 
        cleanHTML = cleanHTML.replace(/\s{2,}/g, ' ');
    
        return cleanHTML.trim();
    }              
});
