$(document).ready(function() {
    // =========== CRUD TAHUN AJARAN ============
    // ===== Toggle Status Tahun Ajaran =====
    $(".toggle-switch").click(function() {
        const tahunId = $(this).data('id');
        const toggleBtn = $(this);
    
        $.ajax({
            url: `/kelola-tahun-ajar/${tahunId}/toggle-status`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // **Matikan semua toggle dulu**
                    $(".toggle-switch").removeClass("active");
    
                    // **Set status semua tahun ajaran ke 'Nonaktif' dulu**
                    $(".status-kegiatan").each(function () {
                        $(this).text("Nonaktif").removeClass("aktif").addClass("nonaktif");
                    });
    
                    // **Aktifkan toggle & update status di baris yang dipilih**
                    toggleBtn.addClass("active");
                    const statusElement = toggleBtn.closest("tr").find(".status-kegiatan");
                    statusElement.text("Aktif").removeClass("nonaktif").addClass("aktif");
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    // Memastikan form kosong saat klik tombol tambah tahun ajar
    $("#tambahTahunAjar").click(function () {
        $("#modalTahunAjar form")[0].reset(); // Kosongkan form
        $('#status').val('Aktif');
        $("#updateTahunAjar").hide(); // Sembunyikan tombol Update
        $("#submitTahunAjar").show(); // Tampilkan tombol Simpan
        $("#modalTahunAjar").modal("show");
    });
    
    $(".editTahunAjar").click(function () {
        let id = $(this).data("id");
        
        $.get(`/kelola-tahun-ajar/${id}/edit`, function (data) {
            $("#tahun_ajaran").val(data.tahun_ajaran);
            $("#periode_mulai").val(data.periode_mulai);
            $("#periode_selesai").val(data.periode_selesai);
            $("#status").val(data.status);
    
            $("#submitTahunAjar").hide(); // Sembunyikan tombol Simpan
            $("#updateTahunAjar").show().data("id", id); // Tampilkan tombol Update dengan ID
            $("#modalTahunAjar").modal("show");
        });
    });
    
    $("#submitTahunAjar").click(function () {
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit

        $.ajax({
            url: "/kelola-tahun-ajar",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                tahun_ajaran: $("#tahun_ajaran").val(),
                periode_mulai: $("#periode_mulai").val(),
                periode_selesai: $("#periode_selesai").val(),
                status: $("#status").val()
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                // Menampilkan pesan kesalahan dari server
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); // Aktifkan kembali tombol submit
            }
        });
    });
    
    $("#updateTahunAjar").click(function () {
        let id = $(this).data("id");
        const submitBtn = $(this);
        submitBtn.prop('disabled', true); // Nonaktifkan tombol submit
    
        $.ajax({
            url: `/kelola-tahun-ajar/${id}/update`,
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: { 
                tahun_ajaran: $("#tahun_ajaran").val(),
                periode_mulai: $("#periode_mulai").val(),
                periode_selesai: $("#periode_selesai").val(),
                status: $("#status").val()
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                // Menampilkan pesan kesalahan dari server
                Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
            },
            complete: function () {
                submitBtn.prop('disabled', false); // Aktifkan kembali tombol submit
            }
        });
    });
    
    $(".deleteTahunAjar").click(function () {
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
                    url: `/kelola-tahun-ajar/${id}/delete`, // Perbaiki URL
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
                        // Menampilkan pesan kesalahan dari server
                        Swal.fire("Error!", xhr.responseJSON.message || "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });
    
    // ===== Reset Form saat Modal Ditutup =====
    $('#modalTahunAjar').on('hidden.bs.modal', function () {
        $('#formTahunAjar')[0].reset();
        $('#formTahunAjar').attr('action', '/kelola-tahun-ajar');
        $('input[name="_method"]').val('POST');
    });
});

