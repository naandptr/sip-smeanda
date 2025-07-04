@props(['jurnal', 'modalId'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailJurnal" aria-hidden="true">
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
                        <h5 class="modal-view-label">Tanggal</h5>
                        <div class="modal-view-value">
                            <h5>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Deskripsi Kegiatan</h5>
                        <div class="modal-view-value desc-box">{!! $jurnal->deskripsi !!}</div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Catatan Pembimbing</h5>
                        <div class="modal-view-value desc-box">
                            <h5>{{ $jurnal->validasi->catatan ?? '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>