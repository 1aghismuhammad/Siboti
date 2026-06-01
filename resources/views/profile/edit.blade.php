@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="account-container account-stack">
        <div class="account-card account-card--narrow">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="account-card account-card--narrow">
            @include('profile.partials.update-password-form')
        </div>

        <div class="account-card account-card--narrow account-danger-zone">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</section>
@endsection
