<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign In - {{ config('app.name', 'Fruitables') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap and any other necessary CSS here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>

<body class="bg-gray-200">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4 col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Sign In</h4>
                </div>

                <div class="card-body">
                    <!-- Yield content here for child views -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Include JS libraries (e.g., jQuery, Bootstrap JS) here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
