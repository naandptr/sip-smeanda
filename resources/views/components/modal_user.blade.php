@props(['jurusans', 'kelas'])
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUser" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formUser" method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
            @csrf
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="roleUser">Role<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="roleUser" name="roleUser" required>
                                <option value="" selected disabled>Pilih Role</option>
                                <option>Siswa</option>
                                <option>Guru</option>
                                <option>Admin Jurusan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaUser">Username<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaUser" name="namaUser">
                        </div>
                    </div>
                    <div class="modal-form-group" id="passwordField">
                        <label for="pwUser">Password<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <div class="password-default"><i>123456</i></div>
                            <input type="hidden" id="pwUser" name="pwUser" value="123456">
                        </div>
                    </div>
                </div>

                <!-- Field tambahan untuk Siswa -->
                <div class="extra-fields" data-role="Siswa" style="display: none;">
                    <div class="modal-form-group">
                        <label for="namaSiswa">Nama Lengkap<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaSiswa" name="namaSiswa">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="nisnSiswa">NISN<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="nisnSiswa" name="nisnSiswa">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="kelasSiswa">Kelas<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="kelasSiswa" name="kelasSiswa" required>
                                <option value="" selected disabled>Pilih Kelas</option>
                                @foreach($kelas as $kelasItem)
                                    <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Field tambahan untuk Guru -->
                <div class="extra-fields" data-role="Guru" style="display: none;">
                    <div class="modal-form-group">
                        <label for="namaGuru">Nama Lengkap<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaGuru" name="namaGuru">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="nipGuru">NIP<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="nipGuru" name="nipGuru">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="telpGuru">Nomor Telepon<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="telpGuru" name="telpGuru">
                        </div>
                    </div>
                </div>

                <!-- Field tambahan untuk Admin Jurusan -->
                <div class="extra-fields" data-role="Admin Jurusan" style="display: none;">
                    <div class="modal-form-group">
                        <label for="namaAdm">Nama Lengkap<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaAdm" name="namaAdm">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="jurusanAdm">Jurusan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="jurusanAdm" name="jurusanAdm" required>
                                <option value="" selected disabled>Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitUser">Simpan</button>
                    <button type="submit" class="btn-submit" id="updateUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
