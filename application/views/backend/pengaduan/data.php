<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if($this->session->userdata('role_id') == 2) { ?>
        <a href="<?= site_url('pengaduan/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    <?php } ?>
</div>

<!-- <form action="<?php echo site_url("pengaduan/laporanperbulan"); ?>" method="post">
    <br>
    <input type="submit" name="cetaksemua" value="Cetak Semua" class="btn btn-warning">
</form> -->


<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data <?php echo $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Aduan</th>
                        <th>Data Pelanggan</th>
                        <th>Keluhan</th>
                        <th>Tanggal Pengaduan</th>
                        <th>Status</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Aduan</th>
                        <th>Data Pelanggan</th>
                        <th>Keluhan</th>
                        <th>Tanggal Pengaduan</th>
                        <th>Status</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($pengaduan as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td class="text-center"><?= $data->pengaduan_id ?></td>
                            <td>
                                <?= 'Nama : '.$data->name.''; ?>
                                <br>
                                <?= 'No Services : '.$data->no_services.''; ?>
                                <br>
                                <?= 'Alamat : '.$data->address.''; ?>
                                <br>
                                <?= 'No HP : '.$data->phone.''; ?>
                            </td>
                            <td><?= $data->keluhan ?></td>
                            <td class="text-center"><?= $data->tanggal_pengaduan ?></td>
                            <td class="text-center">
                                <?php if($data->status == 1) {
                                    echo '<button class="btn btn-sm btn-warning">Pengaduan di Proses</button>';
                                } elseif($data->status == 2) {
                                    echo '<button class="btn btn-sm btn-success">Pengaduan selesai</button>';;
                                } ?>
                            </td>
                            <td style="text-align: center">
                                <?php if($this->session->userdata('role_id') == 2) { 
                                        if($data->status == 1) {    
                                ?>
                                    <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->pengaduan_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                <?php 
                                        } 
                                    } 
                                ?>
                                 <?php if($this->session->userdata('role_id') == 1) { 
                                        if($data->status == 1) {    
                                ?>
                                    <a href="" data-toggle="modal" data-target="#statusModal<?= $data->pengaduan_id ?>" title="Selesaikan Pengaduan"><i class="fa fa-check" style="font-size:25px; color:green"></i></a>
                                <?php 
                                        } 
                                    } 
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<?php
foreach ($pengaduan as $r => $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->pengaduan_id ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pengaduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <?php echo form_open_multipart('pengaduan/delete') ?>
                    <input type="hidden" name="pengaduan_id" value="<?= $data->pengaduan_id ?>">
                        Apakah yakin akan hapus Pengaduan no <?= $data->pengaduan_id ?> ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Status -->
<?php
foreach ($pengaduan as $r => $data) { ?>
    <div class="modal fade" id="statusModal<?= $data->pengaduan_id ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Status Pengaduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <?php echo form_open_multipart('pengaduan/ubah_status') ?>
                    <input type="hidden" name="pengaduan_id" value="<?= $data->pengaduan_id ?>">
                        Apakah yakin akan mengubah Pengaduan no <?= $data->pengaduan_id ?> menjadi selesai ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>