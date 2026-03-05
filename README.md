# 📝 Laravel Todo App

A full-featured Todo application built with Laravel 12, featuring OTP-based authentication, role-based authorization, and complete task management.

---

## ✨ Features

### 🔐 Authentication

- User registration & login
- OTP verification via email on every login (6-digit, 5-minute expiry)
- OTP resend functionality with countdown timer
- Remember me support
- Forgot password & reset via email token

### 👥 Role-Based Authorization

| Feature                | Admin | User          |
| ---------------------- | ----- | ------------- |
| View all users         | ✅    | ❌            |
| View any user's tasks  | ✅    | ❌            |
| Edit & delete any task | ✅    | ❌            |
| View own tasks         | ❌    | ✅            |
| Add new task           | ❌    | ✅            |
| Mark task as complete  | ✅    | ✅ (own only) |

### ✅ Task Management

- Add, edit, delete tasks
- Set title, description, and deadline
- Mark tasks as completed
- Paginated task list

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Language:** PHP 8.2
- **Database:** MySQL
- **Frontend:** Bootstrap 5.3, Blade Templates
- **Mail:** SMTP (Gmail)
- **Authentication:** Custom Auth with OTP

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/laravel-todo-app.git
cd laravel-todo-app
```

### 2. Install dependencies

```bash
composer install
npm install && npm run build
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`

```env
DB_DATABASE=todoapp
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="Todo App"
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Create admin user

```bash
php artisan tinker
User::where('email', 'your@email.com')->update(['role' => 'admin']);
```

### 7. Start the server

```bash
php artisan serve
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthManager.php           # Login, Register, Logout
│   │   ├── TaskManager.php           # Task CRUD
│   │   └── ForgetPasswordManager.php # Password Reset
│   ├── Middleware/
│   │   ├── AdminMiddleware.php        # Admin role check
│   │   └── UserMiddleware.php         # User role check
│   └── Requests/
│       └── OtpVerifyRequest.php       # OTP validation
├── Models/
│   ├── User.php
│   ├── Task.php
│   └── OtpVerification.php
└── Services/
    └── OtpService.php                 # OTP generate, verify, send

resources/views/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── otp-verify.blade.php
│   ├── forget-password.blade.php
│   └── new-password.blade.php
├── admin/
│   ├── home.blade.php                 # Admin dashboard
│   └── user-tasks.blade.php           # User task details
├── tasks/
│   ├── add.blade.php
│   └── edit.blade.php
├── emails/
│   └── otp.blade.php                  # OTP email template
└── welcome.blade.php                  # User home
```

---

## 🔄 OTP Login Flow

```
Email + Password ──► Credentials Check
                            │
                     ✅ Correct
                            │
                     Auth::logout()
                            │
                     OTP Generate & Send to Email
                            │
                     /otp/verify page
                            │
                     User enters 6-digit OTP
                            │
                     ✅ OTP Valid (within 5 min)
                            │
                     Auth::login() ──► Home
```

---

## 🗄️ Database Tables

| Table               | Description                                   |
| ------------------- | --------------------------------------------- |
| `users`             | name, email, password, role (admin/user)      |
| `tasks`             | title, description, deadline, status, user_id |
| `otp_verifications` | user_id, otp (hashed), expires_at, is_used    |
| `password_resets`   | email, token, created_at                      |

---

## 🚀 Key Routes

| Method | URL                      | Description             |
| ------ | ------------------------ | ----------------------- |
| GET    | `/login`                 | Login page              |
| POST   | `/login`                 | Submit credentials      |
| GET    | `/otp/verify`            | OTP verify page         |
| POST   | `/otp/verify`            | Submit OTP              |
| POST   | `/otp/resend`            | Resend OTP              |
| GET    | `/`                      | Home (role-based)       |
| GET    | `/task/add`              | Add task (user only)    |
| GET    | `/admin/user/{id}/tasks` | User tasks (admin only) |
| GET    | `/forget-password`       | Forgot password         |

---

## 👤 Author

**Tamzid Hasan**

- GitHub: [https://github.com/mdtamzidhasan](https://github.com/your-username)

---

## 📄 License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).
