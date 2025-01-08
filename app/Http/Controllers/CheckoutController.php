<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        return view('checkout', compact('cartItems'));
    }

    public function process(Request $request)
    {
        // Basic validation, should be expanded
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            // Add more order details like total, status, etc.
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->delete();
        }

        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

    public function success()
    {
        return view('order.success');
    }
}