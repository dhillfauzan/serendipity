@extends('backend.layout.app')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h4 style="color:black;">Nilai Akhir SMART</h4>
            <p style="color:black;">
                Perhitungan berdasarkan bobot
            </p>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered text-center">

                    <thead style="background:#f8f9fa; color:black;">
                        <tr>
                            <th>Nama</th>
                            <th>Nilai SMART</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($data as $item)

                        <tr>
                            <td>{{ $item['nama'] }}</td>

                            <td>
                                <strong>
                                    {{ number_format($item['nilai'], 4) }}
                                </strong>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between mt-3">

                <a href="{{ route('smart.perhitungan') }}"
                   class="btn btn-secondary">

                    ← Kembali

                </a>

                <a href="{{ route('smart.hasil') }}"
                   class="btn btn-success">

                    Lihat Ranking →

                </a>

            </div>

        </div>

    </div>

</div>

@endsection