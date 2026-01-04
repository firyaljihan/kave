<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.categories.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Tambah Kategori
                </a>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">No</th>
                            <th class="border px-4 py-2 text-left">Nama Kategori</th>
                            <th class="border px-4 py-2 text-center">Jumlah Event</th>
                            <th class="border px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 font-bold">{{ $category->name }}</td>
                            <td class="border px-4 py-2 text-center">
                                <span class="bg-gray-200 px-2 py-1 rounded text-xs">
                                    {{ $category->events->count() }} Event
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-yellow-600 hover:underline mr-3">Edit</a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
