<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Songket\StoreSongketRequest;
use App\Http\Requests\Songket\UpdateSongketRequest;
use App\Models\Songket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

class SongketController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if user can manage products (Admin) or just view them (Employee)
        if (!$user->canAccess('manage_songkets') && !$user->canAccess('view_songkets')) {
            abort(403, 'Access denied.');
        }

        $query = Songket::with(['category'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Stock filter
        if ($request->filled('stock')) {
            $stock = $request->get('stock');
            if ($stock === 'low') {
                $query->where('stock_quantity', '<=', 10);
            } elseif ($stock === 'out') {
                $query->where('stock_quantity', 0);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['name', 'price', 'stock_quantity', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $songkets = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.songkets.index', compact('songkets', 'categories'));
    }

    public function create()
    {
        if (!Auth::user()->canAccess('manage_songkets')) {
            abort(403, 'Access denied.');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.songkets.create', compact('categories'));
    }

    public function store(StoreSongketRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);

            // Handle image uploads
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('songkets', 'public');
                    $imagePaths[] = Storage::url($path);
                }
                $data['images'] = $imagePaths;
            }

            Songket::create($data);

            DB::commit();

            return redirect()->route('admin.songket.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function show(Songket $songket)
    {
        $user = Auth::user();

        if (!$user->canAccess('manage_songkets') && !$user->canAccess('view_songkets')) {
            abort(403, 'Access denied.');
        }

        $songket->load(['category', 'reviews.user', 'orderItems.order']);
        return view('admin.songkets.show', compact('songket'));
    }

    public function edit(Songket $songket)
    {
        if (!Auth::user()->canAccess('manage_songkets')) {
            abort(403, 'Access denied.');
        }

        $categories = Category::where('is_active', true)->get();
        return view('admin.songkets.edit', compact('songket', 'categories'));
    }

    public function update(UpdateSongketRequest $request, Songket $songket)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);

        // Handle existing images
        $currentImages = $songket->images ?? [];
        $finalImages = [];

        // Handle removed existing images
        if ($request->has('remove_existing_images')) {
            $removedImages = $request->input('remove_existing_images', []);

            // Remove files from storage and filter out from current images
            foreach ($removedImages as $removedImage) {
                if (in_array($removedImage, $currentImages)) {
                    // Delete from storage
                    $path = str_replace('/storage/', '', $removedImage);
                    Storage::disk('public')->delete($path);
                }
            }

            // Keep only non-removed images
            $finalImages = array_values(array_diff($currentImages, $removedImages));
        } else {
            // Keep all existing images if no removal specified
            $finalImages = $currentImages;
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $newImagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('songkets', 'public');
                $newImagePaths[] = Storage::url($path);
            }

            // Add new images to final images array
            $finalImages = array_merge($finalImages, $newImagePaths);
        }

        // Ensure we don't exceed maximum images limit (optional)
        $maxImages = 10; // You can adjust this or make it configurable
        if (count($finalImages) > $maxImages) {
            return redirect()->back()
                ->withErrors(['images' => "Maximum {$maxImages} images allowed."])
                ->withInput();
        }

        // Update images in data
        $data['images'] = array_values($finalImages); // Re-index array

        // Update the songket
        $songket->update($data);

        return redirect()->route('admin.songket.index')
            ->with('success', 'Songket berhasil diperbarui!');
    }

    public function destroy(Songket $songket)
    {
        if (!Auth::user()->canAccess('manage_songkets')) {
            abort(403, 'Access denied.');
        }

        try {
            // Delete associated images
            if ($songket->images) {
                foreach ($songket->images as $image) {
                    $path = str_replace('/storage/', '', $image);
                    Storage::disk('public')->delete($path);
                }
            }
            $songket->delete();

            return redirect()->route('admin.songket.index')->with('success', 'Songket deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.songket.index')->with('error', 'Failed to delete Songket: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Songket $songket)
    {
        if (!Auth::user()->canAccess('manage_songkets')) {
            abort(403, 'Access denied.');
        }

        $songket->update([
            'is_active' => !$songket->is_active,
        ]);

        $status = $songket->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Product {$status} successfully!");
    }

    public function export(Request $request)
    {
        if (!Auth::user()->canAccess('export_songkets')) {
            abort(403, 'Access denied.');
        }

        $query = Songket::with('category');

        // Apply same filters as index
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        $response = new StreamedResponse(function () use ($products) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'ID',
                'Name',
                'Category',
                'Price',
                'Stock Quantity',
                'Status',
                'Featured',
                'Created At'
            ]);

            // Add data rows
            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->category->name,
                    $product->base_price,
                    $product->stock_quantity,
                    $product->is_active ? 'Active' : 'Inactive',
                    $product->is_featured ? 'Yes' : 'No',
                    $product->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="products-' . date('Y-m-d') . '.csv"');

        return $response;
    }
}
