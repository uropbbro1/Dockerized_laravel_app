<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateDataController extends Controller
{
    public function updateData(Request $request){

        $rules = [
            'login' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/',
        ];

        $messages = [
            'login.required' => 'Поле "Логин" обязательно.',
            'login.max' => 'Логин должен быть не длиннее 255 символов.',
            'email.required' => 'Поле "Email" обязательно.',
            'email.email' => 'Некорректный формат Email.',
            'password.required' => 'Поле "Пароль" обязательно.',
            'password.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен быть не менее 6 символов.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // проверка на правильность пароля
        $validator->after(function ($validator) use ($request) {
            if(!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])){
                $validator->errors()->add('password', 'Неверный пароль');
            }
        });

        
        // проверка на наличие нового email или никнейма в базе и изменение полей профиля
        $validator->after(function ($validator) use ($request) {
            if(Auth::user()->email === $request->email && Auth::user()->login === $request->login){
                $validator->errors()->add('password', 'Для изменения информации о профиле измените поля email или логин');
            }else{
                if(count(DB::table('new_users')->where('email', "=",  $request->email)->get()) > 0){
                    if(Auth::user()->email !== $request->email){
                        $validator->errors()->add('email', 'Такой email уже зарегистрирован');
                    }
                }
                if(count(DB::table('new_users')->where('login', "=",  $request->login)->get()) > 0){
                    if(Auth::user()->login !== $request->login){
                        $validator->errors()->add('login', 'Этот никнейм уже занят');
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $affected = DB::table('new_users')->where('id', Auth::id())->update(['login' => $request->login, 'email' => $request->email]);
        return redirect(route('profile'));
    }
}
