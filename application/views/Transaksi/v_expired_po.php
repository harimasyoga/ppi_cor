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
		<div class="row">
			<div class="col-md-6">
				<div class="card card-secondary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">SEMUA EXPIRED PO</h3>
					</div>
					<div class="card-body" style="padding:12px 6px">
						<div style="overflow:auto;white-space:nowrap">
							<table id="datatable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="padding:12px;text-align:center">#</th>
										<th style="padding:12px;text-align:center">DETAIL</th>
										<th style="padding:12px;text-align:center">KODE PO</th>
										<th style="padding:12px;text-align:center">ITEM</th>
										<th style="padding:12px;text-align:center">QTY PO</th>
										<th style="padding:12px;text-align:center">PENGIRIMAN</th>
										<th style="padding:12px;text-align:center">AKSI</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card card-info card-outline">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">BARU EXPIRED PO</h3>
					</div>
					<div class="card-body" style="padding:12px 6px">
						<div class="alert-po"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		$(".select2").select2()
		load_data()
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
				"url": '<?php echo base_url('Transaksi/load_data/trs_exp_po')?>',
				"type": "POST",
				// "data": ({  }),
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		})
		alertPOBaru()
	}

	function alertPOBaru(){
		$(".alert-po").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/alertPOBaru')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				$(".alert-po").html(data.html)
			}
		})
	}

	function btnTamatPO(id) {
		swal({
			title : "EXPIRED PO",
			html : "<p>SELESAI?</p>",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>OK</b>',
			cancelButtonText : '<b>BATAL</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?php echo base_url('Transaksi/btnTamatPO')?>',
				type: "POST",
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					toastr.success(`<b>SELESAI!</b>`)
					reloadTable()
				}
			})
		})
	}

</script>
