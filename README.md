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

3. **Copy the Example Environment File**  
This will create a new .env file based on the example:

   ```bash
   cp .env.example .env

4. **Configure SQLite in .env**  
Open the .env file and set the following:

   ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE="${database direct path}.sqlite"


5. **Generate the Application Key**  

   ```bash
   php artisan key:generate

6. **Run Migrations and Seeders**  
   This creates the database structure and seeds it with sample data:

   ```bash
   php artisan migrate --seed

7. **Start the Local Development Server**  
   ```bash
   php artisan serve

8. **Open the App in Your Browser**  

