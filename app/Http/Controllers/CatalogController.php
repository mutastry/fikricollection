<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Songket;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Songket::active()
            ->with(['category', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $songkets = $query->paginate(12);
        $categories = Category::active()->get();

        return view('catalog.index', compact('songkets', 'categories'));
    }

    public function show(Songket $songket)
    {
        $songket->load(['category', 'reviews.user']);

        $relatedSongkets = Songket::where('category_id', $songket->category_id)
            ->where('id', '!=', $songket->id)
            ->active()
            ->limit(4)
            ->get();

        return view('catalog.show', compact('songket', 'relatedSongkets'));
    }
}
