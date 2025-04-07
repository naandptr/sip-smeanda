@props(['siswa', 'penetapan', 'modalId'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailSiswaJurusan" aria-hidden="true">
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
                        <h5 class="modal-view-label">Lokasi Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan->dudiJurusan->dudi->nama_dudi ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Guru Pembimbing</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan->dudiJurusan->pembimbing->nama ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Durasi Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>{{ $penetapan ? \Carbon\Carbon::parse($penetapan->tanggal_mulai)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($penetapan->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                            </h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">CV</h5>
                        <div class="modal-view-status">
                            <div class="status-badge {{ $siswa->status_cv }}">
                                {{ strtoupper($siswa->status_cv) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Portofolio</h5>
                        <div class="modal-view-status">
                            <div class="status-badge {{ $siswa->status_portofolio }}">
                                {{ strtoupper($siswa->status_portofolio) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Laporan Akhir</h5>
                        <div class="modal-view-status">
                            <div class="status-badge {{ $siswa->status_laporan }}">
                                {{ strtoupper($siswa->status_laporan) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Sertifikat</h5>
                        <div class="modal-view-status">
                            <div class="status-badge {{ $siswa->status_sertifikat }}">
                                {{ strtoupper($siswa->status_sertifikat) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>