<div class="modal fade" id="modalValidasiJurnal" tabindex="-1" role="dialog" aria-labelledby="modalValidasiJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <form action="/validasi" method="POST" id="formValidasi">
                <div class="modal-form-header">
                    <h4>Masukkan Alasan</h4>
                </div>
                <div class="modal-form-body">
                    <div class="modal-form-value validasi-value">
                        <textarea name="komentar" id="komentar" cols="30" rows="10" placeholder="Jelaskan alasan..."></textarea>
                    </div>
                    <div class="modal-form-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>