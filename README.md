# **Event Management System**

## **📌 Project Overview**

The **Event Management System** is a web-based application built with **pure PHP** using a **custom MVC architecture**. This system allows users to create, manage, and participate in events efficiently. The project follows **SOLID principles** and includes key features such as **user authentication, event management, attendee registration, ticket printing, ticket cancellation, report generation with CSV export, and file management**.

## **🚀 Key Features**

✔ **User Authentication** – Secure login, registration, and type-based access.  
✔ **User Management** – Super Users can create, edit, and view users.  
✔ **Event Management** – Users can create, edit, change status, and view events with detailed information.  
✔ **Attendee Registration** – Registered or guest users can sign up for events while ensuring capacity limits are respected.  
✔ **Ticket List & Cancellation** – Registered attendees can view, print, and cancel their tickets.  
✔ **Ticket Lookup** – Anyone can find and print tickets using a Booking Number, email, or mobile number.  
✔ **Report Generation** – Admins can generate reports using various filters and export them in CSV format.  
✔ **File Management** – Securely upload and manage event-related files and user profile pictures.  
✔ **Host Management** – Special privileges for event hosts, allowing them to create and manage events.  
✔ **Custom MVC Architecture** – A lightweight and minimal MVC structure optimized for performance and flexibility.  
✔ **REST API Support** – JSON-based API responses for seamless frontend/backend integration.  
✔ **Security Features** – CSRF protection, secure authentication, and input validation.

---

## **📌 Requirements**

Before setting up the **Event Management System**, ensure your environment meets the following requirements:

### **🔧 Server Requirements:**

- **PHP** ≥ 8.0  
- **MySQL** / **MariaDB**  
- **Apache** / **Nginx** (with `mod_rewrite` enabled)  
- **Composer** (for autoloading)  

---

## **📥 Setup Instructions**

### **1️⃣ Clone the Repository**

```sh
git clone https://github.com/naymur92/EventManagementSystem.git
cd EventManagementSystem
```

### **2️⃣ Configure the Environment**

Rename the `.env.example` file to `.env` and update it:

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

Import the database from the `/database/backup.sql` folder.

### **5️⃣ Set Writable Permissions**

Ensure the `public/uploads` folder has the proper writable permissions.

### **6️⃣ Update Configuration File**

Add your host address in the `cors-allowed-origins` section of the `config/config.php` file.

### **7️⃣ Enable Error Reporting in Local Development**

Enable error reporting in `public/index.php` for debugging purposes.

### **8️⃣ Start the Development Server**

```sh
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` in your browser to access the application.

---

## **🔑 Login Credentials**

To access the application, use the following test credentials:

### **👤 Super User Account**

📧 **Email:** `superuser@example.com`  
🔑 **Password:** `abcd1234`  

> ⚠️ **Note:** Do not delete the user with `user_id = 1`.

### **👥 Host Users**

📧 **Email:** `admin@gycm.com`, `admin@limelight.com`, `admin@bylc.com`  
🔑 **Password:** `12345678`  

### **👨‍🎓 Attendee User**

📧 **Email:** `abdrahman@gmail.com`  
🔑 **Password:** `12345678`  

> ⚠️ **Note:** You can create additional users through the registration form or directly via the database.

---

## **📌 Usage Guide**  

This section provides instructions on how to use the **Event Management System** effectively.  

### **1️⃣ User Authentication**  
- Visit the **Login Page** (`/login`).  
- Enter your **email** and **password**.  
- Click **"Login"** to access the dashboard.  
- New general and host users can register via the **Sign Up/Register** page.  
- After login, **Super Users** and **Host Users** are redirected to the **Admin Dashboard**, while **General Users** are redirected to the **Home Page**.  

### **2️⃣ Dashboard Overview (For Super Users and Host Users)**  
- After logging in, Super Users and Host Users are redirected to the **dashboard**.  
- The dashboard provides an overview of events, registered attendees, and other key information.  

### **3️⃣ Managing Events (For Super Users and Host Users)**  
- Create an event using the **"Add New Event"** button.  
- Publish an event.  
- Change event status (Pending, Published, Blocked) – Super Users only.  
- Edit event information using the **Edit** option.  
- View event details using the **View** option.  
- View and download the attendee list (CSV format) using the **Attendee List** option.  

### **4️⃣ Managing Users (For Super Users)**  
- Create, edit, update, view, and manage user status from the **Auth Users** menu.  

### **5️⃣ Reports & Analytics (For Super Users and Host Users)**  
- Generate, search, and download reports from the **Event Report** and **Attendee Report** sections.  

### **6️⃣ User Profile (For Authenticated Users)**  
- Users can view and update their profile information.  
- Change profile pictures.  
- Update user details and passwords.  

### **7️⃣ Home Page**  
- Displays recent events.  
- Users can view events by clicking on the schedule date icons.  

### **8️⃣ Events Page**  
- Displays a list of all events.  
- Includes search, filtering, and pagination features.  
- View event details by clicking on the event name.  

### **9️⃣ Event Registration (For General Users Only)**  
- Attendees can register for an event by clicking **"Get Your Ticket Now"** on the event page.  
- The system enforces event capacity limits before allowing registration.  
- After successful registration, users can print their tickets.  
- Logged-in users can view and cancel their registered tickets under the **"My Tickets"** section.  

### **🔟 Find Tickets**  
- Anyone can search and download tickets from the **Find Tickets** section using:  
  - **Booking Number**  
  - **Mobile Number**  
  - **Email**  

---

## **📌 Conclusion**  

The **Event Management System** is designed to streamline event planning, attendee registration, and ticket management. Built with **pure PHP and a custom MVC architecture**, it ensures security, flexibility, and efficiency.  

Feel free to contribute, report issues, or suggest improvements! 🚀  

---