@props(['dudi', 'modalId'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}" aria-hidden="true">
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
                        <h5 class="modal-view-label">Nama DUDI</h5>
                        <div class="modal-view-value">
                            <h5>{{ $dudi->nama_dudi }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Alamat DUDI</h5>
                        <div class="modal-view-value">
                            <h5>{{ $dudi->alamat }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Bidang Usaha</h5>
                        <div class="modal-view-value">
                            <h5>{{ $dudi->bidang_usaha }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nomor Telepon</h5>
                        <div class="modal-view-value">
                            <h5>{{ $dudi->telp ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Email</h5>
                        <div class="modal-view-value">
                            <h5>{{ $dudi->email ?? '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>