<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1><b>Data Plan</b></h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<!-- <li class="breadcrumb-item active" ><a href="#">Corrugator</a></li> -->
				</ol>
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
			<div class="row row-input" style="display: none;">
			<!-- <div class="row row-input"> -->
				<div class="col-md-6">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT PO LAMINASI</h3>
						</div>
						<div style="margin:12px 6px">
							<button type="button" class="btn btn-sm btn-info" onclick="kembaliListPOLaminasi()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. INPUT PO</div>
							<div class="col-md-9">
								<input type="date" id="tgl" class="form-control" value="<?= date('Y-m-d')?>">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">CUSTOMER</div>
							<div class="col-md-9">
								<select id="customer" class="form-control select2">
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3">NO. PO</div>
							<div class="col-md-9">
								<input type="text" id="no_po" class="form-control" autocomplete="off" placeholder="NO. PO" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card card-primary card-outline" style="position:sticky;top:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">TAMBAH ITEM</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
							<div class="col-md-3">ITEM</div>
							<div class="col-md-9">
								<input type="text" id="item" class="form-control" autocomplete="off" placeholder="ITEM" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SIZE</div>
							<div class="col-md-9">
								<input type="text" id="size" class="form-control" autocomplete="off" placeholder="SIZE" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SHEET</div>
							<div class="col-md-9">
								<input type="text" id="sheet" class="form-control" autocomplete="off" placeholder="SHEET" onkeyup="hitungHarga()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">QTY ( BAL )</div>
							<div class="col-md-9">
								<input type="text" id="qty" class="form-control" autocomplete="off" placeholder="QTY ( BAL )" onkeyup="hitungHarga()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">DATE ORDER</div>
							<div class="col-md-9">
								<input type="date" id="date_order" class="form-control">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">HARGA</div>
							<div class="col-md-9">
								<input type="text" id="harga" class="form-control" autocomplete="off" placeholder="HARGA" onkeyup="hitungHarga()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<input type="hidden" id="id_cart" value="0">
								<button type="button" class="btn btn-sm btn-success" onclick="addItemLaminasi()"><i class="fa fa-plus"></i> <b>ADD</b></button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row row-sementara" style="display: none;">
				<div class="col-md-12">
					<div class="card card-info card-outline" style="position:sticky;top:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div id="list-sementara" style="overflow:auto;white-space:nowrap">
								LIST KOSONG
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST HPP</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<div style="margin-bottom:12px">
								<button type="button" class="btn btn-sm btn-info" onclick="addPOLaminasi()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped" style="width:100%">
									<thead>
										<tr>
											<th style="text-align:center;width:10%">#</th>
											<th style="text-align:center;width:14%">NO. PO</th>
											<th style="text-align:center;width:11%">TGL</th>
											<th style="text-align:center;width:11%">STATUS</th>
											<th style="text-align:center;width:11%">CUSTOMER</th>
											<th style="text-align:center;width:11%">ADMIN</th>
											<th style="text-align:center;width:11%">MKT</th>
											<th style="text-align:center;width:11%">OWNER</th>
											<th style="text-align:center;width:10%">AKSI</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
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

	$(document).ready(function ()
	{
		// kosong()
		load_data()
		$('.select2').select2();
		$("#list-sementara").load("<?php echo base_url('Transaksi/destroyLaminasi') ?>")
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
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
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
		$("#list-sementara").load("<?php echo base_url('Transaksi/destroyLaminasi') ?>")
		swal.close()
	}

	function addPOLaminasi()
	{
		customerLaminasi()
		$(".row-input").attr('style', '');
		$(".row-sementara").attr('style', '');
		$(".row-list").attr('style', 'display:none');
	}

	function kembaliListPOLaminasi()
	{
		$(".row-input").attr('style', 'display:none');
		$(".row-sementara").attr('style', 'display:none');
		$(".row-list").attr('style', '');
	}

	function customerLaminasi()
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/customerLaminasi')?>',
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
				$("#customer").html(res)
				swal.close()
			}
		})
	}

	function hitungHarga()
	{
		let sheet = $("#sheet").val().split('.').join('')
		$("#sheet").val(format_angka(sheet))
		let qty = $("#qty").val().split('.').join('')
		$("#qty").val(format_angka(qty))
		let harga = $("#harga").val().split('.').join('')
		$("#harga").val(format_angka(harga))
	}

	function addItemLaminasi()
	{
		let tgl = $("#tgl").val()
		let customer = $("#customer").val()
		let nm_pelanggan = $("#customer option:selected").attr('nm_pelanggan')
		let no_po = $("#no_po").val()
		let item = $("#item").val()
		let size = $("#size").val()
		let sheet = $("#sheet").val().split('.').join('')
		let qty = $("#qty").val().split('.').join('')
		let date_order = $("#date_order").val()
		let harga = $("#harga").val().split('.').join('')
		let id_cart = parseInt($("#id_cart").val()) + 1
		$("#id_cart").val(id_cart)
		$.ajax({
			url: '<?php echo base_url('Transaksi/addItemLaminasi')?>',
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
				tgl, customer, nm_pelanggan, no_po, item, size, sheet, qty, date_order, harga, id_cart
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.data){
					toastr.success(`<b>BERHASIL ADD!</b>`)
					$("#tgl").prop('disabled', true)
					$("#customer").prop('disabled', true)
					$("#no_po").prop('disabled', true)
					$("#item").val("")
					$("#size").val("")
					$("#sheet").val("")
					$("#qty").val("")
					$("#date_order").val("")
					$("#harga").val("")
					cartPOLaminasi()
				}else{
					toastr.error(`<b>${data.isi}</b>`)
					swal.close()
					return
				}
			}
		})
	}

	function cartPOLaminasi()
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/cartPOLaminasi')?>',
			type: "POST",
			success: function(res){
				$("#list-sementara").html(res)
				swal.close()
			}
		})
	}

	function hapusCartLaminasi(rowid)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusCartLaminasi')?>',
			type: "POST",
			data: ({ rowid }),
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
				cartPOLaminasi()
			}
		})
	}

	function simpanCartLaminasi()
	{
		let tgl = $("#tgl").val()
		let customer = $("#customer").val()
		let no_po = $("#no_po").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/simpanCartLaminasi')?>',
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
				tgl, customer, no_po, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				kosong()
				$(".row-input").attr('style', 'display:none');
				$(".row-sementara").attr('style', 'display:none');
				$(".row-list").attr('style', '');
				toastr.success(`<b>BERHASIL SIMPAN!</b>`)
			}
		})
	}

	function editPOLaminasi(id, opsi)
	{
		customerLaminasi()
		$(".row-input").attr('style', '');
		$(".row-sementara").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#tgl").prop('disabled', false)
		$('#customer').val("").prop('disabled', false).trigger('change');
		$("#no_po").prop('disabled', false)
		$("#item").val("")
		$("#size").val("")
		$("#sheet").val("")
		$("#qty").val("")
		$("#date_order").val("")
		$("#harga").val("")
		$("#list-sementara").html("");
		$.ajax({
			url: '<?php echo base_url('Transaksi/editPOLaminasi')?>',
			type: "POST",
			data: ({ id, opsi }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				statusInput = 'update'

				$("#tgl").val(data.po_lm.tgl_lm)
				$('#customer').val(data.po_lm.id_pelanggan).trigger('change')
				$("#no_po").val(data.po_lm.no_po_lm)
				$("#list-sementara").html(data.po_dtl)
				swal.close()
			}
		})
	}
</script>
