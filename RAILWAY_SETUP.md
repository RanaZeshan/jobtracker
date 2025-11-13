# 🚂 Railway Deployment - Step by Step

## ✅ Fixed Issues:
- ✓ Users table migration created
- ✓ Duplicate migrations removed
- ✓ PostgreSQL configuration added
- ✓ Nixpacks configuration added

---

## 🚀 Deploy to Railway

### Step 1: Add PostgreSQL Database

1. Go to your Railway project
2. Click **"New"** → **"Database"** → **"Add PostgreSQL"**
3. Railway will automatically create and link the database

### Step 2: Set Environment Variables

Go to your service → **Variables** tab and add:

```env
# Application
APP_NAME=JobTracker
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway auto-fills these from PostgreSQL service)
# Just verify they exist:
# DATABASE_URL
# PGHOST
# PGPORT
# PGDATABASE
# PGUSER
# PGPASSWORD

# Laravel Database Config
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Mail (Optional - configure later)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 3: Generate APP_KEY

In Railway's service, go to **Settings** → **Deploy** → **Custom Start Command**:

Run this command once to generate the key:
```bash
php artisan key:generate --show
```

Copy the output (e.g., `base64:xxxxx...`) and add it to Variables:
```env
APP_KEY=base64:your-generated-key-here
```

### Step 4: Deploy

1. Railway will automatically detect the changes from GitHub
2. Click **"Deploy"** or push to GitHub to trigger deployment
3. Wait for build to complete (2-5 minutes)

### Step 5: Verify Deployment

1. Click on your service URL (e.g., `https://jobtracker-production.up.railway.app`)
2. You should see the welcome page
3. Try logging in with default credentials:
   - Email: `admin@example.com`
   - Password: `password`

---

## 🔧 Troubleshooting

### Issue: "No such table: users"

**Solution:** Make sure PostgreSQL is added and environment variables are set correctly.

1. Check Variables tab has `DATABASE_URL` and `PG*` variables
2. Redeploy the service

### Issue: "APP_KEY not set"

**Solution:** Generate and set APP_KEY:

```bash
# In Railway terminal
php artisan key:generate --show
```

Add the output to Variables.

### Issue: "500 Error"

**Solution:** Check logs:

1. Go to your service
2. Click **"Deployments"**
3. Click on latest deployment
4. Check **"View Logs"**

Common fixes:
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Re-run migrations
php artisan migrate:fresh --force --seed
```

### Issue: "Database connection failed"

**Solution:** Verify database variables:

1. Go to PostgreSQL service
2. Click **"Variables"** tab
3. Copy all `PG*` variables
4. Go to your app service
5. Add/update the variables

---

## 📊 Railway Dashboard

### Monitor Your App:

1. **Metrics** - CPU, Memory, Network usage
2. **Logs** - Real-time application logs
3. **Deployments** - Deployment history
4. **Settings** - Configuration options

### Useful Commands in Railway Terminal:

```bash
# Check database connection
php artisan migrate:status

# View routes
php artisan route:list

# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Create admin user
php artisan db:seed --class=AdminUserSeeder --force
```

---

## 🔄 Auto-Deploy from GitHub

Railway automatically deploys when you push to GitHub:

```bash
# Make changes locally
git add .
git commit -m "Your changes"
git push

# Railway will automatically:
# 1. Detect the push
# 2. Build the application
# 3. Run migrations
# 4. Deploy the new version
```

---

## 🌐 Custom Domain (Optional)

### Add Your Own Domain:

1. Go to your service → **Settings**
2. Click **"Domains"**
3. Click **"Custom Domain"**
4. Enter your domain (e.g., `jobtracker.com`)
5. Add the CNAME record to your DNS:
   ```
   CNAME: your-domain.com → your-app.railway.app
   ```
6. Wait for DNS propagation (5-30 minutes)
7. Railway automatically provisions SSL certificate

---

## 💰 Pricing

### Free Tier:
- $5 credit per month
- Enough for small apps
- Includes database

### Paid Plans:
- $5/month per service after free credit
- PostgreSQL: Included
- Unlimited deployments

---

## 📝 Environment Variables Reference

### Required Variables:

```env
APP_NAME=JobTracker
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-key-here
APP_URL=https://your-app.railway.app

DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

SESSION_DRIVER=database
CACHE_DRIVER=database
```

### Optional Variables:

```env
# Google Sheets (if using)
GOOGLE_APPLICATION_CREDENTIALS=/path/to/credentials.json

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525

# Queue (for background jobs)
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

## ✅ Deployment Checklist

- [ ] PostgreSQL database added
- [ ] Environment variables set
- [ ] APP_KEY generated
- [ ] Database variables configured
- [ ] Code pushed to GitHub
- [ ] Deployment successful
- [ ] Migrations ran successfully
- [ ] Can access the application
- [ ] Can login with admin credentials
- [ ] All features working

---

## 🎉 Success!

Your application should now be live at:
```
https://your-app.railway.app
```

### Default Login:
- **Email:** admin@example.com
- **Password:** password

⚠️ **Important:** Change the default password immediately!

---

## 📞 Need Help?

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- GitHub Issues: https://github.com/RanaZeshan/jobtracker/issues

---

**Happy Deploying! 🚀**
