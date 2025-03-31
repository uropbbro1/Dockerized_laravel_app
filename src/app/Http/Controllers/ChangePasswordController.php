<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request){
        $rules = [
            'to_change_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/',
            'repeat_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/',
        ];

        $messages = [
            'to_change_password.required' => 'Поле "Новый пароль" обязательно.',
            'to_change_password.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'to_change_password.min' => 'Пароль должен быть не менее 6 символов.',
            'password.required' => 'Поле "Пароль" обязательно.',
            'password.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'password.min' => 'Пароль должен быть не менее 6 символов.',
            'repeat_password.required' => 'Поле "Повторите пароль" обязательно.',
            'repeat_password.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'repeat_password.min' => 'Пароль должен быть не менее 6 символов.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if($request->to_change_password === $request->password){
                $validator->errors()->add('password', 'Этот пароль совпадает с текущим, введите новый пароль для смены пароля на новый.');
            }
            if($request->to_change_password !== $request->repeat_password){
                $validator->errors()->add('repeat_password', 'Пароли должны совпадать');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('checkPassStatus', 'yes')->with('checkedPass', $request->password)->with('pass', $request->password);
        }
        
        $hashedPass = Hash::make($request->to_change_password);
        $affected = DB::table('new_users')->where('id', Auth::id())->update(['password' => $hashedPass]);
        return redirect(route('profile'))->with('change-password-success', 'Пароль успешно изменен!');
    }
}
