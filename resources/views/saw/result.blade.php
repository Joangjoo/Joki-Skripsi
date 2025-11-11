{{-- resources/views/saw/result.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">🏆 Hasil Perhitungan SAW (Simple Additive Weighting)</h1>

        @if (empty($results))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                <p>Belum ada data untuk dihitung. Pastikan sudah:</p>
                <ul class="list-disc ml-5 mt-2">
                    <li>Menambahkan kriteria dengan sub kriteria</li>
                    <li>Menambahkan alternatif biji kopi</li>
                    <li>Melakukan penilaian untuk setiap alternatif</li>
                </ul>
            </div>
        @else
            {{-- Ranking Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (array_slice($results, 0, 3) as $index => $result)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition">
                        <div
                            class="bg-gradient-to-r {{ $index === 0 ? 'from-yellow-400 to-yellow-600' : ($index === 1 ? 'from-gray-300 to-gray-500' : 'from-orange-400 to-orange-600') }} p-4 text-white">
                            <div class="text-4xl font-bold mb-2">
                                @if ($index === 0)
                                    🥇
                                @elseif($index === 1)
                                    🥈
                                @else
                                    🥉
                                @endif
                                Peringkat {{ $result['rank'] }}
                            </div>
                            <h3 class="text-xl font-bold">{{ $result['name'] }}</h3>
                        </div>
                        <div class="p-4">
                            <div class="text-center mb-2">
                                <span class="text-3xl font-bold text-amber-600">{{ number_format($result['score'], 2) }}</span>
                                <p class="text-gray-600 text-sm">Nilai Preferensi</p>
                            </div>
                            @if ($result['description'])
                                <p class="text-gray-600 text-sm mt-2">{{ $result['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Detail Table --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="bg-amber-800 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Tabel Peringkat Lengkap</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-center">Rank</th>
                                <th class="px-4 py-3 text-left">Alternatif</th>
                                <th class="px-4 py-3 text-center">Nilai Preferensi</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center font-bold text-lg">
                                        {{ $result['rank'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-800">{{ $result['name'] }}</div>
                                        @if ($result['description'])
                                            <div class="text-sm text-gray-600">{{ $result['description'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-block bg-amber-100 text-amber-800 px-3 py-1 rounded-full font-bold">
                                            {{ number_format($result['score'], 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="showDetail({{ json_encode($result) }})"
                                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Penjelasan Metode --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3 text-blue-900">📊 Tentang Metode SAW</h3>
                <p class="text-gray-700 mb-2">
                    Simple Additive Weighting (SAW) adalah metode penjumlahan terbobot yang mencari penjumlahan terbobot
                    dari rating kinerja pada setiap alternatif pada semua kriteria.
                </p>
                <p class="text-gray-700">
                    <strong>Langkah perhitungan:</strong>
                </p>
                <ol class="list-decimal ml-5 mt-2 text-gray-700">
                    <li>Membuat matriks keputusan berdasarkan kriteria</li>
                    <li>Normalisasi matriks (Benefit: Rij/max | Cost: min/Rij)</li>
                    <li>Hasil akhir diperoleh dari penjumlahan perkalian matriks ternormalisasi dengan bobot</li>
                </ol>
            </div>
        @endif
    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="bg-amber-800 text-white px-6 py-4 flex justify-between items-center sticky top-0">
                <h3 class="text-xl font-semibold" id="modalTitle"></h3>
                <button onclick="closeModal()" class="text-white hover:text-gray-200 text-2xl">&times;</button>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <span class="text-gray-600">Nilai Preferensi Akhir:</span>
                    <span class="text-3xl font-bold text-amber-600 ml-2" id="modalScore"></span>
                </div>
                <table class="w-full" id="detailTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Kriteria</th>
                            <th class="px-4 py-2 text-center">Nilai Normalisasi</th>
                            <th class="px-4 py-2 text-center">Bobot</th>
                            <th class="px-4 py-2 text-center">Nilai Terbobot</th>
                        </tr>
                    </thead>
                    <tbody id="detailBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showDetail(result) {
            document.getElementById('modalTitle').textContent = result.name;
            document.getElementById('modalScore').textContent = result.score;

            let tbody = document.getElementById('detailBody');
            tbody.innerHTML = '';

            result.details.forEach(detail => {
                let row = `
            <tr class="border-b">
                <td class="px-4 py-2">${detail.criteria}</td>
                <td class="px-4 py-2 text-center">${detail.normalized}</td>
                <td class="px-4 py-2 text-center">${detail.weight}</td>
                <td class="px-4 py-2 text-center font-semibold">${detail.weighted}</td>
            </tr>
        `;
                tbody.innerHTML += row;
            });

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection
