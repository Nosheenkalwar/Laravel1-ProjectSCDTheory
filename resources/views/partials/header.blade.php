<!--Navigation Bar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold text-info" href="/">SerenityX Spa</a><!--logo Heading-->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
<!--All links in nav bar-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login / Register
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="/userlogin">Login</a></li>
                        <li><a class="dropdown-item" href="/userregister">Register</a></li>
                    </ul>
                </li>
                <li class="nav-item ms-3">
<!--Cart icon and button in header with count badge-->
                    <a class="nav-link position-relative" href="{{ route('cart') }}">
    <i class="bi bi-cart3 fs-4"></i>
    <span id="cartCount" class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">0</span>
</a>

                </li>
            </ul>
        </div>
    </div>
</nav>



               