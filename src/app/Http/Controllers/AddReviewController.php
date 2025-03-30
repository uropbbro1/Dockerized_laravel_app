<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddReviewController extends Controller
{
    public function add(Request $request){
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
