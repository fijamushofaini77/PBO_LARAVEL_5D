# Red Menstruasi — Admin Dashboard

> **PBO Laravel** — Aplikasi pencatatan & monitoring siklus menstruasi dengan dashboard admin interaktif berbasis pink design system.

| | |
|---|---|
| **Mahasiswa** | Fija Mushofaini |
| **NPM** | 2410010375 |
| **Kelas** | TI 5D REG BJB |
| **Phase** | P01: CRUD Dashboard Admin + Tabel Periode |
| **Status** | ✅ Done (2026-11-01) |
| **Fork / branch** | [fijamushofaini77/PBO_LARAVEL_5D](https://github.com/fijamushofaini77/PBO_LARAVEL_5D) · [`feature/red-menstruasi`](https://github.com/fijamushofaini77/PBO_LARAVEL_5D/tree/feature/red-menstruasi) |

---

## Tentang Aplikasi

**Red Menstruasi** adalah aplikasi admin berbasis Laravel untuk mengelola data siklus menstruasi. Dibangun dengan:

- **Backend:** Laravel 11, Eloquent ORM, MySQL (`pbo_laravel_5d`)
- **Frontend:** Tailwind CSS v4, Alpine.js v3, shadcn/ui pattern (dashboard-01 + sidebar-07)
- **Design:** Pink/rose theme — Stop Slop AI (no generic purple/blue gradients)
- **Font:** Plus Jakarta Sans 400/500

---

## Pekerjaan yang Dilakukan

| Job | Deskripsi | Status |
|-----|-----------|--------|
| J1 | Database design + migration tabel `periode` | ✅ Done |
| J2 | Model `Periode` + Factory + Seeder (4 data) | ✅ Done |
| J3 | `PeriodeController` — CRUD lengkap (index, create, store, edit, update, destroy) | ✅ Done |
| J4 | Layout shadcn sidebar-07: collapsible desktop (Ctrl+B), mobile drawer, command palette (Ctrl+K) | ✅ Done |
| J5 | Dashboard interaktif: stat cards, cycle explorer 28 hari, quick logger (mood + flow + symptom) | ✅ Done |
| J6 | CRUD views: `periode/`, `cycles/`, `symptoms/`, `medications/`, `reminders/` | ✅ Done |
| J7 | Feature tests: 28 passed, 80 assertions | ✅ Done |

---

## Cara Menjalankan

```bash
# 1. Install dependencies
composer install
npm install

# 2. Konfigurasi environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan koneksi MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pbo_laravel_5d
DB_USERNAME=root
DB_PASSWORD=rahasia123
```

```bash
# 3. Migrate & seed database
php artisan migrate:fresh --seed

# 4. Build frontend assets
npm run build

# 5. Jalankan server
php artisan serve
```

Buka `http://localhost:8000` — dashboard langsung tampil dengan data seeder.

---

## Struktur Utama

```
app/
├── Http/Controllers/
│   ├── PeriodeController.php     # CRUD utama modul 5
│   ├── DashboardController.php   # Dashboard metrics
│   ├── CycleController.php
│   ├── SymptomController.php
│   ├── MedicationController.php
│   └── ReminderController.php
├── Models/
│   ├── Periode.php               # Model tabel periode
│   └── Cycle.php, Symptom.php, Medication.php, Reminder.php, User.php
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php                  # Layout utama + Alpine.js
│   │   └── components/
│   │       ├── sidebar.blade.php          # Shadcn sidebar-07
│   │       └── header.blade.php          # Header + notifications
│   ├── dashboard.blade.php                # Dashboard interaktif
│   ├── periode/                           # CRUD periode (index, create, edit)
│   ├── cycles/, symptoms/, medications/, reminders/
└── css/app.css                            # Pink design tokens
database/
├── migrations/                            # Semua migration termasuk periode
├── seeders/DatabaseSeeder.php             # Rich seeder dengan data Fija
└── factories/PeriodeFactory.php
docs/
├── design/                                # Design tokens & variables
└── progress/P01-red-menstruasi.md         # Progress report
tests/Feature/
└── PeriodeCrudTest.php                    # 12 tests CRUD periode
```

---

## Hasil Test

```
php artisan test --compact

Tests:      28 passed
Assertions: 80 passed
Duration:   ~236ms
```

---

## Design System (Stop Slop AI)

| Token | Value |
|-------|-------|
| Primary | `#f43f5e` (rose-500) |
| Canvas | `#fdfafb` (off-white) |
| Ink | `#14140f` (near-black) |
| Border | `#fed7dc` (rose-100) |
| Card radius | `28px` |
| Button | pill `9999px` |
| Font weight | 400 / 500 only |

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
