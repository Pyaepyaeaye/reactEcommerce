<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function changePassword(){
        $user_id= request()->user_id;
        $current_password = request()->currentPassword;
        $new_password = request()->newPassword;

        $user= User::where('id', $user_id)->first();
        if(Hash::check($current_password, $user->password)){  
            $user->update([
                'password' => Hash::make($new_password)
            ]);
            return response()->json([
                'message' => true,
                'data' =>  "change password success"
            ]);         

        }
        return response()->json([
            'message' => false,
            'data' =>  "wrong password"
        ]);
    }
    public function profile(){
        $user_id= request()->user_id;
        $users= User::where('id',$user_id)->first();
        return response()->json([
            'message' => true,
            'data'=> $users
        ]);

    }
    public function saveProfile(){
        $user_id= request()->user_id;
        $name = request()->name;
        $address = request()->address;
        $image= request()->image;
        $users= User::where('id',$user_id)->first();
        $img_path= uniqid(). $image->getClientOriginalName();
        $image->move(public_path('images/user/'), $img_path);         
        $user->update([
            'name' => $name,
            'image' =>$img_path,
            'address' => $address
        ]);
        $users_updated= User::where('id',$user_id)->first();
        return response()->json([
            'message' => true,
            'data'=>  $users_updated
        ]);
    }
}
