@extends('backend.layout.app')

@section('content')
<!-- contentAwal -->
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">{{ $judul }}</h4>
            <a href="{{ route('backend.user.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah User
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #1e293b !important; color: #ffffff !important;">
                            <tr>
                                <th style="color: #ffffff !important; font-weight: 600; width: 60px;" class="text-center">No</th>
                                <th style="color: #ffffff !important; font-weight: 600;">Email</th>
                                <th style="color: #ffffff !important; font-weight: 600;">Nama</th>
                                <th style="color: #ffffff !important; font-weight: 600;">Role</th>
                                <th style="color: #ffffff !important; font-weight: 600;">Status</th>
                                <th style="color: #ffffff !important; font-weight: 600; width: 160px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->email }}</td>
                                <td class="fw-bold">{{ $row->nama }}</td>
                                <td>
                                    @if ($row->role == 1)
                                    <span class="badge bg-primary">Super Admin</span>
                                    @elseif ($row->role == 0)
                                    <span class="badge bg-secondary">Admin</span>
                                    @else
                                    <span class="badge bg-light text-dark">{{ $row->role }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 1)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('backend.user.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                            <i class="far fa-edit me-1"></i> Ubah
                                        </a>
                                        <form action="{{ route('backend.user.destroy', $row->id) }}" method="POST" class="d-inline" id="delete-form-{{$row->id}}">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm delete-confirm" data-id="{{$row->id}}" data-nama="{{$row->nama}}">
                                                <i class="fas fa-trash me-1"></i> Hapus
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
<!-- contentAkhir -->
@endsection
