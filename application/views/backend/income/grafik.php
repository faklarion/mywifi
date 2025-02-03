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
        <p class="text-center">Tahun : <?= isset($tahun) ? $tahun : 'Tahun tidak tersedia' ?></p>
        <p class="text-center"><img src="<?= base_url('assets/images/logoicon.png')?>" width="200px"></p>
    </div>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <?php  
    $labels = [];
    $dataJumlah = [];

    for ($i = 1; $i <= 12; $i++) {
        // Data jumlah
        $this->db->select('SUM(nominal) AS total');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', $i);
        $this->db->where('YEAR(date_payment)', $tahun);
        $query = $this->db->get()->row_array();

        $totalJumlah = !empty($query['total']) ? $query['total'] : 0;

        $labels[] = date('F', mktime(0, 0, 0, $i, 1));
        $dataJumlah[] = $totalJumlah;
    }
?>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [
                {
                    label: 'Total Pemasukan',
                    data: <?= json_encode($dataJumlah) ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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