@props(['user', 'modalId'])

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
                        <h5 class="modal-view-label">Username</h5>
                        <div class="modal-view-value">
                            <h5>{{ $user['username'] }}</h5>
                        </div>
                    </div>

                    @if ($user['role'] === 'Siswa')
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Nama Lengkap</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nama'] ?? '-' }}</h5>
                            </div>
                        </div>
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">NIS</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nis'] ?? '-' }}</h5>
                            </div>
                        </div>
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Kelas</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nama_kelas'] ?? '-' }}</h5>
                            </div>
                        </div>
                    @elseif ($user['role'] === 'Guru')
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Nama Lengkap</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nama'] ?? '-' }}</h5>
                            </div>
                        </div>
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">NIP</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nip'] ?? '-' }}</h5>
                            </div>
                        </div>
                    @elseif ($user['role'] === 'Admin Jurusan')
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Nama</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nama'] ?? '-' }}</h5>
                            </div>
                        </div>
                        <div class="modal-view-item">
                            <h5 class="modal-view-label">Jurusan</h5>
                            <div class="modal-view-value">
                                <h5>{{ $user['detail']['nama_jurusan'] ?? '-' }}</h5>
                            </div>
                        </div>
                    @endif

                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Email</h5>
                        <div class="modal-view-value">
                            <h5>{{ $user['email'] ?? '-' }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Role</h5>
                        <div class="modal-view-value">
                            <h5>{{ $user['role'] }}</h5>
                        </div>
                    </div>
                    <div class="modal-view-item">
                        <h5 class="modal-view-label">Status</h5>
                        <div class="modal-view-value">
                            <h5>{{ $user['status'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
