<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StudentPaymentController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $payments = Payment::where('student_id', $student->id)
            ->orderByDesc('paid_at')
            ->get();

        $fee = $student->program_fee ?? 0;

        $amountPaid = $payments->where('status', 'success')->sum('amount');
        $outstanding = max($fee - $amountPaid, 0);
        $isUpToDate = $outstanding <= 0;

        return view('student.payments.index', [
            'student'     => $student,
            'payments'    => $payments,
            'fee'         => $fee,
            'amountPaid'  => $amountPaid,
            'outstanding' => $outstanding,
            'isUpToDate'  => $isUpToDate,
        ]);
    }
}