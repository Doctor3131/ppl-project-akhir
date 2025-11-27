# Test Credentials - E-Commerce Multi Vendor

## 🔑 Akun untuk Testing

### Admin Account
```
Email: admin@example.com
Password: password
```

**Akses:**
- Dashboard admin dengan statistik
- Manage categories (CRUD)
- Approve/reject seller registrations
- View all sellers

---

### Approved Sellers (Sudah bisa login dan manage products)

#### 1. John's Electronics
```
Email: john@electronics.com
Password: password
```
**Products:** 4 produk di kategori Electronics & Books

#### 2. Sarah's Fashion
```
Email: sarah@fashion.com
Password: password
```
**Products:** 4 produk di kategori Fashion

---

### Pending Seller (Belum bisa login - butuh approval admin)

#### 3. Mike's Books
```
Email: mike@books.com
Password: password
Status: Pending
```
**Note:** Tidak bisa login sampai di-approve oleh admin

---

## 🧪 Test Scenarios

### Scenario 1: Test Admin Features
1. Login dengan: `admin@example.com` / `password`
2. View dashboard - lihat statistik
3. Go to "Manage Categories"
4. Try add new category
5. Go to "Manage Sellers"
6. Filter by "Pending" status
7. Approve seller "Mike's Books"
8. Logout

### Scenario 2: Test Approved Seller
1. Login dengan: `john@electronics.com` / `password`
2. View dashboard - lihat list products
3. Click "Add New Product"
4. Fill form dan upload image (optional)
5. Submit product
6. Edit product yang baru dibuat
7. Delete product
8. Logout

### Scenario 3: Test Pending Seller
1. Try login dengan: `mike@books.com` / `password`
2. Should get error: "Your account is pending approval"
3. Login as admin
4. Approve Mike's Books
5. Logout from admin
6. Login as Mike - should work now
7. Add products

### Scenario 4: Test New Seller Registration
1. Click "Register as Seller"
2. Fill form:
   ```
   Name: Test Seller
   Email: test@seller.com
   Password: password
   Confirm Password: password
   ```
3. Submit - akan redirect ke login dengan success message
4. Try login - should fail (pending)
5. Login as admin
6. Approve "Test Seller"
7. Logout and login as test@seller.com

### Scenario 5: Test Public Access (No Login)
1. Visit homepage (/)
2. Browse products (should see 8 products)
3. Use search: "headphones"
4. Use filter: "Electronics"
5. Click any product to view detail
6. See seller information on detail page
7. Navigate back to catalog

---

## 📊 Database Quick Check

Setelah seeding, database harus memiliki:

```
Users: 4
- 1 Admin (admin@example.com)
- 2 Approved Sellers (john, sarah)
- 1 Pending Seller (mike)

Categories: 8
- Electronics
- Fashion
- Home & Living
- Books
- Sports & Outdoors
- Beauty & Health
- Toys & Games
- Food & Beverages

Products: 8
- 4 dari John's Electronics
- 4 dari Sarah's Fashion
```

Cek dengan:
```bash
php artisan tinker --execute="echo 'Users: ' . \App\Models\User::count() . PHP_EOL . 'Categories: ' . \App\Models\Category::count() . PHP_EOL . 'Products: ' . \App\Models\Product::count();"
```

---

## 🔄 Reset Test Data

Jika ingin reset dan mulai dari awal:

```bash
# Reset database dan load semua seeder
php artisan migrate:fresh --seed

# Load test data (sellers & products)
php artisan db:seed --class=TestDataSeeder
```

---

## ⚠️ Important Notes

1. **Password sama untuk semua:** `password`
2. **Admin email verified:** Sudah otomatis verified
3. **Pending sellers:** Tidak bisa login sampai approved
4. **Image upload:** Optional saat add product
5. **Storage link:** Pastikan sudah run `php artisan storage:link`

---

## 🎯 Quick Links

- Homepage: `http://localhost:8000/`
- Login: `http://localhost:8000/login`
- Register: `http://localhost:8000/register`
- Admin Dashboard: `http://localhost:8000/admin/dashboard`
- Seller Dashboard: `http://localhost:8000/seller/dashboard`

---

## 🐛 Common Issues

### "Your account is pending approval"
- Normal untuk seller baru
- Login as admin dan approve dulu

### "Unauthorized access" (403)
- Coba akses route yang tidak sesuai role
- Seller coba akses `/admin/*` atau sebaliknya

### Image tidak muncul
```bash
php artisan storage:link
chmod -R 775 storage
```

### Cannot login after approval
```bash
php artisan cache:clear
php artisan config:clear
```
