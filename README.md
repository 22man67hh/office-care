
<h2>  📝 Task Management System</h2>

A modern **Task Management Web App** with a **draggable Kanban-style UI**, built using **Laravel**, **Blade**, **TailwindCSS**, and **MySQL**. It includes robust **role and permission management** via **Spatie** and uses **Laravel Breeze** for authentication. Ideal for managing users, tasks, and workflows in a structured and restricted environment.

---

## 🚀 Features

- ✅ Drag-and-drop task movement (Kanban-style)
- 🎨 Styled with TailwindCSS
- 🔐 Role-based access using Spatie Permission
- 👑 Admin panel to manage permissions and roles
- 👤 Users restricted to assigned permissions
- 📂 Task filtering by user, type, and date
- 🧠 Seeder creates an admin with full access

---

## 🧱 Tech Stack

| Frontend             | Backend   | Auth System      | Roles & Permissions   | Database |
|----------------------|-----------|------------------|------------------------|----------|
| Blade + TailwindCSS  | Laravel   | Laravel Breeze   | Spatie Laravel Package | MySQL    |

---

## 📦 Installation Guide

Follow the steps below to set up the project locally.

### 1. Clone the repository

git clone https://github.com/your-username/your-repo.git
cd your-repo

2. Configure environment

Copy the .env file:

cp .env.example .env

Update your .env file to match your local database settings:

DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=m@nish123 # You can remove this if you have no password

3. Install PHP dependencies

composer install

4. Run migrations and seeders

php artisan migrate
php artisan db:seed

    🔑 Seeder will create a default admin user with full access.

5. Install and build frontend assets

npm install
npm run dev

    TailwindCSS (via Laravel Breeze) requires npm run dev to compile properly.

6. Run the application

php artisan serve

Visit http://localhost:8000 in your browser.
🔐 Roles & Permissions

    Admin

        Created by default via seeder

        Has access to all routes and actions

        Can create permissions from dropdowns

        Can assign permissions to roles

    User

        Default role for new registrations

        Access limited to what's granted by assigned permissions

    Admin must first create permissions and assign them to roles. Users will only be able to access features based on those permissions.

🔎 Task Management

    Drag tasks between statuses using drag-and-drop UI

    Filter tasks by:

        Assigned User

        Task Type

        Date

    Tasks are permission-controlled

🛠 Admin First Steps

    Login as Admin (from seeded user)

    Create new Permissions

    Assign permissions to Roles

    Only after that, users will be able to access features based on roles

🗂 Example Admin Seeder (Credentials)

    You can customize this in DatabaseSeeder.php or wherever your admin is seeded.
<h3>Credentials</h3>
<strong>username:test@example.com</strong>
<strong>password:password</strong>

