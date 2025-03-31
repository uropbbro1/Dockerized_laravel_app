<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function store(Request $request){

        $rules = [
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/'
        ];

        $messages = [
            'email.required' => 'Поле "Email" обязательно.',
            'email.email' => 'Некорректный формат Email.',
            'password.required' => 'Поле "Пароль" обязательно.',
            'password.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'password.min' => 'Пароль должен быть не менее 6 символов.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if(!Auth::attempt($request->only('email', 'password'))){
                $validator->errors()->add('password', 'Неверный email или пароль');
            }
        });
        
        // проверка на существование email и никнейма пользователя
        $validator->after(function ($validator) use ($request) {
            $users_email = DB::table('new_users')->where('email', '=', $request->email)->get();
            if (count($users_email) === 0) {
                $validator->errors()->add('email', 'Такой email не зарегистрирован.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            return redirect()->route('index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Произошла ошибка при создании учетной записи. Пожалуйста, попробуйте позже.');
        }       
    }
}
