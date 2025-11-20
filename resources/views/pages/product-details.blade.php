@extends('frontend.app')
@section('title', $product['name'])

@section('content')

<div class="container mt-5">

    <!-- Center Modal -->
    <div id="cartModal" 
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); 
                justify-content:center; align-items:center; z-index:9999;">
        <div style="background:white; padding:20px; border-radius:10px; text-align:center; max-width:350px; width:90%; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <p>Added to cart Successfully!</p>
            <img id="cartModalImg" src="" alt="Product Image" style="max-width:150px; margin-bottom:15px;">
            <h5 id="cartModalName" class="fw-bold mb-2"></h5>
            <p id="cartModalPrice" class="mb-3"></p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('cart') }}" class="btn btn-cart">View Cart</a>
                <button id="cartModalOk" class="btn btn-outline-dark">OK</button>
            </div>
        </div>
    </div>

    <div class="row align-items-center">
        <!-- Product image -->
        <div class="col-md-6 text-center mb-4 mb-md-0">
            <img src="{{ $product['img'] ? asset('storage/' . $product['img']) : asset('images/default.jpg') }}" 
                 class="img-fluid rounded shadow-sm" alt="{{ $product['name'] }}">
        </div>

        <!-- Product details -->
        <div class="col-md-6">
            <h3 class="fw-bold mb-2">{{ $product['name'] }}</h3>
            <p class="text-muted">{{ $product['desc'] }}</p>
            <p class="fw-bold fs-5 mb-3">Rs. {{ $product['price'] }}</p>

            <!-- Quantity -->
            <div class="d-flex align-items-center mb-3">
                <label class="fw-semibold me-2">Quantity:</label>
                <div class="input-group" style="width: 130px;">
                    <button class="btn btn-outline-dark" id="decreaseQty">−</button>
                    <input type="text" id="quantity" class="form-control text-center" value="1" readonly>
                    <button class="btn btn-outline-dark" id="increaseQty">+</button>
                </div>
            </div>

            <!-- Add to cart button -->
            <button class="btn btn-cart mb-4 px-4" id="addToCartBtn">Add to Cart</button>

            <hr>

            <!-- Reviews -->
            <h5 class="fw-bold mt-3">Customer Reviews</h5>
            <p>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star text-warning"></i>
                (4.0/5)
            </p>
            <blockquote class="text-muted fst-italic">“Excellent product! Will buy again.”</blockquote>

            <!-- Review form -->
            <div class="mt-3">
                <label for="reviewText" class="fw-semibold">Write your review:</label>
                <textarea id="reviewText" class="form-control mb-2" rows="3" placeholder="Share your experience..."></textarea>
                <button class="btn btn-cart">Submit Review</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Quantity control
const qtyInput = document.getElementById('quantity');
document.getElementById('increaseQty').addEventListener('click', () => qtyInput.value++);
document.getElementById('decreaseQty').addEventListener('click', () => {
    if (qtyInput.value > 1) qtyInput.value--;
});

// Add to cart + show modal
document.getElementById('addToCartBtn').addEventListener('click', () => {
    const name = "{{ $product['name'] }}";
    const price = {{ $product['price'] }};
    const img = "{{ $product['img'] ? asset('storage/' . $product['img']) : asset('images/default.jpg') }}";
    const qty = parseInt(qtyInput.value);

    // Update localStorage cart
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(item => item.name === name);

    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ name, price, qty, img });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();

    // Show modal
    const modal = document.getElementById('cartModal');
    document.getElementById('cartModalImg').src = img;
    document.getElementById('cartModalName').textContent = name;
    document.getElementById('cartModalPrice').textContent = 'Rs. ' + price;
    modal.style.display = 'flex';
});

// Close modal
document.getElementById('cartModalOk').addEventListener('click', () => {
    document.getElementById('cartModal').style.display = 'none';
});

// Update cart badge
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const total = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = total;
}
</script>
@endsection
