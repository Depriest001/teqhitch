<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopicPayment;
use App\Models\TopicPaymentSetting;

class TopicPaymentController extends Controller
{
    /**
     * Display all payments
     */
    public function index()
    {
        $totalPayments = TopicPayment::count();
        $successfulPayments = TopicPayment::where('status', 'success')->count();
        $pendingPayments = TopicPayment::where('status', 'pending')->count();
        $failedPayments = TopicPayment::where('status', 'failed')->count();

        $totalRevenue = TopicPayment::where('status', 'success')->sum('amount');

        $payments = TopicPayment::with('user')
                        ->latest()
                        ->paginate(15);

        return view('admin.topic-payments.index', compact(
            'payments',
            'totalPayments',
            'successfulPayments',
            'pendingPayments',
            'failedPayments',
            'totalRevenue'
        ));
    }

    /**
     * Show single payment details
     */
    public function show($id)
    {
        $payment = TopicPayment::with('user')->findOrFail($id);

        return view('admin.topic-payments.show', compact('payment'));
    }

    /**
     * Update payment status (optional feature)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:success,pending,failed'
        ]);

        $payment = TopicPayment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }

    /**
     * ===============================
     * PAYMENT SETTINGS SECTION
     * ===============================
     */

    public function settingsIndex()
    {
        $settings = TopicPaymentSetting::latest()->get();

        return view('admin.topic-payments.settings.index', compact('settings'));
    }

    public function settingsStore(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        // Create payment setting using model (slug handled automatically)
        TopicPaymentSetting::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Payment type created successfully.');
    }

    public function settingsUpdate(Request $request, TopicPaymentSetting $setting)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'active' => 'required|boolean',
        ]);

        $setting->update($validated);

        return redirect()->back()->with('success', 'Payment type updated successfully.');
    }

    public function paymentDestroy(TopicPayment $id)
    {
        $id->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
    
    public function destroy(TopicPaymentSetting $setting)
    {
        $setting->delete();

        return redirect()->back()->with('success', 'Payment type deleted successfully.');
    }
}