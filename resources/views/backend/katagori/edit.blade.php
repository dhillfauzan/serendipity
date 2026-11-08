@extends('backend.layout.app')
@section('content')
<!-- contentAwal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.katagori.update', $edit->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title"> {{ $judul }} </h4>
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_katagori" value="{{ old('nama_katagori', $edit->nama_katagori) }}" class="form-control @error('nama_katagori') is-invalid @enderror" placeholder="Masukkan Nama Kategori">
                            @error('nama_katagori')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Perbaharui</button>
                            <a href="{{ route('backend.katagori.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
