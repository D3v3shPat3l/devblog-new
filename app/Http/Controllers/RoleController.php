<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($request->user_id);
        $role = Role::where('name', $request->role)->first();
        $user->roles()->syncWithoutDetaching([$role->id]);

        return back()->with('success', "Role '{$role->name}' assigned to {$user->name}.");
    }

    public function removeRoles(User $user)
    {
    $user->roles()->detach();

    return back()->with('success', "All roles removed for {$user->name}.");
    }
}
