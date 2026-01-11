@extends('layouts.app-tailwind')

@section('title', 'Referensi Diagnosis')

@section('content')
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($diagnoses as $d)
                <tr>
                    <td style="font-weight: 700;">{{ $d->nama_diagnosis }}</td>
                    <td>
                        <span class="badge {{ $d->kategori == 'Berat' ? 'badge-error' : ($d->kategori == 'Sedang' ? 'badge-warning' : 'badge-success') }}"
                              style="{{ $d->kategori == 'Sedang' ? 'background: #fef3c7; color: #92400e;' : '' }}">
                            {{ $d->kategori }}
                        </span>
                    </td>
                    <td>{{ Str::limit($d->deskripsi, 50) }}</td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('web.diagnosis.edit', $d) }}" class="btn" style="padding: 0.4rem; background: #f3f4f6; color: #374151;">Edit</a>
                        <form action="{{ route('web.diagnosis.destroy', $d) }}" method="POST" onsubmit="return confirm('Hapus diagnosis ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #b91c1c;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $diagnoses->links() }}</div>
</div>
@endsection
