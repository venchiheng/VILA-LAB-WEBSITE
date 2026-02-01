# Frontend Application

This repository contains the **frontend** of the project, built with **Vue 3** and **Vite**, and connected to a backend API.
The frontend is responsible for UI rendering, state management, routing, and API communication.

---

## 🚀 Tech Stack

* **Vue 3**
* **Vite**
* **Pinia** – State management
* **Vue Router**
* **Axios**
* **Vuetify**

---

## 📂 Project Structure

```bash
src/
├── assets/        # Static files (images, icons, global styles)
├── components/    # Reusable UI components
├── lib/           # Shared libraries, helpers, or utilities
├── plugins/       # Vue plugins (Vuetify, router, Pinia setup, etc.)
├── services/      # API services and axios instances
├── stores/        # Pinia state management
├── views/         # Page-level components (mapped to routes)
├── App.vue        # Root component
└── main.js        # Application entry point
```

---

## ⚙️ Environment Variables

Create a `.env` file in the project root:

```env
VITE_API_BASE_URL=http://localhost:8000/api
```

Make sure this matches your backend API URL.

---

## 📦 Installation & Setup

### 1️⃣ Clone the repository and switch to frontend branch

```bash
git clone <repository-url>
cd <project-folder>
git checkout frontend
```

### 2️⃣ Install dependencies

```bash
npm install
```

### 3️⃣ Run the development server

```bash
npm run dev
```

App will be available at:

```
http://localhost:5173
```

---

## 🧠 State Management (Pinia)

* All stores are located in `src/stores`
* Used for:

  * Authentication
  * Shared application state

Example usage:

```js
import { useAuthStore } from '@/stores/auth'
```

---

## 🔄 API Services

* API logic is centralized in `src/services`
* Axios is configured with:

  * Base URL
  * Authorization headers
  * Interceptors

This keeps API calls consistent across the app.

---

## 🧭 Routing & Views

* Pages are stored in `src/views`
* Routes map directly to views
* Supports protected routes and role-based access

---

## 🧪 Build for Production

```bash
npm run build
```

Preview build:

```bash
npm run preview
```

---

## 📌 Notes

* This branch contains **frontend only**
* Backend runs separately
* Recommended Node.js version: **v18+**

---

Just say the word 💡
