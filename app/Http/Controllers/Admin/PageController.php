<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class PageController extends Controller
{

  
  public function showDashboard() {
    return view('admin.dashboard');
  }
  public function showLogin() {
    return view('admin.login');
  }
  public function adminLogin(Request $request)
  {
    
    $validate = Validator::make($request->all(),[     
      'email'=>'required',
      'password'=> 'required'
    ],[     
      'email.required' => "Email is Required",
      'password.required'=> 'Password is Required'
    ]);    
    if($validate->fails()){
      //return redirect()->back()->withErrors($validate->errors());
      return back()->withErrors($validate->errors())->withInput();
    }

    $cre=['email' => $request->email, 'password' => $request->password];
    
    if (Auth::guard('admin')->attempt($cre , $request->get('remember'))) {
        return redirect()->intended('/admin');
    }
    return redirect()->back()->with('error','Email and Password dont match!');
  }  

  public function adminLogout(Request $request){
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();    
    return redirect('/admin/login');
  }
}
