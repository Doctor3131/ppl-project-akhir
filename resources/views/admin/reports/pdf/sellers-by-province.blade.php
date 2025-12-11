<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjual Per Provinsi</title>
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
            border-bottom: 2px solid #16A34A;
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
        .summary-section {
            margin-bottom: 30px;
            background-color: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 8px;
            padding: 15px;
        }
        .summary-title {
            font-size: 12pt;
            font-weight: bold;
            color: #166534;
            margin-bottom: 10px;
            border-bottom: 1px solid #BBF7D0;
            padding-bottom: 5px;
        }
        .summary-list {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-list td {
            padding: 5px;
            border-bottom: 1px dashed #BBF7D0;
        }
        .summary-list tr:last-child td {
            border-bottom: none;
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
            background-color: #16A34A;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
        }
        .data-table tr:nth-child(even) {
            background-color: #F9FAFB;
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
        <div class="report-title">Laporan Penjual Per Provinsi</div>
        <div class="shop-name">Distribusi Lokasi Toko</div>
        <div class="report-date">Tanggal: {{ now()->format('d F Y') }}</div>
    </div>

    <!-- Summary Stats -->
    <div class="summary-section">
        <div class="summary-title">Ringkasan Per Provinsi</div>
        <table class="summary-list">
            @foreach($statsByProvince as $stat)
                <tr>
                    <td style="width: 70%">{{ $stat->province }}</td>
                    <td style="width: 30%; text-align: right; font-weight: bold;">{{ $stat->total }} Toko</td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Provinsi</th>
                <th style="width: 25%">Nama Toko</th>
                <th style="width: 25%">Nama PIC</th>
                <th style="width: 20%">Kota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $seller->province }}</td>
                    <td>{{ $seller->shop_name }}</td>
                    <td>{{ $seller->pic_name }}</td>
                    <td>{{ $seller->city }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh {{ $adminName ?? 'Administrator' }} pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
