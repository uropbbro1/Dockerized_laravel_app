<?php

namespace App\Http\Controllers;

use App\Models\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request){

        $rules = [
            'login_reg' => 'required|max:255',
            'email_reg' => 'required|email',
            'password_reg' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{6,}$/',
            'password_confirmation' => 'required|min:6',
            'agreement_check' => 'accepted'
        ];

        $messages = [
            'login_reg.required' => 'Поле "Логин" обязательно.',
            'login_reg.max' => 'Логин должен быть не длиннее 255 символов.',
            'email_reg.required' => 'Поле "Email" обязательно.',
            'email_reg.email' => 'Некорректный формат Email.',
            'password_reg.required' => 'Поле "Пароль" обязательно.',
            'password_reg.regex' => 'Пароль должен соответствовать требованиям (минимум одна заглавная буква, одна маленькая буква, одна цифра, один спецсимвол).',
            'password_reg.confirmed' => 'Пароли не совпадают.',
            'password_reg.min' => 'Пароль должен быть не менее 6 символов.',
            'password_confirmation.required' => 'Поле "Подтверждение пароля" обязательно.',
            'password_confirmation.min' => 'Подтверждение пароля должно быть не менее 6 символов.',
            'agreement_check.accepted' => 'Вы должны согласиться с условиями соглашения.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if ($request->password_reg !== $request->password_confirmation) {
                $validator->errors()->add('password_confirmation', 'Пароли не совпадают.');
            }
        });

        // проверка на существование email и никнейма пользователя
        $validator->after(function ($validator) use ($request) {
            $users_email = DB::table('new_users')->where('email', '=', $request->email_reg)->get();
            if (count($users_email) > 0) {
                $validator->errors()->add('email_reg', 'Такой email уже существует.');
            }

            $users_login = DB::table('new_users')->where('login', '=', $request->login_reg)->get();
            if (count($users_login) > 0) {
                $validator->errors()->add('login_reg', 'Такой никнейм уже существует.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            $user = NewUser::create([
                'login' => $request->login_reg,
                'email' => $request->email_reg,
                'password' => $request->password_reg,
                'image' => '',
            ]);

            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Произошла ошибка при создании учетной записи. Пожалуйста, попробуйте позже.');
        }
    }
}
