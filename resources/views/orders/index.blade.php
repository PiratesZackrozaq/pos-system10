@extends('layouts.app')

@section('content')
<!-- orders/index.blade.php -->
<table id="orders-table" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('orders.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'order_id', name: 'order_id' },
                { data: 'customer', name: 'customer' },
                { data: 'total', name: 'total' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
