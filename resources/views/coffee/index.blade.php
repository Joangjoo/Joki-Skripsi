{{-- resources/views/coffee/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Alternatif Biji Kopi</h1>
            <a href="{{ route('coffee.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                + Tambah Alternatif
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($coffees as $coffee)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-amber-600 to-amber-800 p-4">
                        <h3 class="text-xl font-bold text-white">{{ $coffee->name }}</h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">{{ $coffee->description ?? 'Tidak ada deskripsi' }}</p>
                        <div class="flex justify-between">
                            <a href="{{ route('evaluation.edit', $coffee) }}" class="text-blue-600 hover:text-blue-800">
                                📝 Nilai
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-800"
                                data-modal-target="deleteCoffeeModal{{ $coffee->id }}">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal Konfirmasi Hapus --}}
                <div id="deleteCoffeeModal{{ $coffee->id }}"
                    class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Konfirmasi Hapus</h3>
                        <p class="text-gray-600 mb-4">
                            Apakah Anda yakin ingin menghapus alternatif biji kopi
                            <strong>{{ $coffee->name }}</strong>?
                        </p>
                        <div class="flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                onclick="closeModal('deleteCoffeeModal{{ $coffee->id }}')">
                                Batal
                            </button>
                            <form action="{{ route('coffee.destroy', $coffee) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
                    Belum ada alternatif biji kopi. Silakan tambahkan terlebih dahulu.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.getElementById(modalId).classList.remove('hidden');
                document.getElementById(modalId).classList.add('flex');
            });
        });

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection
