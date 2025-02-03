<?php 
function tgl_indo($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
?>
<script type="text/javascript">
    var css = '@page { size: landscape; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet) {
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
    window.print();
</script>

<!doctype html>
<html>
    <head>
    <title>ICONNET</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
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
    <h5><b>Cetak : <?= $this->session->userdata('full_name') ?></b></h5>
    <p><?= $label ?></p>
    <p><?= $label_status ?></p>
        <h3 align="center"><b>Laporan Customer</b></h3><br>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
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
            <tbody>
                    <?php 
                    $no=1;
                    foreach($customer as $data)
                    {
                    ?>
                            <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data->no_services ?></td>
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
                                               
                                            } elseif($data->bukti_bayar != NULL) {
                                                echo '<button class="btn btn-sm btn-success">Upload Pembayaran Selesai, Tunggu Verifikasi Admin</button>';
                                               
                                                
                                            }       
                                        } elseif($this->session->userdata('role_id') == 1) { 
                                            if(($data->bukti_bayar == NULL) || ($data->bukti_bayar == '')) {
                                                echo '<button class="btn btn-sm btn-danger">Belum Melakukan Pembayaran Installasi !</button>';
                                            } elseif($data->bukti_bayar != NULL) {
                                                echo '<button class="btn btn-sm btn-success">Upload Pembayaran Selesai, Silakan Cek</button>';
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
                                    }
                                ?>
                            </td>
              </tr>
                    
                    <?php
                }
                ?>
            </table>
            
    
        </div>
        </body>
    </html>