<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'course'])
            ->where('status', '!=', 'deleted')
            ->latest()
            ->paginate(10);

        // Stats
        $totalPayments = Payment::where('status', '!=', 'deleted')->count();
        $successful = Payment::where('status', 'success')->count();
        $pending = Payment::where('status', 'pending')->count();
        $failed = Payment::where('status', 'failed')->count();

        return view('admin.transaction.index', compact(
            'payments',
            'totalPayments',
            'successful',
            'pending',
            'failed'
        ));
    }

    public function show(Payment $transaction)
    {
        $transaction->load(['student', 'course']);
        return view('admin.transaction.show', compact('transaction'));
    }

    public function markPaid(Payment $transaction)
    {
        if ($transaction->status === 'success') {
            return back()->with('error', 'Transaction is already marked as paid.');
        }

        DB::transaction(function () use ($transaction) {

            // 1️⃣ Update payment
            $transaction->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);

            // 2️⃣ Check if already enrolled
            $existing = Enrollment::where('student_id', $transaction->student_id)
                ->where('course_id', $transaction->course_id)
                ->where('status', 'completed')
                ->first();

            if (!$existing) {
                Enrollment::create([
                    'student_id'  => $transaction->student_id,
                    'course_id'   => $transaction->course_id,
                    'status'      => 'active',
                    'enrolled_at' => now(),
                ]);
            }

        });

        return redirect()
            ->route('admin.transaction.index')
            ->with('success', 'Transaction marked as paid and student enrolled successfully.');
    }

    public function refund(Payment $transaction)
    {
        if ($transaction->status === 'failed') {
            return back()->with('error', 'Transaction is already marked as failed/refunded.');
        }

        $transaction->update([
            'status' => 'failed'
        ]);

        return redirect()
            ->route('admin.transaction.index')
            ->with('success', 'Transaction has been marked as failed/refunded.');
    }
    
    // ================= SOFT DELETE =================
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'deleted'
        ]);

        return back()->with('success', 'Transaction deleted successfully');
    }
}
