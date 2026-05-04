# makaan-colocation
Makaan is a real estate web application designed to help users find, list, and manage properties for sale or rent in a simple and user-friendly way.
# 🏠 Makaan — Real Estate Listing Platform

A full-stack real estate web application for browsing, listing, and managing properties. Built with PHP and MySQL, it features a clean public-facing interface for visitors and a secure admin panel for property management.

---

## 📸 Preview

>![Uploading image.png…]()


---

## 🚀 Features

- 🔍 Browse and search property listings
- 🏡 Detailed property pages with images and info
- 👤 Agent profiles and contact pages
- 🔐 User authentication (login / logout)
- 🛠️ Admin dashboard for full property management (add, edit, delete)
- 📬 Contact form for inquiries
- 📱 Responsive HTML/CSS frontend

---

## 🛠️ Tech Stack

| Layer      | Technology          |
|------------|---------------------|
| Frontend   | HTML, CSS, JavaScript |
| Backend    | PHP                 |
| Database   | MySQL               |

---

## 📁 Project Structure

```
makaan/
├── index.php               # Home / landing page
├── about.html              # About page (static)
├── about.php               # About page (dynamic)
├── contact.html            # Contact page (static)
├── contact.php             # Contact form handler
├── login.php               # User login
├── logout.php              # User logout
├── db.php                  # Database connection
├── database.sql            # SQL schema & seed data
├── add-property.php        # Admin: add new property
├── edit-property.php       # Admin: edit existing property
├── delete-property.php     # Admin: delete property
├── admin-dashboard.php     # Admin control panel
├── property-list.html      # Property listing (static)
├── property-list.php       # Property listing (dynamic)
├── property-detail.php     # Single property detail page
├── property-agent.html     # Agent profile (static)
├── property-agent.php      # Agent profile (dynamic)
├── Makaan.jpg              # Hero/banner image
└── LICENSE.txt             # License file
```

---

## ⚙️ Installation & Setup

### Prerequisites

- PHP 7.4+
- MySQL 5.7+ or MariaDB
- Apache or Nginx (XAMPP / WAMP / LAMP recommended)

### Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/makaan.git
   cd makaan
   ```

2. **Import the database**

   Open phpMyAdmin or your MySQL client and run:

   ```sql
   CREATE DATABASE makaan;
   USE makaan;
   SOURCE database.sql;
   ```

3. **Configure the database connection**

   Edit `db.php` with your credentials:

   ```php
   $host = "localhost";
   $user = "root";
   $password = "";
   $database = "makaan";
   ```

4. **Start your local server**

   Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP) and navigate to:

   ```
   http://localhost/makaan/
   ```

---

## 🔑 Admin Access

To access the admin dashboard, log in with your admin credentials at:

```
http://localhost/makaan/login.php
```

Then navigate to:

```
http://localhost/makaan/admin-dashboard.php
```

---

## 📄 License

This project is licensed under the terms found in [LICENSE.txt](LICENSE.txt).

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you'd like to change.

---

> Built with ❤️ using PHP & MySQL
