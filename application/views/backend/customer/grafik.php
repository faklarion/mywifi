<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="text-center"><?= $title ?></h2>
        <p class="text-center">Tahun : <?= $tahun ?></p>
        <p class="text-center"><img src="<?= base_url('assets/images/logoicon.png')?>" width="200px"></p>
    </div>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <?php  
        $belumInstall = [];
        $sudahInstall = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $this->db->from('customer');
            $this->db->where('status_pasang', '0');
            $this->db->where('YEAR(created)', $tahun);
            $this->db->where('MONTH(created)', $bulan);
            $belumInstall[] = $this->db->count_all_results();
            
            $this->db->from('customer');
            $this->db->where('status_pasang', '1');
            $this->db->where('YEAR(created)', $tahun);
            $this->db->where('MONTH(created)', $bulan);
            $sudahInstall[] = $this->db->count_all_results();
        }
    ?>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Belum Terpasang',
                        data: <?= json_encode($belumInstall) ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sudah Terpasang',
                        data: <?= json_encode($sudahInstall) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
<script>
    window.print();
</script>
