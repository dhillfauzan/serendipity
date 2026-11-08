@extends('backend.layout.app')
@section('content')
<!-- contentAwal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.produk.update', $produk->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h4 class="card-title"> Edit {{ $judul }} </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    @if ($produk->foto)
                                    <img src="{{ asset('storage/img-produk/' . $produk->foto) }}" class="img-thumbnail foto-preview" width="150px">
                                    @endif
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control @error('katagori_id') is-invalid @enderror" name="katagori_id">
                                        <option value="" disabled>--Pilih Kategori--</option>
                                        @foreach ($katagori as $k)
                                        <option value="{{ $k->id }}" {{ $k->id == $produk->katagori_id ? 'selected' : ''
                                            }}>
                                            {{ $k->nama_katagori }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('katagori_id')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan Nama Produk">
                                    @error('nama_produk')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea name="detail" class="form-control @error('detail') is-invalid @enderror">{{ old('detail', $produk->detail) }}</textarea>
                                    @error('detail')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="harga" value="{{ old('harga', $produk->harga) }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga">
                                    @error('harga')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Berat</label>
                                    <input type="text" name="berat" value="{{ old('berat', $produk->berat) }}" class="form-control @error('berat') is-invalid @enderror" placeholder="Masukkan Berat">
                                    @error('berat')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="text" name="stok" value="{{ old('stok', $produk->stok) }}" class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan Stok">
                                    @error('stok')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="1" {{ old('status', $produk->status) == 1 ? 'selected' : ''
                                            }}>Publis</option>
                                        <option value="0" {{ old('status', $produk->status) == 0 ? 'selected' : ''
                                            }}>Blok</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('backend.produk.index') }}">
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

@section('scripts')
<script>
    function previewFoto() {
        const foto = document.querySelector('input[name="foto"]');
        const preview = document.querySelector('.foto-preview');
        const file = foto.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

</script>
@endsection
