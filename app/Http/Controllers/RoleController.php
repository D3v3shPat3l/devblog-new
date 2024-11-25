<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    public function assignRole(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        // Find the user and role
        $user = User::find($request->user_id);
        $role = Role::where('name', $request->role)->first();

        // Attach the role to the user
        $user->roles()->syncWithoutDetaching([$role->id]);

        return back()->with('success', "Role '{$role->name}' assigned to {$user->name}.");
    }

    public function removeRoles(User $user)
    {
    $user->roles()->detach();

    return back()->with('success', "All roles removed for {$user->name}.");
    }
}
