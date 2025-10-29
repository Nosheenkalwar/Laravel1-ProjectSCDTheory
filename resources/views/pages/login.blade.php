@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section>
    <h1 class="text-center mb-4">Login</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="mt-4" action="{{ route('home') }}" method="get">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-custom">Login</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
