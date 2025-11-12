{{-- resources/views/saw/result.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-amber-800 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Tabel Peringkat Lengkap</h2>
            </div>
            {{-- Search & Filter --}}
            <div
                class="flex flex-col md:flex-row md:items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center gap-2 mb-3 md:mb-0">
                    <input type="text" id="searchInput" placeholder="🔍 Cari nama kopi..."
                        class="border border-gray-300 rounded px-3 py-2 text-sm w-64 focus:ring-2 focus:ring-amber-400 outline-none">
                </div>

                <div class="flex items-center gap-2">
                    <label for="scoreFilter" class="text-sm text-gray-700">Filter Nilai:</label>
                    <select id="scoreFilter"
                        class="border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-amber-400 outline-none">
                        <option value="">Semua</option>
                        <option value="high">Tinggi (≥ 0.80)</option>
                        <option value="medium">Sedang (0.60 – 0.79)</option>
                        <option value="low">Rendah (&lt; 0.60)</option>
                    </select>
                </div>
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
                                <td class="px-4 py-3 text-center font-bold text-lg">{{ $result['rank'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-800">{{ $result['name'] }}</div>
                                    @if ($result['description'])
                                        <div class="text-sm text-gray-600">{{ $result['description'] }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block bg-amber-100 text-amber-800 px-3 py-1 rounded-full font-bold">
                                        {{ number_format($result['score'], 3) }}
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

        <div class="grid md:grid-cols-3 gap-6">

            {{-- Matrik Keputusan --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-amber-800 text-white px-6 py-3">
                    <h2 class="text-lg font-semibold">Matriks Keputusan (X)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Alternatif</th>
                                @foreach ($results[0]['details'] as $d)
                                    <th class="px-3 py-2 text-center">{{ $d['criteria'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-2 font-semibold">{{ $result['name'] }}</td>
                                    @foreach ($result['details'] as $detail)
                                        {{-- Nilai mentah belum disimpan di SAWService, tampilkan normalized dikonversi kasar ke X --}}
                                        <td class="px-3 py-2 text-center text-gray-700">
                                            {{ $detail['normalized'] > 0 ? number_format($detail['normalized'], 3) : '0.000' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Matrik Normalisasi --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-amber-800 text-white px-6 py-3">
                    <h2 class="text-lg font-semibold">Matriks Normalisasi (R)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Alternatif</th>
                                @foreach ($results[0]['details'] as $d)
                                    <th class="px-3 py-2 text-center">{{ $d['criteria'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-2 font-semibold">{{ $result['name'] }}</td>
                                    @foreach ($result['details'] as $detail)
                                        <td class="px-3 py-2 text-center text-gray-700">
                                            {{ number_format($detail['normalized'], 3) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Perhitungan Nilai --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-amber-800 text-white px-6 py-3">
                    <h2 class="text-lg font-semibold">Perhitungan Nilai Akhir (Vᵢ)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Alternatif</th>
                                @foreach ($results[0]['details'] as $d)
                                    <th class="px-3 py-2 text-center">{{ $d['criteria'] }}</th>
                                @endforeach
                                <th class="px-3 py-2 text-center font-semibold">Total (Vᵢ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-2 font-semibold">{{ $result['name'] }}</td>
                                    @foreach ($result['details'] as $detail)
                                        <td class="px-3 py-2 text-center">
                                            {{ number_format($detail['weighted'], 3) }}
                                        </td>
                                    @endforeach
                                    <td class="px-3 py-2 text-center font-bold text-amber-700">
                                        {{ number_format($result['score'], 3) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Penjelasan Metode --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
            <h3 class="text-lg font-semibold mb-3 text-blue-900">📊 Tentang Metode SAW</h3>
            <p class="text-gray-700 mb-2">
                Simple Additive Weighting (SAW) adalah metode penjumlahan terbobot yang mencari penjumlahan terbobot
                dari rating kinerja pada setiap alternatif pada semua kriteria.
            </p>
            <p class="text-gray-700"><strong>Langkah perhitungan:</strong></p>
            <ol class="list-decimal ml-5 mt-2 text-gray-700">
                <li>Membuat matriks keputusan berdasarkan kriteria</li>
                <li>Normalisasi matriks (Benefit: Rij/max | Cost: min/Rij)</li>
                <li>Menjumlahkan hasil perkalian nilai normalisasi dengan bobot kriteria untuk memperoleh nilai akhir (Vᵢ)
                </li>
            </ol>
        </div>

    </div>

    {{-- MODAL DETAIL --}}
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
                </tr>`;
                tbody.innerHTML += row;
            });
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        const searchInput = document.getElementById('searchInput');
        const scoreFilter = document.getElementById('scoreFilter');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterType = scoreFilter.value;

            tableRows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)');
                const scoreCell = row.querySelector('td:nth-child(3) span');

                if (!nameCell || !scoreCell) return;

                const name = nameCell.textContent.toLowerCase();
                const score = parseFloat(scoreCell.textContent);

                let show = true;

                if (searchTerm && !name.includes(searchTerm)) {
                    show = false;
                }

                if (filterType === 'high' && score < 0.8) show = false;
                if (filterType === 'medium' && (score < 0.6 || score >= 0.8)) show = false;
                if (filterType === 'low' && score >= 0.6) show = false;

                row.style.display = show ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        scoreFilter.addEventListener('change', filterTable);
    </script>
@endsection
