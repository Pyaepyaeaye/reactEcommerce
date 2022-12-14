<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function showRegister() {
    return view('auth.register');
   }
   
   public function postRegister(Request $request){
      $request->validate([
         'name' => 'required',
         'image' => 'required|mimes:png,jpg,jpg',
         'password' => 'required',
         'email' => 'required|email',
      ]);
      $find_user= User::where('email', $request->email)->first();
      if($find_user){
         return redirect()->back()->with('error', "Email Already Exit");         
      }
      $image = $request->file('image');
      $img_path= uniqid(). $image->getClientOriginalName();
      $image->move(public_path('images/user/'), $img_path);    
      $user = User::create([
         'name'=> $request->name,
         'image' => $img_path,
         'email'=> $request->email,
         'password' => Hash::make($request->password),
      ]);
      auth()->login($user);   
      return redirect('/')->with('success', "Welcome User");
     
   }
   public function showLogin(){
      return view('auth.login');      
   }
   public function postLogin(Request $request){
      $find_user = User::where('email', $request->email)->first();
      if(!$find_user){
         return redirect()->back()->with('error',"Email Not Found");
      }
      if(!Hash::check($request->password, $find_user->password)){
         return redirect()->back()->with('error',"Password Wrong");
      }
      auth()->login($find_user);
      return redirect('/')->with('success','Login success');

   }
   public function logout(){
      auth()->logout();
      return redirect('/login')->with('success', 'Logout Success');
   }

}
