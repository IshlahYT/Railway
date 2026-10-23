@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-[32px] p-8 border border-zinc-200 shadow-xl space-y-6">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-rail-500 text-white flex items-center justify-center font-mono font-bold">HI</span>
            <div>
                <h1 class="text-xl font-extrabold text-zinc-900">Admin CMS HI 102</h1>
                <p class="text-xs text-zinc-500">Kelola seluruh teks, spesifikasi, dan data pengujian</p>
            </div>
        </div>

        @if(session('error'))
            <div class="p-3 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-600 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-zinc-700 mb-1">Password Admin</label>
                <input type="password" name="password" required placeholder="Masukkan password (default: admin123)"
                       class="w-full px-4 py-3 rounded-2xl border border-zinc-300 text-sm focus:outline-none focus:border-rail-500">
            </div>
            <button type="submit" class="w-full py-3 rounded-2xl bg-rail-500 hover:bg-rail-600 text-white font-bold text-sm transition shadow-lg shadow-rail-500/30">
                Masuk ke Dashboard Admin
            </button>
        </form>
    </div>
</div>
@endsection
