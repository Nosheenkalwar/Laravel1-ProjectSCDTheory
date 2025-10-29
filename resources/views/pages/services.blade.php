@extends('layouts.app')

@section('title', 'Services')

@section('content')

<!-- Main Services Section Container -->
<div class="container py-3">
    <h2 class="fw-bold text-center mb-4">Our Services</h2>

    <!-- Search And Filter Area -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-6 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Services...">
        </div>
        <div class="col-md-4 mb-2">
            <select id="categoryFilter" class="form-select">
                <option value="all">All Categories</option>
                <option value="skincare">Skincare</option>
                <option value="hair">Hair</option>
                <option value="massage">Massage</option>
                <option value="nails">Nails</option>
                <option value="manicure & pedicure">Manicure & Pedicure</option>
            </select>
        </div>
    </div>

    <!-- List Of Services -->
    <div class="row" id="serviceList">
        @php
        $services = [
            ['name'=>'Facial Glow Treatment','category'=>'skincare','price'=>2500,'img'=>'skin.png'],
            ['name'=>'Hair Dye','category'=>'hair','price'=>3000,'img'=>'hairspa.jpg'],
            ['name'=>'Deep Tissue Massage','category'=>'massage','price'=>6000,'img'=>'tissuemassage.jpg'],
            ['name'=>'Acrylic','category'=>'nails','price'=>3000,'img'=>'acrylic.jpg'],
        ];
        @endphp

        @foreach($services as $service)
        <div class="col-md-6 mb-4 service-item" data-category="{{ $service['category'] }}">
            <div class="card h-100 shadow-sm">
                <div class="row g-0 align-items-center">
                    <div class="col-4">
                        <img src="{{ asset('images/'.$service['img']) }}" class="img-fluid rounded-start" alt="{{ $service['name'] }}">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <input type="checkbox" class="form-check-input me-3 service-check mt-1">
                                <div>
                                    <h5 class="fw-semibold mb-1">{{ $service['name'] }}</h5>
                                    <p class="text-muted mb-1">Category: {{ ucfirst($service['category']) }}</p>
                                    <p class="fw-bold text-dark mb-0">Price: Rs. {{ $service['price'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Book Now Button -->
    <div class="text-center mt-3">
        <button class="btn btn-cart px-4" id="bookNowBtn">Book Now</button>
    </div>

    <!-- Select Date Section -->
    <div id="dateSection" class="mt-4 d-none text-center">
        <h4 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2"></i>Select Date</h4>
        <div id="dateOptions" class="d-flex justify-content-center flex-wrap gap-2"></div>
    </div>

    <!-- Select Time Section -->
    <div id="timeSection" class="mt-4 d-none text-center">
        <h4 class="fw-bold mb-3"><i class="bi bi-clock me-2"></i>Select Time Slot</h4>
        <div id="timeSlots" class="d-flex justify-content-center flex-wrap gap-2">
            @foreach(['10:00am - 11:00am','11:00am - 12:00pm','12:00pm - 01:00pm','2:00pm - 3:00pm','3:00pm - 4:00pm','4:00pm - 5:00pm','5:00pm - 6:00pm','6:00pm - 7:00pm'] as $slot)
            <button class="btn btn-outline-dark">{{ $slot }}</button>
            @endforeach
        </div>
    </div>

    <!-- Booking Summary Section -->
    <div id="summarySection" class="mt-5 d-none">
        <div class="card shadow-sm border-0 p-4">
            <h4 class="fw-bold mb-3 text-center">
    <i class="bi bi-clipboard-check me-2"></i>Booking Summary
            </h4>
            <div id="selectedServicesList" class="mb-3"></div>
            <p class="fw-bold text-end" id="totalPrice">Total: Rs. 0</p>
            <p class="fw-bold">Selected Date: <span id="summaryDate">-</span></p>
            <p class="fw-bold">Selected Time: <span id="summaryTime">-</span></p>

            <!-- Booking Form -->
            <h5 class="fw-semibold mt-4">Your Details</h5>
            <form id="bookingForm">
                <input type="text" id="customerName" class="form-control mb-2" placeholder="Full Name" required>
                <input type="email" id="customerEmail" class="form-control mb-2" placeholder="Email" required>
                <input type="text" id="customerContact" class="form-control mb-3" placeholder="Contact Number" required>
                <button type="submit" class="btn btn-cart w-100">Confirm Booking</button>
            </form>

            <!-- Success Message -->
            <p id="bookingSuccess" class="text-success fw-bold mt-3 text-center" style="display:none;">✅ Your booking has been confirmed!</p>
        </div>
    </div>
</div>

<!-- JavaScript Starts -->
<script>
    // Get All Main Elements
    const serviceChecks = document.querySelectorAll('.service-check');
    const bookNowBtn = document.getElementById('bookNowBtn');
    const dateSection = document.getElementById('dateSection');
    const timeSection = document.getElementById('timeSection');
    const summarySection = document.getElementById('summarySection');
    const dateOptions = document.getElementById('dateOptions');
    const timeSlots = document.querySelectorAll('#timeSlots button');

    // Generate Next 7 Days
    for (let i = 0; i < 7; i++) {
        const date = new Date();
        date.setDate(date.getDate() + i);
        const btn = document.createElement('button');
        btn.className = 'btn btn-outline-dark';
        btn.textContent = date.toDateString().slice(0, 10);
        btn.onclick = () => {
            document.querySelectorAll('#dateOptions button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            dateSection.dataset.selected = date.toDateString();
            timeSection.classList.remove('d-none');
        };
        dateOptions.appendChild(btn);
    }

    // Handle Time Slot Selection
    timeSlots.forEach(btn => {
        btn.onclick = () => {
            timeSlots.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            showSummary(btn.textContent);
        };
    });

    // When User Clicks Book Now
    bookNowBtn.onclick = () => {
        const selected = Array.from(serviceChecks)
            .filter(c => c.checked)
            .map(c => {
                const card = c.closest('.card');
                const name = card.querySelector('h5').textContent;
                const price = card.querySelector('.fw-bold').textContent.replace('Price: Rs. ', '');
                const img = card.querySelector('img').src;
                return { name, price, img };
            });

        if (selected.length === 0) {
            alert('Please select at least one service!');
            return;
        }

        dateSection.classList.remove('d-none');
        dateSection.dataset.services = JSON.stringify(selected);
        window.scrollTo({ top: dateSection.offsetTop, behavior: 'smooth' });
    };

    // Show Booking Summary
    function showSummary(time) {
        summarySection.classList.remove('d-none');
        const selected = JSON.parse(dateSection.dataset.services);
        const container = document.getElementById('selectedServicesList');
        container.innerHTML = '';
        let total = 0;

        selected.forEach(s => {
            total += parseInt(s.price);
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center mb-2 border p-2 rounded';
            div.innerHTML = `<img src="${s.img}" style="width:60px;height:60px;object-fit:cover;margin-right:10px;"> ${s.name} (Rs. ${s.price})`;
            container.appendChild(div);
        });

        document.getElementById('totalPrice').textContent = `Total: Rs. ${total}`;
        document.getElementById('summaryDate').textContent = dateSection.dataset.selected;
        document.getElementById('summaryTime').textContent = time;

        // When User Submits Form
        const bookingForm = document.getElementById('bookingForm');
        bookingForm.onsubmit = function (e) {
            e.preventDefault();
            bookingForm.style.display = 'none';
            document.getElementById('bookingSuccess').style.display = 'block';
        };
    }

    // Filter Services By Text Or Category
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');

    searchInput.addEventListener('input', filterServices);
    categoryFilter.addEventListener('change', filterServices);

    function filterServices() {
        const text = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        let anyVisible = false;

        document.querySelectorAll('.service-item').forEach(item => {
            const matchesText = item.textContent.toLowerCase().includes(text);
            const matchesCat = category === 'all' || item.dataset.category === category;
            if (matchesText && matchesCat) {
                item.style.display = '';
                anyVisible = true;
            } else {
                item.style.display = 'none';
            }
        });

        let msg = document.getElementById('noServicesMsg');
        if (!msg) {
            msg = document.createElement('p');
            msg.id = 'noServicesMsg';
            msg.className = 'text-center fw-bold mt-3';
            msg.textContent = 'No services found!';
            document.getElementById('serviceList').appendChild(msg);
        }
        msg.style.display = anyVisible ? 'none' : 'block';
    }
</script>
<!-- JavaScript Ends -->

@endsection
