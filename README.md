# Student Record System - CRUD Assessment Project

## ✅ 1. Project Overview

This project is a **basic Student Record Management System**.  
It demonstrates full CRUD operations, table sorting/searching across the entire dataset, and image handling.

🔗 **Live Demo:** *https://student-record-system.up.railway.app/*

---

## ✅ 2. Features

### Application Features

1. **Light Mode / Dark Mode Toggle**  
2. **CRUD Operations** with server-side validation  
3. **Batch Upload of Students** (CSV)  
4. **Global Table Search & Sorting** 
5. **Toast Notifications**
6. **Laravel Breeze Authentication** (Login + Logout only)  
7. **AWS S3 Image Storage** for student profile images  
8. **Mobile Responsive**

### Student Table Schema

The system manages a single table: **students**

| Name           | Data Type         | Description                  |
|----------------|-------------------|------------------------------|
| id             | Int (auto)        | Primary key                  |
| student_id     | String (unique)   | Unique student identifier    |
| full_name      | String            | Student's full name          |
| date_of_birth  | Date              | Student's birth date         |
| gender         | Enum              | Male, Female, or Other       |
| email          | String (unique)   | Student's email address      |
| course_program | String            | Program or course enrolled   |
| year_level     | String            | Year level of the student    |
| image          | String            | Profile image filename/path  |


---

## ✅ 3. Tech Stack

- **Laravel** (backend + authentication)  
- **Bootstrap** (UI)  
- **MySQL** (database)  
- **AWS S3** (image storage)  
- **Railway** (deployment of Laravel app + MySQL database)

---

## ✅ 4. Installation / Setup

### Requirements
- **PHP >= 8.1**
- **Composer**
- **MySQL**

### 1. Clone the repository
```bash
git clone https://github.com/MarcLawrenceKing/student-record-system.git
cd student-record-system
```
### 2. Install PHP & Node dependencies
```bash
composer install
npm install
npm run build
```

### 3. Create environment file
```bash
cp .env.example .env
```

### 4. Configure `.env`
Update the following lines with your local database credentials:
```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```
If you want to implement student image feature (optional):
```env
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket_name
```

### 5. Generate application key
```bash
php artisan key:generate
```

### 6. Run migrations (to create database based on DB_DATABASE)
```bash
php artisan migrate
```

### 7. Seed an user (to be able to login -> check DatabaseSeeder file to access/modify credentials)
```bash
php artisan db:seed
```

### 8. Start the development server
```bash
php artisan serve
```
## ✅ 5. Screenshots

<img src="Screenshot 2025-11-17 115916.png" width="400">
<img src="Screenshot 2025-11-17 115937.png" width="400">
<img src="Screenshot 2025-11-17 115957.png" width="400">
<img src="Screenshot 2025-11-17 120006.png" width="400">
<img src="Screenshot 2025-11-17 120102.png" width="400">
<img src="Screenshot 2025-11-17 120112.png" width="400">


