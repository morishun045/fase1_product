<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        auth()->user()->following()->attach($user->id);
        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->following()->detach($user->id);
        return back();
    }

    public function following(User $user)
    {
        $following_users = $user->following()->paginate(10);

        return view('profile.following', [
            'user' => $user, 
            'users' => $following_users,
        ]);
    }

    public function follower(User $user)
    {
        $follower_users = $user->followers()->paginate(10);

        return view('profile.following', [
            'user' => $user, 
            'users' => $follower_users, 
        ]);
    }
}
