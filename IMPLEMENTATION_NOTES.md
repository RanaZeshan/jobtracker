# Application Limit Feature Implementation

## Overview
Added functionality for admins to set application limits per team member for each assigned client. Team members cannot exceed these limits when submitting applications.

## Changes Made

### 1. Database Migration
- **File**: `database/migrations/2025_11_12_140000_add_application_limit_to_tasks_table.php`
- Added `application_limit` column to `tasks` table (nullable integer)

### 2. Model Update
- **File**: `app/Models/Task.php`
- Added `application_limit` to `$fillable` array

### 3. Task Controller
- **File**: `app/Http/Controllers/TaskController.php`
- Added validation for `application_limit` field (nullable, min: 1)
- Included `application_limit` when creating tasks

### 4. Team Application Controller
- **File**: `app/Http/Controllers/TeamApplicationController.php`
- Added limit check in `store()` method before creating applications
- Validates current application count against the limit
- Returns error message if limit is reached

### 5. Admin Dashboard View
- **File**: `resources/views/admin/dashboard.blade.php`
- Added "Application Limit" input field in the assign client modal
- Includes helpful text explaining the limit purpose

### 6. Team Dashboard View
- **File**: `resources/views/team/dashboard.blade.php`
- Added "Limit" column showing current count vs limit (e.g., "5/10")
- Badge turns red when limit is reached
- "Add" button is disabled when limit is reached
- Shows "—" when no limit is set

### 7. Team Application Create View
- **File**: `resources/views/team/applications/create.blade.php`
- Shows danger alert when limit is reached
- Shows warning alert when approaching limit (within 2 applications)
- Displays current count and maximum limit

## How It Works

1. **Admin sets limit**: When assigning a client to a team member, admin can optionally set an application limit
2. **Team member sees limit**: In their dashboard, they see current count vs limit for each client
3. **Validation on submit**: When submitting a new application, the system checks if the limit has been reached
4. **Visual feedback**: Limits are color-coded (yellow warning when close, red when reached)
5. **Disabled actions**: "Add" button is disabled when limit is reached

## Usage Example

1. Admin assigns Client A to Team Member John with limit of 50 applications
2. John sees "0/50" in his dashboard
3. As John submits applications, the count updates: "25/50", "49/50"
4. When John reaches 48 applications, he sees a warning: "Approaching Limit"
5. At 50 applications, the badge turns red and the "Add" button is disabled
6. If John tries to submit anyway, he gets an error message

## Notes

- Limit is optional (nullable) - if not set, team members can submit unlimited applications
- Limit is per team member per client (different team members can have different limits for the same client)
- The limit check happens server-side for security
- Visual indicators help team members track their progress

---

# Pause/Resume Applications Feature

## Overview
Added functionality for admins to pause and resume applications for specific clients. When paused, team members cannot add new applications for that client until the admin resumes it.

## Changes Made

### 1. Database Migration
- **File**: `database/migrations/2025_11_12_150000_add_application_status_to_clients_table.php`
- Added `application_status` enum column to `clients` table ('active' or 'paused', default: 'active')

### 2. Model Update
- **File**: `app/Models/Client.php`
- Added `application_status` to `$fillable` array

### 3. Client Controller
- **File**: `app/Http/Controllers/ClientController.php`
- Added `pause()` method to set client status to 'paused'
- Added `resume()` method to set client status to 'active'
- Both methods redirect back with success messages

### 4. Routes
- **File**: `routes/web.php`
- Added POST route: `/admin/clients/{client}/pause`
- Added POST route: `/admin/clients/{client}/resume`

### 5. Team Application Controller
- **File**: `app/Http/Controllers/TeamApplicationController.php`
- Added validation check in `store()` method to prevent submissions when client is paused
- Returns error message if team member tries to submit for a paused client

### 6. Admin Dashboard View
- **File**: `resources/views/admin/dashboard.blade.php`
- Added "Status" column showing Active/Paused badge
- Added Pause/Resume toggle button (yellow pause icon or green play icon)
- Button changes based on current status

### 7. Team Dashboard View
- **File**: `resources/views/team/dashboard.blade.php`
- Status column shows "Paused" badge when client is paused
- "Add" button is disabled when client is paused
- Tooltip shows "Applications paused by admin"

### 8. Team Application Create View
- **File**: `resources/views/team/applications/create.blade.php`
- Shows danger alert when client is paused
- Submit button is disabled when client is paused
- Alert message: "The admin has paused applications for this client"

## How It Works

1. **Admin pauses client**: Clicks pause button on admin dashboard
2. **Status changes**: Client's `application_status` changes to 'paused'
3. **Team members see status**: Dashboard shows "Paused" badge and disabled "Add" button
4. **Validation blocks submissions**: If team member tries to submit, they get an error
5. **Admin resumes**: Clicks resume button to allow applications again
6. **Status restored**: Client's `application_status` changes back to 'active'

## Usage Example

1. Admin sees Client A has too many applications and wants to pause temporarily
2. Admin clicks the pause button (⏸️) next to Client A
3. All team members assigned to Client A see "Paused" status
4. Team members cannot add new applications (button disabled, form blocked)
5. When ready, admin clicks resume button (▶️)
6. Team members can now add applications again

## Visual Indicators

- **Admin Dashboard**: Yellow pause button / Green play button
- **Team Dashboard**: Yellow "Paused" badge, disabled "Add" button
- **Application Form**: Red danger alert, disabled submit button
- **Status Column**: Green "Active" badge / Yellow "Paused" badge

## Security

- Validation happens server-side in the controller
- Even if someone bypasses the UI, the backend will reject paused client submissions
- Only admins can pause/resume clients
