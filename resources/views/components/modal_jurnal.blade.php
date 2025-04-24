<div class="modal fade" id="modalJurnal" tabindex="-1" aria-labelledby="modalJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form method="POST" id="formJurnal" action="{{ route('jurnal.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tglJurnal">Tanggal<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" 
                                id="tglJurnal" 
                                value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}" 
                                disabled>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="summernote">Deskripsi<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <textarea id="summernote" name="content" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit" id="submitJurnal">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
