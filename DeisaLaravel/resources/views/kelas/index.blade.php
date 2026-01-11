@extends('layouts.app-tailwind')

@section('title', 'Data Kelas')

@section('content')
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $k)
                <tr>
                    <td style="font-weight: 700;">{{ $k->nama_kelas }}</td>
                    <td>{{ $k->jurusan->nama_jurusan }}</td>
                    <td>{{ $k->tahun_ajaran }}</td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('web.kelas.edit', $k) }}" class="btn" style="padding: 0.4rem; background: #f3f4f6; color: #374151;">Edit</a>
                        <form action="{{ route('web.kelas.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #b91c1c;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $kelas->links() }}</div>
</div>
@endsection
