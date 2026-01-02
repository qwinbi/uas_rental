<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qris;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function qris()
    {
        $qris = Qris::first();
        return view('admin.payment.qris', compact('qris'));
    }

    public function updateQris(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:100',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $qris = Qris::first();

        if ($request->hasFile('qris_image')) {
            if ($qris && $qris->qris_image) {
                Storage::disk('public')->delete($qris->qris_image);
            }
            $validated['qris_image'] = $request->file('qris_image')->store('qris', 'public');
        }

        if ($qris) {
            $qris->update($validated);
        } else {
            Qris::create($validated);
        }

        return redirect()->route('admin.payment.qris')
            ->with('success', 'QRIS updated successfully! 💳');
    }

    public function transactions()
    {
        $transactions = Transaction::with(['user', 'car', 'payment'])
            ->latest()
            ->paginate(15);
            
        return view('admin.payment.transactions', compact('transactions'));
    }

    public function updateTransactionStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,failed'
        ]);

        $transaction->update([
            'status' => $request->status,
            'payment_date' => $request->status === 'paid' ? now() : null
        ]);

        if ($transaction->payment) {
            $transaction->payment->update([
                'status' => $request->status === 'paid' ? 'success' : 'failed'
            ]);
        }

        return back()->with('success', 'Transaction status updated! ✅');
    }
}