# Sistem Pengambilan Keputusan Biji Kopi - Metode SAW

Sistem ini menggunakan metode **SAW (Simple Additive Weighting)** untuk membantu pengambilan keputusan dalam memilih biji kopi terbaik berdasarkan kriteria yang telah ditentukan dengan **subkriteria dinamis**.

## Fitur Utama

✅ **Manajemen Kriteria Dinamis** - Tambah/hapus kriteria sesuai kebutuhan  
✅ **Sub Kriteria Dinamis** - Setiap kriteria bisa memiliki sub kriteria yang berbeda  
✅ **Manajemen Alternatif** - Kelola data biji kopi yang akan dinilai  
✅ **Penilaian Fleksibel** - Nilai setiap alternatif berdasarkan sub kriteria  
✅ **Perhitungan SAW Otomatis** - Normalisasi dan ranking otomatis  
✅ **Visualisasi Hasil** - Tampilan ranking dengan detail perhitungan  

## Teknologi

- Laravel 10+
- PHP 8.1+
- MySQL/MariaDB
- Tailwind CSS

## Cara Penggunaan

### 1. Kelola Kriteria dan Sub Kriteria

1. Buka menu **Kriteria**
2. Tambahkan kriteria baru dengan mengisi:
   - **Kode**: Misal C1, C2, dst
   - **Nama**: Nama kriteria (Harga, Aroma, Rasa, dll)
   - **Bobot**: Nilai 0-1 (total semua bobot harus = 1)
   - **Tipe**: 
     - **Benefit** = semakin tinggi semakin baik
     - **Cost** = semakin rendah semakin baik
3. Setelah kriteria dibuat, tambahkan **Sub Kriteria**:
   - Contoh untuk kriteria "Harga":
     - Sangat Murah (nilai: 1)
     - Murah (nilai: 2)
     - Sedang (nilai: 3)
     - Mahal (nilai: 4)
     - Sangat Mahal (nilai: 5)

### 2. Tambah Alternatif Biji Kopi

1. Buka menu **Alternatif**
2. Klik **Tambah Alternatif**
3. Isi nama dan deskripsi biji kopi
4. Simpan

### 3. Lakukan Penilaian

1. Buka menu **Penilaian**
2. Klik **Edit Nilai** pada alternatif yang ingin dinilai
3. Pilih sub kriteria untuk setiap kriteria
4. Simpan penilaian

### 4. Lihat Hasil Perhitungan SAW

1. Buka menu **Hasil SAW**
2. Sistem akan menampilkan:
   - **Ranking** alternatif dari yang terbaik
   - **Nilai Preferensi** untuk setiap alternatif
   - **Detail Perhitungan** (klik tombol "Lihat Detail")

## Penjelasan Metode SAW

### Konsep Dasar

SAW (Simple Additive Weighting) adalah metode penjumlahan terbobot yang mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua kriteria.

### Formula

**Normalisasi untuk Benefit:**
```
rij = Xij / Max(Xij)
```

**Normalisasi untuk Cost:**
```
rij = Min(Xij) / Xij
```

**Nilai Preferensi:**
```
Vi = Σ (wj × rij)
```

Dimana:
- `rij` = nilai rating kinerja ternormalisasi
- `Xij` = nilai atribut alternatif ke-i pada kriteria ke-j
- `wj` = bobot kriteria ke-j
- `Vi` = nilai preferensi untuk alternatif ke-i

### Langkah Perhitungan

1. **Membuat Matriks Keputusan**
   - Buat tabel alternatif vs kriteria
   - Isi dengan nilai sub kriteria yang dipilih

2. **Normalisasi Matriks**
   - Untuk kriteria **benefit**: bagi nilai dengan nilai maksimum
   - Untuk kriteria **cost**: bagi nilai minimum dengan nilai tersebut

3. **Hitung Nilai Preferensi**
   - Kalikan setiap nilai normalisasi dengan bobot kriteria
   - Jumlahkan semua hasil perkalian
   - Alternatif dengan nilai preferensi tertinggi adalah yang terbaik

## Contoh Kriteria Biji Kopi

### Kriteria yang Umum Digunakan:

| Kode | Kriteria | Bobot | Tipe | Sub Kriteria |
|------|----------|-------|------|--------------|
| C1 | Harga | 0.25 | Cost | Sangat Murah (1), Murah (2), Sedang (3), Mahal (4), Sangat Mahal (5) |
| C2 | Aroma | 0.20 | Benefit | Sangat Lemah (1), Lemah (2), Sedang (3), Kuat (4), Sangat Kuat (5) |
| C3 | Rasa | 0.30 | Benefit | Sangat Pahit (1), Pahit (2), Seimbang (3), Manis (4), Sangat Manis (5) |
| C4 | Keasaman | 0.15 | Benefit | Sangat Rendah (1), Rendah (2), Sedang (3), Tinggi (4), Sangat Tinggi (5) |
| C5 | Body | 0.10 | Benefit | Sangat Ringan (1), Ringan (2), Medium (3), Tebal (4), Sangat Tebal (5) |

**Catatan:** Bobot dapat disesuaikan sesuai preferensi, tetapi total harus = 1.

## Kelebihan Sistem Ini

✅ **Subkriteria Dinamis** - Tidak terbatas pada nilai tertentu  
✅ **Fleksibel** - Bisa menambah/mengurangi kriteria kapan saja  
✅ **Transparan** - Detail perhitungan dapat dilihat  
✅ **User Friendly** - Interface yang mudah digunakan  
✅ **Objektif** - Menggunakan metode matematis yang terukur  

## Troubleshooting

### Error "Class not found"
```bash
composer dump-autoload
```

### Migration Error
```bash
php artisan migrate:fresh
# atau
php artisan migrate:reset
php artisan migrate
```

### Hasil SAW Tidak Muncul
Pastikan:
1. Ada minimal 1 kriteria dengan sub kriteria
2. Ada minimal 1 alternatif
3. Semua alternatif sudah dinilai untuk semua kriteria
4. Total bobot kriteria = 1

### Error 500
Check log error:
```bash
tail -f storage/logs/laravel.log
```

## Tips Penggunaan

1. **Tentukan Kriteria yang Relevan**
   - Pilih kriteria yang benar-benar mempengaruhi keputusan
   - Jangan terlalu banyak kriteria (5-7 kriteria ideal)

2. **Tentukan Bobot dengan Bijak**
   - Kriteria paling penting diberi bobot lebih besar
   - Total bobot harus = 1
   - Contoh: Rasa (0.30), Harga (0.25), Aroma (0.20), dll

3. **Konsisten dalam Penilaian**
   - Gunakan standar yang sama untuk semua alternatif
   - Nilai berdasarkan fakta, bukan asumsi

4. **Review Hasil**
   - Lihat detail perhitungan untuk memahami kenapa suatu alternatif menang
   - Adjust bobot jika hasil tidak sesuai ekspektasi

## Pengembangan Lebih Lanjut

Sistem ini dapat dikembangkan dengan:

- 🔐 Sistem Login & Autentikasi
- 📊 Export hasil ke PDF/Excel
- 📈 Grafik visualisasi hasil
- 🔄 Perbandingan metode (AHP, TOPSIS, ELECTRE)
- 📱 Responsive design mobile
- 🌐 Multi-user dengan role management
- 📝 History perhitungan
- ⚙️ Konfigurasi bobot otomatis

## Lisensi

Open source - silakan digunakan untuk pembelajaran dan pengembangan.

## Kontak & Support

Jika ada pertanyaan atau kendala, silakan buat issue atau hubungi developer.

---

**Happy Coding! ☕** Instalasi

### 1. Clone/Download Project

```bash
# Jika dari git
git clone [repository-url]
cd coffee-decision-saw

# Atau extract file ZIP
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env sesuaikan database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_saw
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database

```sql
CREATE DATABASE coffee_saw;
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. (Opsional) Jalankan Seeder untuk Data Sample

```bash
php artisan db:seed --class=CoffeeDecisionSeeder
```

### 7. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Struktur File

```
app/
├── Http/Controllers/
│   ├── CriteriaController.php
│   ├── SubCriteriaController.php
│   ├── CoffeeAlternativeController.php
│   ├── EvaluationController.php
│   └── SAWController.php
├── Models/
│   ├── Criteria.php
│   ├── SubCriteria.php
│   ├── CoffeeAlternative.php
│   └── Evaluation.php
└── Services/
    └── SAWService.php

database/
├── migrations/
│   └── xxxx_create_coffee_decision_tables.php
└── seeders/
    └── CoffeeDecisionSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
├── criteria/
│   └── index.blade.php
├── coffee/
│   ├── index.blade.php
│   └── create.blade.php
├── evaluation/
│   ├── index.blade.php
│   └── edit.blade.php
└── saw/
    └── result.blade.php

routes/
└── web.php
```

