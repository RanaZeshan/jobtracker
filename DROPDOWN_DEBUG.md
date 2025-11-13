# Dropdown Debug Guide

## Changes Made

1. **Simplified JavaScript** - Removed Alpine.js dependency check, now uses pure vanilla JS
2. **Added type="button"** - Prevents form submission behavior
3. **Added console.log** - For debugging
4. **Added preventDefault()** - Ensures button doesn't trigger any default behavior

## How to Test

### Step 1: Start Server
```bash
php artisan serve
```

### Step 2: Login
Visit `http://localhost:8000/login` and login with your credentials

### Step 3: Open Browser Console
- Chrome/Edge: Press `F12` or `Ctrl+Shift+I` (Windows) / `Cmd+Option+I` (Mac)
- Firefox: Press `F12`
- Safari: Enable Developer menu, then press `Cmd+Option+I`

### Step 4: Check Console Messages
You should see:
```
Navbar dropdown initialized
```

### Step 5: Click User Menu
Click on your user avatar/name in the top-right corner

**Expected behavior:**
- Dropdown menu appears below the button
- Chevron icon rotates 180 degrees
- Console shows no errors

### Step 6: Click Outside
Click anywhere outside the dropdown

**Expected behavior:**
- Dropdown closes
- Chevron rotates back

## Debugging Steps

### If dropdown doesn't appear:

1. **Check Console for Errors**
   - Look for JavaScript errors
   - Look for "User menu elements not found" message

2. **Inspect Elements**
   - Right-click the user button → Inspect
   - Check if these IDs exist:
     - `userMenuContainer`
     - `userMenuButton`
     - `userMenuChevron`
     - `userDropdownMenu`

3. **Check CSS**
   - In browser inspector, find `.dropdown-menu`
   - Check computed styles:
     - `opacity` should change from 0 to 1
     - `visibility` should change from hidden to visible
     - `transform` should change

4. **Manual Test in Console**
   ```javascript
   // Run these in browser console:
   document.getElementById('userMenuButton')
   document.getElementById('userMenuContainer')
   
   // Try manual toggle:
   document.getElementById('userMenuContainer').classList.add('open')
   ```

### If Alpine.js conflicts:

The script now runs immediately and doesn't check for Alpine.js. Both can coexist:
- Alpine.js handles the `x-data` attributes
- Vanilla JS handles the click events
- They shouldn't conflict

### Common Issues:

**Issue 1: Button inside a form**
- Solution: Added `type="button"` to prevent form submission

**Issue 2: Event bubbling**
- Solution: Added `e.stopPropagation()` and `e.preventDefault()`

**Issue 3: CSS not applied**
- Solution: Check if `.user-menu.open .dropdown-menu` CSS exists
- Also check `[data-open="true"]` selector

**Issue 4: Z-index issues**
- Solution: Dropdown has `z-index: 1050`
- Should be above other content

## Alternative: Bootstrap Dropdown

If the custom dropdown still doesn't work, here's a Bootstrap-based alternative:

```html
<!-- Replace user menu with Bootstrap dropdown -->
<div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" 
            data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-avatar d-inline-flex">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        {{ Auth::user()->name }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
            </form>
        </li>
    </ul>
</div>
```

## Files to Check

1. `resources/views/layouts/navigation.blade.php` - Navbar structure
2. `resources/views/layouts/app.blade.php` - Alpine.js and Bootstrap includes
3. Browser Console - JavaScript errors
4. Network tab - Check if Alpine.js loads

## Quick Fix Commands

```bash
# Clear all caches
php artisan optimize:clear

# Clear views only
php artisan view:clear

# Restart server
php artisan serve
```

## Expected HTML Structure

When inspected, you should see:
```html
<div class="user-menu" id="userMenuContainer" data-open="true">
    <button type="button" class="user-button" id="userMenuButton">
        <div class="user-avatar">JD</div>
        <span>John Doe</span>
        <i class="bi bi-chevron-down" id="userMenuChevron" style="transform: rotate(180deg);"></i>
    </button>
    <div class="dropdown-menu open" id="userDropdownMenu" style="opacity: 1; visibility: visible;">
        <!-- dropdown content -->
    </div>
</div>
```

## Status Check

Run this in browser console after page loads:
```javascript
console.log('Button:', document.getElementById('userMenuButton'));
console.log('Container:', document.getElementById('userMenuContainer'));
console.log('Menu:', document.getElementById('userDropdownMenu'));
console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined');
console.log('Alpine loaded:', typeof Alpine !== 'undefined');
```

All should return elements/true, not null/undefined.
