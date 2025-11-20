@extends('frontend.app')
@section('title', 'Our Products')

@section('content')
<div class="container py-3">
    <h2 class="fw-bold text-center mb-4">Our Products</h2>

    <!-- Custom Center Modal -->
    <div id="cartModal" 
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); 
                justify-content:center; align-items:center; z-index:9999;">
        <div style="background:white; padding:20px; border-radius:10px; text-align:center; max-width:350px; width:90%; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <p>Added to cart Successfully!</p>
            <img id="cartModalImg" src="" alt="Product Image" style="max-width:100px; margin-bottom:15px;">
            <h5 id="cartModalName" class="fw-bold mb-2"></h5>
            <p id="cartModalPrice" class="mb-3"></p>
            <div class="d-flex justify-content-center gap-2">
                
                <a href="{{ route('cart') }}" class="btn btn-cart">View Cart</a>
                <button id="cartModalOk" class="btn btn-outline-dark">OK</button>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-3 justify-content-center">
        <div class="col-md-6 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-md-4 mb-2">
            <select id="categoryFilter" class="form-select">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Sort By -->
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
        @forelse($products as $p)
        <div class="col-md-4 mb-4 product-item" 
             data-category="{{ $p->category }}" 
             data-name="{{ $p->name }}" 
             data-price="{{ $p->price }}">
            <div class="card h-100 shadow-sm border-0 text-center p-2">
                <a href="{{ url('product-details/' . $p->id) }}" class="text-dark text-decoration-none product-link">
                    <img src="{{ $p->img ? asset('storage/'.$p->img) : asset('images/default.jpg') }}" 
                         class="card-img-top rounded" alt="{{ $p->name }}">
                </a>
                <div class="card-body">
                    <h5 class="fw-semibold mb-1">{{ $p->name }}</h5>
                    <p class="text-muted mb-1">Category: {{ ucfirst($p->category) }}</p>
                    <p class="fw-bold text-dark mb-2">Rs. {{ $p->price }}</p>

                    <!-- Quantity -->
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <button class="btn btn-outline-dark btn-sm" onclick="changeQty(this, -1)">−</button>
                        <input type="text" class="form-control text-center mx-2 quantity-input" value="1" style="width:60px;">
                        <button class="btn btn-outline-dark btn-sm" onclick="changeQty(this, 1)">+</button>
                    </div>

                    <!-- Add to Cart -->
                    <button class="btn btn-cart w-100" onclick="addToCart(this)">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        @empty
            <p class="text-center fw-bold mt-3">No products found!</p>
        @endforelse
    </div>
</div>

<!-- ===================== JS ===================== -->
<script>
// Quantity Change
function changeQty(btn, delta){
    const input = btn.parentNode.querySelector('.quantity-input');
    let val = parseInt(input.value) || 1;
    val += delta;
    if(val < 1) val = 1;
    input.value = val;
}

// Add to Cart + show modal
function addToCart(button){
    const card = button.closest('.product-item');
    const name = card.dataset.name;
    const price = parseInt(card.dataset.price);
    const img = card.querySelector('img').src;
    const qty = parseInt(card.querySelector('.quantity-input').value);

    // Update localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(item => item.name === name);
    if(existing) existing.qty += qty;
    else cart.push({name, price, qty, img});
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();

    // Show modal
    document.getElementById('cartModalImg').src = img;
    document.getElementById('cartModalName').textContent = name;
    document.getElementById('cartModalPrice').textContent = 'Rs. ' + price;
    document.getElementById('cartModal').style.display = 'flex';
}

// Close modal
document.getElementById('cartModalOk').addEventListener('click', function(){
    document.getElementById('cartModal').style.display = 'none';
});

// Update Cart Count
function updateCartCount(){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const total = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-count');
    if(badge) badge.textContent = total;
}

// Filter & Sort
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const sortFilter = document.getElementById('sortFilter');
const productGrid = document.getElementById('productGrid');

[searchInput, categoryFilter].forEach(el => el && el.addEventListener('input', filterProducts));
if(sortFilter) sortFilter.addEventListener('change', sortProducts);

function filterProducts(){
    const text = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    let anyVisible = false;

    document.querySelectorAll('.product-item').forEach(item=>{
        const matchesText = item.dataset.name.toLowerCase().includes(text);
        const matchesCat = category==='all' || item.dataset.category===category;
        item.style.display = (matchesText && matchesCat) ? '' : 'none';
        if(matchesText && matchesCat) anyVisible = true;
    });

    let msg = document.getElementById('noProductsMsg');
    if(!msg){
        msg = document.createElement('p');
        msg.id = 'noProductsMsg';
        msg.className = 'text-center fw-bold mt-3';
        msg.textContent = 'No products found!';
        productGrid.appendChild(msg);
    }
    msg.style.display = anyVisible ? 'none' : 'block';
}

function sortProducts(){
    const sortValue = sortFilter.value;
    const products = Array.from(document.querySelectorAll('.product-item'));
    products.sort((a,b)=>{
        const priceA = parseInt(a.dataset.price);
        const priceB = parseInt(b.dataset.price);
        if(sortValue==='low-high') return priceA - priceB;
        if(sortValue==='high-low') return priceB - priceA;
        return 0;
    }).forEach(p => productGrid.appendChild(p));
}

// Initialize cart count
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
@endsection
