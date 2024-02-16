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

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
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

			<div class="row">
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

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PENGIRIMAN</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div class="list-pengiriman" style="overflow:auto;white-space:nowrap"></div>
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
		listRencanKirim()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
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

	function kosong()
	{
		// statusInput = 'insert'
		$("#h_header_po_lm").val("")
		$(".list-rencana-sj-laminasi").load("<?php echo base_url('Logistik/destroyLaminasi') ?>")
		$(".row-input-rk").hide()
		$(".row-list-po").hide()
		listRencanKirim()
	}

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
				// swal.close()
				listRencanKirim()
			}
		})
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
				console.log(data)
				if(data.total_items == 0){
					$(".row-input-rk").hide()
					swal.close()
				}else{
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
				console.log(data)
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
				console.log(data)
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
		let no_sj = $("#p_no_sj-"+id_pelanggan_lm+"-"+id_po_lm).val()
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
		$("#p_no_sj-"+id_pelanggan_lm+"-"+id_po_lm).val(no_sj)
	}

	function kirimSJLaminasi(id_pelanggan_lm, id_po_lm)
	{
		let tgl = $("#p_tgl-"+id_pelanggan_lm+"-"+id_po_lm).val()
		let no_sj = $("#p_no_sj-"+id_pelanggan_lm+"-"+id_po_lm).val()
		let no_kendaraan = $("#p_no_kendaraan-"+id_pelanggan_lm+"-"+id_po_lm).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/kirimSJLaminasi')?>',
			type: "POST",
			data: ({
				id_pelanggan_lm, id_po_lm, tgl, no_sj, no_kendaraan
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}
	
</script>
