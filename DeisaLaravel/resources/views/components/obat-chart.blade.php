@props(['id', 'type' => 'line', 'data' => []])

<canvas id="{{ $id }}" {{ $attributes }}></canvas>

@push('scripts')
    <script>
        new Chart(document.getElementById('{{ $id }}'), {
            type: '{{ $type }}',
            data: {
                labels: ['M1', 'M2', 'M3', 'M4'],
                datasets: [{
                    label: 'Penggunaan',
                    data: {{ json_encode($data) }},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    </script>
@endpush