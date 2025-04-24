@props(['dudi', 'pembimbing', 'tahunAjar'])
<div class="modal fade" id="modalDudiJurusan" tabindex="-1" aria-labelledby="modalDudiJurusan" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formDudiJurusan" action="{{ isset($dudiJurusan) ? route('dudi-jurusan.update', $dudiJurusan->id) : route('dudi-jurusan.store') }}">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="lokasiDudi">Penetapan DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="lokasiDudi" name="lokasiDudi" required>
                                @foreach($dudi as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_dudi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaPembimbing">Nama Pembimbing<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaPembimbing" name="namaPembimbing" required>
                                @foreach($pembimbing as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tahunAjar">Tahun Ajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="tahunAjar" name="tahunAjar" required>
                                @foreach($tahunAjar as $data)
                                    <option value="{{ $data->id }}">{{ $data->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit" id="submitDudiJurusan">Kirim</button>
                    <button type="submit" class="btn-submit" id="updateDudiJurusan">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
