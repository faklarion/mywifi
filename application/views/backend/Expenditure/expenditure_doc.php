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
    <h5><b><?= $label ?></b></h5>
        <h3 align="center"><b>Laporan Pengeluaran</b></h3><br>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tanggal</th>
		<th>Nominal</th>
		<th>Keterangan</th>
        <tbody>
                    <?php 
                    $no=0;
                    foreach($expenditure as $isi)
                    {
                    ?>
                            <tr>
		      <td><?php echo ++$no ?></td>
		      <td><?php echo $isi->date_payment ?></td>

		      <td><?php echo $isi->nominal ?></td>
		      <td><?php echo $isi->remark ?></td>
              <td><?php echo $isi->created ?></td>
              </tr>
                    
                    <?php
                }
                ?>
            </table>
            
        </body>
    </html>