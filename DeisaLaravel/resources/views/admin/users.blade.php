@extends('layouts.app-tailwind')

@section('title', 'User Management')
@section('subtitle', 'Manage system users and access')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Active Users</h3>
        <div class="relative w-64 hidden sm:block">
             <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[20px]">search</span>
            </span>
            <input type="text" placeholder="Search users..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
            <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">User Info</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Joined At</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                 @forelse($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role == 'admin')
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 dark:text-purple-300 dark:bg-purple-900/30 rounded-lg text-xs font-medium">Administrator</span>
                            @else
                                <span class="px-2 py-1 bg-slate-100 text-slate-700 dark:text-slate-300 dark:bg-slate-700 rounded-lg text-xs font-medium capitalize">{{ $user->role }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('web.admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors tooltip" title="Delete User">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400 italic">Current User</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300">group_off</span>
                                <p>No users found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
