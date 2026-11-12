# UpPage Technology (Craft by Code) - Hosting & Deployment Guide

This repository contains a full-stack **Laravel 12** application with **MySQL**, **Tailwind CSS**, and **Blade**. Follow the guide below based on your hosting environment.

---

## Pre-Deployment Checklist (Ready in this repo)

1. **Frontend Compiled:** Vite assets are built into `public/build/`.
2. **Encrypted Backup Engine:** Run `php artisan security:backup` before/after releases (`storage/app/private/backups/`).
3. **Admin Provisioning & Security:**
   - Do **not** deploy default demo credentials into production. Create or rotate your admin password immediately via CLI (`php artisan tinker` / password reset) and enable **2FA (TOTP)** inside **Account & Security**.

---

## Option 1: cPanel / Shared Hosting (Hostinger, cPanel, Namecheap, GoDaddy)

### Step 1: Upload Files
1. Zip all files in your project directory (exclude `node_modules` and `.git`).
2. Log in to your hosting **cPanel** or file manager.
3. Upload the `.zip` file into your account root (e.g. `/home/username/`).
4. Extract the zip file into a folder outside public_html, for example: `/home/username/crafbycode/`.
5. Move the contents of the `crafbycode/public/` folder into your `public_html/` directory.
6. Open `public_html/index.php` and edit paths to point to your project directory:
   ```php
   require __DIR__.'/../crafbycode/vendor/autoload.php';
   $app = require_once __DIR__.'/../crafbycode/bootstrap/app.php';
   ```
   *(Alternatively, if your host allows changing the Document Root, simply set Document Root to `/home/username/crafbycode/public`)*.

### Step 2: Create MySQL Database
1. Go to **cPanel > MySQL Databases**.
2. Create a database: e.g. `u123456_crafbycode`.
3. Create a database user & password: e.g. `u123456_dbuser`.
4. Assign the user to the database with **All Privileges**.
5. Open **phpMyAdmin**, select the newly created database, and click **Import**.
6. Choose the file `database/crafbycode_dump.sql` and click **Go**.

### Step 3: Configure `.env`
Open the `.env` file in File Manager (ensure "Show Hidden Files" is enabled) and update:
```env
APP_NAME="craft by code"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456_crafbycode
DB_USERNAME=u123456_dbuser
DB_PASSWORD=your_database_password
```

### Step 4: Storage Permissions & Optimization
In cPanel Terminal (or SSH):
```sh
php artisan storage:link
php artisan optimize
```
Make sure `storage/` and `bootstrap/cache/` directories have permissions `775`.

---

## Option 2: VPS / Cloud Server (Ubuntu 22.04 / 24.04 with Nginx)
*(DigitalOcean Droplet, AWS EC2, Linode, Hetzner, Vultr)*

### Step 1: Server Setup (PHP 8.4 + Nginx + MySQL)
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server git unzip curl

# Install PHP 8.4
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.4 php8.4-fpm php8.4-mysql php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip php8.4-gd php8.4-bcmath
```

### Step 2: Clone / Copy Repository
```bash
cd /var/www
sudo git clone <your-repo-url> crafbycode
cd crafbycode

# Install composer dependencies
composer install --no-dev --optimize-autoloader

# Set permissions
sudo chown -R www-data:www-data /var/www/crafbycode/storage /var/www/crafbycode/bootstrap/cache
sudo chmod -R 775 /var/www/crafbycode/storage /var/www/crafbycode/bootstrap/cache
```

### Step 3: MySQL Database Setup
```bash
sudo mysql
```
```sql
CREATE DATABASE crafbycode CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'crafuser'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON crafbycode.* TO 'crafuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
Import the database:
```bash
mysql -u crafuser -p crafbycode < database/crafbycode_dump.sql
```

### Step 4: Configure `.env`
```bash
cp .env.example .env
nano .env
```
Update:
```env
APP_NAME="craft by code"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crafbycode
DB_USERNAME=crafuser
DB_PASSWORD=StrongPassword123!
```

Generate App Key and link storage:
```bash
php artisan key:generate
php artisan storage:link
php artisan optimize
```

### Step 5: Nginx Configuration
Create Nginx site configuration:
```bash
sudo nano /etc/nginx/sites-available/crafbycode
```
Paste:
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/crafbycode/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Enable site and test:
```bash
sudo ln -s /etc/nginx/sites-available/crafbycode /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 6: Free SSL Certificate (Let's Encrypt)
```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## Option 3: Automated Cloud Hosting (Laravel Forge / Ploi / Railway)

1. Connect your GitHub repository.
2. Add a MySQL database instance.
3. Set Environment variables from `.env`.
4. Deploy command:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize
   ```

