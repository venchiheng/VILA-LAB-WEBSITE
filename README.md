Ah! Got it ✅. That changes the instructions slightly because the Docker setup is **inside `VILA-BACKEND`**, not at the root. I can rewrite the README to reflect that properly. Here's the corrected version:

---

# VILA Lab Official Website

This repository contains the **VILA Lab Official Website**, developed with a **frontend–backend separated architecture**.
It supports **role-based access control** (Admin, Member, Guest) and is designed for **local development, Docker deployment, and production hosting**.

---

## 🛠 Tech Stack

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

* Docker & Docker Compose
* Nginx
* PHP 8.2

---

## 📂 Project Structure

```bash
VILA-LAB-WEBSITE/
├── VILA-FRONTEND/      # Vue + Vite frontend
├── VILA-BACKEND/       # Laravel backend + Docker setup
│   └── docker-compose.yml
├── README.md
├── LICENSE
├── .gitignore
└── .gitattributes
```

---

## ⚡ Prerequisites

Ensure the following are installed:

* Git
* Docker & Docker Compose
* Node.js (v18+ recommended)
* npm or yarn

---

## 🏗 Local Development Setup

### 1️⃣ Clone the repository

```bash
git clone https://github.com/venchiheng/VILA-LAB-WEBSITE.git
cd VILA-LAB-WEBSITE
```

### 2️⃣ Backend environment

```bash
cd VILA-BACKEND
cp .env.example .env
# Update database credentials if needed
```

> The `docker-compose.yml` is located here.

### 3️⃣ Frontend environment

```bash
cd ../VILA-FRONTEND
cp .env.example .env
```

Set API base URL:

```env
VITE_API_BASE_URL=http://localhost:8000/api
```

### 4️⃣ Start Docker containers

From **VILA-BACKEND** directory:
Open a terminal in **VILA-BACKEND**:

```bash
docker compose up -d --build
```

### 5️⃣ Verify containers

```bash
docker ps
```

You should see:

```text
vila_lab_app
vila_lab_db
vila_lab_nginx
```

> ⚠️ If containers are not running, **do not continue**.

---

## 🔧 Backend Initialization

### 6️⃣ Enter Laravel container

```bash
docker exec -it vila_lab_app bash
```

### 7️⃣ Navigate to Laravel root

If you are currently inside **/var/www/html**, means you can skip to **step 8**.

If **not**, please run the command below to proceed to next step.

cd /var/www/html

> ⚠️ You must be in **/var/www/html** directory before runing php artisan. Running `php artisan` outside this directory will cause errors.


```bash
cd /var/www/html
```

> Must be in `/var/www/html` before running `php artisan`.

### 8️⃣ Install dependencies

```bash
composer install
```

### 9️⃣ Generate app key

```bash
php artisan key:generate
```

### 🔟 Run migrations & seeders

```bash
php artisan migrate --seed
```

### 1️⃣1️⃣ Exit container

```bash
exit
```

---

## 🌐 Access the Application

* **Frontend:** [http://localhost:5173](http://localhost:5173)
* **Backend API:** [http://localhost:8000/api](http://localhost:8000/api)

---

## 👤 Authentication & Roles

* **Admin** – system management & approvals
* **Member** – booking & equipment access
* **Guest** – public access

---

## 🛡 Creating an Admin Account

Admin accounts must be created manually (UI disabled for security):

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

Exit Tinker:

```bash
exit
```

* Log in via admin page with created credentials.

> ⚠️ Admin creation via UI is disabled intentionally.

---

## 👥 Member Application Flow

1. **Application:** User submits a member application (status: `pending`)
2. **Admin Approval:** Admin approves or rejects application
3. **Member Account:** Once approved, account created automatically

```text
Example:
Member ID: V20260001
Password: V20260001
```

> Members should change password after first login.

---

## 🚀 Deployment Guide (Production)

### Option 1: VPS Deployment (Recommended)

* AWS EC2, DigitalOcean, Linode

1. Clone repository on server
2. Configure `.env` files in `VILA-BACKEND` and `VILA-FRONTEND`
3. Update frontend API URL:

```env
VITE_API_BASE_URL=https://your-domain.com/api
```

4. Build frontend:

```bash
cd VILA-FRONTEND
npm run build
```

5. Configure Nginx reverse proxy & HTTPS
6. Start containers from `VILA-BACKEND`:

```bash
docker compose up -d --build
```

### Option 2: Separate Deployment

**Frontend:** Vercel / Netlify / Nginx static hosting
**Backend:** VPS / Docker environment

> Ensure correct CORS, API URL, and HTTPS.

---

## ⚠️ Common Errors & Fixes

**1. `Could not open input file: artisan`**
*Cause:* Not in Laravel root
*Fix:*

```bash
cd /var/www/html
```

**2. Database connection error**
*Fix:*

* Check `.env` database credentials
* Ensure database container is running

---

## 🔒 Security Notes

* `.env` files excluded from Git
* Frontend `VITE_*` variables are public
* Backend secrets remain server-side
* Authorization enforced on backend
* Admin approval required for members

---

## 🧹 Maintenance

* Run migrations after schema changes
* Rebuild containers after dependency updates
* View logs:

```bash
docker logs vila_lab_app
```

---

## 📄 License

This project is intended for academic and organizational use.
