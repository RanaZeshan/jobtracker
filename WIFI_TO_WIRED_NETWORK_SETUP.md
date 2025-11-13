# 🌐 WiFi to Wired Network Access Guide

## 📍 Your Network Setup

**Laptop (WiFi - Running Laravel):**
- IP Address: `192.168.100.16`
- Network: `192.168.100.x`
- Connection: WiFi

**Desktop Computer (Wired):**
- Should be on same network: `192.168.100.x`
- Connection: Ethernet Cable

## ✅ Both devices are on the SAME network!

Since both WiFi and Ethernet are connected to the same router, they're on the same local network and can communicate with each other.

---

## 🚀 Step-by-Step Setup

### Step 1: Start the Server on Your Laptop

On your **laptop** (where the project is), run:

```bash
./start-network-server.sh
```

Or manually:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

You should see:
```
   INFO  Server running on [http://0.0.0.0:8000].
```

### Step 2: Find Your Desktop's IP Address

On your **desktop computer**, find its IP address:

**Windows:**
```cmd
ipconfig
```
Look for "IPv4 Address" under your Ethernet adapter. It should be something like `192.168.100.x`

**macOS/Linux:**
```bash
ifconfig
# or
ip addr show
```

### Step 3: Access from Desktop Computer

On your **desktop computer**, open a web browser and go to:

```
http://192.168.100.16:8000
```

That's it! You should see your Laravel application.

---

## 🔍 Verification Steps

### On Your Laptop (Server):

1. **Check if server is running:**
   ```bash
   lsof -i :8000
   ```
   Should show PHP listening on port 8000

2. **Verify your laptop's IP:**
   ```bash
   ifconfig en0 | grep "inet "
   ```
   Should show: `192.168.100.16`

3. **Test locally:**
   Open browser on laptop: `http://192.168.100.16:8000`

### On Your Desktop (Client):

1. **Check your desktop's IP:**
   ```cmd
   ipconfig    (Windows)
   ifconfig    (macOS/Linux)
   ```
   Should be on same network: `192.168.100.x`

2. **Ping the laptop:**
   ```cmd
   ping 192.168.100.16
   ```
   Should get replies (not timeouts)

3. **Test port connectivity:**
   ```cmd
   telnet 192.168.100.16 8000
   ```
   Or use browser: `http://192.168.100.16:8000`

---

## 🛠️ Troubleshooting

### Problem: Can't Access from Desktop

#### Solution 1: Check Firewall on Laptop

**macOS Laptop:**
```bash
# Check firewall status
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate

# Allow PHP through firewall
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --add /usr/bin/php
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --unblockapp /usr/bin/php

# Or temporarily disable firewall for testing
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --setglobalstate off
```

**Windows Laptop:**
1. Open Windows Defender Firewall
2. Click "Allow an app through firewall"
3. Add PHP or allow port 8000

**Linux Laptop:**
```bash
# UFW
sudo ufw allow 8000

# iptables
sudo iptables -A INPUT -p tcp --dport 8000 -j ACCEPT
```

#### Solution 2: Verify Network Connection

**Test connectivity from desktop:**
```cmd
ping 192.168.100.16
```

If ping fails:
- Check if both devices are connected to the same router
- Check router settings (some routers isolate WiFi from Ethernet)
- Try connecting desktop to WiFi temporarily to test

#### Solution 3: Check Server Binding

Make sure server is listening on `0.0.0.0` (all interfaces), not just `127.0.0.1`:

```bash
# On laptop, check what the server is bound to
lsof -i :8000

# Should show:
# php ... *:8000 (LISTEN)
# NOT: php ... localhost:8000 (LISTEN)
```

If it shows `localhost:8000`, restart with:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

#### Solution 4: Router Configuration

Some routers have "AP Isolation" or "Client Isolation" enabled:

1. Access your router admin panel (usually `192.168.100.1` or `192.168.1.1`)
2. Look for settings like:
   - AP Isolation
   - Client Isolation
   - Wireless Isolation
3. Make sure these are **DISABLED**

---

## 📊 Network Diagram

```
                    Router (192.168.100.1)
                           |
                           |
        +------------------+------------------+
        |                                     |
    WiFi (Laptop)                      Ethernet (Desktop)
  192.168.100.16                       192.168.100.x
  [Laravel Server]                     [Browser Client]
  Port: 8000                           Access: http://192.168.100.16:8000
```

---

## 🔐 Security Notes

### For Development Network:

✅ **Safe to use:**
- Home network with trusted devices
- Office network with firewall
- Private network

⚠️ **Be careful:**
- Public WiFi (coffee shops, airports)
- Shared networks with unknown users
- Networks without password protection

### Best Practices:

1. **Use strong passwords** for all accounts
2. **Keep APP_DEBUG=true** only in development
3. **Don't expose sensitive data** during testing
4. **Use HTTPS** in production (not needed for local dev)
5. **Disable server** when not in use

---

## 🎯 Quick Access URLs

### From Laptop (Server):
- `http://localhost:8000` ✅
- `http://127.0.0.1:8000` ✅
- `http://192.168.100.16:8000` ✅

### From Desktop (Client):
- `http://192.168.100.16:8000` ✅

### From Mobile/Tablet (on same WiFi):
- `http://192.168.100.16:8000` ✅

---

## 📱 Testing from Multiple Devices

You can access the application from:

1. **Laptop** (where server runs)
2. **Desktop** (wired connection)
3. **Phone** (connected to same WiFi)
4. **Tablet** (connected to same WiFi)
5. **Other computers** (on same network)

All devices must use: `http://192.168.100.16:8000`

---

## 🔄 Common Scenarios

### Scenario 1: Desktop Can't Connect

**Check:**
1. Is server running on laptop? → `lsof -i :8000`
2. Can desktop ping laptop? → `ping 192.168.100.16`
3. Is firewall blocking? → Temporarily disable to test
4. Is router isolating devices? → Check router settings

### Scenario 2: Slow Connection

**Solutions:**
1. Check WiFi signal strength on laptop
2. Check network congestion
3. Close unnecessary applications
4. Restart router if needed

### Scenario 3: Connection Drops

**Solutions:**
1. Keep laptop plugged in (prevent sleep)
2. Disable laptop sleep mode
3. Check WiFi stability
4. Use wired connection for laptop if possible

---

## ⚙️ Advanced Configuration

### Use Different Port

If port 8000 is busy:

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

Then access: `http://192.168.100.16:8080`

### Multiple Projects

Run different projects on different ports:

```bash
# Project 1
php artisan serve --host=0.0.0.0 --port=8000

# Project 2
php artisan serve --host=0.0.0.0 --port=8001

# Project 3
php artisan serve --host=0.0.0.0 --port=8002
```

### Keep Server Running

Use `screen` or `tmux` to keep server running:

```bash
# Install screen (if not installed)
brew install screen  # macOS
apt install screen   # Linux

# Start screen session
screen -S laravel

# Run server
php artisan serve --host=0.0.0.0 --port=8000

# Detach: Press Ctrl+A then D
# Reattach: screen -r laravel
```

---

## 📋 Checklist

Before accessing from desktop:

- [ ] Server running on laptop (`./start-network-server.sh`)
- [ ] Laptop IP is `192.168.100.16`
- [ ] Desktop is on same network (`192.168.100.x`)
- [ ] Firewall allows port 8000
- [ ] Can ping laptop from desktop
- [ ] Router not isolating devices
- [ ] Browser on desktop ready

---

## 🎉 Success Indicators

You'll know it's working when:

✅ Server shows: `Server running on [http://0.0.0.0:8000]`
✅ Ping from desktop succeeds
✅ Browser loads the Laravel welcome page
✅ You can login and use the application
✅ All assets (CSS, JS, images) load properly

---

## 📞 Quick Commands Reference

### On Laptop (Server):

```bash
# Start server
./start-network-server.sh

# Check server status
lsof -i :8000

# Check IP address
ifconfig en0 | grep "inet "

# Stop server
# Press Ctrl+C in terminal
```

### On Desktop (Client):

```bash
# Check IP address
ipconfig              # Windows
ifconfig              # macOS/Linux

# Test connectivity
ping 192.168.100.16

# Test port
telnet 192.168.100.16 8000
```

---

## 🌟 Pro Tips

1. **Bookmark the URL** on desktop: `http://192.168.100.16:8000`
2. **Keep laptop plugged in** to prevent sleep
3. **Use static IP** for laptop (optional, in router settings)
4. **Monitor server logs** in terminal for debugging
5. **Clear browser cache** if assets don't load

---

## 📖 Related Documentation

- `LOCAL_NETWORK_SETUP.md` - General network setup guide
- `start-network-server.sh` - Server startup script
- `.env` - Configuration file (APP_URL updated)

---

**Need Help?**

If you're still having issues:
1. Check the troubleshooting section above
2. Verify both devices are on `192.168.100.x` network
3. Temporarily disable firewalls to test
4. Check router settings for device isolation

**Your setup is ready! Just start the server and access from your desktop.** 🚀
