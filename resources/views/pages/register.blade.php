@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="container d-flex justify-content-center align-items-center">
    <div class="col-md-6">
        <h1 class ="text-center">Create an Account</h1>
        <form action="{{ route('home') }}" method="get">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="********" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="********" required>
            </div>
            <button type="submit" class="btn btn-custom ">Register</button>
        </form>
    </div>
</section>
@endsection
