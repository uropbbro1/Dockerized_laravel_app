<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class CheckPasswordController extends Controller
{
    public function check(Request $request){
        $rules = [
            'password_to_check' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/'
        ];

        $messages = [
            'password_to_check.required' => 'Поле "Пароль" обязательно.',
            'password_to_check.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'password_to_check.min' => 'Пароль должен быть не менее 6 символов.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if(!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password_to_check])){
                $validator->errors()->add('password_to_check', 'Неверный пароль');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        return redirect(route('profile'))->with('checkPassStatus', 'yes')->with('checkedPass', $request->password_to_check)->with('pass', $request->password_to_check);
    }
}
