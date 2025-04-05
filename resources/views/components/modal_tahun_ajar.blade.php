<div class="modal fade" id="modalTahunAjar" tabindex="-1" aria-labelledby="modalTahunAjarLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formTahunAjar" method="POST" action="{{ isset($tahunAjar) ? route('tahun-ajar.update', $tahunAjar->id) : route('tahun-ajar.store') }}">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tahun_ajaran">Tahun Ajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="tahun_ajaran" name="tahun_ajaran" required>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="periode_mulai">Periode Mulai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="periode_mulai" name="periode_mulai" required>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="periode_selesai">Periode Selesai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="periode_selesai" name="periode_selesai" required>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="status">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="status" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif" selected>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit" id="submitTahunAjar">Simpan</button>
                    <button type="submit" class="btn-submit" id="updateTahunAjar">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>