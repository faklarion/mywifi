<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if($this->session->userdata('role_id') == 1) { ?>
        <a href="<?= site_url('data_user/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
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
        <h6 class="m-0 font-weight-bold"><?php echo $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Role</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Role</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($data_user as $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td class="text-center"><?= $data->email ?></td>
                            <td class="text-center"><?= $data->name ?></td>
                            <td class="text-center"><?= $data->phone ?></td>
                            <td class="text-center"><?= $data->address ?></td>
                            <td class="text-center"><?= $data->gender ?></td>
                            <td class="text-center">
                                <?php 
                                    if($data->role_id == 1) {
                                        echo 'Admin';
                                    } elseif($data->role_id == 3) {
                                        echo 'Teknisi';
                                    }
                                ?>
                            </td>
                            <td style="text-align: center">
                                <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
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
foreach ($data_user as $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->id ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <?php echo form_open_multipart('data_user/delete') ?>
                    <input type="hidden" name="id" value="<?= $data->id ?>">
                        Apakah yakin akan hapus user <?= $data->name ?> / <?= $data->email ?> ?
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
foreach ($data_user as $data) { ?>
    <div class="modal fade" id="statusModal<?= $data->id ?>" tabindex="-1" role="dialog"
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
                    <input type="hidden" name="id" value="<?= $data->id ?>">
                        Apakah yakin akan mengubah Pengaduan no <?= $data->id ?> menjadi selesai ?
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