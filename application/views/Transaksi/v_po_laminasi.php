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
			<div class="row row-input" style="display: none;">
				<div class="col-md-6">
					<div class="card card-success card-outline" style="position:sticky;top:12px">
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
								<select id="customer" class="form-control select2" onchange="plhCustomer()">
									<?php
										$query = $this->db->query("SELECT lm.*,s.nm_sales FROM m_pelanggan_lm lm INNER JOIN m_sales s ON lm.id_sales=s.id_sales ORDER BY nm_pelanggan_lm");
										$html ='';
										$html .='<option value="">PILIH</option>';
										foreach($query->result() as $r){
											$html .='<option value="'.$r->id_pelanggan_lm.'" id_sales="'.$r->id_sales.'" nm_sales="'.$r->nm_sales.'">'.$r->nm_pelanggan_lm.'</option>';
										}
										echo $html
									?>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">MARKETING</div>
							<div class="col-md-9">
								<input type="text" id="marketing" class="form-control" autocomplete="off" placeholder="MARKETING" disabled>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">NO. PO</div>
							<div class="col-md-9">
								<input type="text" id="no_po" class="form-control" autocomplete="off" placeholder="NO. PO" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3">NOTE. PO</div>
							<div class="col-md-9">
								<textarea id="note_po_lm" class="form-control" style="resize:none" placeholder="NOTE. PO" oninput="this.value=this.value.toUpperCase()"></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card-tambah-item" style="display:none">
						<div class="card card-primary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PILIH ITEM</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 0">
								<div class="col-md-3"></div>
								<div class="col-md-9" style="color:#f00;font-size:12px;font-style:italic">* PRODUK | UKURAN | ISI | QTY</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">ITEM</div>
								<div class="col-md-9">
									<select id="item" class="form-control select2" onchange="plhItem()">
										<?php
											$query = $this->db->query("SELECT*FROM m_produk_lm ORDER BY nm_produk_lm");
											$html ='';
											$html .='<option value="">PILIH</option>';
											foreach($query->result() as $r){
												if($r->jenis_qty_lm == 'pack'){
													$qty = $r->pack_lm;
												}else if($r->jenis_qty_lm == 'ikat'){
													$qty = $r->ikat_lm.' ( IKAT )';
												}else{
													$qty = $r->kg_lm.' ( KG )';
												}
												$html .='<option
													value="'.$r->id_produk_lm.'"
													nm_produk_lm="'.$r->nm_produk_lm.'"
													ukuran_lm="'.$r->ukuran_lm.'"
													isi_lm="'.$r->isi_lm.'"
													jenis_qty_lm="'.$r->jenis_qty_lm.'"
													pack_lm="'.$r->pack_lm.'"
													ikat_lm="'.$r->ikat_lm.'"
													kg_lm="'.$r->kg_lm.'"
												>'.$r->nm_produk_lm.' | '.$r->ukuran_lm.' | '.$r->isi_lm.' | '.$qty.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">SIZE</div>
								<div class="col-md-9">
									<input type="text" id="size" class="form-control" autocomplete="off" placeholder="UKURAN" disabled oninput="this.value=this.value.toUpperCase()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">@<span class="txt-item-pack-ikat">PACK</span></div>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" id="sheet" class="form-control" autocomplete="off" placeholder="ISI" disabled>
										<div class="input-group-append"><span class="input-group-text igt-sheet" style="background:#a9acaf;color:#222;font-weight:bold">SHEET</span></div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-3">@BAL</div>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" id="qty" class="form-control" autocomplete="off" placeholder="BAL">
										<div class="input-group-append"><span class="input-group-text igt-qty" style="background:#a9acaf;color:#222;font-weight:bold">-</span></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-order" style="display:none">
						<div class="card card-primary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">ORDER</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">SHEET</div>
								<div class="col-md-9">
									<input type="text" id="order_sheet" class="form-control" placeholder="ORDER SHEET" disabled onkeyup="hitungHarga()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"><span class="txt-order-pack-ikat">PACK</span></div>
								<div class="col-md-9">
									<input type="text" id="order_pori" class="form-control" placeholder="-" disabled onkeyup="hitungHarga()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-3">QTY ( BAL )</div>
								<div class="col-md-9">
									<input type="text" id="qty_bal" class="form-control" autocomplete="off" placeholder="QTY ( BAL )" onkeyup="hitungHarga()">
								</div>
							</div>
						</div>
					</div>

					<div class="card-harga" style="display:none">
						<div class="card card-primary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">HARGA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">HARGA LEMBAR</div>
								<div class="col-md-9">
									<input type="text" id="harga_lembar" class="form-control" autocomplete="off" placeholder="HARGA LEMBAR" onkeyup="hitungHargaP('lembar')">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">HARGA <span class="txt-harga-pack-ikat">PACK</span></div>
								<div class="col-md-9">
									<input type="text" id="harga_pori" class="form-control" autocomplete="off" placeholder="HARGA PACK" onkeyup="hitungHargaP('pori')">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">HARGA TOTAL</div>
								<div class="col-md-9">
									<input type="text" id="harga_total" class="form-control" style="font-weight:bold;color:#000" autocomplete="off" placeholder="HARGA TOTAL" disabled>
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

					<div class="card-verifikasi" style="display:none">
						<div class="card card-info card-outline" style="padding-bottom:12px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">ADMIN</div>
								<div class="col-md-9">
									<div id="verif-admin"></div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MARKETING</div>
								<div class="col-md-9">
									<div id="verif-marketing"></div>
								</div>
							</div>
							<div id="input-marketing"></div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">OWNER</div>
								<div class="col-md-9">
									<div id="verif-owner"></div>
								</div>
							</div>
							<div id="input-owner"></div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row row-sementara" style="display: none;">
				<div class="col-md-12">
					<div class="card card-secondary card-outline" style="position:sticky;top:12px">
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
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PO LAMINASI</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<?php if(in_array($this->session->userdata('level'), ['Admin','Laminasi'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="addPOLaminasi()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="padding:12px;text-align:center">#</th>
											<th style="padding:12px;text-align:center">NO. PO</th>
											<th style="padding:12px;text-align:center">TGL</th>
											<th style="padding:12px;text-align:center">STATUS</th>
											<th style="padding:12px;text-align:center">CUSTOMER</th>
											<th style="padding:12px;text-align:center">ADMIN</th>
											<th style="padding:12px;text-align:center">MKT</th>
											<th style="padding:12px;text-align:center">OWNER</th>
											<th style="padding:12px;text-align:center">LAPORAN</th>
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
		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

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
				"data": ({
					po: 'list',
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
		$("#btn-header").html('')
		$("#tgl").prop('disabled', false)
		$("#customer").val("").prop('disabled', false).trigger('change')
		$("#no_po").val("").prop('disabled', false)
		$("#note_po_lm").val("").prop('disabled', false)
		$("#item").val("").prop('disabled', false).trigger('change')
		$("#size").val("").prop('disabled', true)
		$("#sheet").val("").prop('disabled', true)
		$("#qty").val("").prop('disabled', true)
		$("#order_sheet").val("").prop('disabled', true)
		$("#order_pori").val("").prop('disabled', true)
		$("#qty_bal").val("").prop('disabled', true)
		$("#harga_lembar").val("").prop('disabled', true)
		$("#harga_pori").val("").prop('disabled', true)
		$("#harga_total").val("").prop('disabled', true)
		$("#id_po_header").val("")
		$("#id_po_detail").val("")
		$("#list-input-sementara").html('')
		$("#list-sementara").load("<?php echo base_url('Transaksi/destroyLaminasi') ?>")
		$("#btn-add").html('<button type="button" class="btn btn-sm btn-success" onclick="addItemLaminasi()"><i class="fa fa-plus"></i> <b>ADD</b></button>')
		$("#input-marketing").html('')
		$("#input-owner").html('')
		swal.close()
	}

	function plhCustomer()
	{
		let nm_sales = $("#customer option:selected").attr('nm_sales')
		$("#marketing").val(nm_sales)
	}

	function plhItem()
	{
		let nm_produk_lm = $("#item option:selected").attr('nm_produk_lm')
		let ukuran_lm = $("#item option:selected").attr('ukuran_lm')
		let isi_lm = $("#item option:selected").attr('isi_lm')
		let jenis_qty_lm = $("#item option:selected").attr('jenis_qty_lm')
		let pack_lm = $("#item option:selected").attr('pack_lm')
		let ikat_lm = $("#item option:selected").attr('ikat_lm')
		let kg_lm = $("#item option:selected").attr('kg_lm')
		let qty = ''
		if(jenis_qty_lm == undefined){
			$(".txt-item-pack-ikat").html("PACK")
			$(".txt-order-pack-ikat").html("PACK")
			$(".txt-harga-pack-ikat").html("PACK")
			$(".igt-qty").html("-")
			qty = ''
		}else{
			if(jenis_qty_lm == 'pack'){
				$(".txt-item-pack-ikat").html("PACK")
				$(".txt-order-pack-ikat").html("PACK")
				$(".txt-harga-pack-ikat").html("PACK")
				$(".igt-qty").html("PACK")
				qty = pack_lm
			}else if(jenis_qty_lm == 'ikat'){
				$(".txt-item-pack-ikat").html("IKAT")
				$(".txt-order-pack-ikat").html("IKAT")
				$(".txt-harga-pack-ikat").html("IKAT")
				$(".igt-qty").html("IKAT")
				qty = ikat_lm
			}else{
				$(".txt-item-pack-ikat").html("KG")
				$(".txt-order-pack-ikat").html("KG")
				$(".txt-harga-pack-ikat").html("KG")
				$(".igt-qty").html("KG")
				qty = kg_lm
			}
		}
		$("#order_sheet").val("").prop('disabled', true)
		$("#order_pori").val("").prop('disabled', true)
		$("#qty_bal").val("").prop('disabled', (jenis_qty_lm == undefined) ? true : false)
		$("#harga_lembar").val("").prop('disabled', true)
		$("#harga_pori").val("").prop('disabled', true)
		$("#harga_total").val("").prop('disabled', true)
		$("#size").val(ukuran_lm)
		$("#sheet").val(isi_lm)
		$("#qty").val(qty)
	}

	function addPOLaminasi()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-sementara").attr('style', '')
		$(".card-tambah-item").attr('style', '')
		$(".card-order").attr('style', '')
		$(".card-harga").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$(".card-verifikasi").attr('style', 'display:none')
	}

	function kembaliListPOLaminasi()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-sementara").attr('style', 'display:none')
		$(".card-tambah-item").attr('style', 'display:none')
		$(".card-order").attr('style', 'display:none')
		$(".card-harga").attr('style', 'display:none')
		$(".row-list").attr('style', '')
		$(".card-verifikasi").attr('style', 'display:none')
		$("#id_cart").val(0)
	}

	function hitungHarga()
	{
		let at_sheet = $("#sheet").val()
		let at_bal = $("#qty").val()
		
		let qty_bal = $("#qty_bal").val().split('.').join('')
		$("#qty_bal").val(format_angka(qty_bal))

		let orderSheet = parseInt(at_sheet) * (parseInt(at_bal) * parseInt(qty_bal))
		$("#order_sheet").val(format_angka(orderSheet))

		let orderPackOrIkat = parseInt(at_bal) * parseInt(qty_bal)
		$("#order_pori").val(format_angka(orderPackOrIkat))
		
		let cek = parseInt(qty_bal)
		let jenis_qty_lm = $("#item option:selected").attr('jenis_qty_lm');
		if(jenis_qty_lm == 'kg'){
			$("#harga_lembar").val(0).prop('disabled', true)
		}else{
			$("#harga_lembar").val("").prop('disabled', (isNaN(cek) || cek == 0) ? true : false)
		}
		$("#harga_pori").val("").prop('disabled', (isNaN(cek) || cek == 0) ? true : false)
		$("#harga_total").val("")
	}

	function hitungHargaP(opsi)
	{
		let at_sheet = $("#sheet").val()
		let order_sheet = $("#order_sheet").val().split('.').join('')
		let order_pori = $("#order_pori").val().split('.').join('')

		let harga_total = 0
		if(opsi == 'lembar'){
			let harga_lembar = $("#harga_lembar").val().split('.').join('')
			$("#harga_lembar").val(format_angka(harga_lembar))

			let hitungPori = parseInt(at_sheet) * parseInt(harga_lembar);
			(isNaN(hitungPori)) ? hitungPori = 0 : hitungPori = hitungPori
			$("#harga_pori").val(format_angka(hitungPori))

			harga_total = parseInt(order_sheet) * parseInt(harga_lembar)
		}

		if(opsi == 'pori'){
			let harga_pori = $("#harga_pori").val().split('.').join('')
			$("#harga_pori").val(format_angka(harga_pori))

			let hargaSheet = parseInt(harga_pori) / parseInt(at_sheet);
			$("#harga_lembar").val(hargaSheet)

			harga_total = parseInt(order_pori) * parseInt(harga_pori)
		}

		let jenis_qty_lm = $("#item option:selected").attr('jenis_qty_lm');
		if(jenis_qty_lm == 'kg'){
			$("#harga_lembar").val(0).prop('disabled', true)
		}

		$("#harga_total").val(format_angka(harga_total))
	}

	function addItemLaminasi()
	{
		let id_po_header = $("#id_po_header").val()
		let tgl = $("#tgl").val()
		let customer = $("#customer").val()
		let id_sales = $("#customer option:selected").attr('id_sales');
		(id_sales == undefined) ? id_sales = '' : id_sales = id_sales
		let no_po = $("#no_po").val()
		let note_po_lm = $("#note_po_lm").val()
		let item = $("#item").val()
		let nm_produk_lm = $("#item option:selected").attr('nm_produk_lm');
		(nm_produk_lm == undefined) ? nm_produk_lm = '' : nm_produk_lm = nm_produk_lm
		let ukuran_lm = $("#item option:selected").attr('ukuran_lm');
		(ukuran_lm == undefined) ? ukuran_lm = '' : ukuran_lm = ukuran_lm
		let isi_lm = $("#item option:selected").attr('isi_lm');
		(isi_lm == undefined) ? isi_lm = '' : isi_lm = isi_lm
		let jenis_qty_lm = $("#item option:selected").attr('jenis_qty_lm');
		(jenis_qty_lm == undefined) ? jenis_qty_lm = '' : jenis_qty_lm = jenis_qty_lm
		let qty = $("#qty").val().split('.').join('')
		let order_sheet = $("#order_sheet").val().split('.').join('')
		let order_pori = $("#order_pori").val().split('.').join('')
		let qty_bal = $("#qty_bal").val().split('.').join('')
		let harga_lembar = $("#harga_lembar").val().split('.').join('')
		let harga_pori = $("#harga_pori").val().split('.').join('')
		let harga_total = $("#harga_total").val().split('.').join('')
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
				id_po_header, tgl, customer, id_sales, no_po, note_po_lm, item, nm_produk_lm, ukuran_lm, isi_lm, jenis_qty_lm, qty, order_sheet, order_pori, qty_bal, harga_lembar, harga_pori, harga_total, id_cart
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					toastr.success(`<b>BERHASIL ADD!</b>`)
					$("#tgl").prop('disabled', true)
					$("#customer").prop('disabled', true)
					$("#no_po").prop('disabled', true)
					$("#note_po_lm").prop('disabled', true)
					$("#item").val("").trigger('change')
					$("#size").val("")
					$("#sheet").val("")
					$("#qty").val("")
					$("#order_sheet").val("")
					$("#order_pori").val("")
					$("#qty_bal").val("")
					$("#harga_lembar").val("")
					$("#harga_pori").val("")
					$("#harga_total").val("")
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
		let id_sales = $("#customer option:selected").attr('id_sales')
		let no_po = $("#no_po").val()
		let note_po_lm = $("#note_po_lm").val()
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
				tgl, customer, id_sales, no_po, note_po_lm, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
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
		$("#note_po_lm").prop('disabled', true)
		$("#item").val("").prop('disabled', false).trigger('change')
		$("#size").val("").prop('disabled', true)
		$("#sheet").val("").prop('disabled', true)
		$("#qty").val("").prop('disabled', true)
		$("#order_sheet").val("").prop('disabled', true)
		$("#order_pori").val("").prop('disabled', true)
		$("#qty_bal").val("").prop('disabled', true)
		$("#harga_lembar").val("").prop('disabled', true)
		$("#harga_pori").val("").prop('disabled', true)
		$("#harga_total").val("").prop('disabled', true)
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
				// console.log(data)
				statusInput = 'update'
				$("#btn-header").html((opsi == 'edit') ? `<button type="button" class="btn btn-sm btn-info" onclick="editPOLaminasi(${id}, 0 ,'edit')"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>` : '')
				$("#tgl").val(data.po_lm.tgl_lm)
				$('#customer').val(data.po_lm.id_pelanggan).trigger('change')
				$("#no_po").val(data.po_lm.no_po_lm)
				$("#note_po_lm").val(data.po_lm.note_po_lm)
				$("#list-input-sementara").html(data.html_dtl)
				$("#id_po_header").val(data.po_lm.id)
				if(id != 0 && id_dtl != 0){
					$("#id_po_detail").val(data.po_dtl.id)
					$("#item").val(data.po_dtl.id_m_produk_lm).prop('disabled', true).trigger('change')
					$("#size").val(data.po_dtl.ukuran_lm)
					$("#sheet").val(format_angka(data.po_dtl.isi_lm))
					let qty = 0
					if(data.po_dtl.jenis_qty_lm == 'pack'){
						qty = data.po_dtl.pack_lm
					}else if(data.po_dtl.jenis_qty_lm == 'ikat'){
						qty = data.po_dtl.ikat_lm
					}else{
						qty = data.po_dtl.kg_lm
					}
					$("#qty").val(format_angka(qty))
					$("#order_sheet").val(format_angka(data.po_dtl.order_sheet_lm))
					$("#order_pori").val(format_angka(data.po_dtl.order_pori_lm))
					$("#qty_bal").val(format_angka(data.po_dtl.qty_bal)).prop('disabled', false)

					if(data.po_dtl.jenis_qty_lm == 'pack'){
						$(".txt-item-pack-ikat").html("PACK")
						$(".txt-order-pack-ikat").html("PACK")
						$(".txt-harga-pack-ikat").html("PACK")
						$(".igt-qty").html("PACK")
					}else if(data.po_dtl.jenis_qty_lm == 'ikat'){
						$(".txt-item-pack-ikat").html("IKAT")
						$(".txt-order-pack-ikat").html("IKAT")
						$(".txt-harga-pack-ikat").html("IKAT")
						$(".igt-qty").html("IKAT")
					}else{
						$(".txt-item-pack-ikat").html("KG")
						$(".txt-order-pack-ikat").html("KG")
						$(".txt-harga-pack-ikat").html("KG")
						$(".igt-qty").html("KG")
					}

					$("#harga_lembar").val(format_angka(data.po_dtl.harga_lembar_lm)).prop('disabled', false)
					$("#harga_pori").val(format_angka(data.po_dtl.harga_pori_lm)).prop('disabled', false)
					$("#harga_total").val(format_angka(data.po_dtl.harga_total_lm))
				}
				if(id != 0 && id_dtl != 0){
					$("#btn-add").html((opsi == 'edit') ? '<button type="button" class="btn btn-sm btn-warning" onclick="editListLaminasi()"><i class="fa fa-edit"></i> <b>EDIT</b></button>' : '')
				}else{
					$("#btn-add").html((opsi == 'edit') ? '<button type="button" class="btn btn-sm btn-success" onclick="addItemLaminasi()"><i class="fa fa-plus"></i> <b>ADD</b></button>' : '')
				}
				$(".card-verifikasi").attr('style', '');

				if(opsi == 'verif' || opsi == 'detail'){
					$(".card-tambah-item").attr('style', 'display:none');
					$(".card-order").attr('style', 'display:none');
					$(".card-harga").attr('style', 'display:none');
				}else{
					$(".card-tambah-item").attr('style', '');
					$(".card-order").attr('style', '');
					$(".card-harga").attr('style', '');
				}

				$("#verif-admin").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.add_time_po_lm}`)
				// VERIFIFIKASI MARKETING
				if((urlAuth == 'Admin' || urlAuth == 'Marketing Laminasi') && data.po_lm.status_lm2 == 'N' && (data.po_lm.status_lm1 == 'N' || data.po_lm.status_lm1 == 'H' || data.po_lm.status_lm1 == 'R')){
					// BUTTON MARKETING
					$("#verif-marketing").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifLaminasi('verifikasi','marketing')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifLaminasi('hold','marketing')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifLaminasi('reject','marketing')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN MARKETING
					if(data.po_lm.status_lm1 != 'N'){
						if(data.po_lm.status_lm1 == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$("#input-marketing").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.po_lm.ket_lm1}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifLaminasi('${data.po_lm.status_lm1}', 'marketing')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON MARKETING
					if(data.po_lm.status_lm1 == 'N'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.po_lm.status_lm1 == 'H'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.time_lm1}`)
					}else if(data.po_lm.status_lm1 == 'R'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.time_lm1}`)
					}else{
						$("#verif-marketing").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.time_lm1}`)
					}
					// KETERANGAN MARKETING
					if(data.po_lm.status_lm1 != 'N'){
						if(data.po_lm.status_lm1 == 'H'){
							callout = 'callout-warning'
						}else if(data.po_lm.status_lm1 == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$("#input-marketing").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:6px;margin:0">${data.po_lm.ket_lm1}</div>
								</div>
							</div>
						`)
					}
				}
				// VERIFIFIKASI OWNER
				if((urlAuth == 'Admin' || urlAuth == 'Owner') && data.po_lm.status_lm1 == 'Y' && (data.po_lm.status_lm2 == 'N' || data.po_lm.status_lm2 == 'H' || data.po_lm.status_lm2 == 'R')){
					// BUTTON OWNER
					$("#verif-owner").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifLaminasi('verifikasi','owner')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifLaminasi('hold','owner')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifLaminasi('reject','owner')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN OWNER
					if(data.po_lm.status_lm2 != 'N'){
						if(data.po_lm.status_lm2 == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.po_lm.ket_lm2}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifLaminasi('${data.po_lm.status_lm2}', 'owner')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON OWNER
					if(data.po_lm.status_lm2 == 'N'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.po_lm.status_lm2 == 'H'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.time_lm2}`)
					}else if(data.po_lm.status_lm2 == 'R'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.time_lm2}`)
					}else{
						$("#verif-owner").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.time_lm2}`)
					}
					// KETERANGAN OWNER
					if(data.po_lm.status_lm2 != 'N'){
						if(data.po_lm.status_lm2 == 'H'){
							callout = 'callout-warning'
						}else if(data.po_lm.status_lm2 == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:6px;margin:0">${data.po_lm.ket_lm2}</div>
								</div>
							</div>
						`)
					}
				}
				swal.close()
			}
		})
	}

	function verifLaminasi(aksi, status_verif)
	{
		if(aksi == 'verifikasi'){
			vrf = 'Y'
			callout = 'callout-success'
			colorbtn = 'btn-success'
			txtsave = 'VERIFIKASI!'
		}else if(aksi == 'hold'){
			vrf = 'H'
			callout = 'callout-warning'
			colorbtn = 'btn-warning'
			txtsave = 'HOLD!'
		}else if(aksi == 'reject'){
			vrf = 'R'
			callout = 'callout-danger'
			colorbtn = 'btn-danger'
			txtsave = 'REJECT!'
		}
		(status_verif == 'marketing') ? input_verif = 'input-marketing' : input_verif ='input-owner';
		$("#"+input_verif).html(`
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<div class="callout ${callout}" style="padding:0;margin:0">
						<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifLaminasi('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
				</div>
			</div>
		`)
	}

	function btnVerifLaminasi(aksi, status_verif)
	{
		let id_po_lm = $("#id_po_header").val()
		let ket_laminasi = $("#ket_laminasi").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/btnVerifLaminasi')?>',
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
				id_po_lm, ket_laminasi, aksi, status_verif
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data){
					kembaliListPOLaminasi()
				}else{
					toastr.error(`<b>KETERANGAN TIDAK BOLEH KOSONG!</b>`)
					swal.close()
				}
			}
		})
	}

	function editListLaminasi()
	{
		let tgl = $("#tgl").val()
		let customer = $("#customer").val()
		let no_po = $("#no_po").val()
		let note_po_lm = $("#note_po_lm").val()
		let id_po_header = $("#id_po_header").val()
		let id_po_detail = $("#id_po_detail").val()
		let qty = $("#qty").val().split('.').join('')
		let order_sheet = $("#order_sheet").val().split('.').join('')
		let order_pori = $("#order_pori").val().split('.').join('')
		let qty_bal = $("#qty_bal").val().split('.').join('')
		let harga_lembar = $("#harga_lembar").val().split('.').join('')
		let harga_pori = $("#harga_pori").val().split('.').join('')
		let harga_total = $("#harga_total").val().split('.').join('')
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
				tgl, customer, no_po, note_po_lm, id_po_header, id_po_detail, qty, order_sheet, order_pori, qty_bal, harga_lembar, harga_pori, harga_total
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.updatePOdtl){
					editPOLaminasi(id_po_header, 0, 'edit')
				}
			}
		})
	}

	function hapusPOLaminasi(id_po_header, id, table)
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
					id : id,
					jenis : table,
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
					if(id_po_header == 0){
						reloadTable()
						swal.close()
					}else{
						editPOLaminasi(id_po_header, 0, 'edit')
					}
				},
			});
		});
	}
</script>
