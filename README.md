# 🚗 Car Review Web Application

> A comprehensive Laravel web application for browsing, reviewing, and rating cars with dynamic content rendering and robust database integration.

## ✨ Features

- **Car Browsing**: Explore cars by manufacturer and model
- **User Reviews**: Write and edit detailed car reviews
- **Rating System**: Rate cars and view aggregate ratings
- **Manufacturer Directory**: Browse cars organized by manufacturer
- **Responsive Design**: Mobile-friendly interface
- **Database Integration**: SQLite with Laravel Eloquent ORM

## 🚀 Quick Start

### 📋 Prerequisites

Ensure you have the following installed:

- **PHP 8.x** - [Download here](https://www.php.net/downloads)
- **Composer** - [Download here](https://getcomposer.org/)
- **SQLite** - [Download here](https://www.sqlite.org/)
- **Git** - [Download here](https://git-scm.com/)
- **VS Code** - [Download here](https://code.visualstudio.com/)

### 🛠️ Installation & Setup

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/Car-Review-Web-Application.git
   cd Car-Review-Web-Application
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Environment Setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**

   ```bash
   php artisan migrate --seed
   ```

5. **Start Development Server**

   ```bash
   php artisan serve
   ```

6. **Access the Application**

   Open your browser and navigate to: `http://localhost:8000`

## 🏗️ Project Structure

```
Car-Review-Web-Application/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database migrations
│   ├── seeders/           # Database seeders
│   └── setup.sql          # Initial database setup
├── resources/
│   ├── views/             # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
└── public/                # Public assets
```

## 💻 Technologies Used

- **Backend**: Laravel 11.x, PHP 8.x
- **Database**: SQLite with Eloquent ORM
- **Frontend**: Blade Templates, CSS, JavaScript
- **Build Tools**: Vite, Composer
- **Testing**: PHPUnit
