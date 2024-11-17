@extends('layouts.shop')

@section('content')
<!-- Single Page Header Start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Billing details</h1>

        @if(session('cart'))
            <!-- Table for cart items -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $id => $details)
                            <tr data-id="{{ $id }}">
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $details['image']) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td><p class="mb-0 mt-4">{{ $details['name'] }}</p></td>
                                <td><p class="mb-0 mt-4">{{ number_format($details['price'], 2) }} IDR</p></td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border update-quantity" data-action="decrease">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="text" value="{{ $details['quantity'] }}" class="form-control text-center border-0 quantity-input" readonly>
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border update-quantity" data-action="increase">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td><p class="mb-0 mt-4 item-total">{{ number_format($details['price'] * $details['quantity'], 2) }} IDR</p></td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 remove-from-cart">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total Price -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5>Total:</h5>
                <p class="mb-0 fw-bold" id="cart-total">{{ number_format($total, 2) }} IDR</p>
            </div>
        @else
            <p>Your cart is empty!</p>
        @endif
    </div>
</div>
<!-- Checkout Page End -->
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Update quantity in cart
        document.querySelectorAll('.update-quantity').forEach(function(button) {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.getAttribute('data-id');
                const action = this.getAttribute('data-action');
                let quantityInput = row.querySelector('.quantity-input');
                let newQuantity = parseInt(quantityInput.value);

                // Adjust quantity based on action
                if (action === 'increase') newQuantity++;
                else if (action === 'decrease' && newQuantity > 1) newQuantity--;

                // Update quantity in the cart via AJAX
                fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId, quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityInput.value = newQuantity;
                        updateTotals(row, data.itemTotal, data.cartTotal);
                    } else {
                        alert(data.error);
                    }
                });
            });
        });

        // Remove item from cart
        document.querySelectorAll('.remove-from-cart').forEach(function(button) {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.getAttribute('data-id');

                fetch("{{ route('cart.remove') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                        updateTotals(null, null, data.cartTotal);
                    } else {
                        alert(data.error);
                    }
                });
            });
        });

        function updateTotals(row, itemTotal, cartTotal) {
            if (row) row.querySelector('.item-total').textContent = itemTotal + ' IDR';
            document.getElementById('cart-total').textContent = cartTotal + ' IDR';
        }
    });
</script>
@endsection
