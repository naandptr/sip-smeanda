@props(['siswa', 'penetapan', 'modalId'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailSiswaBimbingan" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-view-content">
                <div class="modal-view-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <img src="{{ asset('img/close-icon.png') }}" alt="">
                    </button>
                </div>
                <div class="modal-view-body">
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">NIS</h5>
                        <div class="modal-view-value">
                            <h5>{{ $siswa->nis ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nama Lengkap</h5>
                        <div class="modal-view-value">
                            <h5>{{ $siswa->nama ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nama DUDI</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan->dudiJurusan->dudi->nama_dudi ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Alamat DUDI</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan->dudiJurusan->dudi->alamat ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Mulai Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan ? \Carbon\Carbon::parse($penetapan->tanggal_mulai)->translatedFormat('d F Y') : '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Selesai Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan ? \Carbon\Carbon::parse($penetapan->tanggal_selesai)->translatedFormat('d F Y') : '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>