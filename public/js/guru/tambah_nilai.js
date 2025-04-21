$(document).ready(function () {
    $('#siswaBimbingan').change(function (e) {
        const siswaId = this.value;
        fetch(`/get-siswa-bimbingan/${siswaId}`)
            .then(res => res.json())
            .then(data => {
                document.querySelector('[data-field="nis"]').textContent = data.nis;
                document.querySelector('[data-field="kelas"]').textContent = data.kelas;
                document.querySelector('[data-field="program_keahlian"]').textContent = data.program_keahlian;
                document.querySelector('[data-field="konsentrasi_keahlian"]').textContent = data.konsentrasi_keahlian;
                document.querySelector('[data-field="tempat_pkl"]').textContent = data.tempat_pkl;
                document.querySelector('[data-field="tanggal_pkl"]').textContent = data.tanggal_pkl;
                document.querySelector('[data-field="pembimbing"]').textContent = data.nama_pembimbing;
            });
    });

    $('#formDetailNilai').submit(function(e) {
        e.preventDefault(); 
        let tp = document.getElementById('tpValue').value;
        let skor = document.getElementById('skorValue').value;
        let desc = document.getElementById('descValue').value;
        let url = document.querySelector('#submitDetailNilai').dataset.url;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const iconUrl = document.querySelector('meta[name="hapus-icon-url"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                tujuan_pembelajaran: tp,
                skor: skor,
                deskripsi: desc
            })
        }).then(response => {
            if (!response.ok) {  
                throw new Error('Error: ' + response.statusText);  
            }
            return response.json(); 
        }).then(data => {
            if (data.success) {
                const index = data.data.length - 1;
                let tbody = document.querySelector('.data-body');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${index + 1}</td> 
                    <td>${tp}</td>
                    <td>${skor}</td>
                    <td>${desc}</td>
                    <td>
                        <button class="btn-icon deleteDetailNilai" data-index="${index}">
                            <img src="${iconUrl}" alt="Hapus">
                        </button>
                    </td>
                `;
                tbody.appendChild(newRow);
                updateRowNumbers(); 


                let btnDelete = newRow.querySelector('.deleteDetailNilai');
                if (btnDelete) {
                    btnDelete.style.display = 'inline-block'; 
                }

                document.getElementById('formDetailNilai').reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalNilai'));
                modal.hide();
            }
        }).catch(err => {
            console.error("Request failed", err);  
        });        
    });

    function updateRowNumbers() {
        const rows = document.querySelectorAll('.data-body tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
    
            const deleteBtn = row.querySelector('.deleteDetailNilai');
            if (deleteBtn) {
                deleteBtn.setAttribute('data-index', index);
            }
        });
    }    
    
    $(document).on('click', '.deleteDetailNilai', function (e) {
        e.preventDefault(); 
        
        const index = $(this).data('index');  
        const row = $(this).closest('tr');  
        
        $.ajax({
            url: `/tambah_nilai/detail/hapus/${index}`,  
            method: 'DELETE',  
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (data) {
                if (data.success) {
                    row.remove(); 
                    updateRowNumbers(); 
                } else {
                    console.error('Gagal menghapus data dari server.');
                }
            },
            error: function (error) {
                console.error('Error:', error);  
            }
        });
    });    

    $('#formNilai').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: routeUrl,  
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'  
            },
            success: function(response) {
                // Pastikan response success ada
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then(function() {
                        window.location.href = response.redirect_to; 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.error,
                    });
                }
            },
            error: function(xhr) {
                var message = xhr.responseJSON.error || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: message,
                });
            }
        });
    });
});
