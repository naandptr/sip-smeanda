@php
    $role = session('role', Auth::user()->role ?? 'siswa');
@endphp

<div class="modal fade" id="modalDetailSiswa" tabindex="-1" role="dialog" aria-labelledby="modalDetailSiswa" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-view-content">
                <div class="modal-view-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <img src="{{ asset('img/close-icon.png') }}" alt="">
                    </button>
                </div>
                @if ($role === 'guru')
                <div class="modal-view-body">
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">NIS</h5>
                        <div class="modal-view-value">
                            <h5>0031652858</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nama Lengkap</h5>
                        <div class="modal-view-value">
                            <h5>Arslan Allen</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Nama DUDI</h5>
                        <div class="modal-view-value">
                            <h5>PT. ABCD Animax Jaya</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Alamat DUDI</h5>
                        <div class="modal-view-value">
                            <h5>Jl. Kendari, Selamet Jaya</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Mulai Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>20/01/2025</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Selesai Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>20/06/2025</h5>
                        </div>
                    </div>
                </div>

                @elseif ($role === 'admin_jurusan')
                <div class="modal-view-body">
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Lokasi Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>PT. ABCD Animax Jaya</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Guru Pembimbing</h5>
                        <div class="modal-view-value">
                            <h5>Siti Menenun</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Durasi Prakerin</h5>
                        <div class="modal-view-value">
                            <h5>20 Januari - 20 Juni 2025</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">CV</h5>
                        <div class="modal-view-status">
                            <div class="status-badge">SELESAI</div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Portofolio</h5>
                        <div class="modal-view-status">
                            <div class="status-badge">SELESAI</div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Laporan Akhir</h5>
                        <div class="modal-view-status">
                            <div class="status-badge">SELESAI</div>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Sertifikat</h5>
                        <div class="modal-view-status">
                            <div class="status-badge">SELESAI</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>