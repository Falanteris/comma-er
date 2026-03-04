# 📖 LogBook — Laravel + SQLite App

A clean, simple logbook application built with **Laravel 10** and **SQLite3**. Track events, incidents, maintenance tasks, and observations with severity levels and category filtering.

---

## ✨ Features

- **CRUD** — Create, view, edit, and delete log entries
- **Severity levels** — Info, Warning, Error, Critical (color-coded)
- **Categories** — General, Maintenance, Incident, Observation, Task, Other
- **Search & Filters** — Filter by keyword, category, and severity
- **Stats Dashboard** — Total entries, today's count, errors, and critical count
- **Pagination** — 15 entries per page
- **SQLite3 database** — Zero configuration required

---

## 🚀 Setup Instructions

### 1. Install Dependencies

```bash
composer install
```

### 2. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and update `DB_DATABASE` to the **absolute path** of your SQLite file:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/logbook/database/database.sqlite
```

### 3. Create the SQLite Database File

```bash
touch database/database.sqlite
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. (Optional) Seed with Sample Data

```bash
php artisan db:seed
```

### 6. Start the Development Server

```bash
php artisan serve
```

Visit **http://localhost:8000** in your browser.

---

## 📂 Project Structure

```
logbook/
├── app/
│   ├── Http/Controllers/
│   │   └── LogEntryController.php   # All CRUD logic
│   └── Models/
│       └── LogEntry.php             # LogEntry model
├── database/
│   ├── migrations/                  # SQLite schema
│   ├── seeders/                     # Sample data
│   └── database.sqlite              # Created by you
├── resources/views/
│   ├── layouts/app.blade.php        # Main layout
│   └── entries/                     # All entry views
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       ├── show.blade.php
│       └── _form.blade.php
└── routes/web.php                   # App routes
```

---

## 🗃 Database Schema

**Table: `log_entries`**

| Column       | Type      | Notes                                      |
|--------------|-----------|--------------------------------------------|
| id           | INTEGER   | Auto-increment primary key                 |
| title        | VARCHAR   | Short summary of the entry                 |
| category     | VARCHAR   | e.g. General, Incident, Maintenance        |
| description  | TEXT      | Detailed notes (nullable)                  |
| severity     | ENUM      | info, warning, error, critical             |
| logged_at    | DATETIME  | When the event actually occurred           |
| created_at   | DATETIME  | Record creation timestamp                  |
| updated_at   | DATETIME  | Record update timestamp                    |

---

## 🛠 Requirements

- PHP 8.1+
- Composer
- SQLite3 extension enabled (`php -m | grep sqlite`)
- Laravel 10
