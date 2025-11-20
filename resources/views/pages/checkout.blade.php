@extends('frontend.app')
@section('title', 'Checkout')

@section('content')
<div class="container mt-3">
    <h2 class="fw-bold text-center mb-4">Checkout</h2><!--Checkout heading-->
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!--Cart items-->
            <div id="cartItems" class="mb-4"></div>

            <!--Customer details form-->
            <form id="checkoutForm" class="shadow p-4 bg-light rounded">
                <div class="mb-3">
                    <label class="fw-semibold">Full Name</label>
                    <input type="text" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="mb-3">
                    <label class="fw-semibold">Address</label>
                    <textarea class="form-control" rows="3" placeholder="Enter your address" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="fw-semibold d-block mb-2">Payment Method</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="cod" checked>
                        <label class="form-check-label" for="cod"> Cash on Delivery </label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="payment" id="card">
                        <label class="form-check-label" for="card"> Credit / Debit Card </label>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span> <span id="subtotal">0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery:</span> <span id="delivery">100</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mt-2">
                        <span>Total:</span> <span id="total">0</span>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-cart px-4">Place Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!--Javascript-->
@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", ()=>{

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContainer = document.getElementById('cartItems');
    const delivery = 100;

    if(cart.length === 0){
        cartContainer.innerHTML = '<p class="text-center fw-bold">Your cart is empty!</p>';
    } else {
        let subtotal = 0;
        cartContainer.innerHTML = '';
        cart.forEach(item=>{
            subtotal += item.price * item.qty;
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center mb-2 border p-2 rounded';
            div.innerHTML = `
                <img src="${item.img}" style="width:60px;height:60px;object-fit:cover;margin-right:10px;" alt="${item.name}">
                <div class="flex-grow-1">
                    <h6 class="mb-1">${item.name}</h6>
                    <p class="mb-0">Price: Rs. ${item.price} | Qty: ${item.qty}</p>
                </div>
            `;
            cartContainer.appendChild(div);
        });

        document.getElementById('subtotal').textContent = subtotal;
        document.getElementById('total').textContent = subtotal + delivery;
    }

    // Checkout form submission
    document.getElementById('checkoutForm').addEventListener('submit', (e)=>{
        e.preventDefault();
        if(cart.length === 0){
            alert('Your cart is empty!');
            return;
        }
        const subtotal = cart.reduce((sum, i)=> sum + i.price*i.qty, 0);
       localStorage.removeItem('cart');
       window.location.href = "{{ route('thankyou') }}";
    });
});
</script>
@endsection
