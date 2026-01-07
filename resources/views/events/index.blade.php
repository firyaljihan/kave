<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Event Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('penyelenggara.events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                    + Buat Event Baru
                </a>

                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Judul</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="border px-4 py-2">{{ $event->title }}</td>
                                <td class="border px-4 py-2">{{ $event->start_date }}</td>
                                <td class="border px-4 py-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $event->status === 'published' ? 'bg-green-100 text-green-800' :
                                           ($event->status === 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('events.show', $event->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>

                                    @if($event->status == 'draft')
                                        <a href="{{ route('penyelenggara.events.edit', $event->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>

                                        <form action="{{ route('penyelenggara.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>

                                        <form action="{{ route('penyelenggara.events.submit', $event->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-indigo-500 text-white text-xs px-2 py-1 rounded hover:bg-indigo-700">
                                                Ajukan ke Admin
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada event.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
