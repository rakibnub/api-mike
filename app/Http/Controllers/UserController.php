<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)) {
            $success = true;
            $message = "User login successfully";
            $user = Auth::user();
            $token = $user->createToken('myapptoken')->plainTextToken;
        } else {
            $success = false;
            $message = "Unautorised";
            $token = '';
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'token'   => $token,
            // 'user'    => Auth::user(),
        ];

        return response()->json($response);
    }


    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = "User register successfully";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function user(){
        return $user = Auth::user();
    }
    public function userlist(){
        $user = Auth::user();
        if($user->parent_id!=null){
            $userlist = User::where('parent_id',$user->parent_id)->get();
        }else{
            $userlist = User::where('parent_id',$user->id)->get();
        }

        $response = [
            'success' => true,
            'users' => $userlist
        ];

        return response()->json($response);

    }

    public function create(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->parent_id = Auth::user()->id;
            $user->date_of_birth = $request->date_of_birth;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = "User register successfully";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function update(Request $request,$id)
    {
        try {
            $user = User::find($id);
            if($user){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->type;
                $user->date_of_birth = $request->date_of_birth;
                $user->password = Hash::make($request->password);
                $user->update();

                $success = true;
                $message = "User Update successfully";

            }else{
                $success = false;
                $message = "User not found";
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function statusUpdate(Request $request,$id)
    {
        try {
            $user = User::find($id);
            if($user){
                $user->type = $request->type;
                $user->update();
                $success = true;
                $message = "User Update successfully";

            }else{
                $success = false;
                $message = "User not found";
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
            $success = true;
            $message = 'User Delete successfully';
        }else{
            $success = false;
            $message = 'User not found';
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

}
