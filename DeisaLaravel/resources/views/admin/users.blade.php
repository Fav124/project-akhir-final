@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="header">
    <h1>Pengaturan Akun Petugas</h1>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tgl Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-success' : '' }}" style="background: #f3f4f6; color: #374151;">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #991b1b;">Hapus</button>
                        </form>
                        @else
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Akun Anda</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $users->links() }}</div>
</div>
@endsection
