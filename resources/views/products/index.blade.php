@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Products
                    <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Add Product(s)</a>
                </h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IMAGE</th>
                                    <th>NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>
                                            @if ($product->image && Storage::exists('public/' . $product->image))
                                                <img src="{{ asset('storage/' . $product->image) }}" style="width:50px;height:50px;" alt="Image" />
                                            @else
                                                <p>Image not found</p>
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            @if ($product->status == 1)
                                                <span class="badge bg-danger">Hidden</span>
                                            @else
                                                <span class="badge bg-primary">Visible</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->product_id) }}"
                                                class="btn btn-success btn-sm">EDIT</a>
                                            <form action="{{ route('products.destroy', $product->product_id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to DELETE THIS PRODUCT?')">DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h4 class="mb-0">No Records Found!</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
