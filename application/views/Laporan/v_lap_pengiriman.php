<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6"></div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">TANGGAL</h3>
						</div>
						<div class="card-body row" style="padding:6px 7px">
							<div class="col-md-12">
								<input type="date" id="tgl" class="form-control" onchange="pilihTanggal()">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST LAPORAN PENGIRIMAN <span class="span-tanggal"></span></h3>
						</div>
						<div class="card-body row" style="padding:6px 7px">
							<div class="col-md-12">
								<div id="list-laporan">
									PILIH TANGGAL
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST OUTSTANDING PO</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:12px 6px 6px">
							<div class="col-md-2">TAHUN</div>
							<div class="col-md-2">
								<select class="form-control select2" id="tahun" onchange="plhOS()">
									<?php 
									$thang = date("Y");
									$thang_maks = $thang + 2;
									$thang_min = $thang - 2;
									for ($th = $thang_min; $th <= $thang_maks; $th++)
									{ ?>
										<?php if ($th==$thang) { ?>
											<option selected value="<?= $th ?>"> <?= $thang ?> </option>
										<?php }else{ ?>
											<option value="<?= $th ?>"> <?= $th ?> </option>
										<?php }
									} ?>
								</select>
							</div>
							<div class="col-md-8"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
							<div class="col-md-2">CUSTOMER</div>
							<div class="col-md-10">
								<select class="form-control select2" id="pelanggan" onchange="plhOS()">
									<?php
										$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
										$html ='';
										$html .='<option value="">PILIH</option>';
										foreach($query->result() as $r){
											if($r->attn == "-" || $r->attn == ""){
												$attn = '';
											}else{
												$attn = ' | '.$r->attn;
											}
											$html .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.''.$attn.'</option>';
										}
										echo $html
									?>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
							<div class="col-md-2">NO. PO</div>
							<div class="col-md-10">
								<select class="form-control select2" id="no_po" onchange="plhOS()">
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px;<?= ($this->session->userdata('level') == 'Admin') ? '' : 'display:none'; ?>">
							<div class="col-md-2">OPSI</div>
							<div class="col-md-10">
								<select class="form-control select2" id="opsi" onchange="plhOS()">
									<option value="">PILIH</option>
									<option value="OPEN">OPEN</option>
									<option value="SEMUA">SEMUA</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 6px 6px">
							<div class="col-md-12">
								<div style="overflow:auto;white-space:nowrap">
									<div class="tampil-list-os"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".select2").select2()
	});

	function pilihTanggal(){
		let tgl = $("#tgl").val()
		$.ajax({
			url: '<?php echo base_url('Laporan/plhTglLapPengiriman')?>',
			type: "POST",
			data: ({ tgl }),
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			success: function(res){
				data = JSON.parse(res)
				$(".span-tanggal").html(data.tgl)
				$("#list-laporan").html(data.html)
				swal.close()
			}
		})
	}

	function plhOS()
	{
		$(".tampil-list-os").html('')
		let tahun = $("#tahun").val()
		let pelanggan = $("#pelanggan").val()
		let no_po = $("#no_po").val()
		let opsi = $("#opsi").val()
		$.ajax({
			url: '<?php echo base_url('Laporan/plhOS')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				tahun, pelanggan, no_po, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				if(no_po == ""){
					$("#no_po").html(data.htmlPO)
				}
				$(".tampil-list-os").html(data.html)
				swal.close()
			}
		})
	}

	function closePengiriman(id_po, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Laporan/closePengiriman')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				id_po, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				plhOS()
				swal.close()
			}
		})
	}
</script>
