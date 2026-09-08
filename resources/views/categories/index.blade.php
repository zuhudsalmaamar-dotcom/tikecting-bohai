<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Form Tambah Kategori -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori Baru</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700">
                        Tambah Kategori
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Kategori</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                            <th class="p-3">Nama Kategori</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @forelse($categories as $category)
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">{{ $category->name }}</td>
                                <td class="p-3 text-gray-600">{{ $category->description ?? '-' }}</td>
                                <td class="p-3">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>