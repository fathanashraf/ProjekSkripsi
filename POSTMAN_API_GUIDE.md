# HIMANIKKA Payment API - Postman Guide

## 📥 Import Collection

1. Buka Postman
2. Klik **Import** (kiri atas)
3. Drag file `HIMANIKKA_Payment_API.postman_collection.json`
4. Collection akan muncul di sidebar

## ⚙️ Setup Environment

Buat environment baru di Postman dengan variable:

| Variable | Value |
|----------|-------|
| `BASE_URL` | `http://127.0.0.1:8000` |
| `TOKEN` | *(otomatis terisi setelah login)* |
| `PENDAFTARAN_ID` | `1` (sesuaikan dengan data di DB) |

## 🔑 Login & Auth

### Sanctum Token (untuk auth API)
```bash
# 1. Login via web untuk dapat session cookie
POST http://127.0.0.1:8000/login
Body: { "email": "admin@himanikka.com", "password": "password" }

# 2. Ambil Sanctum token (opsional, jika pakai sanctum)
POST http://127.0.0.1:8000/sanctum/csrf-cookie

# 3. Login via API untuk dapat token
POST http://127.0.0.1:8000/api/login
Body: { "email": "admin@himanikka.com", "password": "password" }
Response: { "token": "1|abc123...", "user": {...} }
```

> **Note:** Jika API belum pakai Sanctum, gunakan session cookie dari login web.

## 📋 Requests dalam Collection

### 🧪 Test API
- **Method:** GET
- **URL:** `/api/test`
- **Auth:** Tidak perlu
- **Fungsi:** Cek apakah API hidup

### 🔐 Login (Ambil Token)
- **Method:** POST
- **URL:** `/api/login`
- **Auth:** Tidak perlu
- **Body:** `{ "email": "...", "password": "..." }`
- **Auto:** Token otomatis disimpan ke variable `TOKEN`

### 💳 Snap Token
- **Method:** POST
- **URL:** `/api/payment/snap-token`
- **Auth:** Bearer Token
- **Body:** `{ "pendaftaran_id": 1 }`
- **Response:**
  ```json
  {
    "snap_token": "abc-123-def-456",
    "client_key": "SB-Mid-client-xxx",
    "order_id": "PEM-1-1234567890",
    "gross_amount": 50000
  }
  ```

### 💳 Store Payment (Transfer)
- **Method:** POST
- **URL:** `/api/payment/store`
- **Auth:** Bearer Token
- **Body:** Form Data
  - `pendaftaran_id`: `1`
  - `jenis`: `kredit`
  - `bukti_pembayaran`: *(file upload)*

### 💳 Store Payment (Cash)
- **Method:** POST
- **URL:** `/api/payment/store`
- **Auth:** Bearer Token
- **Body:** JSON
  ```json
  {
    "pendaftaran_id": 1,
    "jenis": "cash"
  }
  ```

### 🔍 Check Status
- **Method:** GET
- **URL:** `/api/payment/status/{pendaftaran_id}`
- **Auth:** Bearer Token
- **Response:**
  ```json
  {
    "pendaftaran_id": 1,
    "status_pendaftaran": "diajukan",
    "pembayaran": {
      "id": 1,
      "jenis": "kredit",
      "status": "dibayar",
      "bukti_pembayaran": "bukti_pembayaran/abc.jpg",
      "created_at": "2026-08-21T10:00:00.000000Z"
    },
    "biaya": {
      "nominal": 50000,
      "formatted": "Rp 50.000"
    }
  }
  ```

### 🔔 Midtrans Webhook (Simulasi)
- **Method:** POST
- **URL:** `/api/payment/midtrans-notification`
- **Auth:** Basic Auth (Midtrans server key)
- **Body:** JSON (format notifikasi Midtrans)
- **Fungsi:** Simulasi notifikasi dari Midtrans

## 🔄 Flow Testing

```
1. 🧪 Test API          → Cek API hidup
2. 🔐 Login             → Ambil token
3. 💳 Snap Token        → Generate token Midtrans
4. 💳 Store Payment     → Simpan pembayaran manual
5. 🔍 Check Status      → Cek status pembayaran
6. 🔔 Midtrans Webhook  → Simulasi notifikasi
```

## ⚠️ Error Handling

| Status | Arti |
|--------|------|
| 200 | Success |
| 401 | Unauthorized (belum login / token invalid) |
| 404 | Pendaftaran tidak ditemukan |
| 422 | Validation error (data tidak valid) |
| 500 | Server error |

## 📝 Notes

- **Midtrans Webhook** tidak dilindungi CSRF (karena dikirim dari server Midtrans)
- **Snap Token** hanya bisa digenerate jika acara punya biaya
- **Transfer** wajib upload bukti pembayaran
- **Cash** tidak perlu bukti pembayaran
- **Pembayaran duplikat** akan ditolak (sudah lunas)
