{{-- resources/views/evaluation/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Penilaian: {{ $coffee->name }}</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('evaluation.update', $coffee) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($criteria as $criterion)
                    <div class="mb-6 pb-6 border-b last:border-b-0">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">
                            {{ $criterion->code }} - {{ $criterion->name }}
                            <span class="text-sm font-normal text-gray-600">(Bobot: {{ $criterion->weight }})</span>
                        </h3>

                        @if ($criterion->subCriteria->isEmpty())
                            <p class="text-red-500 italic">Belum ada sub kriteria untuk kriteria ini</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($criterion->subCriteria as $sub)
                                    <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="evaluations[{{ $criterion->id }}]"
                                            value="{{ $sub->id }}"
                                            {{ isset($evaluations[$criterion->id]) && $evaluations[$criterion->id]->sub_criteria_id == $sub->id ? 'checked' : '' }}
                                            class="mr-3" required>
                                        <span class="flex-1">
                                            <span class="font-medium">{{ $sub->name }}</span>
                                            <span class="text-gray-600 ml-2">(Nilai: {{ $sub->value }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="flex gap-2 mt-6">
                    <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">
                        💾 Simpan Penilaian
                    </button>
                    <a href="{{ route('evaluation.index') }}"
                        class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
