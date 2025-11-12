@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Matriks Penilaian Alternatif</h1>

        @if ($coffees->isEmpty() || $criteria->isEmpty())
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                <p>Silakan tambahkan kriteria dan alternatif terlebih dahulu sebelum melakukan penilaian.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-amber-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Alternatif</th>
                            @foreach ($criteria as $criterion)
                                <th class="px-4 py-3 text-center">{{ $criterion->code }}<br><span
                                        class="text-xs font-normal">{{ $criterion->name }}</span></th>
                            @endforeach
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coffees as $coffee)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">{{ $coffee->name }}</td>
                                @foreach ($criteria as $criterion)
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $evaluation = $coffee->evaluations
                                                ->where('criteria_id', $criterion->id)
                                                ->first();
                                        @endphp
                                        @if ($evaluation)
                                            <span
                                                class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                                {{ $evaluation->subCriteria->name }}<br>
                                                <span class="font-bold">({{ $evaluation->subCriteria->value }})</span>
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Belum dinilai</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('evaluation.edit', $coffee) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                        Edit Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('dashboard.index') }}"
                    class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 text-lg font-semibold">
                    🎯 Lihat Hasil Perhitungan SAW
                </a>
            </div>
        @endif
    </div>
@endsection
