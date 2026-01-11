@extends('layouts.app')

@section('title', 'Inventaris Obat')

@section('content')
<div class="header">
    <h1>Inventaris Obat</h1>
    <a href="{{ route('obat.create') }}" class="btn btn-primary">Tambah Obat</a>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga/Satuan</th>
                    <th>Kadaluarsa</th>
                    <th>Status Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obats as $obat)
                <tr>
                    <td style="font-weight: 600;">{{ $obat->nama_obat }}</td>
                    <td>{{ $obat->stok }}</td>
                    <td>{{ $obat->satuan }}</td>
                    <td>Rp{{ number_format($obat->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($obat->stok <= $obat->stok_minimum)
                            <span class="badge badge-error">Stok Rendah</span>
                        @else
                            <span class="badge badge-success">Cukup</span>
                        @endif
                    </td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('obat.edit', $obat) }}" class="btn" style="padding: 0.4rem; background: #f3f4f6; color: #374151;">Edit</a>
                        <form action="{{ route('obat.destroy', $obat) }}" method="POST" onsubmit="return confirm('Hapus obat ini?')">
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
        {{ $obats->links() }}
    </div>
</div>
@endsection
