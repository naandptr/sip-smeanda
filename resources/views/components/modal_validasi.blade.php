<div class="modal fade" id="modalValidasiJurnal{{ $jurnal->id }}" tabindex="-1" role="dialog" aria-labelledby="modalValidasiJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <form action="{{ route('validasi.store', $jurnal->id) }}" method="POST" class="form-validasi">
                @csrf
                <div class="modal-form-header">
                    <h4>Masukkan Catatan</h4>
                </div>
                <div class="modal-form-body">
                    <div class="modal-form-value validasi-value">
                        <textarea name="catatan" id="catatan" cols="30" rows="10" placeholder="Masukkan catatan..."></textarea>
                    </div>
                    <div class="modal-form-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit" id="submitValidasi">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>