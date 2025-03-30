<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDataController extends Controller
{
    public function updateData(Request $request){
        if(Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])){
            //Проверка на совпадение заполненных полей с полями бд, если пользователь ничего не менял и нажал кнопку сохранения, то информация в профиле меняться не будет
            if(Auth::user()->email !== $request->email && Auth::user()->login !== $request->login){
                return redirect(route('profile'));
            }

            //проверка и изменение полей бд
            if(Auth::user()->email !== $request->email && count(DB::table('new_users')->where('email', "=",  $request->email)->get())){
                return "Пользователь с таким email уже существует";
            }elseif (Auth::user()->login !== $request->login && count(DB::table('new_users')->where('login', "=",  $request->login)->get())){
                return "Пользователь с таким никнеймом уже существует";
            }else{
                $affected = DB::table('new_users')->where('id', Auth::id())->update(['login' => $request->login, 'email' => $request->email]);
                return redirect(route('profile'));
            }   
        }else{
            return 'Неверный пароль';
        }         
    }
}
