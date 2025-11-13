# 🌐 Local Network Access Setup

Your Laravel application is now configured to be accessible on your local network!

## 📍 Your Network Information

- **Local IP Address:** `192.168.100.16`
- **Access URL:** `http://192.168.100.16:8000`

## 🚀 How to Start the Server

### Option 1: Using the Script (Recommended)
```bash
./start-network-server.sh
```

### Option 2: Manual Command
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 📱 Accessing from Other Devices

Once the server is running, you can access your application from any device on the same network:

### From Your Computer:
- `http://localhost:8000`
- `http://192.168.100.16:8000`

### From Other Devices (Phone, Tablet, Other Computers):
- `http://192.168.100.16:8000`

## 🔧 Configuration Changes Made

1. **Updated `.env` file:**
   ```
   APP_URL=http://192.168.100.16:8000
   ```

2. **Server binding:**
   - Server now listens on `0.0.0.0` (all network interfaces)
   - Port: `8000`

## ⚠️ Important Notes

### Firewall Settings
Make sure your firewall allows incoming connections on port 8000:

**macOS:**
```bash
# Check if firewall is blocking
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate

# Allow PHP through firewall (if needed)
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --add /usr/bin/php
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --unblockapp /usr/bin/php
```

### Network Requirements
- All devices must be on the **same WiFi network**
- Your router must allow local network communication
- Some corporate/public WiFi networks may block device-to-device communication

### Security Considerations
- ⚠️ This setup is for **local development only**
- Do NOT use this configuration in production
- The server is accessible to anyone on your local network
- Consider using a VPN or secure network for sensitive data

## 🧪 Testing the Connection

### 1. Start the Server
```bash
./start-network-server.sh
```

### 2. Test from Your Computer
Open browser and go to:
```
http://192.168.100.16:8000
```

### 3. Test from Mobile Device
1. Connect your phone to the same WiFi network
2. Open browser on your phone
3. Navigate to: `http://192.168.100.16:8000`

### 4. Verify Server is Running
You should see output like:
```
   INFO  Server running on [http://0.0.0.0:8000].  

  Press Ctrl+C to stop the server
```

## 🔍 Troubleshooting

### Can't Access from Other Devices?

**1. Check if server is running:**
```bash
# Should show php artisan serve process
ps aux | grep "artisan serve"
```

**2. Check if port is open:**
```bash
# Should show port 8000 listening
lsof -i :8000
```

**3. Test network connectivity:**
```bash
# From another device, ping your computer
ping 192.168.100.16
```

**4. Check firewall:**
```bash
# Temporarily disable firewall to test (macOS)
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --setglobalstate off

# Re-enable after testing
sudo /usr/libexec/ApplicationFirewall/socketfilterfw --setglobalstate on
```

**5. Verify IP address hasn't changed:**
```bash
# Get current IP
ipconfig getifaddr en0
```

### Common Issues

| Issue | Solution |
|-------|----------|
| Connection refused | Check firewall settings |
| Can't find server | Verify both devices on same WiFi |
| IP changed | Restart server with new IP |
| Slow loading | Check network speed/congestion |
| Assets not loading | Clear browser cache |

## 🔄 If Your IP Address Changes

If your computer's IP address changes (e.g., after reconnecting to WiFi):

1. **Find new IP:**
   ```bash
   ipconfig getifaddr en0
   ```

2. **Update `.env` file:**
   ```
   APP_URL=http://[NEW_IP]:8000
   ```

3. **Clear config cache:**
   ```bash
   php artisan config:clear
   ```

4. **Restart server:**
   ```bash
   ./start-network-server.sh
   ```

## 📊 Server Information

When the server starts, you'll see:
```
==========================================
🚀 Starting Laravel Server on Local Network
==========================================

📍 Your Local IP: 192.168.100.16
🌐 Access URL: http://192.168.100.16:8000

📱 Other devices on your network can access:
   http://192.168.100.16:8000

⚠️  Make sure your firewall allows connections on port 8000

Press Ctrl+C to stop the server
==========================================

   INFO  Server running on [http://0.0.0.0:8000].
```

## 🛑 Stopping the Server

Press `Ctrl+C` in the terminal where the server is running.

## 🔐 Security Best Practices

1. **Only use on trusted networks** (home/office WiFi)
2. **Don't expose sensitive data** during testing
3. **Use strong passwords** for all accounts
4. **Keep APP_DEBUG=true** only in development
5. **Never use this setup in production**

## 📝 Additional Commands

### View all network interfaces:
```bash
ifconfig
```

### Check which process is using port 8000:
```bash
lsof -i :8000
```

### Kill process on port 8000 (if needed):
```bash
kill -9 $(lsof -t -i:8000)
```

### Test if port is accessible:
```bash
nc -zv 192.168.100.16 8000
```

## ✅ Quick Start Checklist

- [ ] Server script created (`start-network-server.sh`)
- [ ] `.env` file updated with network IP
- [ ] Config cache cleared
- [ ] Firewall configured (if needed)
- [ ] Server started successfully
- [ ] Tested access from computer
- [ ] Tested access from mobile device
- [ ] All devices on same WiFi network

## 🎉 You're All Set!

Your Laravel application is now accessible on your local network. Share the URL with your team members or test on multiple devices!

**Access URL:** `http://192.168.100.16:8000`

---

**Need help?** Check the troubleshooting section above or restart the server.
