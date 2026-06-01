@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="account-container">
        <div class="account-card member-panel">
            <h1 class="page-title">Daftar Booking Saya</h1>
            <p class="member-panel__text">Lihat booking yang sudah Anda buat dan batalkan bila perlu.</p>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:1rem;padding:1rem;border-radius:12px;background:#e5ffcc;color:#1d3f00;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="member-booking-actions" style="margin-bottom:1.5rem;">
                <a href="{{ url('/') }}" class="admin-primary-button">Buat Booking Baru</a>
            </div>

            @if($bookings->isEmpty())
                <div class="admin-card" style="padding:2rem;text-align:center;">
                    <p>Belum ada booking. Silakan lakukan booking melalui halaman utama.</p>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table" style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Sesi</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td>{{ substr($booking->booking_time, 0, 5) }}</td>
                                    <td>{{ $booking->session_type ?? 'Sesi Gym' }}</td>
                                    <td><span class="admin-status admin-status--{{ $booking->status === 'approved' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : ($booking->status === 'completed' ? 'neutral' : 'warning')) }}">{{ ucfirst($booking->status) }}</span></td>
                                    <td class="text-right">
                                        <form action="{{ route('member.booking.destroy', $booking->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-link-button admin-link-button--danger">Batalkan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
