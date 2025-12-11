<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Berdasarkan Rating</title>
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
            border-bottom: 2px solid #CA8A04;
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
            background-color: #FEFCE8;
            border-radius: 8px;
            width: 50%;
            border: 1px solid #FEF08A;
        }
        .summary-label {
            font-size: 9pt;
            color: #854D0E;
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .summary-value {
            font-size: 18pt;
            font-weight: bold;
            color: #CA8A04;
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
            background-color: #CA8A04;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
        }
        .data-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        .rating-star {
            color: #CA8A04;
            font-size: 12pt;
            margin-right: 4px;
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
        <div class="report-title">Laporan Produk Berdasarkan Rating</div>
        <div class="shop-name">Semua Toko</div>
        <div class="report-date">Tanggal: {{ now()->format('d F Y') }}</div>
    </div>

    <!-- Summary Stats -->
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <span class="summary-label">Rata-rata Rating Global</span>
                <span class="summary-value">
                    <span class="rating-star">★</span> {{ number_format($products->avg('average_rating'), 1) }}
                </span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Total Ulasan Global</span>
                <span class="summary-value">{{ $products->sum('rating_count') }}</span>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 30%">Nama Produk</th>
                <th style="width: 20%">Toko</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 15%">Lokasi Utama</th>
                <th style="width: 10%">Rating</th>
                <th style="width: 5%">Ulasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->user->seller->shop_name ?? 'N/A' }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->primary_rater_province }}</td>
                    <td>
                        <span class="rating-star">★</span> {{ number_format($product->average_rating, 1) }}
                    </td>
                    <td>{{ $product->rating_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh {{ $adminName ?? 'Administrator' }} pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
