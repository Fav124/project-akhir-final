@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Permintaan Registrasi User') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($requests->isEmpty())
                        <p class="text-center">Tidak ada permintaan registrasi baru.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Metode</th>
                                        <th>Tanggal Request</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $req)
                                    <tr>
                                        <td>{{ $req->name }}</td>
                                        <td>{{ $req->email }}</td>
                                        <td>
                                            @if($req->google_id)
                                                <span class="badge bg-danger">Google</span>
                                            @else
                                                <span class="badge bg-secondary">Manual</span>
                                            @endif
                                        </td>
                                        <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.registrations.approve', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui user ini?')">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.registrations.reject', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak user ini?')">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
