# Student Record System - CRUD Assessment Project

## ✅ 1. Project Overview

This project is a **basic Student Record Management System**.  
It demonstrates full CRUD operations, table sorting/searching across the entire dataset, image handling, and automated summary email generation for students.

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
9. **Manage Enrollments & Subjects** for each student  
10. **Automatic Average Grade Calculation**  
11. **Send Summary Email** once a student has 5 subjects with grades  

---

### Database Tables

#### Students Table

| Name           | Data Type         | Description                  |
|----------------|-----------------|------------------------------|
| id             | Int (auto)       | Primary key                  |
| student_id     | String (unique)  | Unique student identifier    |
| full_name      | String           | Student's full name          |
| date_of_birth  | Date             | Student's birth date         |
| gender         | Enum             | Male, Female, or Other       |
| email          | String (unique)  | Student's email address      |
| course_program | String           | Program or course enrolled   |
| year_level     | String           | Year level of the student    |
| image          | String           | Profile image filename/path  |
| created_at     | Timestamp        | Record creation time         |
| updated_at     | Timestamp        | Record last update time      |

#### Subjects Table

| Name          | Data Type       | Description                  |
|---------------|----------------|------------------------------|
| id            | Bigint (auto)  | Primary key                  |
| subject_code  | Varchar(20)    | Unique code for the subject  |
| subject_name  | Varchar(100)   | Name of the subject          |
| created_at    | Timestamp      | Record creation time         |
| updated_at    | Timestamp      | Record last update time      |

#### Enrollments Table

| Name         | Data Type       | Description                                |
|--------------|----------------|--------------------------------------------|
| id           | Bigint (auto)  | Primary key                                |
| student_id   | Bigint (FK)    | References `students.id`                   |
| subject_code | Varchar(20)    | Code of the enrolled subject               |
| year_sem     | Varchar(20)    | Year & semester of enrollment              |
| grade        | Decimal(5,2)   | Grade for the subject (nullable)           |
| created_at   | Timestamp      | Record creation time                        |
| updated_at   | Timestamp      | Record last update time                     |

#### Grades Email Table (summary emails)

| Name               | Data Type      | Description                                         |
|--------------------|---------------|-----------------------------------------------------|
| id                 | Bigint (auto) | Primary key                                        |
| student_id         | Bigint (FK)   | References `students.id`                           |
| year_sem           | Varchar(20)   | Year & semester                                    |
| subject_count      | Tinyint       | Total subjects enrolled                             |
| subject_with_grades| Tinyint       | Subjects with grades assigned                       |
| average_grades     | Decimal(5,2)  | Average of all grades (nullable)                    |
| sent               | Boolean       | Whether summary email has been sent                |
| created_at         | Timestamp     | Record creation time                                |
| updated_at         | Timestamp     | Record last update time                             |

---

## ✅ 3. Business Logic & Validation

### Enrollments

- Full CRUD available (create, read, edit, delete)  
- Batch upload feature using CSV template  
- **Validation:** A student cannot be enrolled in the same subject for the same year/semester  

### Summary Emails / Grades Email

- Computed automatically based on enrollments  
- **Validation:** Emails can only be sent if a student has **5 subjects with grades**  
- Average grade is calculated automatically  
- Mailtrap sandbox used for testing (requires `.env` setup)  

### Subjects

- Subjects do not have CRUD operations (managed manually for demonstration)  
- Included in navigation for reference  

---

## ✅ 4. Tech Stack

- **Laravel** (backend + authentication)  
- **Bootstrap** (UI)  
- **MySQL** (database)  
- **AWS S3** (image storage)  

---

## ✅ 5. Installation / Setup

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
Mailtrap credentials (for dummy email sending): 
```env
MAIL_USERNAME=your_sandbox_username
MAIL_PASSWORD=your_sandbox_password
```

### 5. Generate application key
```bash
php artisan key:generate
```

### 6. Run migrations (to create database based on DB_DATABASE)
```bash
php artisan migrate
```

### 7. Seed database (to be able to login -> check DatabaseSeeder file to access/modify credentials && create initial values for students and subjects)
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
