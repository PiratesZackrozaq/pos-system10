@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Add Product
                    <a href="{{ route('products.index') }}" class="btn btn-danger float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <!-- Category selection dropdown -->
                            <label for="category_id">Select Category:</label>
                            <select name="category_id" id="category_id" required>
                                <option value="">-Select Category-</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name">Product Name *</label>
                            <input type="text" name="name" class="form-control" required
                                value="{{ old('name') }}" />
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description *</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price">Price *</label>
                            <input type="text" name="price" class="form-control" required
                                value="{{ old('price') }}" />
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="quantity">Quantity *</label>
                            <input type="text" name="quantity" class="form-control" required
                                value="{{ old('quantity') }}" />
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="image">Image *</label>
                            <input type="file" name="image" class="form-control" />
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Status (Unchecked = Visible, Checked = Hidden)</label><br />
                            <input type="checkbox" name="status" style="width:30px;height:30px;"
                                {{ old('status') ? 'checked' : '' }} />
                        </div>
                        <div class="col-md-6 mb-3 text-end">
                            <br />
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
