Multi-Branch Attendance & Dynamic Salary Management System - Documentation

this project create in laravel - 12.8.1
it has two controller create - branch and salary
data base - my sql 
- branchSeeder and employe data add by direct seeder 

first page has show 
 Total employees
 Avg attendance %
 Employee of the Month
 Employees with &gt;90% attendance 
thes for employe  data 

Set up EC2:

Create an EC2 instance and configure security groups (HTTP, SSH).
Install Nginx, PHP, MySQL, Composer.
Clone Repository:
Clone project and configure .env file.
Install dependencies with composer install.
Set Permissions:
Set file permissions for Laravel.
Database Setup:
Create MySQL database and user.
Run migrations and seeders: php artisan migrate --seed.
Start Services:
Restart Nginx and PHP-FPM: sudo systemctl restart nginx php7.x-fpm.
Access Application:
Access via EC2 public IP or domain name.