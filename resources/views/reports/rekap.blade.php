<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Donasi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.3;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .org-name {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            margin: 0;
        }
        .org-detail {
            font-size: 10px;
            color: #666;
            margin: 2px 0 0 0;
        }
        .report-title {
            text-align: center;
            margin: 15px 0;
        }
        .report-title h2 {
            margin: 0;
            font-size: 16px;
            color: #111;
        }
        .report-title p {
            margin: 3px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .report-table th {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        .report-table td {
            border: 1px solid #e5e7eb;
            padding: 7px 6px;
        }
        .report-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .summary-box {
            background-color: #f5f3ff;
            border: 1px solid #ddd6fe;
            padding: 10px;
            margin-top: 20px;
            width: 300px;
            margin-left: auto;
        }
        .summary-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #8b5cf6;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-val {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1 class="org-name">{{ $organization->name }}</h1>
        <p class="org-detail">
            {{ $organization->address }}, {{ $organization->city }}, {{ $organization->province }}<br>
            Telp: {{ $organization->phone }} | Email: {{ $organization->email }}
        </p>
    </div>

    <!-- Title -->
    <div class="report-title">
        <h2>LAPORAN REKAPITULASI TRANSAKSI DONASI{{ isset($donationType) && $donationType ? ' - ' . strtoupper($donationType->name) : '' }}</h2>
        <p>
            Periode: 
            @if($startDate && $endDate)
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
            @elseif($startDate)
                Dari {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
            @elseif($endDate)
                Sampai {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
            @else
                Semua Periode Waktu
            @endif
        </p>
    </div>

    <!-- Report Table -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No. Transaksi</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Nama Donatur</th>
                <th style="width: 15%;">Program</th>
                <th style="width: 10%;">Metode</th>
                <th style="width: 15%; text-align: right;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @forelse($donations as $index => $donation)
                @php 
                    if ($donation->status === 'Selesai') {
                        $totalAmount += $donation->amount;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $donation->transaction_number }}</td>
                    <td>{{ $donation->donation_date->translatedFormat('d-m-Y H:i') }}</td>
                    <td class="font-bold">{{ $donation->donor->name ?? 'Donatur Umum' }}</td>
                    <td>{{ $donation->donationType->name ?? '-' }}</td>
                    <td>{{ $donation->payment_method }}</td>
                    <td class="text-right font-bold">
                        @if($donation->status === 'Dibatalkan')
                            <span style="text-decoration: line-through; color: #999;">
                                Rp{{ number_format($donation->amount, 0, ',', '.') }}
                            </span>
                            <span style="font-size: 8px; color: red;">(Batal)</span>
                        @else
                            Rp{{ number_format($donation->amount, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #999;">
                        Tidak ditemukan transaksi donasi untuk kriteria filter ini.
                    </td>
                </tr>
            @endforelse
            @if(!$donations->isEmpty())
                <tr style="background-color: #f3f4f6; font-weight: bold;">
                    <td colspan="6" class="text-right">Total Realisasi (Status Selesai):</td>
                    <td class="text-right" style="color: #4f46e5; font-size: 12px;">
                        Rp{{ number_format($totalAmount, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Summary Box -->
    @if(!$donations->isEmpty())
        <div class="summary-box">
            <div class="summary-title">Ringkasan Laporan</div>
            <table>
                <tr>
                    <td style="width: 150px;">Total Transaksi:</td>
                    <td class="font-bold">{{ $donations->count() }}</td>
                </tr>
                <tr>
                    <td>Total Nominal Realisasi:</td>
                    <td class="summary-val">Rp{{ number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @endif

</body>
</html>
