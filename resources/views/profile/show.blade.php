<!Doctype html>
<html lang="en">
<head>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale= 1.0" />
	<title>Incloud | Products</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body class="bg-gray-green"> <!-- body with gray background -->
    <div class=" d-flex f-row w-100">

        <!-- left side nav bar start -->
        <i class="fas fa-bars nav-res-icon left"></i>
        <div class="navbar d-res-none">
            <ul class="navbar-list bg-white">
                <a href="/dashboard" class="nav-item">
                    <i class="fas fa-columns"></i>
                    Dashboard
                </a>@if($user->id==$company->admin_id)
                <a href="/products" class="nav-item ">
                    <i class="fas fa-tag"></i>
                    Product
                </a>@endif
                <a href="/inventory" class="nav-item">
                    <i class="fas fa-dolly-flatbed"></i>
                    Inventory
                </a>@if($user->id==$company->admin_id)
                <a href="buy" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Buy
                </a>@endif
                <a href="sell" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Sell
                </a>
                <a href="settings" class="nav-item active-item">
                    <i class="fas fa-cog"></i>
                    More
                </a>
            </ul>
        </div>
        <div class="vertically-center r-box">
            <h3 class="product-title">Settings</h3>
            <div class="main-container prod-container bg-white">
                <div class="setting">
                    <div class="sett-sec">
                        <div class="set-sec-body">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout></div></div></div></div></div></body></html>
