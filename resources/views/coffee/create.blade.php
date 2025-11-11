{{-- resources/views/coffee/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Tambah Alternatif Biji Kopi</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('coffee.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Nama Biji Kopi</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2"
                        placeholder="Contoh: Arabica Gayo" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2"
                        placeholder="Deskripsi singkat tentang biji kopi ini"></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">Simpan</button>
                    <a href="{{ route('coffee.index') }}"
                        class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
