@props(['prakerin', 'modalId'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailPrakerin" aria-hidden="true">
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
                        <h5 class="modal-view-label">Nama Siswa</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->siswa->nama ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Kelas Siswa</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->siswa->kelas->nama_kelas ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nama DUDI</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->dudiJurusan->dudi->nama_dudi ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Pembimbing</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->dudiJurusan->pembimbing->nama ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Tahun Ajaran</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->tahunAjar->tahun_ajaran ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Tanggal Mulai</h5>
                        <div class="modal-view-value">
                            <h5>{{ \Carbon\Carbon::parse($prakerin->tanggal_mulai)->format('d/m/Y') }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Tanggal Selesai</h5>
                        <div class="modal-view-value">
                            <h5>{{ \Carbon\Carbon::parse($prakerin->tanggal_selesai)->format('d/m/Y') }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Status</h5>
                        <div class="modal-view-value">
                            <h5>{{ $prakerin->status ?? '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>