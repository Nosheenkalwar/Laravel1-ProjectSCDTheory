@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section>
    <h1 class="text-center mb-4">Contact Us</h1>
    <p class="text-center">Feel free to send us inquiries about our services, bookings, or anything else you would like to contact us about!</p>

    <div class="row justify-content-center mt-4">
        

        <!-- Contact Form -->
        <div class="col-md-6 mb-4">
            <h5 class="text-center mb-4">Send us a message</h5>
            <form>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" placeholder="Your Phone">
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" placeholder="Subject">
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="Type your message here"></textarea>
                </div>

                <button type="submit" class="btn btn-custom ">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection
