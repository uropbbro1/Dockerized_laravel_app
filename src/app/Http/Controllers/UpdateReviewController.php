<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateReviewController extends Controller
{
    public function updateReview(Request $request){
        $affected = DB::table('reviews')->where('id', $request->id)->update(['title' => $request->title, 'text' => $request->text, 'is_recommended' => $request->is_recommended]);
        return redirect(route('comments'));
    }
}
