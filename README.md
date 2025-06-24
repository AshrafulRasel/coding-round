Laravel Coding Round API 🛠️
This repository provides a simple Laravel-based API for:

User Registration — register with name, email, and password
Task Management — add tasks, mark as completed, and list pending tasks

Setup Instructions

1. Clone the Repository

git clone https://github.com/AshrafulRasel/coding-round.git
cd coding-round

2. Install Dependencies

composer install

3. Create Environment File

cp .env.example .env
4. Generate Application Key

php artisan key:generate

5. Set Up Database
Edit the .env file and configure your database:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

6. Run Migrations

php artisan migrate

7. Start the Development Server

php artisan serve
The server will run at: http://localhost:8000

