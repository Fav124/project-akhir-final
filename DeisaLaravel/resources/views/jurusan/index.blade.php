@extends('layouts.app-tailwind')

@section('title', 'Data Jurusan')

@section('content')
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusans as $j)
                <tr>
                    <td style="font-weight: 700;">{{ $j->kode_jurusan }}</td>
                    <td>{{ $j->nama_jurusan }}</td>
                    <td>{{ Str::limit($j->deskripsi, 50) }}</td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('web.jurusan.edit', $j) }}" class="btn" style="padding: 0.4rem; background: #f3f4f6; color: #374151;">Edit</a>
                        <form action="{{ route('web.jurusan.destroy', $j) }}" method="POST" onsubmit="return confirm('Hapus jurusan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #b91c1c;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $jurusans->links() }}</div>
</div>
@endsection
