<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($season)
    {
        return view('user.create', ['season' => $season]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $season)
    {
            // dd($season);
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed',
                'role' => 'required',
            ]);
    
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
            

    
            return redirect()->route('user.index', ['season' => $season])->with('success', 'User created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($season, User $user,)
    {
        // dd($user);
        return view('user.edit', ['user' => $user, 'season' => $season]);
    }


    public function editPassword($season, User $user)
    {
        return view('user.edit-password', ['user' => $user, 'season' => $season]);
    }

    public function updatePassword(Request $request, $season, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.index', ['season' => $season])->with('success', 'Password updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $season, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        
        return redirect()->route('user.index', ['season' => $season])->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sesson, User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        // return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
