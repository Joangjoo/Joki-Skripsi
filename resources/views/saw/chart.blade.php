@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">📊 Visualisasi Hasil SAW</h2>
    <p class="text-gray-600 mb-6">Grafik perbandingan nilai preferensi alternatif kopi.</p>

    <div class="relative h-[400px]">
        <canvas id="rankingChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script>
    (function(){
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('rankingChart');
            if (!canvas) {
                console.error('SawChart: canvas #rankingChart tidak ditemukan');
                return;
            }
            if (canvas._chartInstance) {
                try { canvas._chartInstance.destroy(); } catch(e){ console.warn('SawChart: error destroy previous chart', e); }
            }

            const ctx = canvas.getContext('2d');
            const info = document.createElement('div');
            info.className = 'text-xs text-gray-500 mt-2';
            info.textContent = 'Debug: chart inisialisasi pada ' + new Date().toLocaleTimeString();
            canvas.parentNode.appendChild(info);

            try {
                canvas._chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($labels) !!},
                        datasets: [{
                            label: 'Nilai Preferensi (Vᵢ)',
                            data: {!! json_encode($scores) !!},
                            backgroundColor: 'rgba(251, 191, 36, 0.6)',
                            borderColor: 'rgba(217, 119, 6, 1)',
                            borderWidth: 2,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => value.toFixed(2)
                                }
                            }
                        }
                    }
                });
                console.info('SawChart: chart created OK');
            } catch (err) {
                console.error('SawChart: error creating chart', err);
            }
        });
    })();
</script>
@endpush

