$(document).ready(function() {
    $("#tambahUser").click(function() {
        $("#modalUser form")[0].reset();
        $('#passwordField').show();
        $('#roleUser').prop('disabled', false);
        $(".extra-fields").hide(); 
        $("#updateUser").hide();
        $("#submitUser").show();
        $("#modalUser").modal("show");
    });

    $("#roleUser").change(function() {
        const role = $(this).val();
        $(".extra-fields").hide();
        
        if (role) {
            $(`.extra-fields[data-role="${role}"]`).show();
        }
    });

    $(".editUser").click(function() {
        const id = $(this).data("id");
        
        $.get(`/kelola-user/${id}/edit`, function(data) {
            $("#roleUser").val(data.role).trigger("change");
            $('#roleUser').prop('disabled', true);
            $("#namaUser").val(data.username);
            $('#passwordField').hide();
            
            if (data.role === 'Siswa' && data.siswa) {
                $("#namaSiswa").val(data.siswa.nama);
                $("#nisSiswa").val(data.siswa.nis);
                $("#kelasSiswa").val(data.siswa.kelas_id);
            } 
            else if (data.role === 'Guru' && data.pembimbing) {
                $("#namaGuru").val(data.pembimbing.nama);
                $("#nipGuru").val(data.pembimbing.nip);
                $("#telpGuru").val(data.pembimbing.telp);
            } 
            else if (data.role === 'Admin Jurusan' && data.admin_jurusan) {
                $("#namaAdm").val(data.admin_jurusan.nama);
                $("#jurusanAdm").val(data.admin_jurusan.jurusan_id);
            }
            
            $("#submitUser").hide();
            $("#updateUser").show().data("id", id);
            $("#modalUser").modal("show");
        }).fail(function(xhr) {
            Swal.fire("Error!", xhr.responseJSON.message, "error");
        });
    });

    $("#submitUser").click(function(e) {
        e.preventDefault();
        
        const formData = {
            roleUser: $("#roleUser").val(),
            namaUser: $("#namaUser").val(),
        };
        
        const role = formData.roleUser;
        if (role === 'Siswa') {
            formData.namaSiswa = $("#namaSiswa").val();
            formData.nisSiswa = $("#nisSiswa").val();
            formData.kelasSiswa = $("#kelasSiswa").val();
        } 
        else if (role === 'Guru') {
            formData.namaGuru = $("#namaGuru").val();
            formData.nipGuru = $("#nipGuru").val();
            formData.telpGuru = $("#telpGuru").val();
        } 
        else if (role === 'Admin Jurusan') {
            formData.namaAdm = $("#namaAdm").val();
            formData.jurusanAdm = $("#jurusanAdm").val();
        }
        
        $.ajax({
            url: "/kelola-user",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: formData,
            success: function() {
                Swal.fire("Berhasil!", "User berhasil ditambahkan", "success").then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire("Error!", xhr.responseJSON.message, "error");
            }
        });
    });

    $("#updateUser").click(function(e) {
        e.preventDefault();
        const id = $(this).data("id");
        
        const formData = {
            namaUser: $("#namaUser").val(),
            _method: "PATCH"
        };
        
        const role = formData.roleUser;
        if (role === 'Siswa') {
            formData.namaSiswa = $("#namaSiswa").val();
            formData.nisnSiswa = $("#nisnSiswa").val();
            formData.kelasSiswa = $("#kelasSiswa").val();
        } 
        else if (role === 'Guru') {
            formData.namaGuru = $("#namaGuru").val();
            formData.nipGuru = $("#nipGuru").val();
            formData.telpGuru = $("#telpGuru").val();
        } 
        else if (role === 'Admin Jurusan') {
            formData.namaAdm = $("#namaAdm").val();
            formData.jurusanAdm = $("#jurusanAdm").val();
        }
        
        $.ajax({
            url: `/kelola-user/${id}/update`,
            method: "POST", 
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: formData,
            success: function() {
                Swal.fire("Berhasil!", "Data user berhasil diperbarui", "success").then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire("Error!", xhr.responseJSON.message, "error");
            }
        });
    });

    $(".deleteUser").click(function() {
        const id = $(this).data("id");
        
        Swal.fire({
            title: "Yakin?",
            text: "User ini akan dihapus secara permanen",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/kelola-user/${id}/delete`,
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function() {
                        Swal.fire("Berhasil!", "User berhasil dihapus", "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
});