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
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick="kembaliListPOLaminasi()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
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
									<?php
										$query = $this->db->query("SELECT*FROM m_pelanggan_lm ORDER BY nm_pelanggan_lm");
										$html ='';
										$html .='<option value="">PILIH</option>';
										foreach($query->result() as $r){
											$html .='<option value="'.$r->id_pelanggan_lm.'" nm_pelanggan="'.$r->nm_pelanggan_lm.'">'.$r->nm_pelanggan_lm.'</option>';
										}
									?>
									<?= $html ?>
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
								<input type="hidden" id="id_po_header" value="">
								<input type="hidden" id="id_po_detail" value="">
								<input type="hidden" id="id_cart" value="0">
								<div id="btn-add"></div>
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
							<div id="list-input-sementara" style="overflow:auto;white-space:nowrap"></div>
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
		kosong()
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
		statusInput = 'insert'
		$("#btn-header").html('')
		$("#tgl").prop('disabled', false)
		$("#customer").val("").prop('disabled', false).trigger('change')
		$("#no_po").val("").prop('disabled', false)
		$("#item").val("").prop('disabled', false)
		$("#size").val("").prop('disabled', false)
		$("#sheet").val("").prop('disabled', false)
		$("#qty").val("").prop('disabled', false)
		$("#date_order").val("").prop('disabled', false)
		$("#harga").val("").prop('disabled', false)
		$("#id_po_header").val("")
		$("#id_po_detail").val("")
		$("#list-input-sementara").html('')
		$("#list-sementara").load("<?php echo base_url('Transaksi/destroyLaminasi') ?>")
		$("#btn-add").html('<button type="button" class="btn btn-sm btn-success" onclick="addItemLaminasi()"><i class="fa fa-plus"></i> <b>ADD</b></button>')
		swal.close()
	}

	function addPOLaminasi()
	{
		kosong()
		$(".row-input").attr('style', '');
		$(".row-sementara").attr('style', '');
		$(".row-list").attr('style', 'display:none');
	}

	function kembaliListPOLaminasi()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none');
		$(".row-sementara").attr('style', 'display:none');
		$(".row-list").attr('style', '');
		$("#id_cart").val(0)
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
		let id_po_header = $("#id_po_header").val()
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
				if(statusInput == 'insert'){
					kosong()
					reloadTable()
					$(".row-input").attr('style', 'display:none');
					$(".row-sementara").attr('style', 'display:none');
					$(".row-list").attr('style', '');
					toastr.success(`<b>BERHASIL SIMPAN!</b>`)
				}else{
					editPOLaminasi(id_po_header, 0, 'edit')
				}
			}
		})
	}

	function editPOLaminasi(id, id_dtl, opsi)
	{
		$(".row-input").attr('style', '');
		$(".row-sementara").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#tgl").prop('disabled', true)
		$('#customer').prop('disabled', true)
		$("#no_po").prop('disabled', true)
		$("#item").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#size").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#sheet").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#qty").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#date_order").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#harga").val("").prop('disabled', (opsi == 'edit') ? false : true)
		$("#id_po_header").val("")
		$("#id_po_detail").val("")
		$("#list-sementara").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/editPOLaminasi')?>',
			type: "POST",
			data: ({ id, id_dtl, opsi }),
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
				statusInput = 'update'

				$("#btn-header").html((opsi == 'edit') ? `<button type="button" class="btn btn-sm btn-info" onclick="editPOLaminasi(${id}, 0 ,'edit')"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>` : '')

				$("#tgl").val(data.po_lm.tgl_lm)
				$('#customer').val(data.po_lm.id_pelanggan).trigger('change')
				$("#no_po").val(data.po_lm.no_po_lm)
				$("#list-input-sementara").html(data.html_dtl)
				$("#id_po_header").val(data.po_lm.id)

				if(id != 0 && id_dtl != 0){
					$("#id_po_detail").val(data.po_dtl.id)
					$("#item").val(data.po_dtl.nm_item_lm)
					$("#size").val(data.po_dtl.size_lm)
					$("#sheet").val(format_angka(data.po_dtl.sheet_lm))
					$("#qty").val(format_angka(data.po_dtl.qty_lm))
					$("#date_order").val(data.po_dtl.tgl_order_lm)
					$("#harga").val(format_angka(data.po_dtl.harga_lm))
				}

				if(id != 0 && id_dtl != 0){
					$("#btn-add").html((opsi == 'edit') ? '<button type="button" class="btn btn-sm btn-warning" onclick="editListLaminasi()"><i class="fa fa-edit"></i> <b>EDIT</b></button>' : '')
				}else{
					$("#btn-add").html('<button type="button" class="btn btn-sm btn-success" onclick="addItemLaminasi()"><i class="fa fa-plus"></i> <b>ADD</b></button>')
				}

				swal.close()
			}
		})
	}

	function editListLaminasi()
	{
		let tgl = $("#tgl").val()
		let customer = $("#customer").val()
		let no_po = $("#no_po").val()
		let id_po_header = $("#id_po_header").val()
		let id_po_detail = $("#id_po_detail").val()
		let item = $("#item").val()
		let size = $("#size").val()
		let sheet = $("#sheet").val().split('.').join('')
		let qty = $("#qty").val().split('.').join('')
		let date_order = $("#date_order").val()
		let harga = $("#harga").val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/editListLaminasi')?>',
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
				tgl, customer, no_po, id_po_header, id_po_detail, item, size, sheet, qty, date_order, harga, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.updatePOdtl){
					editPOLaminasi(id_po_header, 0, 'edit')
				}
			}
		})
	}

	function hapusPOLaminasi(id_po_header, id_dtl) 
	{
		swal({
			title : "PO Laminasi",
			html : "<p>Hapus List?</p>",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>Hapus</b>',
			cancelButtonText : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?= base_url(); ?>Transaksi/hapus',
				data: ({
					id : id_dtl,
					jenis : 'trs_po_lm_detail',
					field : 'id'
				}),
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'loading ...',
						allowEscapeKey    : false,
						allowOutsideClick : false,
						onOpen: () => {
							swal.showLoading();
						}
					})
				},
				success: function(data) {
					toastr.success(`<b>BERHASIL HAPUS!</b>`)
					editPOLaminasi(id_po_header, 0, 'edit')
				},
			});
		});
	}
</script>
