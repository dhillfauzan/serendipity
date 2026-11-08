@extends('backend.layout.app')
@section('content')
<!-- Content Awal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.katagori.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <div class="form-group">
                            <label for="nama_katagori">Nama Kategori</label>
                            <input type="text" id="nama_katagori" name="nama_katagori" value="{{ old('nama_katagori') }}" class="form-control @error('nama_katagori') is-invalid @enderror" placeholder="Masukkan Nama Katagori">
                            @error('nama_katagori')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.katagori.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content Akhir -->
@endsection
