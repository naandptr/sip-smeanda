<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUser" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/user" method="POST" id="formUser">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="roleUser">Role<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="roleUser" name="roleUser" required>
                                <option>Siswa</option>
                                <option>Guru</option>
                                <option>Admin Jurusan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaUser">Username<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaUser" name="namaUser">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="pwUser">Password<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="password" id="pwUser" name="pwUser">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="statusUser">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="statusUser" name="statusUser" required>
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
