<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Produk Perlu Dipesan</title>
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
            border-bottom: 2px solid #DC2626;
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
            color: #DC2626; /* Red-600 */
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
            background-color: #FEF2F2; /* Red-50 */
            border-radius: 8px;
            width: 100%;
            border: 1px solid #FECACA; /* Red-200 */
        }
        .summary-label {
            font-size: 9pt;
            color: #7F1D1D; /* Red-900 */
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .summary-value {
            font-size: 18pt;
            font-weight: bold;
            color: #DC2626; /* Red-600 */
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
            background-color: #DC2626; /* Red-600 */
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
            border-radius: 9999px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 60px;
        }
        .status-warning { background-color: #FEF3C7; color: #92400E; }
        .status-danger { background-color: #FDE8E8; color: #9B1C1C; }

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
        <div class="report-title">Laporan Stok Produk Perlu Dipesan</div>
        <div class="shop-name">Toko: {{ $shopName }}</div>
        <div class="report-date">Tanggal: {{ now()->format('d F Y') }}</div>
    </div>

    <!-- Summary Stats -->
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <span class="summary-label">Total Produk Perlu Restock</span>
                <span class="summary-value">{{ $stats['low_stock_count'] }}</span>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 40%">Nama Produk</th>
                <th style="width: 25%">Kategori</th>
                <th style="width: 15%">Stok Saat Ini</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->stock == 0)
                            <span class="status-badge status-danger">Habis</span>
                        @else
                            <span class="status-badge status-warning">Menipis</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh {{ $sellerName }} pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
