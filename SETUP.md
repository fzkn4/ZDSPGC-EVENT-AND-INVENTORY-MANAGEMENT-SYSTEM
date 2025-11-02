# Quick Setup Guide

## XAMPP Setup (Easiest Method)

This guide will help you set up the ZDSPGC Event & Inventory Management System using XAMPP.

### What You Need

- **XAMPP** (includes Apache, MySQL, PHP)
  - Download from: https://www.apachefriends.org/
  - **You do NOT need to install MySQL separately** - XAMPP includes it!

---

## Step-by-Step Instructions

### 1. Install XAMPP

1. Download XAMPP from https://www.apachefriends.org/
2. Run the installer
3. Install to `C:\xampp\` (default location)

### 2. Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**

Both services should show green "Running" status.

### 3. Copy Project Files

1. Copy the entire project folder to:
   ```
   C:\xampp\htdocs\ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM\
   ```

2. Your folder structure should look like:
   ```
   C:\xampp\htdocs\
   └── ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM\
       ├── setup.php          ← This file sets up the database
       ├── login.php          ← Login page
       ├── dashboard.php      ← Main dashboard
       ├── config.php         ← Database configuration
       ├── auth.php           ← Authentication system
       └── ... (other files)
   ```

### 4. Run Automatic Database Setup

1. Open your browser
2. Go to: `http://localhost/ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM/setup.php`
3. You'll see the setup form

**Important:** For XAMPP, the MySQL root password is usually **blank** (leave the password field empty).

4. Click **"Run Setup"** button
5. Wait for the success message

The setup script will:
- ✅ Create the database (`zdspgc_db`)
- ✅ Create the `users` table
- ✅ Create a database user (`zdspgc_user`)
- ✅ Add a default admin account

### 5. Access the Application

1. Go to: `http://localhost/ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM/login.php`

2. Login with default credentials:
   - **Username:** admin@example.com
   - **Password:** admin123

3. You're in! 🎉

### 6. Security - Delete Setup File

**IMPORTANT:** Delete `setup.php` after installation!

For security, you should remove the setup file:
```
Delete: C:\xampp\htdocs\ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM\setup.php
```

---

## Troubleshooting

### Port 80 Already in Use

**Problem:** Apache won't start because port 80 is already in use.

**Solution:**
1. Open XAMPP Control Panel
2. Click **Config** next to Apache
3. Click **httpd.conf**
4. Find line: `Listen 80`
5. Change to: `Listen 8080` (or any free port)
6. Save and restart Apache
7. Access app at: `http://localhost:8080/...`

### MySQL Won't Start

**Problem:** MySQL service won't start in XAMPP.

**Solution:**
1. Check if MySQL is already running:
   - Open Task Manager
   - Look for `mysqld.exe` or `MySQL` process
   - End task if found
2. Try starting MySQL again in XAMPP Control Panel

### Can't Access setup.php

**Problem:** Getting "404 Not Found" or "File not found"

**Solution:**
1. Verify file is in correct location:
   `C:\xampp\htdocs\ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM\setup.php`
2. Check Apache is running (green in XAMPP Control Panel)
3. Try: `http://localhost/setup.php` (if you're in the root htdocs folder)

### Database Connection Failed

**Problem:** After setup, login page shows "Database connection failed"

**Solution:**
1. Verify MySQL is running (green in XAMPP Control Panel)
2. Check `config.php` has correct settings:
   ```php
   DB_HOST = '127.0.0.1'
   DB_PORT = '3306'
   DB_DATABASE = 'zdspgc_db'
   DB_USERNAME = 'zdspgc_user'
   DB_PASSWORD = 'zdspgc_pass'
   ```
3. Run setup again: `http://localhost/.../setup.php`

### Forgot Root Password

**Problem:** Don't know MySQL root password for XAMPP

**Solution:**
- XAMPP default: **blank (empty password)**
- If that doesn't work, reset MySQL:
  1. Stop MySQL in XAMPP
  2. Go to: `C:\xampp\mysql\data\`
  3. Delete `mysql` folder (backup first if important!)
  4. Restart XAMPP MySQL
  5. Root password will be reset to blank

---

## Quick Reference

**Default Login:**
- URL: `http://localhost/ZDSPGC-EVENT-AND-INVENTORY-MANAGEMENT-SYSTEM/login.php`
- Username: admin@example.com
- Password: admin123

**Database Info:**
- Host: 127.0.0.1
- Port: 3306
- Database: zdspgc_db
- User: zdspgc_user
- Password: zdspgc_pass

**Important Files:**
- `setup.php` - Run once to set up database (delete after!)
- `login.php` - Login page
- `config.php` - Database connection settings
- `auth.php` - Authentication logic

---

## Need Help?

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify all steps were followed correctly
3. Check XAMPP error logs in the Control Panel
4. Make sure all required files are in the correct location

