<div class="modal fade" id="modalDetailAbsen" tabindex="-1" role="dialog" aria-labelledby="modalDetailAbsen" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-view-content">
                <div class="modal-view-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <img src="{{ asset('img/close-icon.png') }}" alt="">
                    </button>
                </div>
                <div class="modal-view-body">
                    <div class="modal-view-item">
                        <!-- Preview Gambar -->
                        <img id="previewImage" src="" alt="Foto Absen" style="max-width: 100%; border-radius: 12px; display: none;">
                        
                        <!-- Preview PDF -->
                        <iframe id="previewPDF" src="" width="100%" height="500px" style="border: none; display: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>