# Task Pause/Resume Feature

## Overview
Added functionality for admins to pause/resume individual team members from adding applications for specific assigned clients. This provides granular control at the task level (client-team member assignment).

## Features Implemented

### 1. Database Changes
**Migration:** `2025_11_13_160000_add_is_paused_to_tasks_table.php`
- Added `is_paused` boolean column to `tasks` table
- Default value: `false`
- Positioned after `is_active` column

### 2. Model Updates
**File:** `app/Models/Task.php`
- Added `is_paused` to `$fillable` array
- Added `is_paused` to `$casts` array (boolean)

### 3. Controller Methods
**File:** `app/Http/Controllers/TaskController.php`

**New Methods:**
1. `pause(Task $task)` - Pauses a specific task
   - Admin only
   - Sets `is_paused` to `true`
   - Returns success message with team member and client names

2. `resume(Task $task)` - Resumes a paused task
   - Admin only
   - Sets `is_paused` to `false`
   - Returns success message with team member and client names

### 4. Routes Added
**File:** `routes/web.php`
```php
Route::post('/admin/tasks/{task}/pause', [TaskController::class, 'pause'])
    ->name('tasks.pause');
    
Route::post('/admin/tasks/{task}/resume', [TaskController::class, 'resume'])
    ->name('tasks.resume');
```

### 5. Validation Logic
**File:** `app/Http/Controllers/TeamApplicationController.php`

Added check in `store()` method:
- Checks if task is paused before allowing application submission
- Returns error: "You have been paused from adding applications for this client. Please contact the admin."
- Prevents submission even if UI is bypassed

### 6. Admin Dashboard Updates
**File:** `resources/views/admin/dashboard.blade.php`

**New Section: "Task Assignments"**
- Shows all active task assignments
- Displays team member, client, target, completed
- Status badge (Active/Paused)
- Pause/Resume toggle buttons
- Color-coded action buttons:
  - Orange pause button (⏸️)
  - Green play button (▶️)

**Table Columns:**
- Team Member
- Client
- Target (applications)
- Completed (applications)
- Status (Active/Paused badge)
- Actions (Pause/Resume button)

### 7. Team Dashboard Updates
**File:** `resources/views/team/dashboard.blade.php`

**Status Display:**
- Shows "You're Paused" badge when task is paused
- Shows "Client Paused" badge when client is paused
- Distinguishes between task-level and client-level pauses

**Button States:**
- "Add" button disabled when task is paused
- Tooltip: "You have been paused by admin"
- Different tooltip for client-level pause

### 8. Team Application Create Page
**File:** `resources/views/team/applications/create.blade.php`

**Alert Messages:**
- Red danger alert when task is paused
- Message: "You've Been Paused! The admin has paused you from adding applications for this client."
- Separate alert for client-level pause
- Submit button disabled when paused

## How It Works

### Admin Workflow:
1. Admin views "Task Assignments" section on dashboard
2. Sees all active task assignments with status
3. Clicks pause button (⏸️) next to a task
4. Task status changes to "Paused"
5. Team member can no longer add applications for that client
6. Admin can click resume button (▶️) to restore access

### Team Member Experience:
1. Team member sees "You're Paused" status in dashboard
2. "Add" button is disabled with tooltip
3. If they try to access the form, sees red alert
4. Cannot submit applications (form disabled)
5. Server-side validation prevents bypass attempts

## Differences from Client Pause

### Client Pause (Existing):
- Pauses ALL team members for a client
- Set at client level
- Affects everyone assigned to that client
- Use case: Client-wide hold

### Task Pause (New):
- Pauses ONE team member for a client
- Set at task (assignment) level
- Only affects specific team member
- Other team members can still add applications
- Use case: Individual performance issues, temporary restrictions

## Visual Indicators

### Admin Dashboard:
- **Active Status:** Green badge with checkmark
- **Paused Status:** Yellow/orange badge with pause icon
- **Pause Button:** Orange background, pause icon
- **Resume Button:** Green background, play icon

### Team Dashboard:
- **You're Paused:** Yellow badge with pause icon
- **Client Paused:** Yellow badge with pause icon (different text)
- **Disabled Button:** Grayed out with tooltip

### Application Form:
- **Task Paused:** Red danger alert at top
- **Client Paused:** Red danger alert (different message)
- **Disabled Submit:** Button grayed out

## Use Cases

1. **Performance Issues:**
   - Pause team member who needs retraining
   - Other team members continue working

2. **Quality Control:**
   - Pause member with high rejection rate
   - Review and provide feedback
   - Resume when ready

3. **Temporary Restrictions:**
   - Member on vacation/leave
   - Pause their assignments
   - Resume when they return

4. **Client-Specific Issues:**
   - Pause member for one problematic client
   - Keep them active for other clients

5. **Gradual Onboarding:**
   - Pause new members initially
   - Resume assignments gradually

## Security

- Admin-only access to pause/resume
- Server-side validation prevents bypass
- Task ownership verified
- Role-based authorization
- Audit trail via success messages

## Database Schema

```sql
ALTER TABLE tasks ADD COLUMN is_paused BOOLEAN DEFAULT FALSE AFTER is_active;
```

## API Endpoints

**Pause Task:**
- Method: POST
- URL: `/admin/tasks/{task}/pause`
- Auth: Admin only
- Response: Redirect with success message

**Resume Task:**
- Method: POST
- URL: `/admin/tasks/{task}/resume`
- Auth: Admin only
- Response: Redirect with success message

## Error Messages

**Team Member Sees:**
- "You have been paused from adding applications for this client. Please contact the admin."

**Admin Sees:**
- Success: "{Team Member} has been paused from adding applications for {Client}."
- Success: "{Team Member} can now add applications for {Client}."

## Testing Checklist

- [ ] Admin can pause a task
- [ ] Admin can resume a task
- [ ] Team member sees paused status
- [ ] Team member cannot add applications when paused
- [ ] Server-side validation blocks paused submissions
- [ ] Status badges display correctly
- [ ] Buttons toggle between pause/resume
- [ ] Success messages show correct names
- [ ] Other team members unaffected
- [ ] Client-level pause still works
- [ ] Both pauses can coexist
- [ ] Resume restores full functionality

## Future Enhancements (Optional)

1. Pause reason field
2. Pause duration (auto-resume)
3. Pause history/audit log
4. Bulk pause/resume
5. Email notifications
6. Pause notes/comments
7. Scheduled pause/resume
8. Pause statistics
9. Export pause reports
10. Mobile-friendly pause controls

## Files Modified/Created

### New Files:
1. `database/migrations/2025_11_13_160000_add_is_paused_to_tasks_table.php`

### Modified Files:
1. `app/Models/Task.php` - Added is_paused field
2. `app/Http/Controllers/TaskController.php` - Added pause/resume methods
3. `app/Http/Controllers/TeamApplicationController.php` - Added pause validation
4. `routes/web.php` - Added pause/resume routes
5. `resources/views/admin/dashboard.blade.php` - Added task assignments section
6. `resources/views/team/dashboard.blade.php` - Updated status display
7. `resources/views/team/applications/create.blade.php` - Added pause alerts

---

**Status:** ✅ Complete and functional
**Migration:** ✅ Run successfully
**Testing:** Ready for use
