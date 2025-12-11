<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjual per Provinsi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #4F46E5;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            color: #666;
        }
        .report-date {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #4F46E5;
        }
        .province-stat {
            display: inline-block;
            margin: 3px 5px;
            padding: 5px 10px;
            background-color: #EEF2FF;
            border-radius: 5px;
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4F46E5;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .province-badge {
            background-color: #4F46E5;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if(file_exists(public_path('images/LogoChromarket.png')))
            <img src="{{ public_path('images/LogoChromarket.png') }}" alt="Logo" class="logo">
        @endif
        <div class="company-name">CHROMARKET</div>
        <div class="report-title">Laporan Daftar Penjual per Provinsi</div>
        <div class="report-date">Tanggal dibuat: {{ date('d-m-Y') }} oleh {{ $adminName }}</div>
    </div>

    <div class="summary">
        <div class="summary-title">Ringkasan per Provinsi ({{ $statsByProvince->count() }} Provinsi)</div>
        @foreach($statsByProvince as $stat)
            <span class="province-stat">
                {{ $stat->province }}: <strong>{{ $stat->total }}</strong> toko
            </span>
        @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Toko</th>
                <th>Nama PIC</th>
                <th>Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $seller->shop_name }}</td>
                    <td>{{ $seller->pic_name }}</td>
                    <td>
                        <span class="province-badge">{{ $seller->province }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} CHROMARKET - Laporan ini dihasilkan secara otomatis</p>
    </div>
</body>
</html>
