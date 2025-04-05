@php
    $role = session('role', Auth::user()->role ?? 'siswa');
@endphp

<div class="modal fade" id="modalDetailJurnal" tabindex="-1" role="dialog" aria-labelledby="modalDetailJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-view-content">
                <div class="modal-view-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <img src="{{ asset('img/close-icon.png') }}" alt="">
                    </button>
                </div>
                <div class="modal-view-body">
                    @if ($role === 'guru')
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Nama Lengkap</h5>
                            <div class="modal-view-value">
                                <h5>Arslan Allen</h5>
                            </div>
                        </div>
                    @endif

                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Tanggal</h5>
                        <div class="modal-view-value">
                            <h5>20/01/2025</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Deskripsi Kegiatan</h5>
                        <div class="modal-view-value desc-box">
                            <h5>Kegiatan yang dilaksanakan hari ini adalah...</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Catatan Pembimbing</h5>
                        <div class="modal-view-value desc-box">
                            <h5>-</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>