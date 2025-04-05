@props(['jurusan', 'tahunAjar'])

<div class="modal fade" id="modalKelas" tabindex="-1" aria-labelledby="modalKelas" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formKelas" method="POST" action="{{ isset($kelas) ? route('kelas.update', $kelas->id) : route('kelas.store') }}">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaKelas">Nama Kelas<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaKelas" name="namaKelas">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaJurusan">Jurusan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaJurusan" name="namaJurusan" required>
                                @foreach($jurusan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tahunAjarKelas">Tahun Ajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="tahunAjarKelas" name="tahunAjarKelas" required>
                                @foreach($tahunAjar as $data)
                                    <option value="{{ $data->id }}">{{ $data->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitKelas">Simpan</button>
                    <button type="submit" class="btn-submit" id="updateKelas">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
