@extends('layouts.shop')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Checkout</h2>
    
    <form action="{{ route('checkout.confirm') }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td><img src="{{ asset('storage/' . $item['image']) }}" width="50" alt=""></td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} IDR</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} IDR</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mb-4">
            <strong>Total Amount: {{ number_format($totalAmount, 2) }} IDR</strong>
        </div>

        <div class="form-group mb-3">
            <label for="payment_mode">Payment Mode</label>
            <select name="payment_mode" id="payment_mode" class="form-control">
                <option value="cash">Cash</option>
                <option value="online">Online</option>
            </select>
        </div>

        <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

        <button type="submit" class="btn btn-primary">Confirm Order & Download Invoice</button>
    </form>
</div>
@endsection
