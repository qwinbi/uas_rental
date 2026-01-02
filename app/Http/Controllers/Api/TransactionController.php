<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['car', 'payment'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'car_name' => $transaction->car->name,
                    'start_date' => $transaction->start_date,
                    'end_date' => $transaction->end_date,
                    'total_days' => $transaction->total_days,
                    'total_price' => $transaction->total_price,
                    'status' => $transaction->status,
                    'payment_date' => $transaction->payment_date,
                    'payment_status' => $transaction->payment ? $transaction->payment->status : null,
                    'payment_method' => $transaction->payment ? $transaction->payment->method : null
                ];
            })
        ]);
    }

    public function show(Transaction $transaction)
    {
        // Check authorization
        if ($transaction->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $transaction->load(['car', 'payment']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code,
                'car' => [
                    'name' => $transaction->car->name,
                    'type' => $transaction->car->type,
                    'image_url' => $transaction->car->image_url
                ],
                'start_date' => $transaction->start_date,
                'end_date' => $transaction->end_date,
                'total_days' => $transaction->total_days,
                'total_price' => $transaction->total_price,
                'status' => $transaction->status,
                'payment_date' => $transaction->payment_date,
                'payment' => $transaction->payment ? [
                    'method' => $transaction->payment->method,
                    'amount' => $transaction->payment->amount,
                    'status' => $transaction->payment->status,
                    'qris_code' => $transaction->payment->qris_code
                ] : null
            ]
        ]);
    }
}