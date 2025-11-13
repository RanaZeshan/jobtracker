<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TeamMemberController extends Controller
{
    /**
     * We don't use index separately for now (everything on admin dashboard).
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Not used – form is in modal on dashboard.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a new team member (and linked User) from the admin dashboard modal.
     */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|max:255|unique:users,email',
        'password'  => 'required',
        '_form'     => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->route('admin.dashboard')
            ->withErrors($validator)
            ->withInput();
    }

    $data = $validator->validated();

    $plainPassword = $data['password'];
    unset($data['password'], $data['password_confirmation']);

    $data['is_active'] = $request->has('is_active');

    // ✅ THIS PART: create a User as TEAM role
    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($plainPassword),
        'role'     => 'team',   // 👈 important
    ]);

    $data['role']    = 'Team Member';
    $data['user_id'] = $user->id;

    TeamMember::create($data);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Team member created successfully.');
}



    /**
     * Not used separately for now.
     */
    public function show(TeamMember $teamMember)
    {
        abort(404);
    }

    /**
     * Not used separately for now.
     */
    public function edit(TeamMember $teamMember)
    {
        abort(404);
    }

    /**
     * Update a team member (from edit modal if/when you wire it).
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:team_members,email,' . $teamMember->id,
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.dashboard')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['is_active'] = $request->has('is_active');

        // keep role as is (already auto-set)
        $data['role'] = $teamMember->role ?? 'Team Member';

        // update related user as well
        if ($teamMember->user) {
            $teamMember->user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);
        }

        $teamMember->update($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Team member updated successfully.');
    }

    /**
     * Delete a team member.
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Team member deleted successfully.');
    }
}
