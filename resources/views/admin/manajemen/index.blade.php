@extends('admin.layouts.app')

@section('title', 'Manajemen User HIMANIKKA')
@section('pageTitle', 'User')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">
                    Manajemen User HIMANIKKA
                </div>

                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Kelola User
                </h1>

                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">
                    Kelola seluruh user HIMANIKKA dalam satu halaman.
                </p>
            </div>

            {{-- BUTTON TAMBAH --}}
            <div class="flex flex-wrap gap-3">
                <button
                    type="button"
                    @click="$store.modal.open({
                        mode: 'form',
                        title: 'Tambah User',
                        formAction: '{{ route('admin.manajemen.store') }}',
                        method: 'POST',
                        enctype: 'multipart/form-data',

                        fields: [
                            { name: 'name', label: 'Nama Pengguna', type: 'text' },
                            { name: 'NIM', label: 'NIM/NIDN', type: 'text' },

                            {
                                name: 'role_id',
                                label: 'Role',
                                type: 'select',
                                options: [
                                    @foreach ($roles as $role)
                                        { value: '{{ $role->id }}', label: '{{ $role->name }}' },
                                    @endforeach
                                ]
                            },

                            {
                                name: 'alamat',
                                label: 'Alamat',
                                type: 'textarea'
                            },
                            { name: 'email', label: 'Email', type: 'text' },
                            { name: 'avatar', label: 'Avatar', type: 'file' },
                            { name: 'no_hp', label: 'No HP', type: 'text' },
                            { name: 'password', label: 'Password', type: 'password', required: true },
                            { name: 'password_confirmation', label: 'Konfirmasi Password', type: 'password', required: true }
                        ],
                        data: { no_hp: '' }
                    })"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-100"
                >
                    <span class="text-base">+</span>
                    Tambah User
                </button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card p-0 overflow-hidden">

        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                Daftar User
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Data user yang tersimpan.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">

                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIM/NIDN</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">alamat</th>
                        <th class="px-6 py-4">Avatar</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($users as $item)

                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">

                            {{-- ID --}}
                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>

                            {{-- NAMA --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->name }}
                                </div>

                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $item->email }}
                                </div>
                            </td>

                            {{-- NIM --}}
                            <td class="px-6 py-4">
                                {{ $item->NIM ?? '-' }}
                            </td>

                            {{-- ROLE --}}
                            <td class="px-6 py-4">
                                {{ ($item->role_id ? ucfirst($item->role->name) : '-') }}
                            </td>

                            {{-- alamat --}}
                            <td class="px-6 py-4">
                                {{ ucfirst($item->alamat ?? '-') }}
                            </td>

                            {{-- AVATAR --}}
                            <td class="px-6 py-4">
                                @if ($item->avatar)
                                    <img
                                        src="{{ asset('storage/' . $item->avatar) }}"
                                        alt="Avatar"
                                        class="h-12 w-12 rounded-2xl object-cover ring-2 ring-slate-200 dark:ring-slate-700"
                                    >
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400 dark:bg-slate-800">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            {{-- NO HP --}}
                            <td class="px-6 py-4">
                                {{ $item->No_hp ?? '-' }}
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    {{-- DETAIL --}}
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'detail',
                                            title: 'Detail User',
                                            detail: {
                                                name: '{{ $item->name }}',
                                                email: '{{ $item->email }}',
                                                NIM: '{{ $item->NIM ?? '-' }}',
                                                role: '{{ $item->role_id ? ucfirst($item->role->name) : '-' }}',
                                                alamat: '{{ $item->alamat ?? '-' }}',
                                                no_hp: '{{ $item->No_hp ?? '-' }}',
                                                avatar: '{{ $item->avatar ? asset('storage/' . $item->avatar) : '' }}',
                                            },
                                            fields: [
                                                {key: 'avatar', label: 'Avatar', type: 'image'},
                                                {key: 'name', label: 'Nama', type: 'text'},
                                                {key: 'email', label: 'Email', type: 'text'},
                                                {key: 'NIM', label: 'NIM/NIDN', type: 'text'},
                                                {key: 'role', label: 'Role', type: 'text'},
                                                {key: 'no_hp', label: 'No HP', type: 'text'},
                                                {key: 'alamat', label: 'Alamat', type: 'textarea'},
                                            ]
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>

                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
    mode: 'form',
    title: 'Edit User',
    formAction: '{{ route('admin.manajemen.update', $item->id) }}',
    method: 'POST',
    extraMethod: 'PUT',
    enctype: 'multipart/form-data',
    fields: [
                                                { name: 'name', label: 'Nama Pengguna', type: 'text', required: true },
                            { name: 'NIM', label: 'NIM/NIDN', type: 'text' },

                            {
                                name: 'role_id',
                                label: 'Role',
                                type: 'select',
                                options: [
                                    @foreach ($roles as $role)
                                        { value: '{{ $role->id }}', label: '{{ $role->name }}' },
                                    @endforeach
                                ]
                            },

                            {
                                name: 'alamat',
                                label: 'Alamat',
                                type: 'textarea'
                            },
                            { name: 'email', label: 'Email', type: 'text' },
                            { name: 'avatar', label: 'Avatar', type: 'file' },
                            { name: 'no_hp', label: 'No HP', type: 'text' },
                            { name: 'password', label: 'Password', type: 'password' },
                            { name: 'password_confirmation', label: 'Konfirmasi Password', type: 'password' }
                                            ],

                                            data: {
                                                name: @js($item->name),
                                                NIM: @js($item->NIM),
                                                role_id: @js($item->role_id),
                                                alamat: @js($item->alamat),
                                                email: @js($item->email),
                                                no_hp: @js($item->No_hp),
                                                password: '',
                                                password_confirmation: ''
                                            }
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600"
                                    >
                                        Edit
                                    </button>

                                    {{-- DELETE --}}
                                    <button
                                        type="button"
                                        @click="$store.modal.open({
                                            mode: 'confirm',
                                            title: 'Hapus User',
                                            message: 'Data user ini akan dihapus.',
                                            action: () => document.getElementById('delete-form-{{ $item->id }}').submit()
                                        })"
                                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700"
                                    >
                                        Hapus
                                    </button>

                                    <form
    id="delete-form-{{ $item->id }}"
    action="{{ route('admin.manajemen.destroy', $item->id) }}"
    method="POST"
    class="hidden"
>
    @csrf
</form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center">
                                <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    Belum ada data user
                                </div>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Silakan klik tombol Tambah User untuk menambahkan data baru.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection