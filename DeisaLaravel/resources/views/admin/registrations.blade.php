@extends('layouts.app')

@section('title', 'Persetujuan Registrasi')

@section('content')
<div class="header">
    <h1>Permintaan Registrasi Baru</h1>
</div>

<div class="card">
    @if($requests->isEmpty())
        <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Tidak ada permintaan registrasi pending.</p>
    @else
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tgl Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $reg)
                    <tr>
                        <td style="font-weight: 600;">{{ $reg->name }}</td>
                        <td>{{ $reg->email }}</td>
                        <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                        <td style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('admin.approve', $reg->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="padding: 0.4rem; background: #dcfce7; color: #166534;">Setujui</button>
                            </form>
                            <form action="{{ route('admin.reject', $reg->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #991b1b;">Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">{{ $requests->links() }}</div>
    @endif
</div>
@endsection
