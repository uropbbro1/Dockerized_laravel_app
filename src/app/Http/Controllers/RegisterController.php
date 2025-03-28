<?php

namespace App\Http\Controllers;

use App\Models\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function store(Request $request){
        $users = DB::table('new_users')->where('email', '=', $request->email)->get();
        if($request->password !== $request->repeat_password){
            return json_encode((response()->json(['message' => "Пароли не совпадают"], 422))->original["message"], JSON_UNESCAPED_UNICODE);
        }
        if(!count($users)){
            $user = NewUser::create([
                'login' => $request->login,
                'email' => $request->email,
                'password' => $request->password,
                'image' => '',
            ]);
            
            Auth::login($user);
            return redirect('/');
        }else{
            return json_encode((response()->json(['message' => "Такой пользователь уже существует"], 422))->original["message"], JSON_UNESCAPED_UNICODE);
        }

    }
}
