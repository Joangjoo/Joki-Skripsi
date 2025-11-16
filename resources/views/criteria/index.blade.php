{{-- resources/views/criteria/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Manajemen Kriteria & Sub Kriteria</h1>

        {{-- Form Tambah Kriteria --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Tambah Kriteria Baru</h2>
            <form action="{{ route('criteria.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @csrf
                <input type="text" name="code" placeholder="Kode (C1)" class="border rounded px-3 py-2" required>
                <input type="text" name="name" placeholder="Nama Kriteria" class="border rounded px-3 py-2" required>
                <input type="number" name="weight" step="0.01" placeholder="Bobot (0-1)"
                    class="border rounded px-3 py-2" required>
                <select name="type" class="border rounded px-3 py-2" required>
                    <option value="">Pilih Tipe</option>
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
                <button type="submit" class="bg-amber-600 text-white rounded px-4 py-2 hover:bg-amber-700">
                    Tambah
                </button>


            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <h2 class="text-lg font-semibold">Status Bobot Kriteria</h2>
            <p class="mt-2">
                Total Bobot: <strong>{{ $totalWeight }}</strong>
                <span
                    class="{{ $totalWeight < 1 ? 'text-red-600' : ($totalWeight > 1 ? 'text-red-600' : 'text-green-600') }}">
                    ({{ $totalWeight == 1 ? 'Valid' : 'Tidak Valid' }})
                </span>
            </p>
            <p>Jumlah Kriteria: <strong>{{ $countCriteria }}</strong></p>

            @if ($totalWeight < 1)
                <p class="text-red-600 mt-2">
                    Total bobot masih kurang: {{ number_format(1 - $totalWeight, 2) }} lagi.
                </p>
            @elseif ($totalWeight > 1)
                <p class="text-red-600 mt-2">
                    Total bobot kelebihan: {{ number_format($totalWeight - 1, 2) }}.
                </p>
            @endif
        </div>


        {{-- Daftar Kriteria --}}
        @foreach ($criteria as $criterion)
            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $criterion->code }} - {{ $criterion->name }}</h3>
                        <p class="text-gray-600">Bobot: {{ $criterion->weight }} | Tipe:
                            <span
                                class="px-2 py-1 rounded text-sm {{ $criterion->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($criterion->type) }}
                            </span>
                        </p>
                    </div>

                    {{-- Tombol Hapus dengan Modal --}}
                    <button type="button" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                        data-modal-target="deleteCriteriaModal{{ $criterion->id }}">
                        Hapus
                    </button>
                </div>

                {{-- Form Tambah Sub Kriteria --}}
                <div class="bg-gray-50 rounded p-4 mb-3">
                    <h4 class="font-semibold mb-2">Tambah Sub Kriteria</h4>
                    <form action="{{ route('sub-criteria.store') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="hidden" name="criteria_id" value="{{ $criterion->id }}">
                        <input type="text" name="name" placeholder="Nama Sub Kriteria"
                            class="border rounded px-3 py-2 flex-1" required>
                        <input type="number" name="value" step="0.01" placeholder="Nilai"
                            class="border rounded px-3 py-2 w-32" required>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah</button>
                    </form>
                </div>

                {{-- Daftar Sub Kriteria --}}
                @if ($criterion->subCriteria->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Sub Kriteria</th>
                                    <th class="px-4 py-2 text-left">Nilai</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($criterion->subCriteria as $sub)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $sub->name }}</td>
                                        <td class="px-4 py-2">{{ $sub->value }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button" class="text-red-600 hover:text-red-800"
                                                data-modal-target="deleteSubCriteriaModal{{ $sub->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Modal Konfirmasi Hapus Sub Kriteria --}}
                                    <div id="deleteSubCriteriaModal{{ $sub->id }}"
                                        class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                            <h3 class="text-lg font-semibold mb-3 text-gray-800">
                                                Konfirmasi Hapus Sub Kriteria
                                            </h3>
                                            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus sub kriteria
                                                <strong>{{ $sub->name }}</strong>?
                                            </p>
                                            <div class="flex justify-end gap-3">
                                                <button type="button"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                                    onclick="closeModal('deleteSubCriteriaModal{{ $sub->id }}')">
                                                    Batal
                                                </button>
                                                <form action="{{ route('sub-criteria.destroy', $sub) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada sub kriteria</p>
                @endif
            </div>

            {{-- Modal Konfirmasi Hapus Kriteria --}}
            <div id="deleteCriteriaModal{{ $criterion->id }}"
                class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Konfirmasi Hapus Kriteria</h3>
                    <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus kriteria
                        <strong>{{ $criterion->name }}</strong> beserta semua sub kriterianya?
                    </p>
                    <div class="flex justify-end gap-3">
                        <button type="button" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                            onclick="closeModal('deleteCriteriaModal{{ $criterion->id }}')">
                            Batal
                        </button>
                        <form action="{{ route('criteria.destroy', $criterion) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($criteria->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
                Belum ada kriteria. Silakan tambahkan kriteria terlebih dahulu.
            </div>
        @endif
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
@push('scripts')
    <script>
        @if (session('success'))
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}"
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}"
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: "warning",
                title: "{{ session('warning') }}"
            });
        @endif

        @if (session('info'))
            Toast.fire({
                icon: "info",
                title: "{{ session('info') }}"
            });
        @endif
    </script>
@endpush
