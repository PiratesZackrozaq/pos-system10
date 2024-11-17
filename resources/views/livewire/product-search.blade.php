<style>
    #search-popover {
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.search-result {
    padding: 10px;
    cursor: pointer;
}

.search-result:hover {
    background-color: #f8f9fa;
}

</style>
<div>
    <!-- Search form -->
    <form action="{{ route('search.results') }}" method="GET">
        <div class="input-group w-75 mx-auto d-flex mb-4 position-relative">
            <input
                wire:model.debounce.300ms="query"
                type="text"
                name="search"
                placeholder="Search products..."
                class="form-control p-3"
                aria-describedby="search-icon-1"
                onfocus="showPopover()"
                onblur="hidePopoverAfterDelay()"
            />
            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>

            <!-- Popover for showing search results -->
            <div id="search-popover" class="position-absolute bg-white border shadow rounded p-3" style="width: 100%; display: none; top: 60px; z-index: 100;">
                @if ($products && count($products) > 0)
                    @foreach ($products as $product)
                        <div class="search-result p-2 border-bottom" onclick="selectProduct('{{ $product['name'] }}')">
                            <h5 class="mb-0">{{ $product['name'] }}</h5>
                            <p class="text-muted mb-0">{{ $product['description'] }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No products found.</p>
                @endif
            </div>
        </div>
    </form>

    <!-- Grid layout for search results (only visible after search) -->
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 md:grid-cols-2">
        @forelse($products as $product)
            <div class="transform rounded-lg bg-white p-4 shadow transition duration-300 ease-in-out hover:scale-105">
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-blue-600 mt-2 font-bold">${{ number_format($product->price, 2) }}</p>
            </div>
        @empty
            <div class="rounded-lg bg-white p-4 text-center shadow">No products found.</div>
        @endforelse
    </div>
</div>
<script>
    let timer = null;

    // Show the popover when the input is focused
    function showPopover() {
        document.getElementById('search-popover').style.display = 'block';
    }

    // Hide the popover with a delay to allow result clicks
    function hidePopoverAfterDelay() {
        timer = setTimeout(() => {
            document.getElementById('search-popover').style.display = 'none';
        }, 200);  // Hide after a 200ms delay
    }

    // Select product and hide the popover immediately
    function selectProduct(productName) {
        document.querySelector('input[name="search"]').value = productName;
        hidePopover();  // Hide popover immediately
    }

    // Clear timer and hide the popover immediately
    function hidePopover() {
        document.getElementById('search-popover').style.display = 'none';
        if (timer) {
            clearTimeout(timer);
        }
    }
</script>
