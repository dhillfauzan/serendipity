@extends('backend.layout.app')

@section('content')
<!-- contentAwal -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">{{ $judul }}</h4>
                        <div class="row">
                            <!-- Foto -->
                            <div class="col-md-4 text-center">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <img src="#" alt="Foto Preview" class="foto-preview img-thumbnail mb-2" style="max-width: 100%; height: auto;">
                                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Inputs -->
                            <div class="col-md-8">
                                <!-- Hak Akses -->
                                <div class="form-group">
                                    <label for="role">Hak Akses</label>
                                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="" {{ old('role')=='' ? 'selected' : '' }}>- Pilih Hak Akses -
                                        </option>
                                        <option value="1" {{ old('role')=='1' ? 'selected' : '' }}>Super Admin</option>
                                        @if(false)<option value="0" {{ old('role')=='0' ? 'selected' : '' }}>Admin</option>@endif
                                        <option value="2" {{ old('role')=='2' ? 'selected' : '' }}>Kasir</option>
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nama -->
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama">
                                    @error('nama')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                                    @error('email')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- HP -->
                                <div class="form-group">
                                    <label for="hp">HP</label>
                                    <input type="text" id="hp" name="hp" value="{{ old('hp') }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP" onkeypress="return hanyaAngka(event)">
                                    @error('hp')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                                    @error('password')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Form -->
                    <div class="border-top">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
