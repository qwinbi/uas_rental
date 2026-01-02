<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'payment_method' => 'required|in:qris'
        ]);

        $car = Car::findOrFail($request->car_id);
        
        $days = \Carbon\Carbon::parse($request->start_date)
            ->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
            
        $totalPrice = $car->price_per_day * $days;

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $days,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        $payment = Payment::create([
            'transaction_id' => $transaction->id,
            'method' => 'QRIS',
            'amount' => $totalPrice,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully! Please complete QRIS payment.',
            'data' => [
                'transaction' => $transaction,
                'payment' => $payment,
                'qris_code' => 'QRIS_HOPPWHEELS_' . strtoupper(uniqid())
            ]
        ], 201);
    }

    public function confirm(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_proof' => 'required|string' // Base64 encoded image
        ]);

        // In real app, decode and save image
        // For demo, we'll just update status
        
        $payment->update([
            'status' => 'success',
            'qris_code' => $request->get('qris_code', 'QRIS_CONFIRMED'),
            'notes' => 'Payment confirmed via QRIS API'
        ]);

        $payment->transaction->update([
            'status' => 'paid',
            'payment_date' => now(),
            'payment_proof' => 'api_confirm_' . time() . '.txt'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmed successfully!',
            'data' => $payment
        ]);
    }
}