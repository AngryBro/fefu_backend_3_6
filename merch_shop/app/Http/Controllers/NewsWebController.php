<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsWebController extends Controller
{
    public function index(Request $request) {
        $newsList = News::query()->published()->paginate(5);
        return view('newsList', ['newsList' => $newsList]);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $slug)
    {
        $news = News::query()
        ->published()->where('slug', '=', $slug)->first();
        if ($news === null)
            abort(404);
        return view('news', ['news' => $news]);
    }
}