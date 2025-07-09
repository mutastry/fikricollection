<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Songket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $featuredSongkets = Songket::with(['category', 'reviews'])
            ->featured()
            ->active()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->limit(6)
            ->get();

        $categories = Category::active()->withCount('songkets')->get();

        return view('welcome', compact('featuredSongkets', 'categories'));
    }
}
