#!/bin/bash

echo "=========================================="
echo "🔍 Network Connection Test"
echo "=========================================="
echo ""

# Get laptop IP
LAPTOP_IP=$(ipconfig getifaddr en0 || ipconfig getifaddr en1 || hostname -I | awk '{print $1}')

echo "📍 Laptop IP Address: $LAPTOP_IP"
echo "🌐 Network: 192.168.100.x"
echo ""

# Check if server is running
echo "🔎 Checking if Laravel server is running..."
if lsof -i :8000 > /dev/null 2>&1; then
    echo "✅ Server is running on port 8000"
    lsof -i :8000 | grep LISTEN
else
    echo "❌ Server is NOT running on port 8000"
    echo "   Run: ./start-network-server.sh"
fi
echo ""

# Check network interface
echo "🔌 Network Interface Status:"
ifconfig en0 | grep "status:" || echo "   WiFi interface not found"
echo ""

# Show access URLs
echo "=========================================="
echo "📱 Access URLs:"
echo "=========================================="
echo ""
echo "From Laptop (this device):"
echo "  • http://localhost:8000"
echo "  • http://$LAPTOP_IP:8000"
echo ""
echo "From Desktop (wired connection):"
echo "  • http://$LAPTOP_IP:8000"
echo ""
echo "From Mobile/Tablet (same WiFi):"
echo "  • http://$LAPTOP_IP:8000"
echo ""

# Firewall check
echo "=========================================="
echo "🔥 Firewall Status:"
echo "=========================================="
FIREWALL_STATUS=$(sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate 2>/dev/null)
if [ $? -eq 0 ]; then
    echo "$FIREWALL_STATUS"
    echo ""
    echo "⚠️  If firewall is enabled and blocking connections:"
    echo "   sudo /usr/libexec/ApplicationFirewall/socketfilterfw --add /usr/bin/php"
    echo "   sudo /usr/libexec/ApplicationFirewall/socketfilterfw --unblockapp /usr/bin/php"
else
    echo "Unable to check firewall status (requires sudo)"
fi
echo ""

# Instructions for desktop
echo "=========================================="
echo "🖥️  On Your Desktop Computer:"
echo "=========================================="
echo ""
echo "1. Check desktop IP address:"
echo "   Windows: ipconfig"
echo "   macOS:   ifconfig"
echo "   Linux:   ip addr show"
echo ""
echo "2. Verify same network (should be 192.168.100.x)"
echo ""
echo "3. Test connectivity:"
echo "   ping $LAPTOP_IP"
echo ""
echo "4. Open browser and go to:"
echo "   http://$LAPTOP_IP:8000"
echo ""

echo "=========================================="
echo "✅ Test Complete!"
echo "=========================================="
