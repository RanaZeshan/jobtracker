# 🚀 Deployment Guide - Host Your Laravel App

## 🌟 Recommended: Railway Deployment

Railway is the easiest way to deploy your Laravel application with automatic GitHub integration.

### ✅ Why Railway?

- ✨ **Easy Setup** - Deploy in 5 minutes
- 🔄 **Auto Deploy** - Pushes to GitHub auto-deploy
- 💰 **Free Tier** - $5 free credit monthly
- 🗄️ **Built-in Database** - PostgreSQL/MySQL included
- 🔒 **HTTPS** - Free SSL certificates
- 📊 **Monitoring** - Built-in logs and metrics

---

## 🚀 Railway Deployment Steps

### Step 1: Prepare Your Project

First, let's add a Procfile for Railway:

```bash
# Create Procfile in project root
echo "web: php artisan serve --host=0.0.0.0 --port=\$PORT" > Procfile
```

### Step 2: Add Railway Configuration

Create `railway.json`:

```json
{
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

### Step 3: Update Composer.json

Add post-install scripts:

```json
"scripts": {
    "post-install-cmd": [
        "php artisan clear-compiled",
        "php artisan optimize"
    ],
    "post-autoload-dump": [
        "@php artisan package:discover --ansi"
    ]
}
```

### Step 4: Deploy to Railway

1. **Go to Railway:**
   - Visit: https://railway.app
   - Click "Start a New Project"
   - Sign in with GitHub

2. **Deploy from GitHub:**
   - Click "Deploy from GitHub repo"
   - Select `RanaZeshan/jobtracker`
   - Click "Deploy Now"

3. **Add Database:**
   - Click "New" → "Database" → "Add PostgreSQL"
   - Railway auto-configures connection

4. **Set Environment Variables:**
   - Go to your project → Variables
   - Add these variables:

```env
APP_NAME=JobTracker
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=pgsql
# Railway auto-fills these:
# DATABASE_URL
# PGHOST
# PGPORT
# PGDATABASE
# PGUSER
# PGPASSWORD

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

5. **Generate APP_KEY:**
   - In Railway terminal, run:
   ```bash
   php artisan key:generate --show
   ```
   - Copy the key and add to variables:
   ```
   APP_KEY=base64:your-generated-key
   ```

6. **Deploy:**
   - Railway automatically deploys
   - Wait for build to complete
   - Your app will be live at: `https://your-app.railway.app`

---

## 🔧 Alternative: DigitalOcean App Platform

### Cost: $5/month

1. **Create Account:**
   - Go to: https://www.digitalocean.com
   - Sign up and verify

2. **Create App:**
   - Click "Create" → "Apps"
   - Connect GitHub
   - Select `RanaZeshan/jobtracker`

3. **Configure:**
   - Detected as PHP/Laravel
   - Add MySQL database
   - Set environment variables

4. **Deploy:**
   - Click "Create Resources"
   - Wait for deployment

---

## 🌐 Alternative: Heroku

### Cost: $5-7/month (Eco Dynos)

### Setup:

1. **Install Heroku CLI:**
```bash
brew install heroku/brew/heroku  # macOS
```

2. **Login:**
```bash
heroku login
```

3. **Create App:**
```bash
heroku create jobtracker-app
```

4. **Add Database:**
```bash
heroku addons:create heroku-postgresql:mini
```

5. **Set Environment:**
```bash
heroku config:set APP_NAME=JobTracker
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=$(php artisan key:generate --show)
```

6. **Deploy:**
```bash
git push heroku main
heroku run php artisan migrate --force
```

7. **Open App:**
```bash
heroku open
```

---

## 💻 Alternative: VPS Hosting (Advanced)

### Providers:
- **DigitalOcean Droplet** - $4-6/month
- **Linode** - $5/month
- **Vultr** - $5/month
- **AWS Lightsail** - $3.50/month

### Requirements:
- Linux server (Ubuntu 22.04 recommended)
- PHP 8.2+
- MySQL/PostgreSQL
- Nginx/Apache
- Composer
- Node.js

### Quick Setup Script:

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install MySQL
sudo apt install -y mysql-server

# Install Nginx
sudo apt install -y nginx

# Clone your project
cd /var/www
git clone https://github.com/RanaZeshan/jobtracker.git
cd jobtracker

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/jobtracker
sudo chmod -R 755 /var/www/jobtracker/storage

# Configure environment
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link

# Configure Nginx
sudo nano /etc/nginx/sites-available/jobtracker
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/jobtracker/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📊 Hosting Comparison

| Provider | Cost | Ease | Database | Auto Deploy | Best For |
|----------|------|------|----------|-------------|----------|
| **Railway** | $5/mo | ⭐⭐⭐⭐⭐ | ✅ Included | ✅ Yes | Quick start |
| **Heroku** | $7/mo | ⭐⭐⭐⭐ | ✅ Add-on | ✅ Yes | Production |
| **DigitalOcean** | $5/mo | ⭐⭐⭐⭐ | ✅ Included | ✅ Yes | Scalable |
| **VPS** | $4/mo | ⭐⭐ | ⚙️ Manual | ❌ No | Full control |
| **Shared Hosting** | $3/mo | ⭐⭐⭐ | ✅ Included | ❌ No | Budget |

---

## 🔒 Production Checklist

Before deploying to production:

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate new `APP_KEY`
- [ ] Configure database properly
- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure email settings
- [ ] Set up backups
- [ ] Configure caching (Redis/Memcached)
- [ ] Set up queue workers
- [ ] Configure logging
- [ ] Test all features
- [ ] Set up monitoring

---

## 🌍 Custom Domain Setup

### After Deployment:

1. **Buy Domain:**
   - Namecheap, GoDaddy, or Google Domains
   - Cost: $10-15/year

2. **Configure DNS:**
   - Add A record pointing to your server IP
   - Or CNAME record for Railway/Heroku

3. **Update APP_URL:**
   ```env
   APP_URL=https://yourdomain.com
   ```

4. **SSL Certificate:**
   - Railway/Heroku: Automatic
   - VPS: Use Let's Encrypt (free)

---

## 📝 Post-Deployment

### Test Your App:

1. Visit your deployment URL
2. Test login/register
3. Test admin dashboard
4. Test team member features
5. Test file uploads
6. Check database connections

### Monitor:

- Check logs regularly
- Monitor performance
- Set up uptime monitoring (UptimeRobot - free)
- Configure error tracking (Sentry - free tier)

---

## 🆘 Troubleshooting

### Common Issues:

**1. 500 Error:**
```bash
# Check logs
php artisan log:clear
# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

**2. Database Connection:**
```bash
# Test connection
php artisan migrate:status
# Check .env database settings
```

**3. Assets Not Loading:**
```bash
# Rebuild assets
npm run build
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**4. Storage Issues:**
```bash
# Create storage link
php artisan storage:link
# Set permissions
chmod -R 775 storage
```

---

## 🎉 You're Live!

Once deployed, your app will be accessible at:
- Railway: `https://jobtracker-production.up.railway.app`
- Heroku: `https://jobtracker-app.herokuapp.com`
- Custom: `https://yourdomain.com`

Share the URL with your team and start using your application!

---

## 📚 Additional Resources

- [Laravel Deployment Docs](https://laravel.com/docs/deployment)
- [Railway Docs](https://docs.railway.app)
- [Heroku PHP Docs](https://devcenter.heroku.com/categories/php-support)
- [DigitalOcean Tutorials](https://www.digitalocean.com/community/tags/laravel)

---

**Need help? Open an issue on GitHub or contact support!**
