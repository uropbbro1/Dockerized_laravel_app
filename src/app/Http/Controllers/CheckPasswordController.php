<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPasswordController extends Controller
{
    public function check(Request $request){
        if(Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password_to_check])){
            return redirect(route('profile'))->with('checkPassStatus', 'yes')->with('checkedPass', $request->password_to_check);
        }else{
            return redirect(route('profile'))->with('checkPassStatus', 'no');
        } 
    }
}
