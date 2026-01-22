# Web-Kelurahan (Laravel + Inertia + Vue) - Installation Instructions

This project resides in `c:\laragon\www\web-kelurahan`.

## Getting Started

To run the application, open your terminal (PowerShell or Git Bash) and navigate to the project folder:

```bash
cd c:\laragon\www\web-kelurahan
```

### 1. Database Setup
Ensure the database file exists and run migrations:

```bash
# If database.sqlite is missing (it should be there already)
# New-Item -ItemType File database/database.sqlite

php artisan migrate
```

### 2. Run the Development Server
You need to run two commands (in separate terminal tabs/windows):

**Terminal 1 (Vite/Frontend):**
```bash
npm run dev
```

**Terminal 2 (Laravel/Backend):**
```bash
php artisan serve
```

### 3. Access the App
Open your browser and visit:
[http://127.0.0.1:8000](http://127.0.0.1:8000) (or whichever port `php artisan serve` indicates).
