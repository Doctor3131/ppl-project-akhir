<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih atas Rating Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
        }
        .rating-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .rating-stars {
            color: #fbbf24;
            font-size: 20px;
            margin: 10px 0;
        }
        .product-info {
            border-left: 4px solid #4F46E5;
            padding-left: 15px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Terima Kasih!</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $name }}</strong>,</p>

            <p>Terima kasih telah memberikan rating dan komentar untuk produk kami. Masukan Anda sangat berharga bagi kami dan membantu pelanggan lain dalam membuat keputusan pembelian.</p>

            <div class="product-info">
                <h3 style="margin-top: 0; color: #4F46E5;">Produk yang Anda nilai:</h3>
                <p style="margin: 5px 0; font-weight: bold;">{{ $product->name }}</p>
            </div>

            <div class="rating-info">
                <h4 style="margin-top: 0;">Rating Anda:</h4>
                <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                    <span style="color: #333; font-size: 16px;">({{ $rating }}/5)</span>
                </div>

                @if (!empty($comment))
                    <h4 style="margin-bottom: 5px;">Komentar Anda:</h4>
                    <p style="font-style: italic; color: #555; margin: 5px 0;">"{{ $comment }}"</p>
                @endif
            </div>

            <p>Rating dan komentar Anda telah berhasil disimpan dan akan ditampilkan di halaman produk untuk membantu pengunjung lain.</p>

            <div style="text-align: center;">
                <a href="{{ route('catalog.show', $product->id) }}" class="button">
                    Lihat Produk
                </a>
            </div>

            <p style="margin-top: 20px;">Kami sangat menghargai waktu yang Anda luangkan untuk memberikan feedback. Jika Anda memiliki pertanyaan atau masukan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
        </div>

        <div class="footer">
            <p><strong>MartPlace</strong></p>
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p style="margin-top: 10px;">
                © {{ date('Y') }} MartPlace. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
