@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{ asset('path-to-your-avatar') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ Auth::user()->name }}
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        Your Role / Title
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Profile Heading -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>

        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="max-w-xl mt-4">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="max-w-xl mt-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
            <!-- Additional Profile Information -->
            <div class="col-lg-6">
                <h6 class="mb-0">Account Settings</h6>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong class="text-dark">Full Name:</strong> {{ Auth::user()->name }}
                    </li>
                    <li class="list-group-item">
                        <strong class="text-dark">Email:</strong> {{ Auth::user()->email }}
                    </li>
                    <!-- Add more personal info if needed -->
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
