@extends('layouts.app')
@section('title', 'Our Products')

@section('content')
<div class="container py-3">
    <h2 class="fw-bold text-center mb-4">Our Products</h2>

<div id="cartMessage" class="alert d-none alert-dismissible fade show text-center mx-auto cart-alert" role="alert">
    <i class="bi bi-check-circle-fill"></i> Item added to cart!
    <a href="{{ route('cart') }}" class="btn btn-sm btn-view-cart ms-2">View Cart</a>
    <button type="button" class="btn-close" aria-label="Close" onclick="closeCartMessage()"></button>
</div>


    <!-- Search & Filter Section -->
    <div class="row mb-3 justify-content-center">
        <div class="col-md-6 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-md-4 mb-2">
            <select id="categoryFilter" class="form-select">
                <option value="all">All Categories</option>
                <option value="skincare">Skincare</option>
                <option value="makeup">Makeup</option>
                <option value="haircare">Haircare</option>
                <option value="nail">Nail</option>
            </select>
        </div>
    </div>

    <!-- Sort By Section -->
    <div class="text-center mb-4">
        <label class="fw-semibold me-2">Sort by:</label>
        <select id="sortFilter" class="form-select d-inline-block w-auto">
            <option value="default">Default</option>
            <option value="low-high">Price: Low to High</option>
            <option value="high-low">Price: High to Low</option>
        </select>
    </div>

    <!-- Product Grid -->
    <div class="row" id="productGrid">
        @foreach($products as $p)
        <div class="col-md-4 mb-4 product-item" 
             data-category="{{ $p['category'] }}" 
             data-name="{{ strtolower($p['name']) }}" 
             data-price="{{ $p['price'] }}">
            <div class="card h-100 shadow-sm border-0 text-center p-2">
                <a href="{{ url('product-details/' . $p['id']) }}" class="text-dark text-decoration-none product-link">
                    <img src="{{ asset('images/'.$p['img'].'.jpg') }}" class="card-img-top rounded" alt="{{ $p['name'] }}">
                </a>

                <div class="card-body">
                    <h5 class="fw-semibold mb-1">{{ $p['name'] }}</h5>
                    <p class="text-muted mb-1">Category: {{ ucfirst($p['category']) }}</p>
                    <p class="fw-bold text-dark mb-2">Rs. {{ $p['price'] }}</p>

                    <!-- Quantity -->
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <button class="btn btn-outline-dark btn-sm" onclick="decreaseQty(this)">−</button>
                        <input type="text" class="form-control text-center mx-2 quantity-input" value="1" style="width:60px;">
                        <button class="btn btn-outline-dark btn-sm" onclick="increaseQty(this)">+</button>
                    </div>

                    <!-- Add to Cart -->
                    <button class="btn btn-cart w-100" onclick="addToCart(this)">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- JavaScript -->
<script>
// Filter & Sort Logic
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const sortFilter = document.getElementById('sortFilter');
const productGrid = document.getElementById('productGrid');

searchInput.addEventListener('input', filterProducts);
categoryFilter.addEventListener('change', filterProducts);
sortFilter.addEventListener('change', sortProducts);

function filterProducts(){
    const text = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    let anyVisible = false;

    document.querySelectorAll('.product-item').forEach(item=>{
        const matchesText = item.textContent.toLowerCase().includes(text);
        const matchesCat = category==='all' || item.dataset.category===category;
        if(matchesText && matchesCat){
            item.style.display='';
            anyVisible=true;
        } else {
            item.style.display='none';
        }
    });

    let msg = document.getElementById('noProductsMsg');
    if(!msg){
        msg = document.createElement('p');
        msg.id='noProductsMsg';
        msg.className='text-center fw-bold mt-3';
        msg.textContent='No products found!';
        document.getElementById('productGrid').appendChild(msg);
    }
    msg.style.display = anyVisible ? 'none' : 'block';
}

function sortProducts(){
    const sortValue = sortFilter.value;
    const products = Array.from(document.querySelectorAll('.product-item'));
    const sorted = products.sort((a,b)=>{
        const priceA = parseInt(a.dataset.price);
        const priceB = parseInt(b.dataset.price);
        if(sortValue==='low-high') return priceA - priceB;
        if(sortValue==='high-low') return priceB - priceA;
        return 0;
    });
    productGrid.innerHTML = '';
    sorted.forEach(p => productGrid.appendChild(p));
}

function increaseQty(btn){
    const input = btn.parentNode.querySelector('.quantity-input');
    input.value = parseInt(input.value)+1;
}

function decreaseQty(btn){
    const input = btn.parentNode.querySelector('.quantity-input');
    if(parseInt(input.value)>1) input.value = parseInt(input.value)-1;
}

// Add to Cart Function
function addToCart(button){
    const card = button.closest('.product-item');
    const name = card.dataset.name;
    const price = parseInt(card.dataset.price);
    const category = card.dataset.category;
    const img = card.querySelector('img').src;
    const qty = parseInt(card.querySelector('.quantity-input').value);

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(item => item.name === name);
    if(existing) existing.qty += qty;
    else cart.push({name, price, qty, category, img});

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showCartMessage();
}

// Show custom success message
function showCartMessage(){
    const msg = document.getElementById('cartMessage');
    msg.classList.remove('d-none');
}

// Close message manually
function closeCartMessage(){
    document.getElementById('cartMessage').classList.add('d-none');
}

// Update Cart Count
function updateCartCount(){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-count');
    if(badge) badge.textContent = totalItems;
}

document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
@endsection
