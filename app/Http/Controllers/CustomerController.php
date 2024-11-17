<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch customers that belong to the authenticated user
        $customers = Auth::user()->customers;

        if (!$customers) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required',
        ]);

        $customer = new Customer();
        $customer->user_id = Auth::id();  // Associate customer with logged-in user
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->status = $request->has('status') ? 1 : 0;

        if ($customer->save()) {
            return response()->json(['status' => 200, 'message' => 'Customer created successfully!']);
        }

        return response()->json(['status' => 500, 'message' => 'Something went wrong!']);
    }

    // Reuse Existing Customer 
    public function use(Request $request)
    {
        $customer = Customer::find($request->input('customer_id'));

        if ($customer) {
            // You can return any relevant customer data here or handle it as needed
            return response()->json(['status' => 200, 'customer' => $customer]);
        }

        return response()->json(['status' => 404, 'message' => 'Customer not found']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch only the customer's data that belongs to the authenticated user
        $customer = Auth::user()->customers()->find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found!');
        }

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the customer that belongs to the authenticated user
        $customer = Auth::user()->customers()->find($id);

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found!');
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Fetch the customer that belongs to the authenticated user
        $customer = Auth::user()->customers()->find($id);

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found!');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required',
        ]);

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->status = $request->has('status') ? 1 : 0;

        if ($customer->save()) {
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the customer that belongs to the authenticated user
        $customer = Auth::user()->customers()->find($id);

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found!');
        }

        if ($customer->delete()) {
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
