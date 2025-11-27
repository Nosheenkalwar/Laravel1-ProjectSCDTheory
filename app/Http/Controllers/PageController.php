<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Home Page
    public function home() {
        return view('pages.home');
    }

    // Products Page
    public function products(Request $request) {

        // Start query
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Sort by price
        if ($request->filled('sort')) {
            if ($request->sort == 'low-high') $query->orderBy('price', 'asc');
            if ($request->sort == 'high-low') $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'desc'); // default order
        }

        // Pagination
        $products = $query->paginate(9)->withQueryString();

        // Distinct categories for filter dropdown
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('pages.products', compact('products', 'categories'));
    }

    // Product Details
    public function details($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product-details', compact('product'));
    }

    // Cart Page
    public function cart() {
        return view('pages.cart');
    }

    // Checkout Page
    public function checkout() {
        return view('pages.checkout');
    }

    // Other Pages
    public function about() { return view('pages.about'); }
   // **Services Page**
    public function services() {
        $services = Service::all(); // Fetch all services from DB
        return view('pages.services', compact('services'));
    }

    public function contact() { return view('pages.contact'); }
    public function login() { return view('pages.login'); }
    public function register() { return view('pages.register'); }
    public function thankyou() { return view('pages.thankyou'); }
    public function orders() { return view('pages.orders'); }
    public function appointments() { return view('pages.appointments'); }
}
