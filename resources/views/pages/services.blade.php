@extends('frontend.app')

@section('title', 'Services')

@section('content')

<div class="container py-3">
    <h2 class="fw-bold text-center mb-4">Our Services</h2>

    <!-- Search and Category Filter -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-6 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Services...">
        </div>
        <div class="col-md-4 mb-2">
            <select id="categoryFilter" class="form-select">
                <option value="all">All Categories</option>
                @foreach($services->pluck('category')->unique() as $cat)
                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Services List -->
    <div class="row" id="serviceList">
        @if($services->count())
            @foreach($services as $service)
            <div class="col-md-6 mb-4 service-item" data-category="{{ $service->category }}">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-4">
                            <img src="{{ $service->img ? asset('storage/'.$service->img) : asset('images/default.png') }}" 
                                 class="img-fluid rounded-start" alt="{{ $service->name }}">
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-2">
                                    <input type="checkbox" class="form-check-input me-3 service-check mt-1" data-price="{{ $service->price }}">
                                    <h5 class="card-title mb-0">{{ $service->name }}</h5>
                                </div>
                                <p class="card-text">{{ $service->description }}</p>
                                <p class="fw-bold">Price: Rs. {{ $service->price }}</p>
                                <small class="text-muted">Category: {{ $service->category }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-center fw-bold">No services available.</p>
        @endif
    </div>

    <!-- Book Now Button -->
    <div class="text-center mt-3">
        <button class="btn btn-cart px-4" id="bookNowBtn">Book Now</button>
    </div>

    <!-- Date Selection -->
    <div id="dateSection" class="mt-4 d-none text-center">
        <h4 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2"></i>Select Date</h4>
        <div id="dateOptions" class="d-flex justify-content-center flex-wrap gap-2"></div>
    </div>

    <!-- Time Selection -->
    <div id="timeSection" class="mt-4 d-none text-center">
        <h4 class="fw-bold mb-3"><i class="bi bi-clock me-2"></i>Select Time Slot</h4>
        <div id="timeSlots" class="d-flex justify-content-center flex-wrap gap-2">
            @foreach(['10:00am - 11:00am','11:00am - 12:00pm','12:00pm - 01:00pm','2:00pm - 3:00pm','3:00pm - 4:00pm','4:00pm - 5:00pm','5:00pm - 6:00pm','6:00pm - 7:00pm'] as $slot)
                <button class="btn btn-outline-dark">{{ $slot }}</button>
            @endforeach
        </div>
    </div>

    <!-- Booking Summary -->
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
                @csrf
                <input type="text" id="customerName" class="form-control mb-2" placeholder="Full Name" required>
                <input type="email" id="customerEmail" class="form-control mb-2" placeholder="Email" required>
                <input type="text" id="customerContact" class="form-control mb-3" placeholder="Contact Number" required>
                <button type="submit" class="btn btn-cart w-100">Confirm Booking</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" aria-labelledby="msgModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <p id="modalMessage" class="fw-bold"></p>
        <button type="button" class="btn btn-cart mt-2" id="modalOkBtn">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const bookNowBtn = document.getElementById('bookNowBtn');
    const dateSection = document.getElementById('dateSection');
    const timeSection = document.getElementById('timeSection');
    const summarySection = document.getElementById('summarySection');
    const dateOptions = document.getElementById('dateOptions');

    const msgModal = new bootstrap.Modal(document.getElementById('msgModal'));
    const modalMessage = document.getElementById('modalMessage');
    const modalOkBtn = document.getElementById('modalOkBtn');

    modalOkBtn.onclick = () => { msgModal.hide(); window.scrollTo({ top: 0, behavior: 'smooth' }); }

    // Generate next 7 days
    for (let i = 0; i < 7; i++) {
        const date = new Date();
        date.setDate(date.getDate() + i);
        const btn = document.createElement('button');
        btn.className = 'btn btn-outline-dark';
        btn.textContent = date.toDateString().slice(0, 10);
        btn.addEventListener('click', () => {
            document.querySelectorAll('#dateOptions button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            dateSection.dataset.selected = date.toISOString().split('T')[0];
            timeSection.classList.remove('d-none');
        });
        dateOptions.appendChild(btn);
    }

    // Book Now click
    bookNowBtn.addEventListener('click', () => {
        const selected = Array.from(document.querySelectorAll('.service-check'))
            .filter(c => c.checked)
            .map(c => {
                const card = c.closest('.card');
                return {
                    name: card.querySelector('h5').textContent,
                    price: parseInt(c.dataset.price || 0),
                    img: card.querySelector('img').src
                };
            });

        if(selected.length === 0){
            modalMessage.textContent = "⚠️ Please select at least one service!";
            msgModal.show();
            return;
        }

        dateSection.dataset.services = JSON.stringify(selected);
        dateSection.classList.remove('d-none');
        timeSection.classList.add('d-none');
        summarySection.classList.add('d-none');
        window.scrollTo({ top: dateSection.offsetTop, behavior: 'smooth' });
    });

    // Time slot selection
    document.getElementById('timeSlots').addEventListener('click', e => {
        if(e.target.tagName === 'BUTTON'){
            document.querySelectorAll('#timeSlots button').forEach(b => b.classList.remove('active'));
            e.target.classList.add('active');
            showSummary(e.target.textContent);
        }
    });

    // Show booking summary
    function showSummary(time){
        summarySection.classList.remove('d-none');
        const selected = JSON.parse(dateSection.dataset.services);
        const container = document.getElementById('selectedServicesList');
        container.innerHTML = '';
        let total = 0;

        selected.forEach(s => {
            total += s.price;
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center mb-2 border p-2 rounded';
            div.innerHTML = `<img src="${s.img}" style="width:60px;height:60px;object-fit:cover;margin-right:10px;"> ${s.name} (Rs. ${s.price})`;
            container.appendChild(div);
        });

        document.getElementById('totalPrice').textContent = `Total: Rs. ${total}`;
        document.getElementById('summaryDate').textContent = dateSection.dataset.selected;
        document.getElementById('summaryTime').textContent = time;

        const bookingForm = document.getElementById('bookingForm');
        bookingForm.onsubmit = function(e){
            e.preventDefault();

            fetch('{{ route("appointments.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_name: document.getElementById('customerName').value,
                    user_email: document.getElementById('customerEmail').value,
                    user_contact: document.getElementById('customerContact').value,
                    services: JSON.parse(dateSection.dataset.services),
                    total_price: total,
                    appointment_date: dateSection.dataset.selected,
                    appointment_time: time
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    bookingForm.style.display = 'none';
                    modalMessage.textContent = "✅ Your booking has been confirmed!";
                    msgModal.show();
                } else {
                    modalMessage.textContent = data.message || "⚠️ Failed to confirm booking. Please try again!";
                    msgModal.show();
                }
            })
            .catch(err => {
                console.error(err);
                modalMessage.textContent = "⚠️ An error occurred. Please try again!";
                msgModal.show();
            });
        }
    }

    // Search & filter
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    searchInput.addEventListener('input', filterServices);
    categoryFilter.addEventListener('change', filterServices);

    function filterServices(){
        const text = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        let anyVisible = false;

        document.querySelectorAll('.service-item').forEach(item => {
            const matchesText = item.textContent.toLowerCase().includes(text);
            const matchesCat = category === 'all' || item.dataset.category === category;
            if(matchesText && matchesCat){
                item.style.display = '';
                anyVisible = true;
            }else{
                item.style.display = 'none';
            }
        });

        let msg = document.getElementById('noServicesMsg');
        if(!msg){
            msg = document.createElement('p');
            msg.id = 'noServicesMsg';
            msg.className = 'text-center fw-bold mt-3';
            msg.textContent = 'No services found!';
            document.getElementById('serviceList').appendChild(msg);
        }
        msg.style.display = anyVisible ? 'none' : 'block';
    }
});
</script>

@endsection
