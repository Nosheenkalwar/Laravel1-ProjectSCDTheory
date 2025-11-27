@extends('frontend.app')

@section('content')

<div class="container py-2">
    <h2 class="mb-4 text-center fw-bold">My Appointments</h2>

    @foreach($appointments as $a)
        <div class="card mb-3 appointment-card" id="appointment-{{ $a->id }}">
            <div class="card-body">
                <h5>{{ $a->user_name }}</h5>
                <p><strong>Date:</strong> {{ $a->appointment_date }}</p>
                <p><strong>Time:</strong> {{ $a->appointment_time }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-info">{{ ucfirst($a->status) }}</span>
                </p>

                <p><strong>Services:</strong> 
                    @if(!empty($a->services) && is_array($a->services))
                        @foreach($a->services as $service)
                            <span class="badge bg-secondary">{{ is_array($service) ? ($service['name'] ?? json_encode($service)) : $service }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">No services</span>
                    @endif
                </p>

                @if($a->status == "confirmed")
                    <button class="btn btn-danger btn-sm" onclick="cancelAppointment({{ $a->id }})">Cancel</button>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection

@section('styles')
<style>
    .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease-out, height 0.5s ease-out, margin 0.5s ease-out, padding 0.5s ease-out;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
</style>
@endsection

@section('scripts')
<script>
function cancelAppointment(id) {
    if(!confirm('Are you sure you want to cancel this appointment?')) return;

    fetch(`/appointments/${id}/cancel`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.message === 'Appointment cancelled successfully') {
            const card = document.getElementById(`appointment-${id}`);
            if(card) {
                card.classList.add('fade-out');
                setTimeout(() => card.remove(), 500);
            }
        } else {
            alert(data.message || 'Failed to cancel the appointment.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    });
}
</script>
@endsection
