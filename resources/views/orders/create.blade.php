<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Order</h1>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="order_id" class="form-label">Order ID</label>
                <input type="text" id="order_id" name="order_id" class="form-control">
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Product ID</label>
                <input type="text" id="product_id" name="product_id" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create Order</button>
        </form>
    </div>
</body>
</html>
