<x-app-layout>

    <div class="w-full px-4 py-6 text-center">
    <h2 class="text-2xl font-bold text-gray-800">Appointments Management</h2>
    <p class="text-gray-500">View and manage all user appointments</p>
</div>


    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Services</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($appointments as $index => $a)
                    <tr data-id="{{ $a->id }}">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $a->user_name }}</td>
                        <td class="px-6 py-4">{{ $a->user_email }}</td>
                        <td class="px-6 py-4">{{ $a->user_contact }}</td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if(!empty($a->services) && is_array($a->services))
                                    @foreach($a->services as $service)
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                            {{ is_array($service) ? ($service['name'] ?? json_encode($service)) : $service }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-500 rounded">No services</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">{{ $a->appointment_date->format('Y-m-d') ?? $a->appointment_date }}</td>

                        <td class="px-6 py-4 status-cell">
                            <span class="px-3 py-1 text-xs font-semibold 
                                {{ $a->status == 'done' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} 
                                rounded-full">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($a->status != 'done')
                                <button class="mark-done-btn px-3 py-1 bg-green-500 text-white text-xs rounded"
                                        data-id="{{ $a->id }}">
                                    Mark Done
                                </button>
                            @else
                                <span class="text-gray-500 text-xs">Completed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Mark Done Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.mark-done-btn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const tr = btn.closest('tr');

                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PATCH');

                    fetch(`/admin/appointments/${id}/done`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const text = await res.text();
                            throw new Error(`Status ${res.status}: ${text}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            tr.querySelector('.status-cell').innerHTML = `
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                    Done
                                </span>`;
                            btn.remove();
                        } else {
                            alert('Failed: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('An error occurred. Check console.');
                    });
                });
            });
        });
    </script>

</x-app-layout>
