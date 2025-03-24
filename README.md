# **Dog Boutique - PHP Website**  

A dog boutique website built using **PHP, MySQL, JavaScript (AJAX), CSS, and SQL**, running on **XAMPP**.  
It includes **user authentication**, an **admin panel**, and a **password reset feature using Gmail SMTP with PHPMailer**.  

---
## 📸 Preview
![Landing page Screenshot](/public/assets/img/sample-screenshots/landing-page.jpeg)
![User Homepage Screenshot](/public/assets/img/sample-screenshots/home-page.jpeg)
![Admin Page Screenshot](/public/assets/img/sample-screenshots/admin-page.jpeg)
![Login Page Screenshot](/public/assets/img/sample-screenshots/login-page.jpeg)
![Product View Screenshot](/public/assets/img/sample-screenshots/product-view.png)


## **🚀 Features**  
✅ User Registration & Login  
✅ Password Reset via Email (Gmail SMTP)  
✅ Admin Dashboard (**Email:** `admin@gmail.com` | **Password:** `admin123`)  
✅ AJAX-Powered Frontend  

---

## **🛠 Setup Instructions**  

### **1️⃣ Install XAMPP and Start Apache & MySQL**  
1. Download & install [XAMPP](https://www.apachefriends.org/) if you haven't already.  
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.  

### **2️⃣ Clone the Repository**  
```sh
git clone https://github.com/your-username/dog-boutique.git
cd dog-boutique
```
### **3️⃣ Configure the Database**
1. Open [phpMyAdmin](http://localhost/phpmyadmin)
2. Create a new database named:
```sh
dog_boutique
```
3. Import the provided SQL file [dog_boutique.sql](https://github.com/HMDuran/dog-boutique/blob/main/sql/dog_boutique.sql).

## **📦 Install Dependencies**
This project uses Composer for managing dependencies.

### 1️⃣ Install Composer (If Not Installed)
1. Download and install Composer from [getcomposer.org](https://getcomposer.org/).
2. Verify installation by running:
```sh
composer --version
```
### 2️⃣ Install Required Packages
Run the following command in the project root:
```sh
composer install
```
This will automatically install all required packages from composer.json.
### 3️⃣ Manually install only if missing
If ```composer install``` does not install PHPMailer or Dotenv, then run:
```sh 
composer require phpmailer/phpmailer
composer require vlucas/phpdotenv
```
## **📧 Setup Gmail SMTP for Password Reset**
This project uses PHPMailer for sending password reset emails.
### 1️⃣ Enable Less Secure Apps (Optional)
If you are using a personal Gmail account, enable Less Secure Apps or use an App Password.
### 2️⃣ Create a .env File
In the project root, create a ```.env``` file and add:
```sh
DB_HOST=localhost
DB_NAME=dog_boutique
DB_USER=root
DB_PASS=

SMTP_HOST=smtp.gmail.com
SMTP_USERNAME=your-email@gmail.com
SMTP_PASSWORD=your-app-password
SMTP_PORT=587
SMTP_SECURE=tls
```
* Replace your-email@gmail.com and your-app-password with your actual Gmail credentials.
* If using 2FA, generate an App Password from Google App Passwords.

## Run the Project
Place the project folder inside ```htdocs``` (for XAMPP).

Open a browser and go to:
```sh
http://localhost/dog-boutique
```

---
## 📌 **Image Credits:** All images used in this project belong to their respective owners.  
