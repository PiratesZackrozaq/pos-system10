<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Search Results</title>
    <!-- Include the same styles as welcome.blade.php -->
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CDN jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CDN Lightbox (Optional if needed) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    @vite('resources/css/app.css')
    @livewireStyles
  </head>
  <body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
      <h1 class="mb-8 text-center text-3xl font-bold">Search Results</h1>

      <!-- Display search results -->
      <div class="tab-content">
        @if($products->count())
        <div id="tab-1" class="tab-pane fade show p-0 active">
          <div class="row g-4">
            @foreach ($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="rounded position-relative fruite-item">
                <div class="fruite-img">
                  <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                </div>
                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->category->name }}</div>
                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                  <h4>{{ $product->name }}</h4>
                  <p>{{ $product->description }}</p>
                  <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold mb-0">${{ number_format($product->price, 2) }}</p>
                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                      <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @else
        <h4 class="text-center">No products found</h4>
        @endif
      </div>
    </div>

    <!-- Include the same scripts as welcome.blade.php -->
    <!-- jQuery (needed before Bootstrap, Lightbox, and Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    @vite(['resources/js/bootstrap.bundle.min.js'])

    <!-- Lightbox JS -->
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Owl Carousel JS -->
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Main custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('livewire/livewire.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    @vite('resources/js/app.js')
    @livewireScripts
  </body>
</html>
