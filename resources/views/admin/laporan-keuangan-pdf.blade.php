<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan — Skinist</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1A3A5C; font-size: 12px; margin: 30px; }
        h1 { font-size: 20px; margin-bottom: 4px; color: #1A3A5C; }
        .periode { font-size: 11px; color: #5A7FA0; margin-bottom: 24px; }

        .summary { width: 100%; margin-bottom: 24px; }
        .summary td {
            width: 33.33%; padding: 12px; border: 1px solid #E3F2FD;
            vertical-align: top;
        }
        .summary .label { font-size: 9px; color: #5A7FA0; text-transform: uppercase; letter-spacing: 0.05em; }
        .summary .value { font-size: 16px; font-weight: bold; color: #1A3A5C; margin-top: 4px; }

        h2 { font-size: 13px; color: #1A3A5C; margin-top: 24px; margin-bottom: 8px; }

        table.data { width: 100%; border-collapse: collapse; }
        table.data th {
            text-align: left; font-size: 10px; color: #5A7FA0;
            text-transform: uppercase; padding: 6px 8px;
            border-bottom: 2px solid #E3F2FD;
        }
        table.data td {
            padding: 6px 8px; font-size: 11px;
            border-bottom: 1px solid #F0F7FF; color: #1A3A5C;
        }
        table.data td.right, table.data th.right { text-align: right; }

        .footer { margin-top: 30px; font-size: 9px; color: #9CA3AF; text-align: center; }
    </style>
</head>
<body>

    <h1>Laporan Keuangan — Skinist</h1>
    <p class="periode">
        Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }}
        s/d
        {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
        &mdash; Dicetak {{ now()->format('d M Y, H:i') }}
    </p>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Total Order Selesai</div>
                <div class="value">{{ $totalOrder }}</div>
            </td>
            <td>
                <div class="label">Rata-rata per Order</div>
                <div class="value">Rp {{ $totalOrder > 0 ? number_format($totalPendapatan / $totalOrder, 0, ',', '.') : 0 }}</div>
            </td>
        </tr>
    </table>

    <h2>Pendapatan per Bulan</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendapatanPerBulan as $bulan => $total)
            <tr>
                <td>{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</td>
                <td class="right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="2">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detail Transaksi</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td class="right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="5">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">© {{ now()->year }} Skinist Admin Panel — Laporan Keuangan</p>

</body>
</html>