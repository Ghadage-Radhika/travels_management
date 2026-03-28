<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with previous enquiries.
     */
    public function index()
    {
        $enquiries = Enquiry::where('user_id', Auth::id())
                            ->latest()
                            ->get();

        return view('dashboard', compact('enquiries'));
    }

    /**
     * Store a new enquiry submitted by the user.
     */
    public function storeEnquiry(Request $request)
    {
        $requiresDate = in_array($request->type_of_enquiry, [
            'Bus Booking', 'Sleeper Coach Booking', 'Bus Rental'
        ]);

        $rules = [
            'name'            => 'required|string|max:100',
            'mobile'          => 'required|digits:10',
            'address'         => 'required|string|max:255',
            'type_of_enquiry' => 'required|in:Bus Booking,Sleeper Coach Booking,Package Tours,Bus Rental',
            'message'         => 'nullable|string|max:1000',
        ];

        if ($requiresDate) {
            $rules['date_of_requirement'] = 'required|date|after_or_equal:today';
        }

        $validated = $request->validate($rules);

        Enquiry::create([
            'user_id'            => Auth::id(),
            'name'               => $validated['name'],
            'mobile'             => $validated['mobile'],
            'address'            => $validated['address'],
            'type_of_enquiry'    => $validated['type_of_enquiry'],
            'date_of_requirement'=> $requiresDate ? $validated['date_of_requirement'] : null,
            'message'            => $validated['message'] ?? null,
            'status'             => 'pending',
        ]);

        return redirect()->route('dashboard')->with('enquiry_success', 'Your enquiry has been submitted successfully! We will contact you soon.');
    }
}