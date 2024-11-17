@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Add Customer
                <a href="{{ route('customers.index') }}" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf <!-- CSRF protection token -->

                <div class="row">
                    <!-- Name Field -->
                    <div class="col-md-12 mb-3">
                        <label for="name">NAME *</label>
                        <input type="text" name="name" required class="form-control" value="{{ old('name') }}" />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-12 mb-3">
                        <label for="email">EMAIL ID</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="col-md-12 mb-3">
                        <label for="phone">PHONE NUMBER</label>
                        <input type="number" name="phone" class="form-control" value="{{ old('phone') }}" />
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="col-md-6">
                        <label>STATUS (UNCHECKED = VISIBLE, CHECKED = HIDDEN)</label>
                        <br/>
                        <input type="checkbox" name="status" style="width:30px;height:30px;" {{ old('status') ? 'checked' : '' }} />
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-6 mb-3 text-end">
                        <br/>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
