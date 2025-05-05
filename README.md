<p align="center">
  <b>Sistem Pemesanan Makanan & Minuman</b><br>
  <i>(Food Ordering System - Metode COD)</i><br><br>
  <img src="images/logoFoodHub.png" width="150"><br><br>
  <b>Muhammad Naufal. N</b><br>
  <b>D0223325</b><br><br>
  Framework Web Based<br>
  2025
</p>

---

## Role dan Fitur-fiturnya

| Role     | Fitur                                                                                                                                   |
|----------|-----------------------------------------------------------------------------------------------------------------------------------------|
| Admin    | - Mengelola seluruh data pengguna (penjual & pelanggan) <br> - Melihat dan menghapus produk <br> - Melihat semua transaksi             |
| Penjual  | - Menambahkan, mengedit, dan menghapus produk <br> - Melihat pesanan terhadap produk miliknya <br> - Menetapkan kurir <br> - Mengubah status pesanan |
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

| Nama Field   | Tipe Data     | Keterangan                                                   |
|--------------|---------------|--------------------------------------------------------------|
| id           | BIGINT        | Primary key                                                  |
| customer_id  | BIGINT        | Relasi ke `customers`                                       |
| total_price  | DECIMAL       | Total harga pesanan                                         |
| status       | ENUM          | `pending`, `confirmed`, `on_delivery`, `completed`, `cancelled` |
| is_paid      | BOOLEAN       | Status pembayaran: `false` saat pesan, `true` saat dibayar  |
| courier_id   | BIGINT        | (Opsional) Relasi ke `couriers`                             |
| created_at   | TIMESTAMP     | Waktu dibuat                                                |
| updated_at   | TIMESTAMP     | Waktu diperbarui                                            |

---

### Tabel 6: `order_items`

| Nama Field | Tipe Data    | Keterangan                               |
|------------|--------------|------------------------------------------|
| id         | BIGINT       | Primary key                              |
| order_id   | BIGINT       | Relasi ke `orders`                       |
| product_id | BIGINT       | Relasi ke `products`                     |
| quantity   | INTEGER      | Jumlah produk                            |
| price      | DECIMAL      | Harga satuan saat dipesan                |
| created_at | TIMESTAMP    | Waktu dibuat                             |
| updated_at | TIMESTAMP    | Waktu diperbarui                         |

---

### Tabel 7: `couriers`

| Nama Field | Tipe Data    | Keterangan                               |
|------------|--------------|------------------------------------------|
| id         | BIGINT       | Primary key                              |
| seller_id  | BIGINT       | Relasi ke `sellers`                      |
| name       | VARCHAR(255) | Nama kurir                               |
| phone      | VARCHAR(20)  | Nomor HP kurir                           |
| created_at | TIMESTAMP    | Waktu dibuat                             |
| updated_at | TIMESTAMP    | Waktu diperbarui                         |

---

## Relasi Antar Tabel

- **`users`** ↔ `sellers` / `customers` (One-to-One)
  - 1 user hanya bisa menjadi 1 penjual atau 1 customer.

- **`sellers`** ↔ `products` (One-to-Many)
  - 1 penjual bisa memiliki banyak produk.

- **`customers`** ↔ `orders` (One-to-Many)
  - 1 customer bisa membuat banyak pesanan.

- **`orders`** ↔ `order_items` (One-to-Many)
  - 1 order bisa terdiri dari banyak item produk.

- **`products`** ↔ `order_items` (One-to-Many)
  - 1 produk bisa dibeli dalam banyak pesanan berbeda.

- **`sellers`** ↔ `couriers` (One-to-Many)
  - 1 penjual bisa memiliki beberapa kurir.

- **`orders`** ↔ `couriers` (Many-to-One, opsional)
  - 1 order bisa dikirim oleh 1 kurir.

---

## Metode Pembayaran

- Sistem hanya menggunakan **COD (Cash on Delivery)**.
- Kurir akan mengantarkan pesanan dan menerima pembayaran langsung dari customer.
- Setelah kurir mengonfirmasi pembayaran, status `is_paid` diubah menjadi `true` dan status order menjadi `completed`.
