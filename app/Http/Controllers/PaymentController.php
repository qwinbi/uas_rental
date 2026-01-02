<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Payment;
use App\Models\Qris;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        $car = Car::findOrFail($request->car_id);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        $days = \Carbon\Carbon::parse($startDate)
            ->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
            
        $totalPrice = $car->price_per_day * $days;
        
        $qris = Qris::where('is_active', true)->first();
        
        return view('payment.form', compact('car', 'startDate', 'endDate', 'days', 'totalPrice', 'qris'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'total_days' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:qris'
        ]);

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $validated['total_days'],
            'total_price' => $validated['total_price'],
            'status' => 'pending'
        ]);

        // Create payment record
        $payment = Payment::create([
            'transaction_id' => $transaction->id,
            'method' => 'QRIS',
            'amount' => $validated['total_price'],
            'status' => 'pending'
        ]);

        return redirect()->route('payment.status', $transaction)
            ->with('info', 'Please complete the QRIS payment! 📱');
    }

    public function paymentStatus(Transaction $transaction)
    {
        $payment = $transaction->payment;
        $qris = Qris::where('is_active', true)->first();
        
        return view('payment.status', compact('transaction', 'payment', 'qris'));
    }

    public function confirmPayment(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            
            $transaction->update([
                'status' => 'paid',
                'payment_date' => now(),
                'payment_proof' => $path
            ]);

            $transaction->payment->update([
                'status' => 'success',
                'notes' => 'Payment confirmed via QRIS'
            ]);

            return redirect()->route('payment.status', $transaction)
                ->with('success', 'Payment confirmed successfully! 🎉 Your car rental is now active.');
        }

        return back()->with('error', 'Please upload payment proof.');
    }

    public function cancelPayment(Transaction $transaction)
    {
        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'cancelled']);
            
            $transaction->payment->update([
                'status' => 'failed',
                'notes' => 'Cancelled by user'
            ]);

            return redirect()->route('profile.history')
                ->with('info', 'Payment cancelled. ❌');
        }

        return back()->with('error', 'Cannot cancel this transaction.');
    }
}