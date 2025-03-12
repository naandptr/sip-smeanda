<div class="modal fade" id="modalTahunAjar" tabindex="-1" aria-labelledby="modalTahunAjar" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/tahun-ajar" method="POST" id="formTahunAjar">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tahunAjar">Tahun Ajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="tahunAjar" name="tahunAjar">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="mulaiTA">Periode Mulai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="mulaiTA" name="mulaiTA">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="selesaiTA">Periode Selesai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="selesaiTA" name="selesaiTA">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="listTA">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="listTA" name="listTA" required>
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
