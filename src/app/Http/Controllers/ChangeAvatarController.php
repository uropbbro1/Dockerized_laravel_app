<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChangeAvatarController extends Controller
{
    public function change(Request $request) {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $messages = [
            'image.mimes' => 'Изображение должно быть в формате: jpeg, png, jpg, gif, svg.',
            'image.max'   => 'Размер изображения не должен превышать 2048 килобайт.',
            'image.required' => 'Пожалуйста, загрузите изображение.',
            'image.image' => 'Файл должен быть изображением.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = Auth::user();
        if ($request->hasFile('image')) {
            // 1. Удаление старого аватара (если есть)
            if ($user->image) {
                Storage::disk('public')->delete($user->image); // Удаляем файл из хранилища
            }

            // 2. Загрузка нового аватара
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();  // Генерируем уникальное имя
            $path = $image->storeAs('avatars', $filename, 'public');        // Сохраняем файл в storage/app/public/avatars

            // 3. Обновление данных пользователя
            $affected = DB::table('new_users')->where('id', $user->id)->update(['image' => $path]);
            return redirect(route('profile'));
        }
        return redirect(route("profile"));
    }
}
