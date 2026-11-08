@extends('backend.layout.app')

@section('content')
<!-- Content Awal -->
<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.produk.create') }}">
            <button type="button" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->katagori->nama_katagori ?? '-' }}</td>
                                <td>
                                    {{ $row->status_text }}
                                    @if ($row->status == 1)
                                    <span class="badge badge-success">Publis</span>
                                    @elseif ($row->status == 0)
                                    <span class="badge badge-secondary">Blok</span>
                                    @else
                                    <span class="badge badge-warning">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>{{ $row->nama_produk }}</td>
                                <td>Rp. {{ number_format($row->harga, 0, ',', '.') }}</td>
                                <td>{{ $row->stok }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('backend.produk.edit', $row->id) }}" title="Ubah Data">
                                            <button type="button" class="btn btn-sm btn-warning">
                                                <i class="far fa-edit"></i> Ubah
                                            </button>
                                        </a>
                                        <form method="POST" action="{{ route('backend.produk.destroy', $row->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-konf-delete="{{ $row->nama_produk }}" title="Hapus Data">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Akhir -->
@endsection
