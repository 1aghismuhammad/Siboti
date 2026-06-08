@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="account-container">
        <div class="account-card member-panel">
            <div class="member-panel__header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <div>
                    <h1 class="page-title">Member Dashboard</h1>
                    <p class="member-panel__text">Selamat datang di area member Siboti.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="button button--secondary">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
