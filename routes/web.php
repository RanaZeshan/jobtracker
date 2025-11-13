<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TeamDashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamApplicationController;
use App\Http\Controllers\AdminClientApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamEarningsController;
use App\Http\Controllers\TeamMemberEarningsController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\RecentActivityController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', [JobSearchController::class, 'index'])->name('jobs.index');



Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // everything else goes to team dashboard
    return redirect()->route('team.dashboard');
})->middleware(['auth'])->name('dashboard');






// Admin  dashboard routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('clients', ClientController::class);
    Route::post('/clients/{client}/pause', [ClientController::class, 'pause'])->name('clients.pause');
    Route::post('/clients/{client}/resume', [ClientController::class, 'resume'])->name('clients.resume');
    
    Route::resource('team-members', TeamMemberController::class);
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/{task}/pause', [TaskController::class, 'pause'])->name('tasks.pause');
    Route::post('/tasks/{task}/resume', [TaskController::class, 'resume'])->name('tasks.resume');

    Route::get(
        '/admin/clients/{client}/applications',
        [AdminClientApplicationController::class, 'index']
    )->name('admin.clients.applications');

    // Team earnings routes
    Route::get('/earnings', [TeamEarningsController::class, 'index'])->name('admin.earnings.index');
    Route::get('/earnings/{user}', [TeamEarningsController::class, 'show'])->name('admin.earnings.show');
    
    // Recent activity API
    Route::get('/api/recent-activities', [RecentActivityController::class, 'index'])->name('admin.recent-activities');
});










// Team dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/team/dashboard', [TeamDashboardController::class, 'index'])
        ->name('team.dashboard');
    
    // Team member earnings
    Route::get('/team/earnings', [TeamMemberEarningsController::class, 'index'])
        ->name('team.earnings.index');


 Route::get(
        '/team/clients/{client}/applications',
        [TeamApplicationController::class, 'indexByClient']
    )->name('team.clients.applications');

    // NEW: page to show the Add Application form
    //Route::get('/team/applications/create', [TeamApplicationController::class, 'create'])
    //    ->name('team.applications.create');

Route::get(
        '/team/clients/{client}/applications/create',
        [TeamApplicationController::class, 'createForClient']
    )->name('team.clients.applications.create');



    Route::post('/team/applications', [TeamApplicationController::class, 'store'])
        ->name('team.applications.store');   


      Route::get('/team/clients/{client}/applications', [TeamApplicationController::class, 'indexByClient'])
        ->name('team.clients.applications'); 



        Route::delete(
        '/team/applications/{application}',
        [TeamApplicationController::class, 'destroy']
    )->name('team.applications.destroy');

    // 🔹 NEW: bulk delete applications for a client
    Route::post(
        '/team/clients/{client}/applications/bulk-delete',
        [TeamApplicationController::class, 'bulkDestroy']
    )->name('team.clients.applications.bulk-destroy');





});



// Profile dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile picture routes
    Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');
    Route::delete('/profile/picture', [ProfileController::class, 'destroyPicture'])->name('profile.picture.destroy');
});




require __DIR__.'/auth.php';
















