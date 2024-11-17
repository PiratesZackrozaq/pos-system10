<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Order Details</h1>
        <table class="table table-bordered" id="order-details-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#order-details-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('orders.show', $order->order_id) }}",  // Adjust as per data needs
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'total', name: 'total' }
                ]
            });
        });
    </script>
</body>
</html>
