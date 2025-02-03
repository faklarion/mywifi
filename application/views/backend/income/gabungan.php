<?php
$data = [];

for ($i = 1; $i <= 12; $i++) {
    $bulanNama = date('F', mktime(0, 0, 0, $i, 1));
    
    // Pemasukan
    $this->db->select('SUM(nominal) AS total');
    $this->db->from('income');
    $this->db->where('MONTH(date_payment)', $i);
    $this->db->where('YEAR(date_payment)', $tahun);
    $query = $this->db->get()->row_array();
    $pemasukan = !empty($query['total']) ? $query['total'] : 0;
    
    // Pengeluaran
    $this->db->select('SUM(nominal) AS total');
    $this->db->from('expenditure');
    $this->db->where('MONTH(date_payment)', $i);
    $this->db->where('YEAR(date_payment)', $tahun);
    $query = $this->db->get()->row_array();
    $pengeluaran = !empty($query['total']) ? $query['total'] : 0;
    
    // Tagihan Belum Dibayar
    $this->db->select('SUM(price * qty) AS total');
    $this->db->from('invoice_detail');
    $this->db->join('invoice', 'invoice.invoice_id = invoice_detail.invoice_id');
    $this->db->where('invoice.month', $i);
    $this->db->where('invoice.year', $tahun);
    $this->db->where('invoice.status', 'BELUM BAYAR');
    $query = $this->db->get()->row_array();
    $tagihanBelum = !empty($query['total']) ? $query['total'] : 0;
    
    // Tagihan Sudah Dibayar
    $this->db->select('SUM(price * qty) AS total');
    $this->db->from('invoice_detail');
    $this->db->join('invoice', 'invoice.invoice_id = invoice_detail.invoice_id');
    $this->db->where('invoice.month', $i);
    $this->db->where('invoice.year', $tahun);
    $this->db->where('invoice.status', 'SUDAH BAYAR');
    $query = $this->db->get()->row_array();
    $tagihanSudah = !empty($query['total']) ? $query['total'] : 0;
    
    // Instalasi
    $this->db->from('customer');
    $this->db->where('YEAR(created)', $tahun);
    $this->db->where('MONTH(created)', $i);
    $installasi = $this->db->count_all_results();
    
    // Pengaduan
    $this->db->from('pengaduan');
    $this->db->where('MONTH(tanggal_pengaduan)', $i);
    $this->db->where('YEAR(tanggal_pengaduan)', $tahun);
    $pengaduan = $this->db->count_all_results();
    
    $data[] = [
        'bulan' => $bulanNama,
        'pemasukan' => $pemasukan,
        'pengeluaran' => $pengeluaran,
        'tagihan_belum' => $tagihanBelum,
        'tagihan_sudah' => $tagihanSudah,
        'installasi' => $installasi,
        'pengaduan' => $pengaduan,
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Laporan Gabungan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <p align="center"><b>
    <br><br>
            <font size="5">PT RINAYA DWI SINERGI | ICONNET BANJARBARU</font> <br>
            <font size="3">Jl Karang Anyar 1 Gg Arrozak 2 Loktabat Utara,Banjarbaru Utara,Banjarbaru,Kalimantan Selatan</font>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        </b></p>
    <br>
    <h2 class="text-center">Laporan Gabungan Tahun <?php echo $tahun; ?></h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Tagihan Belum Dibayar</th>
                <th>Tagihan Sudah Dibayar</th>
                <th>Installasi</th>
                <th>Pengaduan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo $row['bulan']; ?></td>
                    <td>Rp <?php echo number_format($row['pemasukan'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($row['pengeluaran'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($row['tagihan_belum'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($row['tagihan_sudah'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['installasi']; ?></td>
                    <td><?php echo $row['pengaduan']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<script>
    window.print();
</script>