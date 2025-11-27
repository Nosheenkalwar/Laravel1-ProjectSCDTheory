<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // User view of appointments
    public function index()
    {
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        return view('pages.appointments', compact('appointments'));
    }

    // Admin view of all appointments
public function adminIndex()
{
    // Fetch only confirmed or done appointments (skip canceled)
    $appointments = Appointment::where('status', '!=', 'canceled')
                               ->orderBy('appointment_date', 'desc')
                               ->get();

    return view('admin.appointment', compact('appointments'));
}

   public function store(Request $request)
{
    $request->validate([
        'user_name' => 'required|string|max:255',
        'user_email' => 'required|email|max:255',
        'user_contact' => 'required|string|max:20',
        'services' => 'required|array',
        'total_price' => 'required|numeric',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|string',
    ]);

    try {
        Appointment::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_contact' => $request->user_contact,
            'services' => $request->services,
            'total_price' => $request->total_price,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'confirmed',
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Your appointment has been successfully booked!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '⚠️ Failed to book appointment. Error: '.$e->getMessage()
        ], 500);
    }
}

    // User cancels appointment
    public function cancel($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete(); // Remove from DB

        return response()->json(['message' => 'Appointment cancelled successfully']);
    }

   public function markDone(Appointment $appointment, Request $request)
{
    $appointment->update(['status' => 'done']);

    return response()->json([
        'success' => true,
        'message' => 'Appointment marked as done.'
    ]);
}
    // Admin updates status (confirmed/canceled/done)
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorizeAdmin();

        $request->validate(['status' => 'required|in:confirmed,canceled,done']);

        $appointment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    private function authorizeAdmin()
    {
        if (!auth()->check() || !(auth()->user()->is_admin ?? false)) {
            abort(403);
        }
    }
}
