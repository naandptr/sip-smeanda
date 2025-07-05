$(function () {
    const $chartPrakerin = $('#chartPrakerin');
    const $chartDudi = $('#chartDudi');

    const ctx1 = $chartPrakerin[0]?.getContext('2d');
    const ctx2 = $chartDudi[0]?.getContext('2d');

    let chart1 = null;
    let chart2 = null;

    function renderCharts(res) {
        if (chart1) chart1.destroy();
        if (chart2) chart2.destroy();

        chart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: res.chart1.labels,
                datasets: [{
                    label: 'Jumlah Penetapan Prakerin',
                    data: res.chart1.data,
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56,189,248,0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: res.chart2.labels,
                datasets: [{
                    label: 'Jumlah Siswa per DUDI',
                    data: res.chart2.data,
                    backgroundColor: '#a78bfa'
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y', 
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    $('#tahun_awal, #tahun_akhir').on('change', fetchChartData);

    const initialLabels1 = $chartPrakerin.data('initial-labels');
    const initialData1 = $chartPrakerin.data('initial-values');

    const initialLabels2 = $chartDudi.data('initial-labels');
    const initialData2 = $chartDudi.data('initial-values');

    renderCharts({
        chart1: {
            labels: initialLabels1,
            data: initialData1
        },
        chart2: {
            labels: initialLabels2,
            data: initialData2
        }
    });

    function fetchChartData() {
        const url = $chartPrakerin.data('url');
        const tahun_awal = $('#tahun_awal').val();
        const tahun_akhir = $('#tahun_akhir').val();

        $.get(url, {
            tahun_awal: tahun_awal,
            tahun_akhir: tahun_akhir
        }, function (res) {
            renderCharts(res);
        });
    }
});
