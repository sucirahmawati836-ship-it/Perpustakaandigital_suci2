@extends('kepala.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-3">Tambah Akun</h3>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('kepala.akun.store') }}" method="POST">
                        @csrf

                        <!-- role -->
                        <div class="mb-3">
                            <label class="form-label">role *</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">-- Pilih role --</option>
                                <option value="anggota">Anggota</option>
                                <option value="petugas">Petugas</option>
                                <option value="kepala">Kepala Perpus</option>
                            </select>
                            @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <!-- Data User -->
                        <div class="mb-3">
                            <label class="form-label">Nama *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col">
                                <label class="form-label">Konfirmasi Password *</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <hr>

                        <!-- Dinamis: Anggota -->
                        <div id="fieldAnggota" style="display:block;">
                            <h5 class="mb-2">Data Anggota</h5>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">NIS *</label>
                                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}">
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">Kelas *</label>
                                    <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" placeholder="Contoh: 10A" value="{{ old('kelas') }}">
                                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                            </div>
                        </div>

                        <!-- Dinamis: Petugas -->
                        <div id="fieldPetugas" style="display:block;">
                            <h5 class="mb-2">Data Petugas</h5>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip_petugas" class="form-control @error('nip_petugas') is-invalid @enderror" value="{{ old('nip_petugas') }}">
                                    @error('nip_petugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">No HP</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Dinamis: Kepala -->
                        <div id="fieldKepala" style="display:block;">
                            <h5 class="mb-2">Data Kepala Perpus</h5>
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip_KepalaPerpus" class="form-control @error('nip_KepalaPerpus') is-invalid @enderror" value="{{ old('nip') }}">
                                @error('nip_KepalaPerpus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kepala.akun.index') }}" class="btn btn-secondary">Batal</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('role').addEventListener('change', function() {
        document.getElementById('fieldAnggota').style.display = this.value === 'anggota' ? 'block' : 'none';
        document.getElementById('fieldPetugas').style.display = this.value === 'petugas' ? 'block' : 'none';
        document.getElementById('fieldKepala').style.display  = this.value === 'kepala'  ? 'block' : 'none';
    });

    @if(old('role'))
        document.getElementById('role').value = '{{ old("role") }}';
        document.getElementById('role').dispatchEvent(new Event('change'));
    @endif
</script>
@endpush