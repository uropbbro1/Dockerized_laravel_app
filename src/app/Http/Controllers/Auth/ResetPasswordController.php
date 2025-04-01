<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        // Возвращаем представление с формой для сброса пароля
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        // Валидация данных
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Пытаемся сбросить пароль с помощью Laravel Password Reset
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        // Проверяем результат
        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Пароль успешно сброшен!');
        }

        return back()->withErrors(['email' => [trans($response)]]);
    }
}