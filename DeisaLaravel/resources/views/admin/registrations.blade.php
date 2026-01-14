@extends('layouts.app-tailwind')

@section('title', 'Registration Requests')
@section('subtitle', 'Manage new user sign-ups')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Pending Requests</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
            <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Submitted At</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                 @forelse($requests as $req)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800 dark:text-white">{{ $req->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $req->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $req->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('web.admin.approve', $req->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition-colors text-xs font-semibold">
                                        <span class="material-symbols-outlined text-[16px]">check</span> Approve
                                    </button>
                                </form>
                                <form action="{{ route('web.admin.reject', $req->id) }}" method="POST" class="inline" onsubmit="return confirm('Reject this user request?');">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs font-semibold">
                                        <span class="material-symbols-outlined text-[16px]">close</span> Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300">verified_user</span>
                                <p>No pending registration requests</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($requests->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection
