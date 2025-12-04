<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Akun Penjual</title>
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
        .stats-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .stat-box {
            text-align: center;
            padding: 10px 15px;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4F46E5;
            color: white;
            padding: 10px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 6px;
            border-bottom: 1px solid #eee;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-active {
            background-color: #D1FAE5;
            color: #065F46;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .status-inactive {
            background-color: #E5E7EB;
            color: #374151;
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
        @if(file_exists(public_path('images/LogoCampusMarket.png')))
            <img src="{{ public_path('images/LogoCampusMarket.png') }}" alt="Logo" class="logo">
        @endif
        <div class="company-name">CAMPUSMARKET</div>
        <div class="report-title">Laporan Daftar Akun Penjual (Aktif & Non-Aktif)</div>
        <div class="report-date">Tanggal dibuat: {{ date('d-m-Y') }} oleh {{ $adminName }}</div>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-number" style="color: #059669;">{{ $stats['active'] }}</div>
            <div class="stat-label">Penjual Aktif</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #6B7280;">{{ $stats['inactive'] }}</div>
            <div class="stat-label">Penjual Non-Aktif</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama User</th>
                <th>Nama PIC</th>
                <th>Nama Toko</th>
                <th style="width: 80px;">Status</th>
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
                        <span class="status-{{ $seller->is_active ? 'active' : 'inactive' }}">
                            {{ $seller->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} CAMPUSMARKET - Laporan ini dihasilkan secara otomatis</p>
    </div>
</body>
</html>
