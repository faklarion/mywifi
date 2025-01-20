<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Kartu Pelanggan</h1>
    <img src="<?= base_url('assets/images/logoicon.png') ?>" width="200px" alt="">
    <div class="row g-4">
        <?php if (!empty($customers)) : ?>
            <?php foreach ($customers as $customer) : ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($customer->name) ?></h5>
                            <p class="card-text"><strong>No Pelanggan:</strong> <?= htmlspecialchars($customer->no_services) ?></p>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($customer->email) ?></p>
                            <p class="card-text"><strong>Alamat:</strong> <?= htmlspecialchars($customer->address) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Tidak ada data customer.</p>
        <?php endif; ?>
    </div>
    <small>*Disarankan tempel dirumah Pelanggan</small>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.print();
</script>
</body>
</html>
