<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddReviewController extends Controller
{
    public function add(Request $request){

        $rules = [
            'title' => 'required|max:255',
            'text' => 'required|max:5000',
            'is_recommended' => 'required'
        ];

        $messages = [
            'title.required' => 'Заголовок должен быть заполненным',
            'title.max'   => 'Заголовок не может быть длинее 255 символов',
            'text.required' => 'Текст отзыва должен быть заполненным',
            'text.max' => 'Текст отзыва не может быть длинее 5000 символов',
            'is_recommended.required' => 'Выберите рекомендуете вы товар или нет.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()->with('error', 'yes');
        }
        
        if(Auth::id()){
            $review = Reviews::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'text' => $request->text,
                'is_recommended' => $request->is_recommended
            ]);
            return redirect(route('comments'));
        }else{
            $review = Reviews::create([
                'user_id' => -1,
                'title' => $request->title,
                'text' => $request->text,
                'is_recommended' => 'none'
            ]);
            return redirect(route('comments'));
        }
    }
}
