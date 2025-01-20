<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4"><?= $title ?></h1>
    <img src="<?= base_url('assets/images/logoicon.png') ?>" width="200px" alt="">
    <div class="row g-4">
        <?php if (!empty($pengaduan)) : ?>
            <?php foreach ($pengaduan as $data) : ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                           <table>
                           <tr>
                            <td>Nomer Aduan</td>
                            <td>:</td>
                            <td><?= $data->pengaduan_id?></td>
                        </tr>
                        <tr>
                            <td>Nama Pelanggan</td>
                            <td>:</td>
                            <td><?= $data->name ?></td>
                        </tr>
                        <tr>
                            <td>Nomer Pelanggan</td>
                            <td>:</td>
                            <td><?= $data->no_services?></td>
                        </tr>
                        <tr>
                            <td>Alamat Pelanggan</td>
                            <td>:</td>
                            <td><?= $data->address ?></td>
                        </tr>
                        <tr>
                            <td>Keluhan Pelanggan</td>
                            <td>:</td>
                            <td><?= $data->keluhan?></td>
                        </tr>
                        <tr>
                            <td>Status Perbaikan</td>
                            <td>:</td>
                            <td> <?php if($data->status == 1) {
                                    echo '<button class="btn btn-sm btn-warning">Pengaduan di Proses</button>';
                                } elseif($data->status == 2) {
                                    echo '<button class="btn btn-sm btn-success">Pengaduan selesai</button>';
                                } ?></td>
                        </tr>
                           </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Tidak ada.</p>
        <?php endif; ?>
    </div>
    <small>*Disarankan disimpan untuk pengingat/bukti teknisi.</small>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.print();
</script>
</body>
</html>
