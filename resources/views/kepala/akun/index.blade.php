@extends('kepala.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Akun</h3>
        <a href="{{ route('kepala.akun.create') }}" class="btn btn-success">
            + Tambah Akun
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>role</th>
                        <th>Identitas</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>

                        <td>
                            @if($user->role == 'anggota' && $user->anggota)
                                NIS: {{ $user->anggota->nis }} / {{ $user->anggota->kelas }}
                            @elseif($user->role == 'petugas' && $user->petugas)
                                NIP: {{ $user->petugas->nip_petugas ?? '-' }}
                            @elseif($user->role == 'kepala' && $user->kepala)
                                NIP: {{ $user->kepala->nip_KepalaPerpus ?? '-' }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('kepala.akun.detail', $user->id) }}" 
                               class="btn btn-info btn-sm text-white">
                                Detail
                            </a>

                            <a href="{{ route('kepala.akun.edit', $user->id) }}" 
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('kepala.akun.destroy', $user->id) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus akun ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data belum ada</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection