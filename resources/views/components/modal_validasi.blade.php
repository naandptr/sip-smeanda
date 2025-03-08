<div class="modal fade" id="modalValidasiJurnal" tabindex="-1" role="dialog" aria-labelledby="modalValidasiJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content modal-validasi-content">
            <form action="/validasi" method="POST" class="validasi-form" id="formValidasi">
                <div class="modal-validasi-body validasi-container">
                    <div class="validasi-header">
                        <h4>Masukkan Alasan</h4>
                    </div>
                    <div class="validasi-value">
                        <textarea name="komentar" id="komentar" cols="30" rows="10" placeholder="Jelaskan alasan..."></textarea>
                    </div>
                    <div class="modal-validasi-footer">
                        <button type="button" class="close btn-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>