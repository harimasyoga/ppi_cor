<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
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

			<div class="row row-list-surat-jalan">
				<div class="col-md-6">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">SURAT JALAN</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px 6px">
							<button type="button" class="btn btn-sm btn-danger" onclick="laporanSJLaminasi('laporan')"><i class="fas fa-file-alt"></i> <b>LAPORAN</b></button>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:6px">
							<div class="col-md-3">TAHUN</div>
							<div class="col-md-9">
								<select class="form-control select2" id="plh-thn" onchange="load_data_sj()">
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
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 12px">
							<div class="col-md-3">CUSTOMER</div>
							<div class="col-md-9">
								<select class="form-control select2" id="plh-customer" onchange="load_data_sj()">
									<?php
										$query = $this->db->query("SELECT lm.*,s.nm_sales FROM m_pelanggan_lm lm INNER JOIN m_sales s ON lm.id_sales=s.id_sales ORDER BY nm_pelanggan_lm");
										$html ='';
										$html .='<option value="">SEMUA</option>';
										foreach($query->result() as $r){
											$html .='<option value="'.$r->id_pelanggan_lm.'" id_sales="'.$r->id_sales.'" nm_sales="'.$r->nm_sales.'">'.$r->nm_pelanggan_lm.'</option>';
										}
										echo $html
									?>
								</select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 6px 6px">
							<div class="col-md-12">
								<div style="overflow:auto;white-space:nowrap">
									<table id="datatable1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th style="padding:12px;text-align:center">DESKRIPSI</th>
												<th style="padding:12px;text-align:center">NO. SJ</th>
												<th style="padding:12px;text-align:center">AKSI</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card card-secondary card-outline" style="position:sticky;top:12px;bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PO LAMINASI</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="width:47%;padding:12px;text-align:center">CUSTOMER</th>
											<th style="width:47%;padding:12px;text-align:center">NO. PO</th>
											<th style="width:6%;padding:12px;text-align:center">AKSI</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-po" style="display: none;">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST PO</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div class="list-po-sj-laminasi" style="overflow:auto;white-space:nowrap">LIST PO KOSONG!</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-input-rk" style="display: none;">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT RENCANA KIRIM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div class="list-rencana-sj-laminasi" style="overflow:auto;white-space:nowrap"></div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="row row-list-edit-sj-lam">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">EDIT SURAT JALAN</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<input type="hidden" id="h_header_po_lm" value="">
							<div class="list-edit-sj-lam" style="overflow:auto;white-space:nowrap"></div>
						</div>
					</div>
				</div>
			</div> -->

			<div class="row row-list-rk">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST RENCANA KIRIM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<input type="hidden" id="h_header_po_lm" value="">
							<div class="list-rencana-kirim" style="overflow:auto;white-space:nowrap">LIST RENCANA KIRIM KOSONG!</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-lap-sj-lam" style="display:none">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LAPORAN</h3>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<button type="button" class="btn btn-sm btn-info" onclick="laporanSJLaminasi('list')"><i class="fas fa-list"></i> <b>LIST</b></button>
							<div style="overflow:auto;white-space:nowrap">
								<table style="font-weight:bold">
									<tr>
										<td style="padding:3px 0">JENIS LAPORAN</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh_sj_jenis" class="form-control select2">
												<option value="HARI">PER HARI</option>
												<option value="CUSTOMER">PER CUSTOMER</option>
												<option value="BARANG">PER BARANG</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">CUSTOMER</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh_sj_cust" class="form-control select2">
												<?php
													$query = $this->db->query("SELECT p.id_perusahaan,p.attn_pl,l.nm_pelanggan_lm FROM pl_laminasi p
													INNER JOIN m_pelanggan_lm l ON p.id_perusahaan=l.id_pelanggan_lm
													GROUP BY p.id_perusahaan,p.attn_pl
													ORDER BY p.attn_pl");
													$html ='';
													$html .='<option value="" attn="">SEMUA</option>';
													foreach($query->result() as $r){
														if($r->attn_pl == null){
															$attn = $r->nm_pelanggan_lm;
														}else{
															if($r->attn_pl == $r->nm_pelanggan_lm){
																$attn = $r->nm_pelanggan_lm;
															}else{
																$attn = $r->attn_pl.' ( '.$r->nm_pelanggan_lm.' )';
															}
														}
														$html .='<option value="'.$r->id_perusahaan.'" attn="'.$r->attn_pl.'">'.$r->id_perusahaan.' | '.$attn.'</option>';
													}
													echo $html;
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">TANGGAL SURAT JALAN</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0">
											<input type="date" id="tgl1_lap" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">S/D</td>
										<td style="padding:3px 0">
											<input type="date" id="tgl2_lap" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">
											<button type="button" class="btn btn-primary" onclick="cariLaporanSJLaminasi('laporan')"><i class="fas fa-search"></i></button>
										</td>
										<td style="padding:3px 10px">
											<div class="btn-print-lap-lam-pdf"></div>
										</td>
									</tr>
								</table>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="tampil-list-laporan"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		// kosong()
		$(".list-rencana-sj-laminasi").load("<?php echo base_url('Logistik/destroyLaminasi') ?>")
		load_data()
		load_data_sj()
		listRencanKirim()
		$('.select2').select2();
	});

	function reloadTable() {
		let table2 = $('#datatable').DataTable();
		tabel2.ajax.reload(null, false);
	}

	function load_data() {
		let table2 = $('#datatable').DataTable();
		table2.destroy();
		tabel2 = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Transaksi/load_data/trs_po_laminasi')?>',
				"type": "POST",
				"data": ({
					po: 'pengiriman'
				}),
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function reloadTableSJ() {
		let table = $('#datatable1').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data_sj() {
		let plh_thn = $("#plh-thn").val()
		let plh_customer = $("#plh-customer").val()

		let table = $('#datatable1').DataTable();
		table.destroy();
		tabel = $('#datatable1').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/load_data_sj')?>',
				"type": "POST",
				"data": ({
					plh_thn, plh_customer
				}),
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			},
			"order": [
				[2, "desc"]
			]
		})
	}

	function kosong()
	{
		// statusInput = 'insert'
		$("#h_header_po_lm").val("")
		$(".list-rencana-sj-laminasi").load("<?php echo base_url('Logistik/destroyLaminasi') ?>")
		$(".row-input-rk").hide()
		$(".row-list-po").hide()
		listRencanKirim()
		reloadTableSJ()
	}

	// LAPORAN

	function laporanSJLaminasi(opsi)
	{
		$(".row-list-po").hide()
		$(".row-input-rk").hide()
		if(opsi == 'laporan'){
			$(".row-list-surat-jalan").hide()
			$(".row-list-rk").hide()
			$(".row-lap-sj-lam").show()
		}else{
			$(".row-list-surat-jalan").show()
			$(".row-list-rk").show()
			$(".row-lap-sj-lam").hide()
			kosong()
		}
	}

	function cariLaporanSJLaminasi(opsi)
	{
		$(".tampil-list-laporan").html("")
		$(".btn-print-lap-lam-pdf").html("")
		let plh_sj_jenis = $("#plh_sj_jenis").val()
		let plh_sj_cust = $("#plh_sj_cust").val()
		let nm_pelanggan = $('#plh_sj_cust option:selected').attr('nm-pelanggan')
		let attn = $('#plh_sj_cust option:selected').attr('attn')
		let tgl1_lap = $("#tgl1_lap").val()
		let tgl2_lap = $("#tgl2_lap").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariLaporanSJLaminasi')?>',
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
				opsi, plh_sj_jenis, plh_sj_cust, nm_pelanggan, attn, tgl1_lap, tgl2_lap
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".tampil-list-laporan").html(data.html)
				$(".btn-print-lap-lam-pdf").html(data.pdf)
				swal.close()
			}
		})
	}

	// END LAPORAN

	function addListPOLaminasi(id)
	{
		$("#h_header_po_lm").val(id)
		$.ajax({
			url: '<?php echo base_url('Logistik/addListPOLaminasi')?>',
			type: "POST",
			data: ({ id }),
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
				$(".row-list-po").show()
				$(".list-po-sj-laminasi").html(data.html)
				listRencanKirim()
			}
		})
	}

	function closePOLaminasi(id, no_po_lm)
	{
		swal({
			title: "Yakin Close PO Ini?",
			text: no_po_lm,
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Close",
			cancelButtonText: "Batal"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/closePOLaminasi')?>',
				type: "POST",
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					if(data.data){
						$(".row-list-po").hide()
						$(".list-po-sj-laminasi").html('')
						toastr.success(`<b>BERHASIL CLOSE PO ${data.po_lm.no_po_lm}!</b>`)
						reloadTable()
					}
				}
			})
		});
	}

	// LIST PO

	function addItemLaminasi(id_dtl)
	{
		let muat = $("#muat-"+id_dtl).val()
		let h_idpo = $("#h_idpo-"+id_dtl).val()
		let h_id_pelanggan_lm = $("#h_id_pelanggan_lm-"+id_dtl).val()
		let h_nm_pelanggan_lm = $("#h_nm_pelanggan_lm-"+id_dtl).val()
		let h_no_po_lm = $("#h_no_po_lm-"+id_dtl).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/addItemLaminasi')?>',
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
				id_dtl, muat, h_idpo, h_id_pelanggan_lm, h_nm_pelanggan_lm, h_no_po_lm
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.total_items == 0){
					toastr.error(`<b>${data.isi}</b>`)
					$(".row-input-rk").hide()
					swal.close()
				}else{
					if(data.data == false){
						toastr.error(`<b>${data.isi}</b>`)
					}
					$(".row-input-rk").show()
					loadItemLaminasi()
				}
			}
		})
	}

	function loadItemLaminasi()
	{
		$(".row-input-rk").show()
		$.ajax({
			url: '<?php echo base_url('Logistik/loadItemLaminasi')?>',
			type: "POST",
			success: function(res){
				$(".list-rencana-sj-laminasi").html(res)
				swal.close()
			}
		})
	}

	function hapusItemLaminasi(rowid)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusItemLaminasi')?>',
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
			data: ({ rowid }),
			success: function(res){
				data = JSON.parse(res)
				if(data.total_items == 0){
					$(".row-input-rk").hide()
					swal.close()
				}else{
					loadItemLaminasi()
				}
			}
		})
	}

	function simpanCartLaminasi()
	{
		let id = $("#h_header_po_lm").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanCartLaminasi')?>',
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
			success: function(res){
				data = JSON.parse(res)
				// kosong()
				$(".list-rencana-sj-laminasi").load("<?php echo base_url('Logistik/destroyLaminasi') ?>")
				$(".row-input-rk").hide()
				addListPOLaminasi(id)
			}
		})
	}

	// RENCANA KIRIM

	function listRencanKirim()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/listRencanKirim')?>',
			type: "POST",
			success: function(res){
				$(".list-rencana-kirim").html(res)
				swal.close()
			}
		})
	}

	function iKeterangan(id_rk, pc)
	{
		$("#keterangan-"+id_rk).val(pc)
	}

	function addKeterangan(id_rk)
	{
		let keterangan = $("#keterangan-"+id_rk).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/addKeterangan')?>',
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
			data: ({ id_rk, keterangan }),
			success: function(res){
				data = JSON.parse(res)
				listRencanKirim()
			}
		})
	}

	function hapusListItemLaminasi(id_rk, opsi)
	{
		let id = $("#h_header_po_lm").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusListItemLaminasi')?>',
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
			data: ({ id_rk }),
			success: function(res){
				data = JSON.parse(res)
				if(opsi == 'RK'){
					kosong()
				}else{
					addListPOLaminasi(id)
				}
			}
		})
	}

	function noSJLaminasi(id_pelanggan_lm, id_po_lm)
	{
		let no_sj = $("#p_no_sj-"+id_pelanggan_lm).val()
		if(no_sj == "" || no_sj < 0){
			no_sj = "000000"
		}else if(no_sj.length == 1){
			no_sj = "00000"+no_sj.substring(no_sj.length - 1)
		}else if(no_sj.length == 2){
			no_sj = "0000"+no_sj.substring(no_sj.length - 2)
		}else if(no_sj.length == 3){
			no_sj = "000"+no_sj.substring(no_sj.length - 3)
		}else if(no_sj.length == 4){
			no_sj = "00"+no_sj.substring(no_sj.length - 4)
		}else if(no_sj.length == 5){
			no_sj = "0"+no_sj.substring(no_sj.length - 5)
		}else{
			no_sj = no_sj.substring(no_sj.length - 6)
		}
		$("#p_no_sj-"+id_pelanggan_lm).val(no_sj)
	}

	function kirimSJLaminasi(id_pelanggan_lm, id_hub)
	{
		let tgl = $("#p_tgl-"+id_pelanggan_lm).val()
		// let no_sj = $("#p_no_sj-"+id_pelanggan_lm).val()
		let attn = $("#attn-"+id_pelanggan_lm).val()
		let alamat_kirim = $("#alamat_kirim-"+id_pelanggan_lm).val()
		let no_telp = $("#no_telp-"+id_pelanggan_lm).val()
		let no_kendaraan = $("#p_no_kendaraan-"+id_pelanggan_lm).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/kirimSJLaminasi')?>',
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
				id_pelanggan_lm, id_hub, tgl, attn, alamat_kirim, no_telp, no_kendaraan
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.data){
					kosong()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					listRencanKirim()
				}
			}
		})
	}

	function insertSuratJalanJasa(no_surat)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/insertSuratJalanJasa')?>',
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
				no_surat, opsi: 'lam'
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				let url = '<?php echo base_url('Logistik/suratJalanJasa') ?>'
				if(data.insert){
					toastr.success(`<b>BERHASIL! ${data.no_jasa}</b>`);
					window.open(url+'?jenis='+data.no_jasa+'&top=5&ctk=0&opsi=lam', '_blank');
					swal.close()
				}else{
					window.open(url+'?jenis='+data.no_jasa+'&top=5&ctk=0&opsi=lam', '_blank');
					swal.close()
				}
			}
		})
	}
</script>
