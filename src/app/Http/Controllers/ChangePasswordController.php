<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request){
        if($request->to_change_password === $request->repeat_password){
            $hashedPass = Hash::make($request->to_change_password);
            $affected = DB::table('new_users')->where('id', Auth::id())->update(['password' => $hashedPass]);
            return redirect(route('profile'));
        }else{
            return 'Пароли не совпадают';
        }
    }
}
