@extends('layouts.app')
@section('title', $product['name'])

@section('content')

<div class="container mt-5">

    <!-- Success Message -->
    <div id="cartMessage" class="alert alert-dismissible fade show text-center d-none" role="alert">
        <button type="button" class="btn-close" aria-label="Close" onclick="closeCartMessage()"></button>
    </div>

    <div class="row align-items-center">
        <!-- Product image -->
        <div class="col-md-6 text-center mb-4 mb-md-0">
            <img src="{{ asset('images/'.$product['img'].'.jpg') }}" class="img-fluid rounded shadow-sm" alt="{{ $product['name'] }}">
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
// Quantity
const qtyInput = document.getElementById('quantity');
document.getElementById('increaseQty').addEventListener('click', () => qtyInput.value++);
document.getElementById('decreaseQty').addEventListener('click', () => {
    if (qtyInput.value > 1) qtyInput.value--;
});

// Add to cart
document.getElementById('addToCartBtn').addEventListener('click', () => {
    const name = "{{ strtolower($product['name']) }}";
    const price = {{ $product['price'] }};
    const category = "{{ $product['category'] }}";
    const img = "{{ asset('images/'.$product['img'].'.jpg') }}";
    const qty = parseInt(qtyInput.value);

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(item => item.name === name);

    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ name, price, qty, category, img });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showCartMessage();
});

// Show success message with View Cart button
function showCartMessage() {
    const msg = document.getElementById('cartMessage');
    msg.innerHTML = `
        <i class="bi bi-check-circle-fill text-success"></i> Item added to cart!
<a href="{{ route('cart') }}" class="btn btn-sm btn-view-cart ms-2">View Cart</a>
    `;
    msg.classList.remove('d-none');
}

// Close message manually
function closeCartMessage() {
    document.getElementById('cartMessage').classList.add('d-none');
}
</script>
@endsection