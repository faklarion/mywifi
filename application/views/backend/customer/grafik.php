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
        <p class="text-center"><img src="<?= base_url('assets/images/logoicon.png')?>" width="200px"></p>
    </div>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <?php  
        $this->db->from('customer');
        $this->db->where('status_pasang', '0');
        $totalBelumInstall = $this->db->count_all_results();
    ?>

    <?php  
        $this->db->from('customer');
        $this->db->where('status_pasang', '1');
        $totalInstall = $this->db->count_all_results();
    ?>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar', // Change to 'line', 'pie', 'doughnut', etc. for different chart types
            data: {
                labels: ['Data Installasi'],
                datasets: [
                    {
                        label: 'Belum Terpasang',
                        data: [<?= $totalBelumInstall ?>],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sudah Terpasang',
                        data: [<?= $totalInstall ?>],
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