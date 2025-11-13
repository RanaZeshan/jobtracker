# 🚀 JobTracker - Job Application Management System

A comprehensive Laravel-based application for managing job applications, team members, and client relationships. Built with modern UI/UX and powerful features for tracking job applications at scale.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## ✨ Features

### 👨‍💼 Admin Dashboard
- **Client Management** - Create, edit, and manage clients with Google Sheets integration
- **Team Management** - Assign tasks to team members with application limits
- **Application Tracking** - Monitor all applications across clients and team members
- **Earnings Reports** - Comprehensive earnings tracking with charts and analytics
- **Real-time Activity** - Live feed of recent applications and team activity
- **Pause/Resume Controls** - Manage application flow for clients and tasks

### 👥 Team Member Dashboard
- **Personal Dashboard** - View assigned clients and application targets
- **Application Submission** - Submit applications with resume upload
- **Earnings Tracking** - View personal earnings and performance metrics
- **Daily Summary** - Track daily progress and achievements
- **Profile Management** - Update profile picture and password

### 🎨 Modern UI/UX
- **Gradient Designs** - Beautiful purple gradient theme throughout
- **Responsive Layout** - Works on desktop, tablet, and mobile
- **Interactive Cards** - Hover effects and smooth animations
- **Real-time Updates** - Live notifications and activity feed
- **Bootstrap Icons** - Comprehensive icon library
- **Alpine.js** - Reactive components and dropdowns

### 🔐 Security Features
- **Role-based Access** - Admin and Team member roles
- **Profile Picture Upload** - Automatic image resizing (300x300px)
- **Password Protection** - Secure authentication
- **Team Member Restrictions** - Limited profile editing for team members

### 📊 Reporting & Analytics
- **Earnings Dashboard** - Track earnings by team member and client
- **Performance Metrics** - Applications, tailored CVs, and averages
- **6-Month Trends** - Visual charts showing performance over time
- **Client Breakdown** - Detailed earnings per client
- **Date Range Filters** - Custom date range selection

### 🔗 Integrations
- **Google Sheets API** - Automatic sync of applications to client sheets
- **File Storage** - Resume and profile picture management
- **Local Assets** - All CSS/JS assets served locally (no CDN dependencies)

## 🛠️ Tech Stack

- **Backend:** Laravel 11.x
- **Frontend:** Blade Templates, Alpine.js, Bootstrap 5.3.3
- **Database:** MySQL/SQLite
- **Authentication:** Laravel Breeze
- **Image Processing:** Intervention Image
- **Icons:** Bootstrap Icons 1.11.3
- **Styling:** Custom CSS with gradients and animations

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or SQLite
- Git

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/jobtracker.git
cd jobtracker
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

### 4. Database Setup

```bash
# Update .env with your database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobtracker
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed admin user (optional)
php artisan db:seed --class=AdminUserSeeder
```

### 5. Build Assets

```bash
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🌐 Local Network Access

To access the application from other devices on your network:

```bash
# Start server on all network interfaces
./start-network-server.sh

# Or manually
php artisan serve --host=0.0.0.0 --port=8000
```

Access from other devices: `http://YOUR_IP:8000`

See `LOCAL_NETWORK_SETUP.md` for detailed instructions.

## 👤 Default Credentials

After running the seeder:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Team Member Account:**
- Email: `team@example.com`
- Password: `password`

⚠️ **Change these credentials immediately in production!**

## 📁 Project Structure

```
jobtracker/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic services
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   └── vendor/               # Local CSS/JS assets
├── resources/
│   ├── views/                # Blade templates
│   │   ├── admin/           # Admin views
│   │   ├── team/            # Team member views
│   │   └── layouts/         # Layout templates
│   └── css/                  # Custom styles
├── routes/
│   └── web.php              # Application routes
└── storage/
    └── app/public/          # Uploaded files
```

## 🎯 Key Features Explained

### Application Management
- Submit applications with job details
- Upload resumes (PDF, DOC, DOCX)
- Track application status
- Automatic Google Sheets sync
- Earnings calculation

### Client Management
- Create clients with Google Sheet URLs
- Assign to team members
- Set application limits
- Pause/resume applications
- Track progress

### Team Management
- Create team member accounts
- Assign multiple clients
- Set individual targets
- Monitor performance
- Track earnings

### Earnings System
- Configurable rates per application
- Bonus for tailored resumes
- Automatic calculation
- Detailed reports
- Date range filtering

## 🔧 Configuration

### Google Sheets Integration

1. Create a Google Cloud Project
2. Enable Google Sheets API
3. Create service account credentials
4. Download JSON key file
5. Add to `.env`:

```env
GOOGLE_APPLICATION_CREDENTIALS=/path/to/credentials.json
```

### Currency Settings

Update currency symbol in views (currently set to Rs.):
- `resources/views/admin/earnings/`
- `resources/views/team/earnings/`

### Profile Pictures

Images are automatically resized to 300x300px and stored in:
```
storage/app/public/profile-pictures/
```

## 📚 Documentation

- `LOCAL_NETWORK_SETUP.md` - Network access guide
- `WIFI_TO_WIRED_NETWORK_SETUP.md` - WiFi to Ethernet setup
- `ADMIN_DASHBOARD_REDESIGN.md` - Dashboard features
- `TEAM_EARNINGS_FEATURE.md` - Earnings system
- `RESUME_COLUMN_FEATURE.md` - Resume management

## 🐛 Troubleshooting

### Common Issues

**1. Storage Link Error**
```bash
php artisan storage:link
```

**2. Permission Issues**
```bash
chmod -R 775 storage bootstrap/cache
```

**3. Database Connection**
- Check `.env` database credentials
- Ensure database exists
- Run migrations

**4. Assets Not Loading**
```bash
npm run build
php artisan view:clear
php artisan config:clear
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap Team
- Alpine.js
- Intervention Image
- All contributors

## 📞 Support

For support, email your.email@example.com or open an issue on GitHub.

## 🔄 Updates

### Version 1.0.0 (Current)
- Initial release
- Admin and team dashboards
- Application management
- Earnings tracking
- Profile picture upload
- Local network access
- Google Sheets integration

---

**Made with ❤️ using Laravel**
