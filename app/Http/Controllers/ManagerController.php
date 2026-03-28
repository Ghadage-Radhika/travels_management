<?php
// app/Http/Controllers/ManagerController.php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\BusBooking;
use App\Models\BillingRecord;
use App\Models\BusMaintenance;
use App\Models\BusTax;
use App\Models\BusInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ManagerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $allEnquiries = Enquiry::with('user')->latest()->paginate(20);
        $allForStats  = Enquiry::with('user')->latest()->get();

        // ── Maintenance: load all records (search/sort is handled client-side in JS) ──
        $maintenanceRecords = BusMaintenance::latest()
            ->paginate(200, ['*'], 'maint_page'); // high limit so all records are available client-side

        return view('manager.dashboard', [
            'allEnquiries'         => $allEnquiries,
            'recentEnquiries'      => $allForStats->take(8),
            'totalEnquiries'       => $allForStats->count(),
            'pendingCount'         => $allForStats->where('status', 'pending')->count(),
            'resolvedCount'        => $allForStats->where('status', 'approved')->count(),
            'busCount'             => $allForStats->where('type_of_enquiry', 'Bus Booking')->count(),
            'sleeperCount'         => $allForStats->where('type_of_enquiry', 'Sleeper Coach Booking')->count(),
            'packageCount'         => $allForStats->where('type_of_enquiry', 'Package Tours')->count(),
            'rentalCount'          => $allForStats->where('type_of_enquiry', 'Bus Rental')->count(),
            'totalUsers'           => User::count(),
            'todayCount'           => Enquiry::whereDate('created_at', today())->count(),
            'upcomingCount'        => Enquiry::whereNotNull('date_of_requirement')
                                             ->whereDate('date_of_requirement', '>=', today())
                                             ->count(),
            'busBookings'          => BusBooking::latest()->paginate(15),
            'billingRecords'       => BillingRecord::with('booking')->latest()->paginate(15, ['*'], 'billing_page'),
            'maintenanceRecords'   => $maintenanceRecords,
            'totalMaintenanceCost' => BusMaintenance::sum('amount_paid'),
            'maintCount'           => BusMaintenance::count(),
            'bookingCount'         => BusBooking::count(),
            'billingCount'         => BillingRecord::count(),
            'taxCount'             => BusTax::count(),
            'insuranceCount'       => BusInsurance::count(),
            // ── Insurance Module ──────────────────────────────────────────
            'taxRecords'           => BusTax::latest('tax_date')->get(),
            'insuranceRecords'     => BusInsurance::latest('insurance_date')->get(),
            'totalTaxCost'         => BusTax::sum('amount'),
            'totalInsuranceCost'   => BusInsurance::sum('amount'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RESOLVE ENQUIRY
    |--------------------------------------------------------------------------
    */
    public function resolveEnquiry($id)
    {
        Enquiry::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('manager_success', "Enquiry #{$id} marked as approved.");
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ENQUIRY
    |--------------------------------------------------------------------------
    */
    public function destroyEnquiry($id)
    {
        Enquiry::findOrFail($id)->delete();
        return back()->with('manager_success', "Enquiry #{$id} deleted successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | SHARED VALIDATION RULES — BUS BOOKING
    |--------------------------------------------------------------------------
    */
    private function bookingRules(): array
    {
        return [
            'booking_date'   => ['required', 'date', 'after:today'],
            'route_from'     => 'required|string|max:100',
            'route_to'       => 'required|string|max:100|different:route_from',
            'kilometer'      => 'required|numeric|min:1',
            'bus_no'         => 'required|string|max:20',
            'pickup_time'    => 'required|date_format:H:i',
            'booking_amount' => 'required|numeric|min:1',
            'advance_amount' => 'required|numeric|min:0|lte:booking_amount',
            'note'           => 'nullable|string|max:500',
        ];
    }

    private function bookingMessages(): array
    {
        return [
            'booking_date.after'      => 'Booking date must be after today.',
            'route_to.different'      => 'Start and destination cannot be the same.',
            'advance_amount.lte'      => 'Advance cannot exceed booking amount.',
            'pickup_time.date_format' => 'Pickup time must be a valid time (HH:MM).',
        ];
    }

    private function pickupTimeCheck(string $date, string $time): bool
    {
        return $date === Carbon::today()->toDateString()
            && $time <= Carbon::now()->format('H:i');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE BUS BOOKING
    |--------------------------------------------------------------------------
    */
    public function storeBooking(Request $request)
    {
        $validated = $request->validateWithBag('booking', $this->bookingRules(), $this->bookingMessages());

        if ($this->pickupTimeCheck($validated['booking_date'], $validated['pickup_time'])) {
            return back()
                ->withErrors(['pickup_time' => 'Pickup time must be greater than current time.'], 'booking')
                ->withInput();
        }

        BusBooking::create([
            'booking_date'     => $validated['booking_date'],
            'route_from'       => $validated['route_from'],
            'route_to'         => $validated['route_to'],
            'kilometer'        => $validated['kilometer'],
            'bus_number'       => strtoupper($validated['bus_no']),
            'pickup_time'      => $validated['pickup_time'],
            'booking_amount'   => $validated['booking_amount'],
            'advance_amount'   => $validated['advance_amount'],
            'remaining_amount' => $validated['booking_amount'] - $validated['advance_amount'],
            'note'             => $validated['note'] ?? null,
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('manager.dashboard')
            ->with('booking_success', 'Bus booking confirmed successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE BUS BOOKING
    |--------------------------------------------------------------------------
    */
    public function updateBooking(Request $request, $id)
    {
        $booking   = BusBooking::findOrFail($id);
        $validated = $request->validateWithBag('editBooking', $this->bookingRules(), $this->bookingMessages());

        if ($this->pickupTimeCheck($validated['booking_date'], $validated['pickup_time'])) {
            return back()
                ->withErrors(['pickup_time' => 'Pickup time must be greater than current time.'], 'editBooking')
                ->withInput();
        }

        $booking->update([
            'booking_date'     => $validated['booking_date'],
            'route_from'       => $validated['route_from'],
            'route_to'         => $validated['route_to'],
            'kilometer'        => $validated['kilometer'],
            'bus_number'       => strtoupper($validated['bus_no']),
            'pickup_time'      => $validated['pickup_time'],
            'booking_amount'   => $validated['booking_amount'],
            'advance_amount'   => $validated['advance_amount'],
            'remaining_amount' => $validated['booking_amount'] - $validated['advance_amount'],
            'note'             => $validated['note'] ?? null,
        ]);

        return redirect()->route('manager.dashboard')
            ->with('booking_success', "Booking #{$id} updated successfully!");
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE BOOKING
    |--------------------------------------------------------------------------
    */
    public function destroyBooking($id)
    {
        BusBooking::findOrFail($id)->delete();
        return back()->with('manager_success', "Booking #{$id} deleted successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF (Bookings)
    |--------------------------------------------------------------------------
    */
    public function exportBookingsPdf()
    {
        $bookings   = BusBooking::latest()->get();
        $exportMode = true;
        return view('manager.bookings.pdf', compact('bookings', 'exportMode'));
    }

    public function printBookings()
    {
        $bookings   = BusBooking::latest()->get();
        $exportMode = false;
        return view('manager.bookings.pdf', compact('bookings', 'exportMode'));
    }

    /*
    |==========================================================================
    | BILLING MODULE
    |==========================================================================
    */

    private function billingRules(): array
    {
        return [
            'bus_booking_id' => 'required|exists:bus_bookings,id',
            'rate_per_km'    => 'nullable|numeric|min:0',
            'diesel_amount'  => 'nullable|numeric|min:0',
            'toll_parking'   => 'nullable|numeric|min:0',
            'online_permit'  => 'nullable|numeric|min:0',
            'driver_amount'  => 'nullable|numeric|min:0',
            'other_expenses' => 'nullable|numeric|min:0',
            'driver_name'    => 'nullable|string|max:100',
            'driver_mobile'  => 'nullable|string|max:20',
            'description'    => 'nullable|string|max:1000',
        ];
    }

    public function storeBilling(Request $request)
    {
        $validated = $request->validateWithBag('billing', $this->billingRules());

        $expenses = ($validated['diesel_amount']  ?? 0)
                  + ($validated['toll_parking']   ?? 0)
                  + ($validated['online_permit']  ?? 0)
                  + ($validated['driver_amount']  ?? 0)
                  + ($validated['other_expenses'] ?? 0);

        $booking  = BusBooking::findOrFail($validated['bus_booking_id']);
        $profit   = $booking->booking_amount - $expenses;

        BillingRecord::create(array_merge($validated, [
            'total_expenses' => $expenses,
            'net_profit'     => $profit,
            'created_by'     => Auth::id(),
        ]));

        return redirect()->route('manager.dashboard', ['#mod-billing'])
            ->with('billing_success', 'Billing record created successfully!');
    }

    public function updateBilling(Request $request, $id)
    {
        $record    = BillingRecord::findOrFail($id);
        $validated = $request->validateWithBag('editBilling', $this->billingRules());

        $expenses = ($validated['diesel_amount']  ?? 0)
                  + ($validated['toll_parking']   ?? 0)
                  + ($validated['online_permit']  ?? 0)
                  + ($validated['driver_amount']  ?? 0)
                  + ($validated['other_expenses'] ?? 0);

        $booking = BusBooking::findOrFail($validated['bus_booking_id']);
        $profit  = $booking->booking_amount - $expenses;

        $record->update(array_merge($validated, [
            'total_expenses' => $expenses,
            'net_profit'     => $profit,
        ]));

        return redirect()->route('manager.dashboard', ['#mod-billing'])
            ->with('billing_success', "Billing record #{$id} updated successfully!");
    }

    public function destroyBilling($id)
    {
        BillingRecord::findOrFail($id)->delete();
        return back()->with('billing_success', "Billing record #{$id} deleted.");
    }

    public function exportBillingPdf($id)
    {
        $record     = BillingRecord::with('booking')->findOrFail($id);
        $exportMode = true;
        return view('manager.billing.pdf', compact('record', 'exportMode'));
    }

    public function printBilling($id)
    {
        $record     = BillingRecord::with('booking')->findOrFail($id);
        $exportMode = false;
        return view('manager.billing.pdf', compact('record', 'exportMode'));
    }

    /*
    |==========================================================================
    | MAINTENANCE MODULE  — UPDATED WITH IMAGES + CUSTOM TYPE + SEARCH/SORT
    |==========================================================================
    */

    /**
     * Shared validation rules for store + update.
     */
    private function maintenanceRules(bool $isUpdate = false): array
    {
        $imageRule = $isUpdate ? 'nullable' : 'nullable';   // both store & update allow optional files

        return [
            'maintenance_date' => ['required', 'date'],
            'bus_number'       => 'required|string|max:20',
            'maintenance_type' => 'required|string|max:100',
            // custom_type is required only when maintenance_type = "Other"
            'custom_type'      => 'nullable|required_if:maintenance_type,Other|string|max:150',
            'description'      => 'nullable|string|max:1000',
            'amount_paid'      => 'required|numeric|min:0',
            'vendor_name'      => 'nullable|string|max:100',
            // Image uploads: jpg/jpeg/png/pdf, max 5 MB each
            'tier_image'       => "{$imageRule}|file|mimes:jpg,jpeg,png,pdf|max:5120",
            'bill_image'       => "{$imageRule}|file|mimes:jpg,jpeg,png,pdf|max:5120",
        ];
    }

    private function maintenanceMessages(): array
    {
        return [
            'custom_type.required_if' => 'Please enter the custom maintenance type.',
            'tier_image.mimes'        => 'Tier image must be JPG, PNG, or PDF (max 5 MB).',
            'bill_image.mimes'        => 'Bill image must be JPG, PNG, or PDF (max 5 MB).',
            'tier_image.max'          => 'Tier image must not exceed 5 MB.',
            'bill_image.max'          => 'Bill image must not exceed 5 MB.',
        ];
    }

    /**
     * Store a new maintenance record.
     * POST /manager/maintenance
     */
    public function storeMaintenance(Request $request)
    {
        $validated = $request->validateWithBag('maintenance', $this->maintenanceRules(false), $this->maintenanceMessages());

        $data = array_merge(
            collect($validated)->except(['tier_image', 'bill_image'])->toArray(),
            [
                'bus_number' => strtoupper($validated['bus_number']),
                'created_by' => Auth::id(),
            ]
        );

        // Handle tier image upload
        if ($request->hasFile('tier_image')) {
            $data['tier_image'] = $request->file('tier_image')
                ->store('maintenance/tier_images', 'public');
        }

        // Handle bill image upload
        if ($request->hasFile('bill_image')) {
            $data['bill_image'] = $request->file('bill_image')
                ->store('maintenance/bill_images', 'public');
        }

        BusMaintenance::create($data);

        return redirect()->route('manager.dashboard')
            ->with('maintenance_success', 'Maintenance record added successfully!');
    }

    /**
     * Update an existing maintenance record.
     * PUT /manager/maintenance/{id}
     */
    public function updateMaintenance(Request $request, $id)
    {
        $record    = BusMaintenance::findOrFail($id);
        $validated = $request->validateWithBag('editMaintenance', $this->maintenanceRules(true), $this->maintenanceMessages());

        $data = array_merge(
            collect($validated)->except(['tier_image', 'bill_image'])->toArray(),
            ['bus_number' => strtoupper($validated['bus_number'])]
        );

        // Replace tier image only if a new file was uploaded
        if ($request->hasFile('tier_image')) {
            // Delete old file
            if ($record->tier_image) {
                Storage::disk('public')->delete($record->tier_image);
            }
            $data['tier_image'] = $request->file('tier_image')
                ->store('maintenance/tier_images', 'public');
        }

        // Replace bill image only if a new file was uploaded
        if ($request->hasFile('bill_image')) {
            if ($record->bill_image) {
                Storage::disk('public')->delete($record->bill_image);
            }
            $data['bill_image'] = $request->file('bill_image')
                ->store('maintenance/bill_images', 'public');
        }

        $record->update($data);

        return redirect()->route('manager.dashboard')
            ->with('maintenance_success', "Maintenance record #{$id} updated successfully!");
    }

    /**
     * Delete a maintenance record (and its images).
     * DELETE /manager/maintenance/{id}
     */
    public function destroyMaintenance($id)
    {
        $record = BusMaintenance::findOrFail($id);

        // Clean up uploaded files
        if ($record->tier_image) {
            Storage::disk('public')->delete($record->tier_image);
        }
        if ($record->bill_image) {
            Storage::disk('public')->delete($record->bill_image);
        }

        $record->delete();

        return back()->with('maintenance_success', "Maintenance record #{$id} deleted.");
    }

    /**
     * Remove a single image from a maintenance record (AJAX / inline action).
     * DELETE /manager/maintenance/{id}/image/{field}
     */
    public function deleteMaintenanceImage($id, $field)
    {
        if (!in_array($field, ['tier_image', 'bill_image'])) {
            abort(422, 'Invalid image field.');
        }

        $record = BusMaintenance::findOrFail($id);

        if ($record->$field) {
            Storage::disk('public')->delete($record->$field);
            $record->update([$field => null]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Export all maintenance records as a printable PDF.
     * GET /manager/maintenance/export-pdf
     */
    public function exportMaintenancePdf()
    {
        $records    = BusMaintenance::latest()->get();
        $exportMode = true;
        return view('manager.maintenance.pdf', compact('records', 'exportMode'));
    }

    /*
    |==========================================================================
    | TAX MODULE
    |==========================================================================
    */

    /**
     * Store a new tax record.
     * POST /manager/tax
     */
    public function storeTax(Request $request)
    {
        $data = $request->validateWithBag('tax', [
            'tax_date'   => 'required|date',
            'bus_number' => 'required|string|max:30',
            'tax_from'   => 'required|date',
            'tax_to'     => 'required|date|after_or_equal:tax_from',
            'amount'     => 'required|numeric|min:0',
            'tax_image'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes'      => 'nullable|string|max:500',
        ], [
            'tax_to.after_or_equal' => 'Tax end date must be on or after the start date.',
            'tax_image.mimes'       => 'Receipt must be JPG, PNG, or PDF (max 5 MB).',
            'tax_image.max'         => 'Receipt file must not exceed 5 MB.',
        ]);

        $data['bus_number'] = strtoupper($data['bus_number']);

        if ($request->hasFile('tax_image')) {
            $data['tax_image'] = $request->file('tax_image')
                ->store('insurance/tax_receipts', 'public');
        }

        BusTax::create($data);

        return redirect()->route('manager.dashboard')
            ->with('tax_success', 'Tax record added successfully!');
    }

    /**
     * Update an existing tax record.
     * PUT /manager/tax/{tax}
     */
    public function updateTax(Request $request, BusTax $tax)
    {
        $data = $request->validateWithBag('editTax', [
            'tax_date'   => 'required|date',
            'bus_number' => 'required|string|max:30',
            'tax_from'   => 'required|date',
            'tax_to'     => 'required|date|after_or_equal:tax_from',
            'amount'     => 'required|numeric|min:0',
            'tax_image'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes'      => 'nullable|string|max:500',
        ], [
            'tax_to.after_or_equal' => 'Tax end date must be on or after the start date.',
            'tax_image.mimes'       => 'Receipt must be JPG, PNG, or PDF (max 5 MB).',
        ]);

        $data['bus_number'] = strtoupper($data['bus_number']);

        if ($request->hasFile('tax_image')) {
            // Delete old file first
            if ($tax->tax_image) {
                Storage::disk('public')->delete($tax->tax_image);
            }
            $data['tax_image'] = $request->file('tax_image')
                ->store('insurance/tax_receipts', 'public');
        } else {
            unset($data['tax_image']); // keep existing
        }

        $tax->update($data);

        return redirect()->route('manager.dashboard')
            ->with('tax_success', "Tax record #{$tax->id} updated successfully!");
    }

    /**
     * Delete a tax record (and its receipt image).
     * DELETE /manager/tax/{tax}
     */
    public function destroyTax(BusTax $tax)
    {
        if ($tax->tax_image) {
            Storage::disk('public')->delete($tax->tax_image);
        }
        $tax->delete();

        return redirect()->route('manager.dashboard')
            ->with('tax_success', 'Tax record deleted.');
    }

    /*
    |==========================================================================
    | INSURANCE MODULE
    |==========================================================================
    */

    /**
     * Store a new insurance record.
     * POST /manager/insurance
     */
    public function storeInsurance(Request $request)
    {
        $data = $request->validateWithBag('insurance', [
            'insurance_date' => 'required|date',
            'bus_number'     => 'required|string|max:30',
            'amount'         => 'required|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
        ]);

        $data['bus_number'] = strtoupper($data['bus_number']);

        BusInsurance::create($data);

        return redirect()->route('manager.dashboard')
            ->with('insurance_success', 'Insurance record added successfully!');
    }

    /**
     * Update an existing insurance record.
     * PUT /manager/insurance/{insurance}
     */
    public function updateInsurance(Request $request, BusInsurance $insurance)
    {
        $data = $request->validateWithBag('editInsurance', [
            'insurance_date' => 'required|date',
            'bus_number'     => 'required|string|max:30',
            'amount'         => 'required|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
        ]);

        $data['bus_number'] = strtoupper($data['bus_number']);

        $insurance->update($data);

        return redirect()->route('manager.dashboard')
            ->with('insurance_success', "Insurance record #{$insurance->id} updated successfully!");
    }

    /**
     * Delete an insurance record.
     * DELETE /manager/insurance/{insurance}
     */
    public function destroyInsurance(BusInsurance $insurance)
    {
        $insurance->delete();

        return redirect()->route('manager.dashboard')
            ->with('insurance_success', 'Insurance record deleted.');
    }

    /*
    |==========================================================================
    | TAX — PDF / PRINT EXPORTS
    |==========================================================================
    */

    /**
     * Export ALL tax records as a printable/saveable PDF list.
     * GET /manager/tax/export-pdf
     */
    public function exportTaxPdf()
    {
        $records    = BusTax::latest('tax_date')->get();
        $exportMode = true;
        return view('manager.tax.pdf', compact('records', 'exportMode'));
    }

    /**
     * Print-view for ALL tax records.
     * GET /manager/tax/print
     */
    public function printTaxAll()
    {
        $records    = BusTax::latest('tax_date')->get();
        $exportMode = false;
        return view('manager.tax.pdf', compact('records', 'exportMode'));
    }

    /**
     * Export a SINGLE tax record as a detailed PDF receipt.
     * GET /manager/tax/{tax}/pdf
     */
    public function exportTaxRecordPdf(BusTax $tax)
    {
        $exportMode = true;
        return view('manager.tax.record-pdf', compact('tax', 'exportMode'));
    }

    /**
     * Print-view for a SINGLE tax record.
     * GET /manager/tax/{tax}/print
     */
    public function printTaxRecord(BusTax $tax)
    {
        $exportMode = false;
        return view('manager.tax.record-pdf', compact('tax', 'exportMode'));
    }

    /*
    |==========================================================================
    | INSURANCE — PDF / PRINT EXPORTS
    |==========================================================================
    */

    /**
     * Export ALL insurance records as a printable PDF list.
     * GET /manager/insurance/export-pdf
     */
    public function exportInsurancePdf()
    {
        $records    = BusInsurance::latest('insurance_date')->get();
        $exportMode = true;
        return view('manager.insurance.pdf', compact('records', 'exportMode'));
    }

    /**
     * Print-view for ALL insurance records.
     * GET /manager/insurance/print
     */
    public function printInsuranceAll()
    {
        $records    = BusInsurance::latest('insurance_date')->get();
        $exportMode = false;
        return view('manager.insurance.pdf', compact('records', 'exportMode'));
    }

    /**
     * Export a SINGLE insurance record as a detailed PDF certificate.
     * GET /manager/insurance/{insurance}/pdf
     */
    public function exportInsuranceRecordPdf(BusInsurance $insurance)
    {
        $exportMode = true;
        return view('manager.insurance.record-pdf', compact('insurance', 'exportMode'));
    }

    /**
     * Print-view for a SINGLE insurance record.
     * GET /manager/insurance/{insurance}/print
     */
    public function printInsuranceRecord(BusInsurance $insurance)
    {
        $exportMode = false;
        return view('manager.insurance.record-pdf', compact('insurance', 'exportMode'));
    }
}