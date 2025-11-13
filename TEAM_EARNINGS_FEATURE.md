# Team Earnings Feature

## Overview
Added comprehensive earnings tracking functionality for admins to view individual team member performance and earnings by month.

## Features Implemented

### 1. Earnings Overview Page
**Route:** `/admin/earnings`

**Features:**
- View all team members' earnings for a selected month
- Month selector to filter data
- Ranking system with medals (🥇🥈🥉)
- Color-coded rank badges (gold, silver, bronze)
- Sortable by earnings (highest first)

**Metrics Displayed:**
- Total earnings per team member
- Number of applications submitted
- Number of tailored CVs
- Average earning per application

**Design:**
- Purple gradient header
- Hover effects on cards
- Rank badges in top-right corner
- "View Details" button for each member
- Empty state for months with no data

### 2. Individual Team Member Details Page
**Route:** `/admin/earnings/{user}`

**Features:**
- Detailed breakdown for a specific team member
- Month selector to view different periods
- 6-month trend chart (Chart.js)
- Earnings by client breakdown
- Complete list of all applications for the month
- All-time performance statistics

**Metrics Displayed:**
- Total earnings (current month)
- Total applications (current month)
- Tailored CVs count and percentage
- Average earning per application
- Earnings by client (table)
- All applications with details
- All-time totals

**Chart:**
- Dual-axis line chart
- Earnings (green line, left axis)
- Applications (blue line, right axis)
- Last 6 months of data
- Interactive tooltips

### 3. Admin Dashboard Integration
- Added "View Team Earnings" button in header
- Quick access to earnings overview
- Prominent placement for easy discovery

## Technical Implementation

### Controller: `TeamEarningsController`

**Methods:**
1. `index()` - Overview of all team members
   - Fetches all team members
   - Calculates earnings for selected month
   - Sorts by earnings (descending)
   - Returns data to view

2. `show(User $user)` - Individual member details
   - Validates user is a team member
   - Fetches applications for selected month
   - Calculates various metrics
   - Groups earnings by client
   - Generates 6-month historical data
   - Returns comprehensive data to view

### Routes Added
```php
Route::get('/admin/earnings', [TeamEarningsController::class, 'index'])
    ->name('admin.earnings.index');
    
Route::get('/admin/earnings/{user}', [TeamEarningsController::class, 'show'])
    ->name('admin.earnings.show');
```

### Views Created

1. **`resources/views/admin/earnings/index.blade.php`**
   - Overview page with all team members
   - Ranking cards with stats
   - Month selector
   - Responsive grid layout

2. **`resources/views/admin/earnings/show.blade.php`**
   - Detailed individual page
   - KPI cards (4 metrics)
   - Chart.js integration
   - Multiple data tables
   - All-time statistics

## Design Features

### Color Scheme
- **Primary:** Green gradient (#10b981 to #059669)
- **Rank Badges:**
  - Gold: #ffd700 to #ffed4e
  - Silver: #c0c0c0 to #e8e8e8
  - Bronze: #cd7f32 to #e6a85c
  - Default: #f0f0f0

### Visual Elements
- Gradient headers with animated circles
- Floating KPI cards with hover effects
- Modern tables with hover states
- Rank badges with emojis
- Month selector with backdrop blur
- Smooth transitions (0.3s ease)

### Typography
- Headers: 2.5rem, weight 800
- KPI values: 2.5rem, weight 800
- Labels: 0.85rem, uppercase
- Consistent spacing throughout

## Data Calculations

### Earnings Metrics
- **Total Earnings:** Sum of all application earnings
- **Total Applications:** Count of applications
- **Tailored Count:** Applications with tailored_resume = true
- **Average Earning:** Total earnings / Total applications

### Filtering
- By month (YYYY-MM format)
- By team member (user_id)
- By client (for breakdown)

### Sorting
- Team members sorted by earnings (descending)
- Clients sorted by earnings (descending)
- Applications sorted by date (descending)

## Chart Implementation

**Library:** Chart.js 4.4.0 (CDN)

**Chart Type:** Line chart with dual Y-axes

**Data:**
- Last 6 months of historical data
- Earnings on left Y-axis (green)
- Applications on right Y-axis (blue)
- Filled area under lines
- Smooth curves (tension: 0.4)

**Interactivity:**
- Hover tooltips
- Legend toggle
- Responsive sizing

## User Experience

### Navigation Flow
1. Admin Dashboard → "View Team Earnings" button
2. Earnings Overview → Select month → View rankings
3. Click "View Details" → Individual member page
4. View charts, tables, and detailed breakdown
5. Change month to compare periods
6. Back buttons for easy navigation

### Empty States
- Friendly messages when no data
- Icon-based empty states
- Clear call-to-action

### Responsive Design
- Grid layouts adapt to screen size
- Tables scroll horizontally on mobile
- Buttons stack on small screens
- Charts resize automatically

## Security

- Routes protected by `auth` middleware
- Admin-only access (in admin prefix group)
- User validation (team role check)
- No direct database queries in views

## Performance

- Efficient queries with eager loading
- Grouped calculations
- Minimal database hits
- Cached month calculations
- Optimized sorting algorithms

## Future Enhancements (Possible)

1. Export to PDF/Excel
2. Email reports
3. Comparison between team members
4. Goal setting and tracking
5. Bonus calculations
6. Performance ratings
7. Year-over-year comparisons
8. Custom date ranges
9. Filtering by client
10. Advanced analytics

## Files Modified/Created

### New Files:
1. `app/Http/Controllers/TeamEarningsController.php`
2. `resources/views/admin/earnings/index.blade.php`
3. `resources/views/admin/earnings/show.blade.php`

### Modified Files:
1. `routes/web.php` - Added earnings routes
2. `resources/views/admin/dashboard.blade.php` - Added earnings button

## Usage

### For Admins:
1. Click "View Team Earnings" on admin dashboard
2. Select month using month picker
3. View rankings and stats for all team members
4. Click "View Details" on any team member
5. Explore detailed breakdown, charts, and tables
6. Change months to compare performance
7. Use data for performance reviews, bonuses, etc.

### Data Insights:
- Identify top performers
- Track monthly trends
- Compare team member productivity
- Analyze earnings by client
- Monitor tailored CV usage
- Calculate average earnings
- Review all-time performance

---

**Status:** ✅ Complete and functional
**Testing:** Ready for use
**Documentation:** Complete
