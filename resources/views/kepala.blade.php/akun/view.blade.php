@extends('layouts.app')

@section('content')
<div class="p-4">
    <h3 class="mb-3">Detail Akun</h3>

    <table class="table table-bordered" style="max-width: 600px;">
        <tr>
            <th width="180">ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Level</th>
            <td>{{ ucfirst($user->level) }}</td>
        </tr>

        @if($user->level == 'anggota' && $user->anggota)
        <tr>
            <th>NIS</th>
            <td>{{ $user->anggota->nis }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $user->anggota->kelas }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $user->anggota->alamat ?? '-' }}</td>
        </tr>
        @endif

        @if($user->level == 'petugas' && $user->petugas)
        <tr>
            <th>NIP</th>
            <td>{{ $user->petugas->nip_petugas ?? '-' }}</td>
        </tr>
        <tr>
            <th>No HP</th>
            <td>{{ $user->petugas->no_hp ?? '-' }}</td>
        </tr>
        @endif

        @if($user->level == 'kepala' && $user->kepala)
        <tr>
            <th>NIP</th>
            <td>{{ $user->kepala->nip_KepalaPerpus ?? '-' }}</td>
        </tr>
        @endif

        <td>{{ optional($user->created_at)->format('d-m-Y H:i') }}</td>
`       <td>{{ optional($user->updated_at)->format('d-m-Y H:i') }}</td>
    </table>

    <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-warning text-white">Edit</a>
    <form action="{{ route('akun.destroy', $user->id) }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus akun ini?')">Hapus</button>
    </form>
    <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection