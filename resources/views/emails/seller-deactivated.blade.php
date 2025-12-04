<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Dinonaktifkan</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">CAMPUSMARKET</h1>
                        </td>
                    </tr>
                    
                    <!-- Alert Icon -->
                    <tr>
                        <td style="padding: 30px 40px 20px 40px; text-align: center;">
                            <div style="background-color: #FEE2E2; border-radius: 50%; width: 80px; height: 80px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                <span style="font-size: 40px;">🔒</span>
                            </div>
                            <h2 style="color: #DC2626; margin: 0; font-size: 20px;">Akun Toko Dinonaktifkan</h2>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                                Halo <strong>{{ $seller->name }}</strong>,
                            </p>
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                                Dengan berat hati kami sampaikan bahwa akun toko Anda 
                                <strong>{{ $seller->seller->shop_name ?? 'Toko Anda' }}</strong> 
                                telah <strong>dinonaktifkan</strong>.
                            </p>
                            
                            <div style="background-color: #FEE2E2; border-left: 4px solid #DC2626; padding: 15px 20px; margin: 20px 0; border-radius: 0 8px 8px 0;">
                                <p style="color: #991B1B; font-size: 14px; margin: 0;">
                                    <strong>Alasan:</strong> 
                                    @if($reason === 'inactivity')
                                        Tidak ada aktivitas login selama lebih dari 30 hari.
                                    @elseif($reason === 'admin')
                                        Dinonaktifkan oleh administrator.
                                    @else
                                        {{ $reason }}
                                    @endif
                                </p>
                            </div>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                                <strong>Dampak penonaktifan:</strong>
                            </p>
                            <ul style="color: #6B7280; font-size: 14px; line-height: 1.8; padding-left: 20px;">
                                <li>Produk Anda tidak akan ditampilkan kepada pengunjung</li>
                                <li>Anda tidak dapat menambah atau mengedit produk</li>
                                <li>Toko Anda tidak akan muncul di pencarian</li>
                            </ul>
                            
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 20px 0;">
                                <strong>Ingin mengaktifkan kembali akun Anda?</strong>
                            </p>
                            <p style="color: #6B7280; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                                Silakan login dan ajukan permintaan reaktivasi melalui halaman khusus. 
                                Tim admin kami akan meninjau permintaan Anda.
                            </p>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/login') }}" 
                                   style="display: inline-block; background-color: #4F46E5; color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 8px; font-weight: bold; font-size: 16px;">
                                    Login & Ajukan Reaktivasi
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F3F4F6; padding: 20px 40px; text-align: center;">
                            <p style="color: #6B7280; font-size: 12px; margin: 0;">
                                © {{ date('Y') }} CAMPUSMARKET. All rights reserved.
                            </p>
                            <p style="color: #9CA3AF; font-size: 11px; margin: 10px 0 0 0;">
                                Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
