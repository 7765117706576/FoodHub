<p align="center">
  <b>Sistem Pemesanan Makanan & Minuman</b><br>
  <i>(Food Ordering System)</i><br><br>
  <img src="images/logoFoodHub.png" width="150"><br><br>
  <b>MUHAMMAD NAUFAL. N</b><br>
  <b>D0223325</b><br><br>
  Framework Web Based<br>
  2025
</p>

---

## Role dan Fitur-fiturnya

| Role     | Fitur                                                                                                                                   |
|----------|-----------------------------------------------------------------------------------------------------------------------------------------|
| Admin    | - Mengelola seluruh data pengguna (penjual & pelanggan) <br> - Melihat dan menghapus produk <br> - Melihat semua transaksi             |
| Penjual  | - Menambahkan, mengedit, dan menghapus produk <br> - Melihat pesanan terhadap produk miliknya <br> - Mengubah status pesanan           |
| Customer | - Melihat dan mencari produk <br> - Menambahkan produk ke keranjang dan melakukan pemesanan <br> - Melihat riwayat pesanan mereka      |

---

## Struktur Tabel Database

### Tabel 1: `users`

| Nama Field | Tipe Data    | Keterangan                                 |
|------------|--------------|--------------------------------------------|
| id         | BIGINT       | Primary key, auto increment                |
| name       | VARCHAR(255) | Nama lengkap pengguna                      |
| email      | VARCHAR(255) | Email unik untuk login                     |
| password   | VARCHAR(255) | Password terenkripsi                       |
| role       | ENUM         | Role pengguna: admin, seller, customer     |
| created_at | TIMESTAMP    | Waktu dibuat                               |
| updated_at | TIMESTAMP    | Waktu diperbarui                           |

---

### Tabel 2: `sellers`

| Nama Field | Tipe Data    | Keterangan                                   |
|------------|--------------|----------------------------------------------|
| id         | BIGINT       | Primary key                                  |
| user_id    | BIGINT       | Relasi ke `users`, hanya jika role = seller |
| store_name | VARCHAR(255) | Nama toko                                    |
| address    | VARCHAR(255) | Alamat toko                                  |
| created_at | TIMESTAMP    | Waktu dibuat                                 |
| updated_at | TIMESTAMP    | Waktu diperbarui                             |

---

### Tabel 3: `customers`

| Nama Field    | Tipe Data    | Keterangan                                  |
|---------------|--------------|---------------------------------------------|
| id            | BIGINT       | Primary key                                 |
| user_id       | BIGINT       | Relasi ke `users`, hanya jika role = customer |
| phone_number  | VARCHAR(50)  | Nomor HP                                    |
| address       | VARCHAR(255) | Alamat pelanggan                            |
| created_at    | TIMESTAMP    | Waktu dibuat                                |
| updated_at    | TIMESTAMP    | Waktu diperbarui                            |

---

### Tabel 4: `products`

| Nama Field  | Tipe Data    | Keterangan                               |
|-------------|--------------|------------------------------------------|
| id          | BIGINT       | Primary key                              |
| seller_id   | BIGINT       | Relasi ke `sellers`                      |
| name        | VARCHAR(255) | Nama produk                              |
| description | TEXT         | Deskripsi produk                         |
| price       | DECIMAL      | Harga produk                             |
| image       | VARCHAR(255) | Gambar produk (opsional)                 |
| created_at  | TIMESTAMP    | Waktu dibuat                             |
| updated_at  | TIMESTAMP    | Waktu diperbarui                         |

---

### Tabel 5: `orders`

| Nama Field   | Tipe Data    | Keterangan                                |
|--------------|--------------|-------------------------------------------|
| id           | BIGINT       | Primary key                               |
| customer_id  | BIGINT       | Relasi ke `customers`                     |
| total_price  | DECIMAL      | Total harga pemesanan                     |
| status       | ENUM         | Status: pending, processing, completed, cancelled |
| created_at   | TIMESTAMP    | Waktu dibuat                              |
| updated_at   | TIMESTAMP    | Waktu diperbarui                          |

---

### Tabel 6: `order_items`

| Nama Field | Tipe Data    | Keterangan                               |
|------------|--------------|------------------------------------------|
| id         | BIGINT       | Primary key                              |
| order_id   | BIGINT       | Relasi ke `orders`                       |
| product_id | BIGINT       | Relasi ke `products`                     |
| quantity   | INTEGER      | Jumlah produk yang dipesan               |
| price      | DECIMAL      | Harga satuan saat dipesan                |
| created_at | TIMESTAMP    | Waktu dibuat                             |
| updated_at | TIMESTAMP    | Waktu diperbarui                         |

---

## Relasi Antar Tabel

- **`users`** memiliki relasi *one-to-one* ke `sellers` dan `customers` berdasarkan role.
  - Foreign key: `user_id` di `sellers` dan `customers` → `users.id`
  - Penjelasan: 1 user bisa menjadi 1 penjual atau 1 customer, tergantung role-nya.

- **`sellers`** memiliki relasi *one-to-many* ke `products`.
  - Foreign key: `seller_id` di `products` → `sellers.id`

- **`customers`** memiliki relasi *one-to-many* ke `orders`.
  - Foreign key: `customer_id` di `orders` → `customers.id`

- **`orders`** memiliki relasi *one-to-many* ke `order_items`.
  - Foreign key: `order_id` di `order_items` → `orders.id`

- **`products`** memiliki relasi *one-to-many* ke `order_items`.
  - Foreign key: `product_id` di `order_items` → `products.id`
