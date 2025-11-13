#!/bin/bash

# Get local IP address
LOCAL_IP=$(ipconfig getifaddr en0 || ipconfig getifaddr en1 || hostname -I | awk '{print $1}')

echo "=========================================="
echo "🚀 Starting Laravel Server on Local Network"
echo "=========================================="
echo ""
echo "📍 Your Local IP: $LOCAL_IP"
echo "🌐 Access URL: http://$LOCAL_IP:8000"
echo ""
echo "📱 Other devices on your network can access:"
echo "   http://$LOCAL_IP:8000"
echo ""
echo "⚠️  Make sure your firewall allows connections on port 8000"
echo ""
echo "Press Ctrl+C to stop the server"
echo "=========================================="
echo ""

# Start Laravel server on all network interfaces
php artisan serve --host=0.0.0.0 --port=8000
