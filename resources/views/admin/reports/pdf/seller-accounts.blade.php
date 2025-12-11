<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Akun Penjual</title>
    <style>
        @page {
            margin: 1cm 2cm 2cm 2cm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #1f2937;
            line-height: 1.5;
        }
        .header-container {
            text-align: center;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-img {
            height: 50px;
            width: auto;
            vertical-align: middle;
            margin-right: 10px;
        }
        .brand-text {
            font-size: 24pt;
            font-weight: bold;
            color: #000000;
            vertical-align: middle;
        }
        .report-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 8px;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .shop-name {
            font-size: 12pt;
            margin-bottom: 4px;
            color: #374151;
        }
        .report-date {
            font-size: 10pt;
            color: #6B7280;
        }
        .summary-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: separate;
            border-spacing: 15px 0;
        }
        .summary-cell {
            text-align: center;
            padding: 15px;
            background-color: #EEF2FF;
            border-radius: 8px;
            width: 33.33%;
            border: 1px solid #C7D2FE;
        }
        .summary-label {
            font-size: 9pt;
            color: #3730A3;
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .summary-value {
            font-size: 18pt;
            font-weight: bold;
            color: #4F46E5;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        .data-table th, .data-table td {
            border: 1px solid #E5E7EB;
            padding: 12px;
            text-align: left;
        }
        .data-table th {
            background-color: #4F46E5;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
        }
        .data-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-active {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #9CA3AF;
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-container">
        <img src="{{ public_path('images/LogoChromarket.png') }}" class="logo-img" alt="Chromarket Logo">
        <span class="brand-text">Chromarket</span>
    </div>

    <!-- Report Info -->
    <div class="report-info">
        <div class="report-title">Laporan Akun Penjual</div>
        <div class="shop-name">Daftar Status Keaktifan Penjual</div>
        <div class="report-date">Tanggal: {{ now()->format('d F Y') }}</div>
    </div>

    <!-- Summary Stats -->
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <span class="summary-label">Total Penjual</span>
                <span class="summary-value">{{ $stats['total'] }}</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Aktif</span>
                <span class="summary-value">{{ $stats['active'] }}</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Tidak Aktif</span>
                <span class="summary-value">{{ $stats['inactive'] }}</span>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama User</th>
                <th style="width: 25%">Nama PIC</th>
                <th style="width: 25%">Nama Toko</th>
                <th style="width: 20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->seller->pic_name ?? '-' }}</td>
                    <td>{{ $seller->seller->shop_name ?? '-' }}</td>
                    <td>
                        @if($seller->is_active)
                            <span class="status-badge status-active">Aktif</span>
                        @else
                            <span class="status-badge status-inactive">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh {{ $adminName ?? 'Administrator' }} pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
