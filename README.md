# Car-Review-Web-Application  

A full-stack Laravel web application that allows users to browse, review, and rate cars, featuring dynamic content rendering, relational database integration, and input validation.

## 🚀 How to Run This Laravel App in VS Code

### ✅ Prerequisites  

Make sure the following are installed on your machine:

- [PHP 8.x](https://www.php.net/downloads)  
- [Composer](https://getcomposer.org/)  
- [SQLite](https://www.sqlite.org/)  
- [Git](https://git-scm.com/)  
- [Visual Studio Code](https://code.visualstudio.com/)  

---

### 🛠️ Steps to Run the Project

1. **Open the Project in VS Code**

2. **Install PHP Dependencies**  
   Run the following command in the terminal:

   ```bash
   composer install
   ```

3. **Copy the Example Environment File**  

This will create a new .env file based on the example:

   ```bash
   cp .env.example .env
   ```

4. **Configure SQLite in .env**  

Open the .env file and update the database configuration:

   ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE="[YOUR_PROJECT_PATH]/database/database.sqlite"
   ```

   **Important:** Replace `[YOUR_PROJECT_PATH]` with the full absolute path to your project directory.

   For example:

- Windows: `"C:/Users/YourName/path/to/Car-Review-Web-Application/database/database.sqlite"`
- macOS/Linux: `"/home/username/path/to/Car-Review-Web-Application/database/database.sqlite"`

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

   The application will be available at: `http://127.0.0.1:8000`

---

## 🔧 Troubleshooting

### Database Issues

If you encounter errors like "Database file does not exist" during migration:

1. **Check your .env file**: Ensure `DB_DATABASE` points to the correct absolute path
2. **Verify the database file exists**: Check if `database/database.sqlite` exists in your project
3. **Create the database file if missing**:

   ```bash
   touch database/database.sqlite
   ```

   (On Windows PowerShell, use: `New-Item database/database.sqlite -ItemType File`)

### Common Error: "UNIQUE constraint failed"

If you see this error when running `php artisan migrate --seed`, it means the database already has data. To start fresh:

```bash
php artisan migrate:fresh --seed
```

---

## 📋 Features

- Browse car manufacturers and their vehicles
- View detailed car specifications
- Add and edit car reviews
- Rate cars with star ratings
- Responsive web design
- SQLite database integration

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Database**: SQLite
- **Frontend**: Blade Templates, CSS
- **Build Tool**: Vite
