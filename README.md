# VILA Lab Website

This repository contains the **VILA Lab Official Website**, developed using a **frontend–backend separated architecture**.
The system supports **role-based access control** (Admin, Member, Guest) and is designed for **local development, Docker deployment, and production hosting**.

---

## Tech Stack

### Frontend

* Vue 3
* Vite
* Vue Router
* Pinia
* Vuetify
* Axios

### Backend

* Laravel
* MySQL
* REST API

### Infrastructure

* Docker
* Docker Compose
* Nginx
* PHP 8.2

---

## Project Structure

```bash
VILA-LAB-WEBSITE/
├── VILA-FRONTEND/      # Vue + Vite frontend
├── VILA-BACKEND/       # Laravel backend
├── docker-compose.yml
├── README.md
```

---

## Prerequisites

Ensure the following are installed:

* Git
* Docker
* Docker Compose
* Node.js (v18+ recommended)
* npm or yarn

---

## Local Development Setup (Docker)

### 1️⃣ Clone the repository

```bash
git clone https://github.com/venchiheng/VILA-LAB-WEBSITE.git
cd VILA-LAB-WEBSITE
```

---

### 2️⃣ Backend environment file

```bash
cd VILA-BACKEND
cp .env.example .env
```

> You may update database credentials later if needed.

---

### 3️⃣ Frontend environment file

```bash
cd ../VILA-FRONTEND
cp .env.example .env
```

Set API base URL:

```env
VITE_API_BASE_URL=http://localhost:8000/api
```

---

### 4️⃣ Start Docker containers

From the **project root**:

```bash
docker compose up -d --build
```

---

### 5️⃣ Verify containers are running (IMPORTANT)

```bash
docker ps
```

You should see containers similar to:

```text
vila_lab_app
vila_lab_db
vila_lab_nginx
```

> If containers are not running, **do not continue**.

---

## Backend Initialization (Required)

### 6️⃣ Enter the Laravel container

```bash
docker exec -it vila_lab_app bash
```

---

### 7️⃣ Navigate to Laravel root directory

If you are currently inside **/var/www/html**, means you can skip to step 8.

If not, please run the command below to proceed to next step.

```bash
cd /var/www/html
```

> ⚠️ You must be in /var/www/html directory before runing php artisan.
> Running `php artisan` outside this directory will cause errors.

---

### 8️⃣ Install backend dependencies

```bash
composer install
```

---

### 9️⃣ Generate application key

```bash
php artisan key:generate
```

---

### 🔟 Run database migrations & seeders

```bash
php artisan migrate --seed
```

---

### 1️⃣1️⃣ Exit container

```bash
exit
```

---

## Access the Application

* **Frontend**
  👉 [http://localhost:5173](http://localhost:5173)

* **Backend API**
  👉 [http://localhost:8000/api](http://localhost:8000/api)

---

## Authentication & User Roles

The system implements **role-based authentication**:

* **Admin** – system management and approvals
* **Member** – booking and equipment access
* **Guest** – public access only

---

## Creating an Admin Account (Required)

Admin accounts **cannot be created via UI** and must be created manually.

### Steps

```bash
docker exec -it vila_lab_app bash
cd /var/www/html
php artisan tinker
```

Inside Tinker:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin',
    'email' => 'admin@vila-lab.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin',
]);
```

Exit:

```bash
exit
```

### Admin Login

* Log in via admin login page
* Use credentials created above
* Admin dashboard will be accessible

> ⚠️ Admin creation via UI is intentionally disabled for security reasons.

---

## Member Application Flow

### Step 1: Application

* User submits a member application
* Status is set to `pending`

### Step 2: Admin Approval

* Admin reviews applications
* Approves or rejects from admin panel

### Step 3: Member Account

Once approved:

* Member account is created automatically by the system
* Password is Member ID

Example:

```text
Member ID: V20260001
Password: V20260001
```

> Members should change their password after first login.

---

## Deployment Guide (Production)

### Option 1: VPS Deployment (Recommended)

Supports:

* AWS EC2
* DigitalOcean
* Linode

Steps:

1. Clone repository on server
2. Configure `.env` files
3. Update frontend API URL:

   ```env
   VITE_API_BASE_URL=https://your-domain.com/api
   ```
4. Build frontend:

   ```bash
   npm run build
   ```
5. Configure Nginx reverse proxy
6. Enable HTTPS (Let’s Encrypt)
7. Start containers:

   ```bash
   docker compose up -d --build
   ```

---

### Option 2: Separate Deployment

#### Frontend

* Vercel
* Netlify
* Static Nginx hosting

#### Backend

* VPS
* Docker-based environment

Ensure:

* Correct CORS configuration
* Correct API base URL
* HTTPS enabled

---

## Common Errors & Fixes

### ❌ `Could not open input file: artisan`

**Cause:** Not inside Laravel root directory
**Fix:**

```bash
cd /var/www/html
```

---

### ❌ Database connection error

**Fix:**

* Check `.env` database credentials
* Ensure database container is running

---

## Security Notes

* `.env` files are excluded from Git
* Frontend `VITE_*` variables are public by design
* Backend secrets remain server-side
* Authorization enforced on backend
* Admin approval required for members

---

## Maintenance

* Run migrations after schema changes
* Rebuild containers after dependency updates
* View logs:

```bash
docker logs vila_lab_app
```

---

## License

This project is intended for academic and organizational use.

---

Just tell me 💪
