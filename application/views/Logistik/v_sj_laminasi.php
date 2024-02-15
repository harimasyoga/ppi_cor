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

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST PO</h3>
						</div>
						<div class="card-body" style="padding:0">
							<div class="list-po-sj-laminasi" style="overflow:auto;white-space:nowrap">
								<span style="padding:6px;display:block">LIST PO KOSONG!</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">RENCANA KIRIM</h3>
						</div>
						<div class="card-body" style="padding:0">
							<div class="list-rencana-sj-laminasi" style="overflow:auto;white-space:nowrap">
								<span style="padding:6px;display:block">RENCANA KIRIM KOSONG!</span>
							</div>
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
		statusInput = 'insert'

		swal.close()
	}

	function addListPOLaminasi(id)
	{
		console.log(id)
		$(".list-po-sj-laminasi").html('<span style="padding:6px;display:block">MEMUAT . . .</span>')
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
				$(".list-po-sj-laminasi").html(data.html)
				swal.close()
			}
		})
	}

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
			data: ({
				id_dtl, muat, h_idpo, h_id_pelanggan_lm, h_nm_pelanggan_lm, h_no_po_lm
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				loadItemLaminasi()
			}
		})
	}

	function loadItemLaminasi()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/loadItemLaminasi')?>',
			type: "POST",
			success: function(res){
				$(".list-rencana-sj-laminasi").html(res)
			}
		})
	}

	function hapusItemLaminasi(rowid)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusItemLaminasi')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				loadItemLaminasi()
			}
		})
	}

	function simpanCartLaminasi()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanCartLaminasi')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}
	
</script>
