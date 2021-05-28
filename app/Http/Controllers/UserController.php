<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\SendSms;
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
            return ['data'=>$users];
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to load data, Try again later.',500);
        }
    }
    
    //add user
    public function addUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);
        try {
            //file 
            if($request->file('photo'))
            {
                $extensions = array("png","jpg","jpeg");
                $result = array($request->file('photo')->getClientOriginalExtension());
                
                if(!in_array($result[0],$extensions)){
                    return back()->with('failure',"File must be of required type ( e.g. .png, .jpg, or .jpeg)");
                }
                //upload file
                $files = $request->file('photo');
                $destinationPath = 'photos/'; // upload path
                $file = "photo_".date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $imagelink =  \Config::get('app.url').'/'.$destinationPath.$file;
                
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->photo = $imagelink ?? '';
            $user->save();
            return response()->json(['success'=>true, 'message'=>'Added successfully!']);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to add user, Try again later.',400);
        }
    }
    //edit user
    public function editUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);
        try {
            //file 
            if($request->file('photo'))
            {
                $extensions = array("png","jpg","jpeg");
                $result = array($request->file('photo')->getClientOriginalExtension());
                
                if(!in_array($result[0],$extensions)){
                    return back()->with('failure',"File must be of required type ( e.g. .png, .jpg, or .jpeg)");
                }
                //upload file
                $files = $request->file('photo');
                $destinationPath = 'photos/'; // upload path
                $file = "photo_".date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $imagelink =  \Config::get('app.url').'/'.$destinationPath.$file;
                
            }

            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->photo = $imagelink ?? $user->photo;
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
            //send sms to Manager that user has been deleted
            $sms = new SendSms();
            $sms->sendSms('+254708058225','User '.$user->name." has been deleted");
            return response()->json('success',200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json('Failed to delete user, Try again later.',400);
        }
    }
}
