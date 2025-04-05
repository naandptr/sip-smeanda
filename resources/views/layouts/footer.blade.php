<!-- Load jQuery & Global JS  -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous"></script>

<script src="{{ asset('js/core/global.js') }}"></script>

<!-- Bootstrap JS  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>

<!-- Conditional Loading -->
@if(isset($page_name))
    @if($page_name === 'auth/login')
        <script src="{{ asset('js/auth/login.js') }}"></script>
    @endif

    @if($page_name === 'auth/setup_akun')
        <script src="{{ asset('js/auth/setup_akun.js') }}"></script>
    @endif

    @if($page_name === 'admin_utama/user')
        <script src="{{ asset('js/admin_utama/user.js') }}"></script>
    @endif

    @if($page_name === 'admin_utama/jurusan')
        <script src="{{ asset('js/admin_utama/jurusan.js') }}"></script>
    @endif

    @if($page_name === 'admin_utama/kelas')
        <script src="{{ asset('js/admin_utama/kelas.js') }}"></script>
    @endif

    @if($page_name === 'admin_utama/lokasi')
        <script src="{{ asset('js/admin_utama/lokasi.js') }}"></script>
    @endif

    @if($page_name === 'admin_utama/tahun_ajar')
        <script src="{{ asset('js/admin_utama/tahun_ajar.js') }}"></script>
    @endif

    @if($page_name === 'admin_jurusan_dudi_jurusan')
        <script src="{{ asset('js/admin_jurusan/dudi_jurusan.js') }}"></script>
    @endif

    @if($page_name === 'admin_jurusan_prakerin')
        <script src="{{ asset('js/admin_jurusan/prakerin.js') }}"></script>
    @endif
    
    @if($page_name === 'guru_jurnal')
        <script src="{{ asset('js/guru/jurnal.js') }}"></script>
    @endif

    @if($page_name === 'guru_nilai')
        <script src="{{ asset('js/guru/nilai.js') }}"></script>
    @endif

    @if($page_name === 'siswa_absen')
        <script src="{{ asset('js/siswa/absen.js') }}"></script>
    @endif

    @if($page_name === 'siswa_jurnal')
        <script src="{{ asset('js/siswa/jurnal.js') }}"></script>
    @endif

    @if($page_name === 'siswa_dokumen')
        <script src="{{ asset('js/siswa/dokumen.js') }}"></script>
    @endif
@endif


<!-- Sweet Alert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!-- FilePond JS -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>




