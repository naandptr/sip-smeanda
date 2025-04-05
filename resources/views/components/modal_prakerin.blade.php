@props(['siswa', 'dudiJurusan', 'tahunAjar'])
<div class="modal fade" id="modalPrakerin" tabindex="-1" aria-labelledby="modalPrakerin" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formPrakerin" action="{{ isset($penetapanPrakerin) ? route('prakerin.update', $penetapanPrakerin->id) : route('prakerin.store') }}">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaSiswa">Nama Siswa<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaSiswa" name="namaSiswa" required>
                                @foreach($siswa as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="dudiSiswa">Penetapan DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="dudiSiswa" name="dudiSiswa" required>
                                @foreach($dudiJurusan as $data)
                                    <option value="{{ $data->id }}">{{ $data->dudi->nama_dudi }}</option>
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
                    <div class="modal-form-group">
                        <label for="tglMulai">Tanggal Mulai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="tglMulai" name="tglMulai">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tglSelesai">Tanggal Selesai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="tglSelesai" name="tglSelesai">
                        </div>
                    </div>

                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitPrakerin">Simpan</button>
                    <button type="submit" class="btn-submit" id="updatePrakerin">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
