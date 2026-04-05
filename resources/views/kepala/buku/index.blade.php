@extends('kepala.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Buku</h3>
        <a href="{{ route('kepala.buku.create') }}" class="btn btn-success">
            + Tambah Buku
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Cover</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($buku as $i => $b)
                    <tr>
                        <td>{{ $i+1 }}</td>

                        <!-- COVER -->
                        <td>
                            @if($b->cover)
                                <img src="{{ asset('storage/' . $b->cover) }}" 
                                     width="60" height="80" 
                                     style="object-fit:cover; border-radius:5px;">
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $b->kode_buku }}</td>
                        <td>{{ $b->judul_buku }}</td>
                        <td>{{ $b->penulis }}</td>

                        <!-- TAHUN SAJA -->
                        <td>{{ \Carbon\Carbon::parse($b->tahun_terbit)->format('Y') }}</td>

                        <td>{{ $b->stok }}</td>
                        <td>
                            <a href="{{ route('kepala.buku.edit', $b->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('kepala.buku.destroy', $b->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Data belum ada</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection