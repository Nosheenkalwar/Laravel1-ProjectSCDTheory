@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Your Cart</h2>

    <!-- Table Headings -->
    <div class="row fw-bold border-top pt-2 pb-2">
        <div class="col-md-6">Product</div>
        <div class="col-md-3 text-center">Quantity</div>
        <div class="col-md-2 text-center">Total</div>
        <div class="col-md-1 text-center">Remove</div>
    </div>

    <div id="cartContainer"></div>

    <div id="cartSummary" class="mt-4 d-none text-end">
    <h5 class="fw-bold">Estimated Total: Rs. <span id="cartTotal">0</span> PKR</h5>
    <p class="text-muted">Shipping will be calculated at checkout.</p>
    <div class="mt-3">
        <a href="{{ route('checkout') }}" class="btn btn-cart px-4">Checkout</a>
        <a href="{{ route('products') }}" class="btn btn-outline-dark px-4">Continue Shopping</a>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const container = document.getElementById('cartContainer');
    const summary = document.getElementById('cartSummary');
    const cartTotalEl = document.getElementById('cartTotal');

    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center p-5 border">
                <h5><i class="bi bi-cart-x me-2 text-secondary"></i>Your cart is empty</h5>
                <a href="{{ route('products') }}" class="btn btn-cart mt-3">Browse Products</a>
            </div>`;
        return;
    }

    let total = 0;
    container.innerHTML = '';

    cart.forEach((item, index) => {
        const subtotal = item.price * item.qty;
        total += subtotal;

        container.innerHTML += `
        <div class="row py-3 align-items-center border-top">
            <div class="col-md-6 d-flex align-items-center">
                <img src="${item.img}" class="img-fluid rounded me-3" style="width: 80px; height: 80px;">
                <div>
                    <h6>${item.name}</h6>
                    <small class="text-muted">Rs. ${item.price}</small>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <button class="btn btn-outline-dark btn-sm" onclick="changeQty(${index}, -1)">−</button>
                <input type="text" id="qty-${index}" value="${item.qty}" class="text-center mx-2" style="width: 40px;" disabled>
                <button class="btn btn-outline-dark btn-sm" onclick="changeQty(${index}, 1)">+</button>
            </div>
            <div class="col-md-2 text-center fw-bold">
                Rs. <span id="sub-${index}">${subtotal}</span>
            </div>
            <div class="col-md-1 text-center text-danger" style="cursor:pointer" onclick="removeItem(${index})">
            <i class="bi bi-trash"></i>
            </div>
        </div>`;
    });

    cartTotalEl.textContent = total;
    summary.classList.remove('d-none');

    window.changeQty = function(index, delta) {
        if (cart[index].qty + delta < 1) return;
        cart[index].qty += delta;
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById(`qty-${index}`).value = cart[index].qty;
        document.getElementById(`sub-${index}`).textContent = cart[index].qty * cart[index].price;
        cartTotalEl.textContent = cart.reduce((sum, i) => sum + i.qty * i.price, 0);
    };

    window.removeItem = function(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
    };
});
</script>
@endsection
