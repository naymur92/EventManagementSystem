# **Event Management System**

## **📌 Project Overview**

The **Event Management System** is a web-based application built with **pure PHP** following a **custom MVC architecture**. This system allows users to create, manage, and participate in events efficiently. The project follows **SOLID principles** and includes key features like **user authentication, event management, attendee registration, ticket printing, ticket cancellation, report generation with csv export and file management**.

## **🚀 Key Features**

✔ **User Authentication** – Secure login, registration, and type-based access.  
✔ **User Management** – Create, edit, delete, and view feature for Super Users.  
✔ **Event Management** – Create, edit, delete, and view events with detailed information.  
✔ **Attendee Registration** – Registered or Guest Users can register for events with capacity restrictions and unique registration restrictions.  
✔ **Ticket List & Cancellation** – Registered Attendees can view there tickets, print, and cancel.  
✔ **Ticket Finding** – Anyone can find tickets and print using Booking No, email, and mobile.  
✔ **Report Generation** – Admins can generate reports using multiple parameters and export in csv format.  
✔ **File Management** – Upload and manage event-related files and User profile pictures securely.  
✔ **Host Management** – Special role for event hosts with additional privileges like Event create, edit.  
✔ **Custom MVC Architecture** – Built with a lightweight and minimal MVC structure for better performance and flexibility.  
✔ **REST API Support** – JSON-based API responses for seamless frontend/backend integration.  
✔ **Security Features** – CSRF protection, secure authentication, and input validation.

---

## **📌 Requirements**

Before setting up the **Event Management System**, ensure your environment meets the following requirements:

### **🔧 Server Requirements:**

- **PHP** ≥ 8.0
- **MySQL** / **MariaDB**
- **Apache** / **Nginx** (with mod_rewrite enabled)
- **Composer** (for dependency management and autoloading)

---

## **📥 Setup Instructions**

### **1️⃣ Clone the Repository**

```sh
git clone https://github.com/naymur92/EventManagementSystem.git
cd EventManagementSystem
```

### **2️⃣ Configure the Environment**

Rename the `.env.example` file to `.env` and update:

```sh
cp .env.example .env
```

Then, edit the `.env` file:

```
APP_NAME="Your App Name"
APP_URL=http://your-domain.com

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **3️⃣ Update Autoload**

```sh
composer dump-autoload
```

### **4️⃣ Set Up the Database**

Import the database from the `/database/backup.sql` folder

### **5️⃣ Set writable permission**

Set writable permission to `public/uploads` folder

### **6️⃣ Update config file**

Add your host address in `cors-allowed-origins` in `config/config.php` file

### **7️⃣ Enable error reporting in Local Development**

Enable error reporting lines from `public/index.php`.

### **8️⃣ Start the Development Server**

```sh
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` in your browser to access the application.

---

## **🔑 Login Credentials**

To access the application, use the following test credentials:

### **👤 Admin Account**

📧 **Email:** `superuser@example.com`  
🔑 **Password:** `abcd1234`

> ⚠️ **Note:** Do not delete user with user_id 1.

### **👥 Host Users**

📧 **Email:** `admin@gycm.com` `admin@limelight.com` `admin@bylc.com`  
🔑 **Password:** `12345678`

### **👨‍🎓 Attendee User**

📧 **Email:** `abdrahman@gmail.com`  
🔑 **Password:** `12345678`

> ⚠️ **Note:** You can create more users via the registration form or database.

---

## **👤 About Me**

🔹 **Name:** _Naymur Rahman_  
🔹 **Role:** Software Engineer  
🔹 **Expertise:** PHP, Laravel, Custom MVC, JavaScript, Vue, C++, DSA, API Development & Integration  
🔹 **Current Projects:** **Event Management System**, Custom ERP  
🔹 **Skills:**  
&nbsp; &nbsp; ✔️ Backend: PHP (Pure PHP, Laravel), MySQL  
&nbsp; &nbsp; ✔️ Frontend: JavaScript, AJAX, Vue, React  
&nbsp; &nbsp; ✔️ API Development & Integration: Payment Gateways, Custom APIs  
&nbsp; &nbsp; ✔️ Others: C++, DSA, Problem Solving, Mathematics, SOLID, OOP  
🔹 **GitHub Stats:** 🚀 _[Optionally, you can add GitHub stats images here]_

---

### **📫 Connect with Me**

💼 **LinkedIn:** _[https://www.linkedin.com/in/naymur/]_
