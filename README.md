# 3103_AmikomEvent
Tugas DIgital Bisnis

## Google SSO Checkout

Fitur login instan dengan Google dipakai untuk checkout tiket. Setelah pengguna login lewat tombol `Continue with Google`, nama dan email akan otomatis terisi di halaman checkout.

### Konfigurasi yang dibutuhkan

- Tambahkan `GOOGLE_CLIENT_ID`
- Tambahkan `GOOGLE_CLIENT_SECRET`
- Set `GOOGLE_REDIRECT_URI` ke `http://localhost/auth/google/callback` atau URL aplikasi yang dipakai

### Contoh `.env`

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
```

### Redirect URI Google Cloud

Daftarkan callback ini di Google Cloud Console:

- `http://localhost/auth/google/callback`

### Langkah Google Cloud Console

1. Buka Google Cloud Console.
2. Buat project baru atau pilih project yang sudah ada.
3. Aktifkan Google People API jika diminta oleh OAuth screen.
4. Konfigurasi OAuth consent screen untuk aplikasi web.
5. Buat OAuth Client ID dengan tipe Web application.
6. Tambahkan Authorized JavaScript origins: `http://localhost`.
7. Tambahkan Authorized redirect URI: `http://localhost/auth/google/callback`.
8. Salin Client ID dan Client Secret ke `.env`.

### Alur penggunaan

1. Buka halaman checkout event.
2. Klik `Continue with Google`.
3. Setelah berhasil login, kembali ke checkout.
4. Nama dan email pengguna akan terisi otomatis, lalu tinggal isi nomor WhatsApp untuk lanjut pembayaran.
