@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
<div class="header">
    <h1>Data Santri</h1>
    <a href="{{ route('santri.create') }}" class="btn btn-primary">Tambah Santri</a>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($santris as $santri)
                <tr>
                    <td style="font-weight: 600;">{{ $santri->nis }}</td>
                    <td>{{ $santri->nama_lengkap }}</td>
                    <td>{{ $santri->kelas->nama_kelas }} ({{ $santri->jurusan->kode_jurusan }})</td>
                    <td>
                        <span class="badge {{ $santri->status_kesehatan === 'Sehat' ? 'badge-success' : 'badge-error' }}">
                            {{ $santri->status_kesehatan }}
                        </span>
                    </td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('santri.edit', $santri) }}" class="btn" style="padding: 0.4rem; background: #f3f4f6; color: #374151;">Edit</a>
                        <form action="{{ route('santri.destroy', $santri) }}" method="POST" onsubmit="return confirm('Hapus data santri ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #b91c1c;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">
        {{ $santris->links() }}
    </div>
</div>
@endsection
