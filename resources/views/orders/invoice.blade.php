<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <header class="clearfix">
            <div id="logo">
                <img src="{{ asset('logo.png') }}" alt="Logo">
            </div>
            <h1>Invoice {{ $order->invoice_no }}</h1>
            <div id="company" class="clearfix">
                <div>Company Name</div>
                <div>123 Street, City,<br /> ZIP, Country</div>
                <div>(555) 555-5555</div>
                <div><a href="mailto:company@example.com">company@example.com</a></div>
            </div>
            <div id="project">
                <div><span>CLIENT</span> {{ $customer->name }}</div>
                <div><span>ADDRESS</span> {{ $customer->address ?? 'N/A' }}</div>
                <div><span>EMAIL</span> <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></div>
                <div><span>DATE</span> {{ now()->format('F d, Y') }}</div>
            </div>
        </header>
        
        <main>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['description'] ?? 'N/A' }}</td>
                            <td>{{ number_format($item['price'], 2) }} IDR</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 2) }} IDR</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">Total Amount</td>
                        <td>{{ number_format($order->total_amount, 2) }} IDR</td>
                    </tr>
                </tbody>
            </table>
        </main>

        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </div>
</body>
</html>
