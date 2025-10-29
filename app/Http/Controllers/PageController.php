<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Home Page
    public function home() {
        return view('pages.home');
    }

    // Products Page
    public function products() {
        $products = [
            1 => ['id'=>1, 'name'=>'Hair Oil', 'img'=>'hairoil', 'price'=>2000, 'category'=>'haircare', 'desc'=>'Natural nourishment for shiny hair'],
            2 => ['id'=>2, 'name'=>'Lipstick', 'img'=>'lipstick', 'price'=>1500, 'category'=>'makeup', 'desc'=>'Long-lasting lipstick'],
            3 => ['id'=>3, 'name'=>'Blush', 'img'=>'blush', 'price'=>1800, 'category'=>'makeup', 'desc'=>'Gives a natural glow'],
            4 => ['id'=>4, 'name'=>'Sunscreen', 'img'=>'sunscreen', 'price'=>2200, 'category'=>'skincare', 'desc'=>'Protects your skin from UV rays'],
            5 => ['id'=>5, 'name'=>'Nail Polish', 'img'=>'nailpaint', 'price'=>1300, 'category'=>'nail', 'desc'=>'Bright colors for nails'],
            6 => ['id'=>6, 'name'=>'Cosmetic Kit', 'img'=>'cosmetics', 'price'=>3500, 'category'=>'makeup', 'desc'=>'Complete kit for makeup lovers'],
        ];

        return view('pages.products', compact('products'));
    }

    // Product Details
    public function details($id)
    {
        $products = [
            1 => ['id'=>1, 'name'=>'Hair Oil', 'img'=>'hairoil', 'price'=>2000, 'category'=>'haircare', 'desc'=>'Natural nourishment for shiny hair'],
            2 => ['id'=>2, 'name'=>'Lipstick', 'img'=>'lipstick', 'price'=>1500, 'category'=>'makeup', 'desc'=>'Long-lasting lipstick'],
            3 => ['id'=>3, 'name'=>'Blush', 'img'=>'blush', 'price'=>1800, 'category'=>'makeup', 'desc'=>'Gives a natural glow'],
            4 => ['id'=>4, 'name'=>'Sunscreen', 'img'=>'sunscreen', 'price'=>2200, 'category'=>'skincare', 'desc'=>'Protects your skin from UV rays'],
            5 => ['id'=>5, 'name'=>'Nail Polish', 'img'=>'nailpaint', 'price'=>1300, 'category'=>'nail', 'desc'=>'Bright colors for nails'],
            6 => ['id'=>6, 'name'=>'Cosmetic Kit', 'img'=>'cosmetics', 'price'=>3500, 'category'=>'makeup', 'desc'=>'Complete kit for makeup lovers'],
        ];

        if (!isset($products[$id])) abort(404);

        $product = $products[$id];

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
    public function services() { return view('pages.services'); }
    public function contact() { return view('pages.contact'); }
    public function login() { return view('pages.login'); }
    public function register() { return view('pages.register'); }
    public function thankyou() { return view('pages.thankyou'); }
}
