<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SortReviewsController extends Controller
{
    public function sort(Request $request){
        if($request->query('is-searched')){
            $searchTerm = $request->query('is-searched');
            if($request->query('is-sorted') === '1'){
                $reviews = DB::table('reviews')
                ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
                ->select('reviews.*', 'new_users.login', 'new_users.image')
                ->where('text', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('reviews.created_at', 'asc')
                ->simplePaginate(3);
                $reviews_count = count(DB::table('reviews')
                ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
                ->select('reviews.*', 'new_users.login', 'new_users.image')
                ->where('text', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('reviews.created_at', 'asc')
                ->get());
                return view('sorted-comments')->with('reviews', $reviews)
                            ->with('reviews_count', $reviews_count)
                            ->with('sorted', -1)
                            ->with('complete_search', $searchTerm);
            }else{
                $reviews = DB::table('reviews')
                ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
                ->select('reviews.*', 'new_users.login', 'new_users.image')
                ->where('text', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('reviews.created_at', 'desc')
                ->simplePaginate(3);
                $reviews_count = count(DB::table('reviews')
                ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
                ->select('reviews.*', 'new_users.login', 'new_users.image')
                ->where('text', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('reviews.created_at', 'desc')
                ->get());
                return view('sorted-comments')->with('reviews', $reviews)
                            ->with('reviews_count', $reviews_count)
                            ->with('sorted', 1)
                            ->with('complete_search', $searchTerm);
            }
        }else{
            $reviews = DB::table('reviews')
            ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
            ->select('reviews.*', 'new_users.login', 'new_users.image')
            ->orderBy('reviews.created_at', 'desc')
            ->simplePaginate(3);
            $reviews_count = count(DB::table('reviews')
            ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
            ->select('reviews.*', 'new_users.login', 'new_users.image')
            ->get());
            return view('sorted-comments')->with('reviews', $reviews)
                            ->with('reviews_count', $reviews_count)
                            ->with('sorted', 1);
        }
    }

    public function search(Request $request){
        $validatedData = $request->validate([
            'search_term' => 'required|string|max:255',
        ]);
        $searchTerm = $validatedData['search_term'];

        $reviews = DB::table('reviews')
        ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
        ->select('reviews.*', 'new_users.login', 'new_users.image')
        ->where('text', 'LIKE', '%' . $searchTerm . '%')
        ->orderBy('reviews.created_at', 'desc')
        ->simplePaginate(3);

        $reviews_count = count(DB::table('reviews')
        ->leftJoin('new_users', 'reviews.user_id', '=',  'new_users.id')
        ->select('reviews.*', 'new_users.login', 'new_users.image')
        ->where('text', 'LIKE', '%' . $searchTerm . '%')
        ->orderBy('reviews.created_at', 'desc')
        ->get());

        return view('sorted-comments')->with('reviews', $reviews)->with('reviews_count', $reviews_count)->with('sorted', -1)->with('complete_search', $searchTerm);
    }

}
