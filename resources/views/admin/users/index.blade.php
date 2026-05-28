<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Users Management</h2>
    </x-slot>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>All Users</h3>
            </div>
            <div class="card-body">
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i => $user)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-muted">{{ $user->role }}</td>
                                    <td class="small">{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
