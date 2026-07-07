<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6"></div>
			</div>
		</div>
	</section>

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-secondary card-outline">
				<div class="card-header" style="padding:12px">
					<h3 class="card-title" style="font-weight:bold;font-size:18px">LAPORAN OUTSTANDING PO</h3>
				</div>
				<div class="card-body">
					<div style="overflow:auto;white-space:nowrap">
						<div class="tab_laporan"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PILIH</h3>
						</div>
						<div class="card-body row" style="padding:12px 6px 6px">
							<div class="col-md-12">
								<select class="form-control select2" id="cust_list_lap">
									<?php
										$id_sales = $this->session->userdata('id_sales');
										if($id_sales == "" || $id_sales == null){
											$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
										}else{
											$query = $this->db->query("SELECT*FROM m_pelanggan WHERE id_sales='$id_sales' ORDER BY nm_pelanggan");
										}
										$html ='';
										$html .='<option value="">SEMUA</option>';
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
						<div class="card-body row" style="padding:0 6px 6px">
							<div class="col-md-5">
								<input type="date" id="tgl1" class="form-control" style="margin-bottom:6px" value="<?= date("Y-m-d")?>">
							</div>
							<div class="col-md-5">
								<input type="date" id="tgl2" class="form-control" style="margin-bottom:6px" value="<?= date("Y-m-d")?>">
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary" onclick="cariListLaporan()"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
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
									$thang_maks = $thang + 1;
									$thang_min = $thang - 3;
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
										$id_sales = $this->session->userdata('id_sales');
										if($id_sales == "" || $id_sales == null){
											$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
										}else{
											$query = $this->db->query("SELECT*FROM m_pelanggan WHERE id_sales='$id_sales' ORDER BY nm_pelanggan");
										}
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
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px;<?= (in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User', 'Marketing'])) ? '' : 'display:none'; ?>">
							<div class="col-md-2">STATUS PO</div>
							<div class="col-md-10">
								<select class="form-control select2" id="sts" onchange="plhOS()">
									<option value="">PILIH</option>
									<option value="OPEN">OPEN</option>
									<option value="CLOSE">CLOSE</option>
									<option value="SEMUA">SEMUA</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px;<?= (in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User', 'Marketing'])) ? '' : 'display:none'; ?>">
							<div class="col-md-2">STATUS PENGIRIMAN</div>
							<div class="col-md-10">
								<select class="form-control select2" id="opsi" onchange="plhOS()">
									<option value="">PILIH</option>
									<option value="OPEN">OPEN</option>
									<option value="CLOSE">CLOSE</option>
									<option value="SEMUA">SEMUA</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
							<div class="col-md-2">RINCIAN</div>
							<div class="col-md-10">
								<select class="form-control select2" id="rincian" onchange="plhOS()">
									<option value="LIST">LIST</option>
									<option value="REKAP">REKAP</option>
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
		lapOSperSales()
	});

	function lapOSperSales() {
		$(".tab_laporan").html('')
		$.ajax({
			url: '<?php echo base_url('Laporan/lapOSperSales') ?>',
			type: "POST",
			success: function(res) {
				data = JSON.parse(res)
				$(".tab_laporan").html(data.html)
				// if(data.html){
				// 	OSperItem()
				// }
			}
		})
	}

	// function OSperItem() {
	// 	$.ajax({
	// 		url: '<?php echo base_url('Laporan/OSperItem') ?>',
	// 		type: "POST",
	// 		success: function(res) {
	// 			data = JSON.parse(res)
	// 			console.log(data)
	// 		}
	// 	})
	// }

	function btnPiuSales(i) {
		$(".tr1").hide()
		$(".tr2").hide()
		$(".tr3").hide()
		$("#ts2").val("")
		$(".ab1").removeClass("btn-warning").addClass("btn-success")
		$(".af1").removeClass("fa-minus").addClass("fa-plus")
		$(".ab2").removeClass("btn-secondary").addClass("btn-info")
		$(".af2").removeClass("fa-minus").addClass("fa-plus")
		$(".ab3").removeClass("btn-secondary").addClass("btn-info")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		let ts1 = $("#ts1").val()
		if (parseInt(ts1) == parseInt(i)) {
			$("#ts1").val("")
		} else {
			$(".b1-" + i).removeClass("btn-success").addClass("btn-warning")
			$(".f1-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts1").val(i)
			$(".t" + i).show()
		}
	}

	function btnPiuCustomer(i) {
		$(".tr2").hide()
		$(".tr3").hide()
		$(".ab2").removeClass("btn-secondary").addClass("btn-info")
		$(".af2").removeClass("fa-minus").addClass("fa-plus")
		$(".ab3").removeClass("btn-secondary").addClass("btn-info")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		let ts2 = $("#ts2").val()
		if (parseInt(ts2) == parseInt(i)) {
			$("#ts2").val("")
		} else {
			$(".b2-" + i).removeClass("btn-info").addClass("btn-secondary")
			$(".f2-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts2").val(i)
			$(".c" + i).show()
		}
	}

	function btnPiuProduk(i) {
		$(".tr3").hide()
		$(".ab3").removeClass("btn-secondary").addClass("btn-info")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		let ts3 = $("#ts3").val()
		if (parseInt(ts3) == parseInt(i)) {
			$("#ts3").val("")
		} else {
			$(".b3-" + i).removeClass("btn-info").addClass("btn-secondary")
			$(".f3-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts3").val(i)
			$(".n" + i).show()
		}
	}

	function cariListLaporan(){
		let id_pelanggan = $("#cust_list_lap").val()
		let tgl1 = $("#tgl1").val()
		let tgl2 = $("#tgl2").val()
		$.ajax({
			url: '<?php echo base_url('Laporan/cariListLaporan')?>',
			type: "POST",
			data: ({
				id_pelanggan, tgl1, tgl2
			}),
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
		let rincian = $("#rincian").val()
		let opsi = $("#opsi").val()
		let sts = $("#sts").val()
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
				tahun, pelanggan, no_po, rincian, opsi, sts
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

	function returKiriman(ii)
	{
		let h_tr = $("#h_tr").val()
		if(parseInt(h_tr) == parseInt(ii)){
			$("#h_tr").val("")
			$(".tr").hide()
		}else{
			$("#h_tr").val(ii)
			$(".tr").hide()
			$(".tampilkantr-"+ii).show()
		}
	}

	function addReturKiriman(ii)
	{
		let h_tot_muat = $("#h_tot_muat_"+ii).val()
		let h_tgl = $("#h_tgl_"+ii).val()
		let h_id_pelanggan = $("#h_id_pelanggan_"+ii).val()
		let h_id_produk = $("#h_id_produk_"+ii).val()
		let h_kode_po = $("#h_kode_po_"+ii).val()
		let h_urut = $("#h_urut_"+ii).val()
		let h_no_surat = $("#h_no_surat_"+ii).val()
		let h_plat = $("#h_plat_"+ii).val()
		let rtr_tgl = $("#rtr_tgl_"+ii).val()
		let rtr_ket = $("#rtr_ket_"+ii).val()
		let rtr_jumlah = $("#rtr_jumlah_"+ii).val()
		$.ajax({
			url: '<?php echo base_url('Laporan/addReturKiriman')?>',
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
				h_tot_muat, h_tgl, h_id_pelanggan, h_id_produk, h_kode_po, h_urut, h_no_surat, h_plat, rtr_tgl, rtr_ket, rtr_jumlah
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					plhOS()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function deleteReturkiriman(id)
	{
		$.ajax({
			url: '<?php echo base_url('Laporan/deleteReturkiriman')?>',
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
				id
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					plhOS()
				}
			}
		})
	}

	function addGudangLap(id, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Laporan/addGudangLap')?>',
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
				id, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					plhOS()
				}
			}
		})
	}
</script>
