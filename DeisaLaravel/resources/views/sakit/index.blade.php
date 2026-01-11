@extends('layouts.app')

@section('title', 'Catatan Sakit')

@section('content')
<div class="header">
    <h1>Catatan Kesehatan Santri</h1>
    <a href="{{ route('sakit.create') }}" class="btn" style="background: #ef4444; color: white;">Catat Santri Sakit</a>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Tgl Masuk</th>
                    <th>Nama Santri</th>
                    <th>Gejala</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $sakit)
                <tr>
                    <td>{{ $sakit->tgl_masuk->format('d M Y') }}</td>
                    <td style="font-weight: 600;">{{ $sakit->santri->nama_lengkap }}</td>
                    <td>{{ Str::limit($sakit->gejala, 30) }}</td>
                    <td>
                        <span class="badge {{ $sakit->status === 'Sembuh' ? 'badge-success' : 'badge-error' }}">
                            {{ $sakit->status }}
                        </span>
                    </td>
                    <td>
                        @if($sakit->status !== 'Sembuh')
                        <form action="{{ route('sakit.sembuh', $sakit) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #f0fdf4; color: #166534; font-size: 0.75rem;">Tandai Sembuh</button>
                        </form>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.875rem;">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">
        {{ $records->links() }}
    </div>
</div>
@endsection
