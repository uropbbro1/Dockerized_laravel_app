<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetReviewsController extends Controller
{
    public function get(){
        $reviews = DB::table('reviews')
        ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
        ->select('reviews.*', 'new_users.login', 'new_users.image')
        ->simplePaginate(2);
        $reviews_count = count(DB::table('reviews')
        ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
        ->select('reviews.*', 'new_users.login', 'new_users.image')
        ->get());
        return view('comments')->with('reviews', $reviews)->with('reviews_count', $reviews_count);
    }

    public function search(Request $request){
        return 1;        
    }
}
