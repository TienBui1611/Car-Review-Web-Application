# Car-Review-Web-Application  

A full-stack Laravel web application that allows users to browse, review, and rate cars, featuring dynamic content rendering, relational database integration, and input validation.

## ✨ Features

- 🚗 Browse cars by manufacturer
- ⭐ Add and view car reviews with ratings
- 📝 Dynamic content management
- 🔐 User authentication and authorization
- 📱 Responsive web design
- 🗄️ SQLite database integration

## 🚀 How to Run This Laravel App

### ✅ Prerequisites  

Make sure the following are installed on your machine:

- [PHP 8.x](https://www.php.net/downloads)  
- [Composer](https://getcomposer.org/)  
- [SQLite](https://www.sqlite.org/)  
- [Git](https://git-scm.com/)  
- [Visual Studio Code](https://code.visualstudio.com/) (optional but recommended)

---

### 🛠️ Steps to Run the Project

1. **Clone or Download the Project**
   ```bash
   git clone [repository-url]
   cd Car-Review-Web-Application
   ```

2. **Install PHP Dependencies**  
   ```bash
   composer install
   ```

3. **Copy the Example Environment File**  
   ```bash
   cp .env.example .env
   ```

4. **Configure Database in .env**  
   Open the `.env` file and ensure the database settings are correct:
   ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE="C:/Users/[YourUsername]/[ProjectPath]/Car-Review-Web-Application/database/database.sqlite"
   ```
   
   **Note:** Replace `[YourUsername]` and `[ProjectPath]` with your actual paths, or use the full absolute path to your project's database directory.

5. **Generate the Application Key**  
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders**  
   This creates the database structure and seeds it with sample data:
   ```bash
   php artisan migrate --seed
   ```

7. **Start the Local Development Server**  
   ```bash
   php artisan serve
   ```

8. **Open the App in Your Browser**  
   Navigate to: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔧 Troubleshooting

### Database Path Issues
If you encounter errors like "Database file does not exist", check your `.env` file:

1. Ensure `DB_DATABASE` points to the correct absolute path
2. Verify the `database` folder exists in your project
3. Make sure the path uses forward slashes `/` even on Windows

**Example for Windows:**
```bash
DB_DATABASE="C:/Users/YourName/Projects/Car-Review-Web-Application/database/database.sqlite"
```

### Fresh Database Reset
If you need to start with a clean database:
```bash
php artisan migrate:fresh --seed
```

### Common Commands
```bash
# View routes
php artisan route:list

# Clear cache
php artisan cache:clear

# View application information
php artisan about
```

---

## 📁 Project Structure

- `app/` - Application logic (Models, Controllers)
- `resources/views/` - Blade templates
- `routes/web.php` - Web routes definition
- `database/` - Migrations, seeders, and SQLite database
- `public/` - Public assets (CSS, JS, images)

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).  
