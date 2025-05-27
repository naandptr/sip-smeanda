@props(['dudi', 'pembimbing', 'tahunAjar', 'tahunAjarAktif'])
<div class="modal fade" id="modalDudiJurusan" tabindex="-1" aria-labelledby="modalDudiJurusan" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formDudiJurusan" action="{{ isset($dudiJurusan) ? route('dudi-jurusan.update', $dudiJurusan->id) : route('dudi-jurusan.store') }}">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="lokasiDudi">Lokasi DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="lokasiDudi" name="lokasiDudi" required>
                                <option value="" selected>Pilih Lokasi DUDI</option>
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
                                <option value="" selected>Pilih Pembimbing</option>
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
                                @if($tahunAjarAktif)
                                    <option value="{{ $tahunAjarAktif->id }}" selected>
                                        {{ $tahunAjarAktif->tahun_ajaran }}
                                    </option>
                                @else
                                    <option value="">Tidak ada tahun ajaran aktif</option>
                                @endif
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
