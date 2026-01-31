# VILA Lab Website

This repository contains the **VILA Lab Official Website**, developed using a modern **frontend–backend separated architecture**.
The system supports **role-based access control** with Admin and Member roles and is designed for **local development, Docker deployment, and real server hosting**.

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

### 2️⃣ Backend environment setup

```bash
cd VILA-BACKEND
cp .env.example .env
```

Update `.env` if necessary (database credentials, app name, etc.).

---

### 3️⃣ Frontend environment setup

```bash
cd ../VILA-FRONTEND
cp .env.example .env
```

Set API base URL:

```env
VITE_API_BASE_URL=http://44.223.137.10:8000/api
```

---

### 4️⃣ Start Docker containers

From the project root:

```bash
docker compose up -d --build
```

---

### 5️⃣ Generate Laravel app key

```bash
docker exec -it vila_lab_app php artisan key:generate
```

---

### 6️⃣ Run migrations & seeders

```bash
docker exec -it vila_lab_app php artisan migrate --seed
```

---

### 7️⃣ Access the application

* Frontend:
  👉 [http://localhost:5173](http://localhost:5173)

* Backend API:
  👉 [http://44.223.137.10:8000/api](http://44.223.137.10:8000/api)

---

## Authentication & User Roles

The system implements **role-based authentication** with the following roles:

* **Admin** – system management and application approval
* **Member** – approved users with limited access
* **Guest** – public access only

---

## Creating an Admin Account (Required)

Admin accounts **cannot be registered through the UI** and must be created manually using Laravel Tinker.

### Steps

1. Enter the backend container:

```bash
docker exec -it vila_lab_app bash
```

2. Open Laravel Tinker:

```bash
php artisan tinker
```

3. Create an admin user:

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

4. Exit Tinker:

```bash
exit
```

### Admin Login

* Use the admin login page
* Log in with the email and password created above
* Admin will have access to the admin dashboard and approval system

> ⚠️ Admin creation via UI is intentionally disabled for security reasons.

---

## Member Application & Login Flow

### Step 1: Submit Application

* A user submits a **member application** via the frontend
* Application status is set to `pending`

---

### Step 2: Admin Approval

* Admin logs in
* Reviews submitted applications
* Approves or rejects applications from the admin panel

---

### Step 3: Member Account Creation

Once approved:

* A member account is created automatically
* Login credentials are generated as follows:

  * **Email**: applicant’s email
  * **Password**: user ID assigned by the system

---

### Member Login

Example:

```text
Email: member@example.com
Password: 12
```

> Members are strongly encouraged to **change their password after first login**.

---

## Deployment Guide (Production)

### Option 1: VPS Deployment (Recommended)

Supports:

* AWS EC2
* DigitalOcean
* Linode

#### Steps

1. Clone the repository on the server
2. Configure `.env` files for production
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

* Deploy to:

  * Vercel
  * Netlify
  * Static Nginx hosting

#### Backend

* Deploy Laravel API on:

  * VPS
  * Docker-based environment

Ensure:

* Correct CORS configuration
* Proper API base URL
* HTTPS enabled

---

## Security Notes

* `.env` files are excluded from Git
* Frontend `VITE_*` variables are public by design
* Backend secrets are never exposed
* Authentication and authorization are enforced server-side
* Admin approval is required for member access

---

## Maintenance

* Run migrations after schema updates
* Rebuild Docker containers after dependency changes
* View logs:

```bash
docker logs vila_lab_app
```

---

## License

This project is intended for academic and organizational use.

---
