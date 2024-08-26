<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RazorpayService;

class PaymentController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $order = $this->razorpayService->createOrder($validated['amount']);

        return response()->json($order);
    }

    public function capturePayment(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        try {
            $payment = $this->razorpayService->capturePayment($validated['payment_id'], $validated['amount']);
            return response()->json($payment);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
