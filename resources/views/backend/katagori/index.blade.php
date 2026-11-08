@extends('backend.layout.app')

@section('content')
<!-- Content Awal -->
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">{{ $judul }}</h4>
            <a href="{{ route('backend.katagori.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Kategori
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover align-middle mb-0">
                        <thead style="background-color: #1e293b !important; color: #ffffff !important;">
                            <tr>
                                <th style="width: 80px; text-align: center; color: #ffffff !important; font-weight: 600;">No</th>
                                <th style="color: #ffffff !important; font-weight: 600;">Nama Kategori</th>
                                <th style="width: 180px; text-align: center; color: #ffffff !important; font-weight: 600;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_katagori }}</td>
                                <td style="text-align: center;">

                                    <!-- Tombol Ubah -->
                                    <a href="{{ route('backend.katagori.edit', $row->id) }}" title="Ubah Data">
                                        <button type="button" class="btn btn-sm btn-warning">
                                            <i class="far fa-edit"></i> Ubah
                                        </button>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form method="POST" action="{{ route('backend.katagori.destroy', $row->id) }}" style="display: inline-block;">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm" data-konf-delete="{{ $row->nama_katagori }}" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
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
