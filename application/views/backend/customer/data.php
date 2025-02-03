<!-- Page Heading -->
<?php if($this->session->userdata('role_id') == 1) : ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="<?= site_url('customer/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>
<?php endif ?>
<div class="mb-4">
<?php if($this->session->userdata('role_id') == 1) : ?>
    <form action="<?php echo site_url('customer/laporanperbulan'); ?>" method="get" target="_blank">
    <div class="form-group">
        <label for="tahun">Tahun</label>
        <select name="tahun" id="tahun" class="form-control">
            <?php
            $tahunSekarang = date('Y');
            for ($i = $tahunSekarang; $i >= $tahunSekarang - 7; $i--) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="bulan">Bulan</label>
        <select name="bulan" id="bulan" class="form-control">
            <?php
            $bulanList = [
                "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
                "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
                "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
            ];
            foreach ($bulanList as $key => $value) {
                echo "<option value='$key'>$value</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="1">Sudah Dipasang</option>
            <option value="0">Belum Dipasang</option>
        </select>
    </div>

    <br>
    <input type="submit" name="cetak" value="Cetak" class="btn btn-warning">
</form>
</div>

<?php endif ?>

<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No KTP</th>
                        <th>No Telp.</th>
                        <th>Tagihan / Bulan</th>
                        <th>Alamat</th>
                        <th>Status Pembayaran Installasi</th>
                        <th>Status Pemasangan</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center">
                        <th style="text-align: center">No</th>
                        <th>No Layanan</th>
                        <th>Tanggal Daftar</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No KTP</th>
                        <th>No Telp.</th>
                        <th>Tagihan / Bulan</th>
                        <th>Alamat</th>
                        <th>Status Pembayaran Installasi</th>
                        <th>Status Pemasangan</th>
                        <th style="text-align: center;width: 100px">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($customer as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data->no_services ?> <br>
                                <?php if($this->session->userdata('role_id') != 3) : ?>
                                <a href="<?= site_url('services/detail/') ?><?= $data->no_services ?>" class="btn btn-success" style="font-size: smaller">Rincian Paket</a>
                                <?php endif ?>
                            </td>
                            <?php 
                            setlocale(LC_TIME, 'id_ID.utf8'); // Pastikan sistem mendukung lokal Indonesia
                            $timestamp = strtotime($data->created);
                            ?>
                            <td><?= strftime('%d %B %Y, %H:%M', $timestamp); ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= $data->email ?></td>
                            <td><?= $data->no_ktp ?></td>
                            <td><?= $data->no_wa ?></td>
                            <td style="text-align:right; font-weight:bold ">
                                <?php $query = "SELECT *
                                    FROM `services`
                                        WHERE `services`.`no_services` = $data->no_services";
                                $querying = $this->db->query($query)->result(); ?>
                                <?php $subtotal = 0;
                                foreach ($querying as  $dataa)
                                    $subtotal += (int) $dataa->total;
                                ?>
                                <?= indo_currency($subtotal) ?>

                            </td>
                            <td><?= $data->address ?></td>
                            <td>
                                <?php 
                                    if($data->status_bayar == 0) {
                                        if($this->session->userdata('role_id') == 2) {
                                            if(($data->bukti_bayar == NULL) || ($data->bukti_bayar == '')) {
                                                echo '<button class="btn btn-sm btn-danger">Belum Melakukan Pembayaran Installasi !</button>';
                                                echo '<a href="" data-toggle="modal" data-target="#bayarModal'.$data->customer_id.'"><button class="btn btn-sm btn-info">Bayar Sekarang</button></a>';    
                                            } elseif($data->bukti_bayar != NULL) {
                                                echo '<button class="btn btn-sm btn-success">Upload Pembayaran Selesai, Tunggu Verifikasi Admin</button>';
                                                echo '<a target="_blank" href='.base_url('assets/images/bukti_bayar/'.$data->bukti_bayar.'').'>Lihat Bukti Bayar</a>';
                                                
                                            }       
                                        } elseif($this->session->userdata('role_id') == 1) { 
                                            if(($data->bukti_bayar == NULL) || ($data->bukti_bayar == '')) {
                                                echo '<button class="btn btn-sm btn-danger">Belum Melakukan Pembayaran Installasi !</button>';
                                            } elseif($data->bukti_bayar != NULL) {
                                                echo '<button class="btn btn-sm btn-success">Upload Pembayaran Selesai, Silakan Cek</button>';
                                                echo '<a target="_blank" href='.base_url('assets/images/bukti_bayar/'.$data->bukti_bayar.'').'>Lihat Bukti Bayar</a>';
                                                echo '<a href="" data-toggle="modal" data-target="#verifModal'.$data->customer_id.'"><button class="btn btn-sm btn-primary">Verifikasi Pembayaran</button></a>';    
                                            }  
                                        }   
                                    } elseif($data->status_bayar == 1) {
                                        echo '<button class="btn btn-sm btn-info">Sudah Melakukan Pembayaran Installasi</button>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($data->status_pasang == 0) {
                                        echo '<button class="btn btn-sm btn-danger">Belum Dipasang !</button>';
                                    } elseif($data->status_pasang == 1) {
                                        echo '<button class="btn btn-sm btn-info">Sudah Dipasang</button>';
                                        echo '<br>';
                                        echo '<a href="" data-toggle="modal" data-target="#detailModal'.$data->customer_id.'"><button class="btn btn-sm btn-primary">Detail Pemasangan</button></a>';    
                                    }
                                ?>
                            </td>
                            <td style="text-align: center">
                                <?php if($this->session->userdata('role_id') == 1) : ?>    
                                    <a href="<?= site_url('customer/edit/') ?><?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> 
                                    <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->customer_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                <?php endif ?>    
                                <?php if($this->session->userdata('role_id') == 3) : ?> 
                                    <?php if($data->status_pasang == 0) { ?>
                                        <a href="" data-toggle="modal" data-target="#updateModal<?= $data->customer_id ?>" title="Update"><i class="fa fa-check" style="font-size:25px; color:green"></i></a>
                                    <?php } ?>
                                <?php endif ?>    
                                <?php if($this->session->userdata('role_id') != 3) : ?> 
                                        <a href="<?= base_url('customer/print_kartu/'.$data->customer_id.'')?>" target="_blank"><i class="fa fa-print" style="font-size:25px; color:orange"></i></a>
                                <?php endif ?>  
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
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('customer/delete') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <input type="hidden" name="no_services" value="<?= $data->no_services ?>" class="form-control">
                    Apakah yakin akan hapus No Layanan <?= $data->no_services ?> A/N <?= $data->name ?> ?
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

<!-- Modal Update -->
<?php
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="updateModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Pemasangan Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php echo form_open_multipart('customer/update_pemasangan'); ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <input type="hidden" name="no_services" value="<?= $data->no_services ?>" class="form-control">

                    <div class="form-group">
                        <label for="foto_pasang">Upload Foto Pemasangan</label>
                        <input type="file" name="foto_pasang" id="foto_pasang" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="lokasi_pasang">Lokasi Pemasangan</label>
                        <textarea name="lokasi_pasang" id="lokasi_pasang" class="form-control" rows="3" required></textarea>
                    </div>

                    <hr>
                    Sudah melakukan pemasangan No Layanan <?= $data->no_services ?> A/N <?= $data->name ?> ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Sudah</button>
                    </div>
                <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Bayar -->
<?php
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="bayarModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bayar Installasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('customer/upload_bayar') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <input type="file" name="bukti_bayar" id="bukti_bayar" required>
                    <br>
                        Cek Kembali Bukti Pembayaran Anda !
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Verif -->
<?php
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="verifModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pembayaran Installas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('customer/verif_pembayaran') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <input type="hidden" name="no_services" value="<?= $data->no_services ?>" class="form-control">
                        Sudah verifikasi pembayaran installasi No Layanan <?= $data->no_services ?> A/N <?= $data->name ?> ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Sudah</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Detail -->
<?php
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="detailModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pemasangan Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>:</td>
                        <td><?= $data->name?></td>
                    </tr>
                    <tr>
                        <td>Nomer Pelanggan</td>
                        <td>:</td>
                        <td><?= $data->no_services?></td>
                    </tr>
                    <tr>
                        <td>Foto Pemasangan</td>
                        <td>:</td>
                        <td><img src="<?= base_url('assets/images/pemasangan/'.$data->foto_pasang.'')?>" alt="" width="200px"></td>
                    </tr>
                    <tr>
                        <td>Lokasi Pemasangan</td>
                        <td>:</td>
                        <td><?= $data->lokasi_pasang ?></td>
                    </tr>
                </table>

                </div>
            </div>
        </div>
    </div>
<?php } ?>