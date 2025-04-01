<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;


class PasswordRecoveryController extends Controller
{
    public function sendPasswordRecoveryEmail(Request $request)
    {
        // Валидация email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Найдем пользователя по email
        $user = NewUser::where('email', $request->email)->first();

        if ($user) {
            // Генерация токена для сброса пароля
            $token = Password::createToken($user);

            // Отправка email для сброса пароля
            Mail::to($user->email)->send(new PasswordResetMail($token));

            // Успешное сообщение
            return back()->with('status', 'Письмо восстановления пароля отправлено на указанный E-mail адрес.');
        }

        // Если пользователь не найден, выводим ошибку
        return back()->withErrors(['email' => 'Неверный E-mail']);
    }
}