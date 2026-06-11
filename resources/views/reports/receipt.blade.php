<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kuitansi Donasi {{ $donation->transaction_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eaeaea;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .org-name {
            font-size: 18px;
            font-weight: bold;
            color: #4f46e5;
            margin: 0;
        }
        .org-detail {
            font-size: 11px;
            color: #666;
            margin: 3px 0 0 0;
        }
        .receipt-title {
            text-align: right;
            vertical-align: top;
        }
        .receipt-title h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }
        .receipt-title p {
            margin: 5px 0 0 0;
            color: #888;
            font-size: 11px;
        }
        .info-section {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-section td {
            vertical-align: top;
            width: 50%;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .amount-box {
            background-color: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }
        .amount-box h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 26px;
        }
        .amount-box p {
            margin: 5px 0 0 0;
            font-style: italic;
            color: #5b21b6;
            font-size: 12px;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        .detail-table th {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #6b7280;
        }
        .detail-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- Branding Header -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <h1 class="org-name">{{ $organization->name }}</h1>
                    <p class="org-detail">
                        {{ $organization->address }}, {{ $organization->city }}, {{ $organization->province }} {{ $organization->postal_code }}<br>
                        Telp: {{ $organization->phone }} | Email: {{ $organization->email }}<br>
                        NPWP: {{ $organization->tax_number ?? '-' }}
                    </p>
                </td>
                <td class="receipt-title">
                    <h2>KUITANSI DONASI</h2>
                    <p>No: {{ $donation->transaction_number }}</p>
                    <p>Tanggal: {{ $donation->donation_date->translatedFormat('d F Y H:i') }} WIB</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Info Section -->
    <table class="info-section">
        <tr>
            <td>
                <div class="info-label">Telah Diterima Dari</div>
                <strong>{{ $donation->donor->name ?? 'Donatur Umum' }}</strong><br>
                Tipe: {{ $donation->donor->donor_type ?? '-' }}<br>
                Telp: {{ $donation->donor->phone }}<br>
                Email: {{ $donation->donor->email ?? '-' }}
            </td>
            <td style="text-align: right;">
                <div class="info-label">Metode Pembayaran</div>
                <strong>{{ $donation->payment_method }}</strong><br>
                <div class="info-label" style="margin-top: 10px;">Status</div>
                <strong style="color: {{ $donation->status === 'Selesai' ? '#10b981' : '#f59e0b' }};">
                    {{ $donation->status }}
                </strong>
            </td>
        </tr>
    </table>

    <!-- Amount Panel -->
    <div class="amount-box">
        <div class="info-label">Jumlah Penyaluran</div>
        <h1>Rp{{ number_format($donation->amount, 0, ',', '.') }}</h1>
        <p>"Terbilang: {{ \App\Helpers\CoretanTerbilang::convert($donation->amount) }} Rupiah"</p>
    </div>

    <!-- Items Detail -->
    <table class="detail-table">
        <thead>
            <tr>
                <th style="width: 70%;">Program Deskripsi Donasi</th>
                <th style="width: 30%; text-align: right;">Alokasi Donasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Donasi {{ $donation->donationType->name ?? '-' }}</strong><br>
                    <span style="font-size: 11px; color: #666;">
                        {{ $donation->notes ?? 'Penyaluran dana program kepedulian bersama.' }}
                    </span>
                </td>
                <td style="text-align: right; font-weight: bold;">
                    Rp{{ number_format($donation->amount, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Signatures -->
    <table class="signatures">
        <tr>
            <td>
                <div class="info-label">Penerima / Petugas</div>
                <div class="signature-line">{{ $donation->user->name ?? '-' }}</div>
                <span style="font-size: 10px; color: #888;">Staf Yayasan</span>
            </td>
            <td>
                <div class="info-label">Penyetor / Donatur</div>
                <div class="signature-line">{{ $donation->donor->name ?? 'Donatur Umum' }}</div>
                <span style="font-size: 10px; color: #888;">Pemberi Donasi</span>
            </td>
        </tr>
    </table>

</div>

</body>
</html>
