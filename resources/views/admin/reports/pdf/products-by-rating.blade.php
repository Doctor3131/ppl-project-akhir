<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Berdasarkan Rating</title>
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
        .rating-stars {
            color: #F59E0B;
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
        .province-badge {
            background-color: #EEF2FF;
            color: #4F46E5;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 7px;
            display: inline-block;
            margin: 1px;
        }
        .province-more {
            color: #6B7280;
            font-size: 7px;
            font-style: italic;
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
        <div class="report-title">Laporan Produk Berdasarkan Rating (Menurun)</div>
        <div class="report-date">Tanggal dibuat: {{ date('d-m-Y') }} oleh {{ $adminName }}</div>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-number">{{ $products->count() }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #F59E0B;">{{ $products->where('rating_count', '>', 0)->count() }}</div>
            <div class="stat-label">Produk dgn Rating</div>
        </div>
        <div class="stat-box">
            <div class="stat-number" style="color: #059669;">{{ $products->sum('rating_count') }}</div>
            <div class="stat-label">Total Rating</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th style="text-align: right;">Harga</th>
                <th style="text-align: center;">Rating</th>
                <th>Nama Toko</th>
                <th>Propinsi (Pemberi Rating)</th>
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
                        <span class="rating-stars">{{ number_format($product->average_rating, 1) }} ★</span>
                        <br><small>({{ $product->rating_count }})</small>
                    </td>
                    <td>{{ $product->user->seller->shop_name ?? '-' }}</td>
                    <td>
                        @if($product->rater_provinces && $product->rater_provinces->count() > 0)
                            @foreach($product->rater_provinces->take(2) as $prov)
                                <span class="province-badge">{{ $prov->province }} ({{ $prov->count }})</span>
                            @endforeach
                            @if($product->rater_provinces->count() > 2)
                                <span class="province-more">+{{ $product->rater_provinces->count() - 2 }} lainnya</span>
                            @endif
                        @else
                            <span style="color: #999;">-</span>
                        @endif
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
