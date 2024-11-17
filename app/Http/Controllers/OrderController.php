<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf; // Correct import for PDF generation
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Display orders index view
    public function index()
    {
        return view('orders.index');
    }

    // Retrieves order data for DataTables
    public function data()
    {
        $orders = Order::all();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('action', function ($order) {
                return '<button class="btn btn-sm btn-primary">View</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Add product to order_items and set session
    public function create($id)
    {
        $product = Product::findOrFail($id);

        // Generate unique session order ID if not set
        session([
            'order_id' => session('order_id', uniqid()),
            'product_id' => $product->product_id,
        ]);

        return redirect()->route('orders.index');
    }

    // Finalize and store order in order_items table
    public function store(Request $request)
    {
        $orderId = session('order_id');
        $productId = session('product_id');
        $quantity = $request->input('quantity', 1);

        if ($orderId && $productId) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->forget(['order_id', 'product_id']);
            
            return redirect()->route('orders.index')->with('success', 'Product added to order successfully!');
        } else {
            return back()->with('error', 'No order data available.');
        }
    }

    // Show order details with products for DataTables
    public function show($id)
    {
        $orderDetails = Order::with('products')->where('order_id', $id)->get();

        return DataTables::of($orderDetails)
            ->addIndexColumn()
            ->addColumn('product_name', function ($detail) {
                return $detail->product->name;
            })
            ->rawColumns(['product_name'])
            ->make(true);
    }

    // Deletes order and adjusts stock
    public function destroy($id)
    {
        $order = Order::find($id);
        $orderDetails = Order::where('order_id', $order->order_id)->get();

        foreach ($orderDetails as $item) {
            $product = Product::find($item->product_id);

            if ($product) {
                $product->stock -= $item->quantity;
                $product->update();
            }

            $item->delete();
        }

        $order->delete();

        return response(null, 204);
    }

    // Checkout method to display cart summary
    public function checkout()
    {
        $cart = session('cart', []);
        $totalAmount = array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);

        return view('orders.checkout', compact('cart', 'totalAmount'));
    }

    public function viewCart()
    {
        $cart = session('cart', []);
        $total = 0;

        // Calculate total
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Pass cart items and total to the view
        return view('orders.session.cart', compact('cart', 'total'));
    }

    // Generate and stream the invoice PDF
    public function generateInvoice($orderId)
    {
        $order = Order::findOrFail($orderId);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));

        return $pdf->stream('invoice.pdf');
    }

    // Confirm order, store in DB, and generate PDF
    public function confirmOrder(Request $request)
    {
        $order = new Order();
        $order->customer_id = Auth::id();
        $order->tracking_no = 'TRK-' . strtoupper(uniqid());
        $order->invoice_no = 'INV-' . strtoupper(uniqid());
        $order->total_amount = $request->input('total_amount');
        $order->order_date = now();
        $order->order_status = 'Pending';
        $order->payment_mode = $request->input('payment_mode');
        $order->save();

        foreach (session('cart') as $id => $details) {
            $order->products()->attach($id, [
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'total' => $details['price'] * $details['quantity'],
            ]);
        }

        $pdf = Pdf::loadView('orders.invoice', [
            'order' => $order,
            'cart' => session('cart'),
            'customer' => Auth::user(),
        ]);

        session()->forget('cart');

        return $pdf->stream('invoice.pdf');
    }
}
