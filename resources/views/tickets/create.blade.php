<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tiket Kendala Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori Masalah</label>
                        <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul Kendala</label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Printer Rusak / Lupa Password">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tingkat Prioritas</label>
                        <select name="priority" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="low">Low (Rendah)</option>
                            <option value="medium" selected>Medium (Sedang)</option>
                            <option value="high">High (Tinggi)</option>
                            <option value="critical">Critical (Sangat Mendesak)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Detail Masalah</label>
                        <textarea name="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan detail kendala secara rinci..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lampiran Foto/File (Opsional)</label>
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-semibold text-sm hover:bg-gray-400">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-sm hover:bg-blue-700">Kirim Tiket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>