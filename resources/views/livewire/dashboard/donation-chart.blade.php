<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 h-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">Tren Donasi Bulanan</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total nominal donasi terkumpul 6 bulan terakhir</p>
        </div>
        <div class="text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 px-3 py-1 rounded-full font-semibold">
            Grafik 6 Bulan
        </div>
    </div>

    <!-- Chart Container -->
    <div class="relative w-full h-80">
        <!-- Load Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
        
        <div wire:ignore 
             x-data="{
                labels: @js($labels),
                values: @js($values),
                init() {
                    // Poll until Chart.js is loaded
                    const checkInterval = setInterval(() => {
                        if (typeof Chart !== 'undefined') {
                            clearInterval(checkInterval);
                            this.renderChart();
                        }
                    }, 50);
                },
                renderChart() {
                    const ctx = document.getElementById('donationChartCanvas').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: this.labels,
                            datasets: [{
                                label: 'Nominal Donasi',
                                data: this.values,
                                borderColor: 'rgb(79, 70, 229)',
                                backgroundColor: 'rgba(79, 70, 229, 0.08)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: 'rgb(79, 70, 229)',
                                pointHoverRadius: 7,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(156, 163, 175, 0.1)'
                                    },
                                    ticks: {
                                        color: 'rgba(156, 163, 175, 0.8)',
                                        font: { size: 11 },
                                        callback: function(value) {
                                            if (value >= 1000000) {
                                                return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                                            }
                                            if (value >= 1000) {
                                                return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                            }
                                            return 'Rp' + value;
                                        }
                                    }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: 'rgba(156, 163, 175, 0.8)',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                }
             }" class="absolute inset-0">
            <canvas id="donationChartCanvas" class="w-full h-full"></canvas>
        </div>
    </div>
</div>
