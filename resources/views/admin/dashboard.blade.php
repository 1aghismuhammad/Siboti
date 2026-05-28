<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="admin-container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Members</div>
                <div class="stat-value">{{ $totalMembers ?? 0 }}</div>
                <div class="stat-sub">Active members</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Bookings Today</div>
                <div class="stat-value">{{ $bookingsToday ?? 0 }}</div>
                <div class="stat-sub">New bookings</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Check-ins Today</div>
                <div class="stat-value">{{ $checkinsToday ?? 0 }}</div>
                <div class="stat-sub">Visits recorded</div>
            </div>
        </div>

        <div class="card" style="margin-top:1rem;">
            <div class="card-header">
                <h3 class="text-white">Latest Users</h3>
                <a href="{{ route('admin.users.index') }}" class="link-manage">Manage Users</a>
            </div>
            <div class="card-body">
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-muted">{{ $user->role }}</td>
                                    <td class="small">{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted" colspan="4">No users yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>