@extends('frontend.app')
@section('title', 'Thank You')

@section('content')
<div class="thankyou-container">
    <div class="thankyou-card">
        <i class="bi bi-check-circle-fill thankyou-icon"></i>
        <h2 class="thankyou-title">Thank You for Your Order!</h2>
        <p class="thankyou-text">
            Your order has been placed successfully! Thank you for choosing us — we hope you enjoy your purchase.
        </p>

        <a href="{{ route('products') }}" class="btn btn-thankyou">Continue Shopping</a>
    </div>
</div>
@endsection
