<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Log;
use Auth;

class UserController extends Controller
{
    //return users view
    public function index()
    {
        return view('users.index');
    }
    //get paginate users
    public function getUsers()
    {
        try {
            $users = User::orderByDesc('id')->paginate(10);
            return $users;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to load data, Try again later.',500);
        }
    }

    //get all users
    public function getAllUsers()
    {
        try {
            $users = User::orderByDesc('id')->get();
            return $users;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to load data, Try again later.',500);
        }
    }
    
    //add user
    public function addUser(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->photo = $request->photo;
            $user->save();
            return 'success';
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to add user, Try again later.',400);
        }
    }
    //edit user
    public function editUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->photo = $request->photo;
            $user->save();
            return 'success';
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to add user, Try again later.',400);
        }
    }
    //delete user
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json('success',200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to delete user, Try again later.',400);
        }
    }
}
