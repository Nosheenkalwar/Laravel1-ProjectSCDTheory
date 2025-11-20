@extends('frontend.app')

@section('content')




<!-- Hero Video Banner -->
<section class="hero-video">
    <video autoplay muted loop class="hero-video-bg">
        <source src="{{ asset('images/hero.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="hero-overlay">
        <h1 class="text-center">SerenityX Spa</h1>
        <p class="text-center">Beauty | Spa | Services</p>
        <a href="{{ route('services') }}" class="btn btn-hero">Book Service</a>
    </div>
</section>



<!-- Divider Line -->
<div class="section-divider"></div>

<!-- Our Services Section -->
<section class="services">
    <h2 class="text-center">Our Services</h2>

    <div class="service-gallery">
        <div class="service-card">
            <img src="{{ asset('images/nails.jpg') }}" alt="Nail Care">
            <h4>Nail Care</h4>
        </div>

        <div class="service-card">
            <img src="{{ asset('images/foot.jpg') }}" alt="Foot Massage">
            <h4>Foot Massage</h4>
        </div>

        <div class="service-card">
            <img src="{{ asset('images/hand.jpg') }}" alt="Hand Spa">
            <h4>Hand Spa</h4>
        </div>

        <div class="service-card">
            <img src="{{ asset('images/wax.jpg') }}" alt="Lash Extension">
            <h4>Lash Extension</h4>
        </div>

        <div class="service-card">
            <img src="{{ asset('images/makeup.jpg') }}" alt="Makeup">
            <h4>Makeup</h4>
        </div>
    </div>
</section>

<!-- Divider Line -->
<div class="section-divider"></div>

<!-- Reviews Section -->
<section class="reviews">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">What Our Clients Say</h2>
        
        <!-- Review Cards -->
        <div class="review-cards">
            <div class="review">
                <p>"Absolutely relaxing experience! Highly recommended!"</p>
                <span>- Ayesha</span>
            </div>
            <div class="review">
                <p>"The best spa in town. Staff was so friendly and professional."</p>
                <span>- Sara</span>
            </div>
            <div class="review">
                <p>"Loved the ambiance and services. Will visit again!"</p>
                <span>- Hina</span>
            </div>
        </div>

        <!-- Submit Review Form -->
        <div class="submit-review">
            <h4 class="mt-5 mb-3">Share Your Experience</h4>
            <textarea placeholder="Write your review here..." rows="4"></textarea>
            <br>
            <button  class="btn btn-submit-review">Submit Review</button>
        </div>
    </div>
</section>


@endsection

