<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi {{ $startDate }} - {{ $endDate }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .main-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 20px 0;
            font-size: 0.9em;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #eee;
            padding: 8px;
        }

        .detail-table th {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .transaction-row {
            border-bottom: 2px solid #eee;
        }

        .transaction-details {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 15px;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        @media print {
            body {
                padding: 0;
                font-size: 12pt;
            }

            .no-print {
                display: none;
            }
        }

    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Transaksi Kasir</h2>
        <p>Periode: {{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Kasir</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $key => $transaksi)
            <tr class="transaction-row">
                <td>{{ $key + 1 }}</td>
                <td>{{ $transaksi->kode_transaksi }}</td>
                <td>{{ $transaksi->tanggal->format('d/m/Y H:i') }}</td>
                <td>{{ $transaksi->user->nama }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 0;">
                    <div class="transaction-details">
                        <strong>Detail Item:</strong>
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th width="40%">Nama Produk</th>
                                    <th width="15%" class="text-center">Qty</th>
                                    <th width="20%" class="text-right">Harga Satuan</th>
                                    <th width="25%" class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->formatted_items as $item)
                                <tr>
                                    <td>{{ $item['nama_produk'] }}</td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p><strong>Total Transaksi:</strong> {{ $totalTransaksi }}</p>
        <p><strong>Total Item Terjual:</strong> {{ $totalItemTerjual }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
    </div>

    <script>
        window.print();

    </script>
</body>

</html>
