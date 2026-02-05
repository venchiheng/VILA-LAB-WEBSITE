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

### 🔟 Run migrations & seeders & storage link

```bash
php artisan migrate --seed
```

```bash
php artisan storage:link
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

## 📂 Project Category Creation (Admin Only)

Before creating projects, an admin must create **project categories**, which define the type or group a project belongs to (e.g., AI, Robotics, etc).

**Steps to create a category via Laravel Tinker:**

1. **Enter the Laravel container:**

```bash
docker exec -it vila_lab_app bash
cd /var/www/html
```

2. **Start Tinker:**

```bash
php artisan tinker
```

3. **Create a new project category:**

```php
use App\Models\ProjectCategory;

ProjectCategory::create([
    'name' => 'AI'
]);
```

> ✅ The new category is saved directly to the database and can now be assigned to projects.

---

# 🚀 Deployment Guide — **VILA Lab Website**

**Repository:** `https://github.com/venchiheng/VILA-LAB-WEBSITE.git`

**Stack overview**
✔ Frontend: Vue.js + Vite
✔ Backend: Laravel (API)
✔ Database: MySQL
✔ Docker & Docker Compose for container orchestration

---

## 🔐 Prerequisites (for both scenarios)

On **all deployment machines:**

✔ OS: Ubuntu 20.04/22.04 (recommended)
✔ Docker installed

```bash
sudo apt update
sudo apt install -y docker.io
sudo systemctl enable --now docker
```

✔ Docker Compose (v2+ recommended)

```bash
sudo apt install -y docker-compose-plugin
```

✔ Nginx installed

```bash
sudo apt install -y nginx
```

✔ Domain names ready with DNS pointed to your server(s)


## **Option 1: Separate Servers**

**Server A — Backend (Laravel + Docker + MySQL)**

1. Clone repo:

```bash
cd /var/www
git clone https://github.com/venchiheng/VILA-LAB-WEBSITE.git
cd VILA-LAB-WEBSITE/VILA-BACKEND
```

2. Copy `.env`:

```bash
cp .env.example .env
```

3. Update `.env` for production (APP_URL, DB credentials).

4. Generate Laravel key:

```bash
docker compose run --rm app php artisan key:generate
```

5. Start containers:

```bash
docker compose up -d
```

6. Verify containers:

```bash
docker ps
# Should see vila_lab_app, vila_lab_db, vila_lab_nginx
```

7. Initialize backend (inside `vila_lab_app` container):

```bash
docker exec -it vila_lab_app bash
cd /var/www/html
composer install
php artisan migrate --seed
php artisan key:generate
exit
```

8. Configure Nginx for backend:

```nginx
server {
    listen 80;
    server_name <your-backend-domain.com>;

    location / {
        proxy_pass http://localhost:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}
```

Enable & restart Nginx.

---

**Server B — Frontend (Vue.js + Vite)**

1. Clone frontend:

```bash
cd /var/www
git clone https://github.com/venchiheng/VILA-LAB-WEBSITE.git
cd VILA-LAB-WEBSITE/VILA-FRONTEND
```

2. Install dependencies & build:

```bash
npm install
npm run build
```

3. Serve with Nginx (root points to `dist/`):

```nginx
server {
    listen 80;
    server_name www.your-frontend-domain.com;

    root /var/www/VILA-LAB-WEBSITE/VILA-FRONTEND/dist;
    index index.html;
    try_files $uri $uri/ /index.html;
}
```

4. Update frontend `.env`:

```
VITE_API_BASE_URL=https://<your-backend-domain.com>/api
```

Rebuild if needed.

---

## **Option 2: Single Server**

1. Clone repo, backend first:

```bash
cd /var/www
git clone https://github.com/venchiheng/VILA-LAB-WEBSITE.git
cd VILA-LAB-WEBSITE/VILA-BACKEND
```

2. Copy `.env`, configure for production.

3. Build frontend:

```bash
cd ../VILA-FRONTEND
npm install
npm run build
cp -r dist/* ../VILA-BACKEND/public/
```

4. Start Docker containers:

```bash
cd ../VILA-BACKEND
docker compose up -d
```

5. Configure Nginx (root → Laravel `public/`):

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;

    root /var/www/VILA-LAB-WEBSITE/VILA-BACKEND/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
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
