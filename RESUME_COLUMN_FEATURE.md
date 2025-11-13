# Resume Column Feature

## Overview
Added a "Resume" column to all application tables to display and download uploaded resume files.

## Changes Made

### 1. Team Applications Index View
- **File**: `resources/views/team/applications/index.blade.php`
- Added "Resume" column header
- Shows download button with PDF icon when resume exists
- Shows "—" when no resume uploaded
- Button opens resume in new tab

### 2. Admin Client Applications View
- **File**: `resources/views/admin/clients/applications.blade.php`
- Added "Resume" column header
- Shows download button with PDF icon when resume exists
- Shows "—" when no resume uploaded
- Button opens resume in new tab

### 3. Team Applications Create View
- **File**: `resources/views/team/applications/create.blade.php`
- Added "Resume" column to the applications list table
- Shows PDF icon button when resume exists
- Shows "—" when no resume uploaded
- Compact icon-only button to save space

## Visual Design

**Resume Button:**
- Green outline button (`btn-outline-success`)
- PDF file icon (`bi-file-earmark-pdf`)
- "View" text label (in index views)
- Icon only (in create view for space)
- Opens in new tab/window

**No Resume:**
- Shows "—" (em dash) in muted gray
- Indicates no file was uploaded

## File Access

- Files are stored in `storage/app/public/resumes/`
- Accessed via `asset('storage/' . $app->resume_file)`
- Storage link already created (`public/storage` → `storage/app/public`)
- Files open in new browser tab for viewing/downloading

## Usage

1. Team member uploads resume when creating application
2. Resume is saved to storage with unique filename
3. Resume column shows download button in all application tables
4. Clicking button opens resume in new tab
5. Admin and team members can both access the resumes

## File Naming Convention

Resumes are saved with format:
```
{company-slug}_{job-title-slug}_{timestamp}.{extension}
```

Example: `google_software-engineer_20251112_143022.pdf`

## Security

- Files are stored in Laravel's storage system
- Only authenticated users can access application tables
- Team members can only see their own applications
- Admins can see all applications
- Files are served through Laravel's asset system
