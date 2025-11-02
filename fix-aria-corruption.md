# Fix Aria Storage Engine Corruption Error

## Error: "Read page with wrong checksum" from storage engine Aria

This error indicates that MariaDB's Aria storage engine (system tables) has corruption. This commonly happens when XAMPP/MariaDB shuts down improperly.

## Quick Fix Solutions

### Solution 1: Repair Aria Tables (Recommended)

1. **Stop MySQL in XAMPP**
   - Open XAMPP Control Panel
   - Click "Stop" next to MySQL

2. **Open Command Prompt as Administrator**
   - Press `Win + X` → Select "Windows PowerShell (Admin)" or "Command Prompt (Admin)"

3. **Navigate to MySQL bin directory**
   ```cmd
   cd C:\xampp\mysql\bin
   ```

4. **Repair Aria tables**
   ```cmd
   aria_chk -r C:\xampp\mysql\data\mysql\*.MAI
   ```
   Or repair all Aria tables:
   ```cmd
   mysqlcheck --all-databases --check --auto-repair -u root -p
   ```
   (Press Enter when prompted for password if it's blank)

5. **Start MySQL again** in XAMPP Control Panel

### Solution 2: Recreate System Tables (If Solution 1 fails)

1. **Stop MySQL in XAMPP**

2. **Backup your data directory** (just in case)
   ```cmd
   xcopy C:\xampp\mysql\data C:\xampp\mysql\data_backup /E /I
   ```

3. **Run MySQL with recovery mode**
   - Open Command Prompt as Administrator
   ```cmd
   cd C:\xampp\mysql\bin
   mysqld --skip-grant-tables --skip-external-locking --aria-recover=FORCE
   ```
   (Let it run for a few minutes, then press Ctrl+C)

4. **Start MySQL normally** in XAMPP

### Solution 3: Reset MySQL Data (Nuclear Option - Last Resort)

**⚠️ WARNING: This will delete all databases!**

1. **Stop MySQL in XAMPP**

2. **Backup your project database** (if you have data you want to keep)
   ```cmd
   cd C:\xampp\mysql\bin
   mysqldump -u root -p zdspgc_db > C:\backup_zdspgc_db.sql
   ```
   (Press Enter if password is blank)

3. **Delete MySQL data directory**
   ```cmd
   del /F /S /Q C:\xampp\mysql\data\*
   ```
   (Be very careful with this!)

4. **Run MySQL installation**
   ```cmd
   cd C:\xampp\mysql\bin
   mysql_install_db.exe --datadir=C:\xampp\mysql\data
   ```

5. **Start MySQL** in XAMPP

6. **Re-run setup.php** to recreate your database

## Prevention

To prevent this from happening again:
- Always stop MySQL properly through XAMPP Control Panel
- Don't force-close XAMPP or shut down Windows while MySQL is running
- Consider backing up your database regularly

