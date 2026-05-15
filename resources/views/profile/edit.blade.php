@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-primary-950">
            {{ __('Profile') }}
        </h2>
        <p class="text-nautical-600">Gestiona tu información personal y seguridad de la cuenta.</p>
    </div>

    <div class="space-y-8">
        <div class="p-6 bg-white shadow-md border border-nautical-100 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow-md border border-nautical-100 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow-md border border-nautical-100 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
