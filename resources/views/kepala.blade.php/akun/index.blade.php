@extends('layouts.app')

@section('content')
<div class="p-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Daftar Akun</h3>
        <a href="{{ route('akun.create') }}" class="btn btn-primary">+ Tambah Akun</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <th>Identitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->level) }}</td>
                <td>
                    @if($user->level == 'anggota' && $user->anggota)
                        NIS: {{ $user->anggota->nis }} / {{ $user->anggota->kelas }}
                    @elseif($user->level == 'petugas' && $user->petugas)
                        NIP: {{ $user->petugas->nip_petugas ?? '-' }}
                    @elseif($user->level == 'kepala' && $user->kepala)
                        NIP: {{ $user->kepala->nip_KepalaPerpus ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('akun.detail', $user->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                    <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                    <form action="{{ route('akun.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus akun ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection