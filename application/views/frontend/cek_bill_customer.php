<div class="container">
	<div class="section-services">
		<div class="row mt-4">
			<div class="col-lg-8 mb-2">
				<div class="card border-info">
					<div class="card-body">
						<h5 class="card-title"><?php echo $title ?></h5>
						<div class="row">
							<div class="col">
                            <?php 
                            $userId = $user['id'];

                            $query = "SELECT * FROM `customer`
                            JOIN user ON user.customer_id = customer.customer_id
                            WHERE user.id = $userId";
                            $querying = $this->db->query($query);
                            foreach ($querying->result() as $row) :
                            ?>
								<input class="form-control mb-2 mr-sm-2" id="no_services" name="no_services" type="text" placeholder="No Layanan" value="<?= $row->no_services?>" readonly required>
                            <?php endforeach ?>
							</div>
							<div class="col">

								<select name="month" id="month" class="form-control mb-2 mr-sm-2" required>
									<option value="">-Bulan-</option>
									<option value="01">Januari</option>
									<option value="02">Februari</option>
									<option value="03">Maret</option>
									<option value="04">April</option>
									<option value="05">Mei</option>
									<option value="06">Juni</option>
									<option value="07">Juli</option>
									<option value="08">Agustus</option>
									<option value="09">September</option>
									<option value="10">Oktober</option>
									<option value="11">November</option>
									<option value="12">Desember</option>
								</select>
							</div>
							<div class="col">
								<select class="form-control select2" style="width: 100%;" id="year" name="year" required>
									<option value="">-Tahun-</option>
									<?php
									for ($i = date('Y'); $i >= date('Y') - 1; $i -= 1) {
									?>
										<option value="<?= $i ?>"><?= $i ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<button class="btn btn-success mb-2 my-2 my-sm-0" type="submit" onclick="cek_bill()">Cek</button>
					</div>
					<div class="loading"></div>
					<div class="view_data"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
		<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Layanan</th>
                        <th>Nama Pelanggan</th>
                        <th>No. telp.</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <!-- <th style="text-align: center">Aksi</th> -->
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center">
                        <th style="text-align: center">No</th>
                        <th>No Layanan</th>
                        <th>Nama Pelanggan</th>
                        <th>No. telp.</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <!-- <th style="text-align: center">Aksi</th> -->
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($bill_customer as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td style="text-align: center"><?= $data->no_services ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= $data->no_wa ?></td>
                            <td><?= $data->month == '01' ? 'Januari' : '' ?>
                                <?= $data->month == '02' ? 'Februari' : '' ?>
                                <?= $data->month == '03' ? 'Maret' : '' ?>
                                <?= $data->month == '04' ? 'April' : '' ?>
                                <?= $data->month == '05' ? 'Mei' : '' ?>
                                <?= $data->month == '06' ? 'Juni' : '' ?>
                                <?= $data->month == '07' ? 'Juli' : '' ?>
                                <?= $data->month == '08' ? 'Agustus' : '' ?>
                                <?= $data->month == '09' ? 'September' : '' ?>
                                <?= $data->month == '10' ? 'Oktober' : '' ?>
                                <?= $data->month == '11' ? 'November' : '' ?>
                                <?= $data->month == '12' ? 'Desember' : '' ?>
                                <?= $data->year ?></td>
                            <td style="font-weight: bold;text-align: center"> <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $data->invoice";
                                                                                $querying = $this->db->query($query)->result(); ?>
                                <?php $subtotal = 0;
                                foreach ($querying as  $dataa)
                                    $subtotal += (int) $dataa->total;
                                ?>
                                <?= indo_currency($subtotal) ?></td>
                            <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                <td style="text-align: center; font-weight:bold; color:green"> <?= $data->status  ?></td>
                            <?php } ?>
                            <?php if ($data->status == 'BELUM BAYAR') { ?>
                                <td style="text-align: center; font-weight:bold; color:red"> <?= $data->status  ?></td>
                            <?php } ?>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</div>



<script>
	function cek_bill() {
		var no = $('#no_services').val()
		var m = $('#month').val()
		var y = $('#year').val()
		no_services = $('[name="no_services"]');
		month = $('[name="month"]');
		year = $('[name="year"]');
		if (no == '') {
			$('#no_services').focus()
		} else {
			if (m == '') {
				$('#month').focus()
			} else {
				if (y == '') {
					$('#year').focus()
				} else {
					$.ajax({
						type: 'POST',
						data: "cek_bill=" + 1 + "&no_services=" + no_services.val() + "&month=" + month.val() + "&year=" + year.val(),
						url: '<?= site_url('front/view_bill') ?>',
						cache: false,

						beforeSend: function() {
							no_services.attr('disabled', true);
							$('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
						},
						success: function(data) {
							no_services.attr('disabled', false);
							$('.loading').html('');
							$('.view_data').html(data);
						}
					});
				}
			}
		}
		return false;
	}
</script>