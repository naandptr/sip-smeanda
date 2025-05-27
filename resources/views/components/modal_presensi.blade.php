<div class="modal fade" id="modalPresensi" tabindex="-1" role="dialog" aria-labelledby="modalPresensi" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formPresensi" action="{{ route('presensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tglPresensiFormatted">Tanggal</label>
                        <div class="modal-form-value">
                            <input type="text" id="tglPresensiView" readonly>
                            <input type="hidden" name="tglPresensiFormatted" id="tglPresensiFormatted">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="jenisPresensi">Jenis<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="jenisPresensi" name="jenisPresensi">
                                <option value="" selected>Pilih Jenis Presensi</option>
                                <option value="Presensi Datang">Presensi Datang</option>
                                <option value="Presensi Pulang">Presensi Pulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="statusPresensi">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="statusPresensi" name="statusPresensi">
                                <option value="" selected>Pilih Status Presensi</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="ketPresensi">Keterangan</label>
                        <div class="modal-form-value">
                            <input type="text" id="ketPresensi" name="ketPresensi">
                        </div>
                        
                    </div>
                    <div class="modal-form-group">
                        <label for="filePresensi">Bukti Presensi<span class="required-label">*</span></h5></label>
                        <div class="modal-form-value">
                            <input type="file" class="filepond" name="filePresensi" id="filePresensi">
                        </div>
                    </div>
                </div>

                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit" id="submitPresensi">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>