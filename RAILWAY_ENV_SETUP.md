# 🚂 Railway Environment Setup - CRITICAL

## ⚠️ IMPORTANT: Database Configuration

Railway is using **SQLite** instead of **PostgreSQL**. This MUST be fixed!

---

## ✅ Step-by-Step Fix

### Step 1: Add PostgreSQL Database

1. Go to your Railway project dashboard
2. Click **"New"** button
3. Select **"Database"**
4. Choose **"Add PostgreSQL"**
5. Wait for it to provision (30 seconds)

### Step 2: Link Database to Your Service

Railway should automatically link the database. Verify:

1. Go to your **app service** (not the database)
2. Click **"Variables"** tab
3. You should see these variables (auto-added by Railway):
   ```
   DATABASE_URL
   PGHOST
   PGPORT
   PGDATABASE
   PGUSER
   PGPASSWORD
   ```

If you DON'T see these variables, manually link:
1. Go to your app service
2. Click **"Settings"**
3. Scroll to **"Service Variables"**
4. Click **"New Variable"** → **"Add Reference"**
5. Select your PostgreSQL database
6. Select all PG* variables

### Step 3: Set Required Environment Variables

In your app service → **Variables**, add these:

```env
# Application
APP_NAME=JobTracker
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

# CRITICAL: Force PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Step 4: Generate APP_KEY

**Option A: Using Railway CLI**
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link to your project
railway link

# Generate key
railway run php artisan key:generate --show
```

**Option B: Using Deployment Logs**
1. Wait for deployment to complete
2. Go to **Deployments** → Latest deployment
3. Click **"View Logs"**
4. In the logs, find the command output or run:
   ```bash
   php artisan key:generate --show
   ```
5. Copy the key (e.g., `base64:xxxxx...`)

**Option C: Generate Locally**
```bash
# On your local machine
php artisan key:generate --show
```

Then add to Railway Variables:
```env
APP_KEY=base64:your-generated-key-here
```

### Step 5: Verify Database Connection

After setting variables, redeploy:

1. Go to **Deployments**
2. Click **"Redeploy"** or push to GitHub
3. Watch the logs for:
   ```
   Running migrations...
   Migrated: 0001_01_01_000000_create_users_table
   Migrated: 0001_01_01_000001_create_cache_table
   ...
   ```

---

## 🔍 Troubleshooting

### Issue: Still Using SQLite

**Check 1: Verify PostgreSQL is added**
- Go to your project
- You should see TWO services:
  1. Your app (e.g., "jobtracker")
  2. PostgreSQL database

**Check 2: Verify variables are set**
```bash
# In Railway terminal or logs
echo $DB_CONNECTION  # Should be: pgsql
echo $PGHOST         # Should be: postgres hostname
```

**Check 3: Clear config cache**
```bash
# In Railway terminal
php artisan config:clear
php artisan cache:clear
```

### Issue: "No such table" Errors

**Solution:** Run migrations manually

1. Go to your service
2. Open **Terminal** (if available) or use deployment logs
3. Run:
   ```bash
   php artisan migrate:fresh --force
   ```

### Issue: "Connection refused"

**Solution:** Database not linked properly

1. Delete all PG* variables from your app
2. Go to Settings → Service Variables
3. Re-link the PostgreSQL database
4. Redeploy

---

## 📋 Complete Variable List

Copy this to your Railway Variables (replace values):

```env
# Application
APP_NAME=JobTracker
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

# Database - Use Railway References
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}

# Alternative: Use DATABASE_URL
# DATABASE_URL=${{DATABASE_URL}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
LOG_DEPRECATIONS_CHANNEL=null

# Broadcasting
BROADCAST_DRIVER=log

# Mail (Optional - configure later)
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## ✅ Verification Checklist

- [ ] PostgreSQL database added to project
- [ ] Database linked to app service
- [ ] All PG* variables visible in app
- [ ] DB_CONNECTION set to "pgsql"
- [ ] APP_KEY generated and set
- [ ] APP_URL set correctly
- [ ] Deployment successful
- [ ] Migrations ran without errors
- [ ] Can access the application
- [ ] Can login successfully

---

## 🎯 Quick Test

After deployment, test the database:

1. Visit your app URL
2. Try to register a new user
3. Try to login
4. Check if data persists after refresh

If everything works, PostgreSQL is configured correctly!

---

## 📞 Still Having Issues?

### Check Logs:
1. Go to **Deployments**
2. Click latest deployment
3. Click **"View Logs"**
4. Look for database connection errors

### Common Log Messages:

**Good:**
```
INFO  Running migrations.
Migrated: 0001_01_01_000000_create_users_table
```

**Bad:**
```
SQLSTATE[HY000]: General error: 1 no such table
Connection: sqlite
```

If you see "sqlite" in logs, PostgreSQL is NOT configured!

---

## 🔄 Nuclear Option: Start Fresh

If nothing works:

1. **Delete the service** (not the database)
2. **Create new service** from GitHub
3. **Link PostgreSQL** immediately
4. **Set all variables** before first deployment
5. **Deploy**

---

**Follow these steps carefully and your app will use PostgreSQL! 🎉**
