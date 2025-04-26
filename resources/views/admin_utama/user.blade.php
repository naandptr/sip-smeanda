@php 
    $page_name = 'admin_utama/user'; 
@endphp

@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Data User</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('admin.user') }}">
                <div class="filter-value">
                    <select name="role">
                        <option value="">Pilih Role</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="admin_jurusan" {{ request('role') == 'admin_jurusan' ? 'selected' : '' }}>Admin Jurusan</option>
                    </select>
                </div>
                <div class="filter-value">
                    <select name="status">
                        <option value="">Pilih Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-icon">
                    <img src="{{ asset('img/filter-icon.png') }}" alt="Filter">
                </button>
            </form>            
        </div>
        <div class="data-action">
            <button class="btn-open" id="tambahUser" data-bs-toggle="modal" data-bs-target="#modalUser">Tambah User</button>
            <x-modal_user :jurusans="$jurusans" :kelas="$kelas" />
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PENGGUNA</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user['username'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ $user['status'] }}</td>
                            <td class="data-aksi">
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailUser-{{ $user['id'] }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_user :user="$user" :modalId="'modalDetailUser-' . $user['id']" />
                          
                                <button class="btn-icon editUser" data-id="{{ $user['id'] }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>

                                <button class="btn-icon deleteUser" data-id="{{ $user['id'] }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="5">
                                <div class="pagination custom-pagination">
                                    @if ($users->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $users->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
                                    </span>
                    
                                    @if ($users->hasMorePages())
                                        <a href="{{ $users->nextPageUrl() }}" class="next">Next</a>
                                    @else
                                        <span class="next disabled">Next</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tfoot>                
                </table>
            </div>
        </div>
    </div>
</div>
@endsection