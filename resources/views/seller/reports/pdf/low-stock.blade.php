<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Produk Perlu Dipesan</title>
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
            border-bottom: 2px solid #DC2626;
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
            color: #DC2626;
            font-weight: bold;
        }
        .seller-info {
            font-size: 11px;
            color: #333;
            margin-top: 5px;
        }
        .report-date {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }
        .alert-box {
            background-color: #FEF2F2;
            border: 1px solid #FCA5A5;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .alert-title {
            font-size: 12px;
            font-weight: bold;
            color: #DC2626;
            margin-bottom: 5px;
        }
        .alert-text {
            font-size: 10px;
            color: #991B1B;
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
            padding: 10px 20px;
        }
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #DC2626;
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
            background-color: #FEF2F2;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
        .stock-out {
            background-color: #DC2626;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .stock-low {
            background-color: #F59E0B;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .category-badge {
            background-color: #DBEAFE;
            color: #1E40AF;
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
        <div class="report-title">⚠️ LAPORAN PRODUK PERLU DIPESAN (STOK < 2)</div>
        <div class="seller-info">Toko: {{ $shopName }}</div>
        <div class="report-date">Tanggal dibuat: {{ date('d-m-Y') }} oleh {{ $sellerName }}</div>
    </div>

    @if($products->count() > 0)
        <div class="alert-box">
            <div class="alert-title">⚠️ PERHATIAN: {{ $products->count() }} Produk Perlu Segera Dipesan!</div>
            <div class="alert-text">Produk dengan stok kurang dari 2 unit harus segera dipesan untuk menghindari kehabisan stok.</div>
        </div>
    @endif

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-number" style="color: #DC2626;">{{ $stats['low_stock_count'] }}</div>
            <div class="stat-label">Produk Stok Rendah</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #DC2626;">{{ $stats['out_of_stock'] }}</div>
            <div class="stat-label">Produk Habis</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #F59E0B;">{{ $stats['stock_1'] }}</div>
            <div class="stat-label">Stok = 1</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #059669;">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</div>
            <div class="stat-label">Nilai Stok Tersisa</div>
        </div>
    </div>

    @if($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: center;">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            <span class="category-badge">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td style="text-align: right;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            @if($product->stock == 0)
                                <span class="stock-out">{{ $product->stock }}</span>
                            @else
                                <span class="stock-low">{{ $product->stock }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #059669;">
            <p style="font-size: 14px; font-weight: bold;">✅ Semua produk memiliki stok yang cukup!</p>
            <p style="font-size: 10px; margin-top: 10px;">Tidak ada produk yang perlu dipesan saat ini.</p>
        </div>
    @endif

    <div class="footer">
        <p>© {{ date('Y') }} CHROMARKET - Laporan ini dihasilkan secara otomatis</p>
    </div>
</body>
</html>
