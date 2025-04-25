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

    $('#formDetailNilai').submit(function (e) {
        e.preventDefault();
    
        $('.text-danger').text('');
    
        let tp = document.getElementById('tpValue').value;
        let skor = document.getElementById('skorValue').value;
        let desc = document.getElementById('descValue').value;
        let url = document.querySelector('#submitDetailNilai').dataset.url;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const iconUrl = document.querySelector('meta[name="hapus-icon-url"]').getAttribute('content');
    
        if (tp === '' || skor === '' || desc === '') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Semua data wajib diisi!',
            });
            return;
        }
    
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            
            credentials: 'same-origin',
            body: JSON.stringify({
                tujuan_pembelajaran: tp,
                skor: skor,
                deskripsi: desc
            })
        })
            .then(async (response) => {
                if (response.status === 422) {
                    const errorData = await response.json();
                    const errors = errorData.errors;
    
                    for (let field in errors) {
                        const errorElement = document.getElementById(`error-${field}`);
                        if (errorElement) {
                            errorElement.textContent = errors[field][0];
                        }
                    }
    
                    throw errorData;
                }
    
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;
                    });
                }
                return response.json();

            })
            .then(data => {
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
            })

            .catch(err => {

                if (err.errors) {
                    let pesan = Object.values(err.errors).flat().join('<br>');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: pesan 
                    });        
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: err.message || 'Gagal mengirim data.'
                    });
                }
            });
    });
    
    function updateRowNumbers() {
        const rows = document.querySelectorAll('.data-nilai tr');
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
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.success,
                    }).then(function() {
                        window.location.href = response.redirect_to; 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.error,
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        let messages = Object.values(res.errors).map(errArr => errArr[0]).join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: messages,
                        });
                    }
                    else if (res.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.error,
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengirim data.',
                    });
                }
            }
        });
    });
});
