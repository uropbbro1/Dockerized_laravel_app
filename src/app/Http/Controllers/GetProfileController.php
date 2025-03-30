<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetProfileController extends Controller
{
    public function get(){
        $reviews = DB::table('reviews')
        ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
        ->where('reviews.user_id', '=', Auth::id())
        ->select('reviews.*', 'new_users.login', 'new_users.image')
        ->get()->toArray();
        return view('profile')->with('reviews', $reviews);
    }
}
