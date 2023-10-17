<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Data Transaksi </h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item active" ><a href="#"><?= $judul ?></a></li>
				</ol>
			</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= $judul ?></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<button type="button" class="tambah_data btn btn-outline-primary pull-right" >Tambah Data</button>
				<br><br>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th style="width:5%">NO.</th>
							<th style="width:%">NO. SO</th>
							<th style="width:%">TGL. SO</th>
							<th style="width:%">STATUS</th>
							<th style="width:%">NO. PO</th>
							<th style="width:%">KODE MC</th>
							<th style="width:10%">AKSI</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<table style="width:100%">
					<tr>
						<td style="width:10%;padding:5px;border:1px solid #000"></td>
						<td style="width:90%;padding:5px;border:1px solid #000"></td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">TANGGAL SO</td>
						<td style="padding:5px 0">
							<input type="date" name="tgl_so" id="tgl_so" class="form-control" value="<?= date('Y-m-d')?>" disabled>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">NO. PO</td>
						<td style="padding:5px 0">
							<select name="no_po" id="no_po" class="form-control select2"></select>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">MARKETING</td>
						<td style="padding:5px 0">
							<input type="text" name="marketing" id="marketing" class="form-control" disabled>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">CUSTOMER</td>
						<td style="padding:5px 0">
							<input type="text" name="customer" id="customer" class="form-control" disabled>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">ITEMS</td>
						<td style="padding:5px 0">
							<input type="hidden" id="idpodetail">
							<select name="items" id="items" class="form-control select2"></select>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">UK. BOX</td>
						<td style="padding:5px 0" id="uk_box">-</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">UK. SHEET</td>
						<td style="padding:5px 0" id="uk_sheet">-</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">FLUTE</td>
						<td style="padding:5px 0" id="flute">-</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">KUALITAS</td>
						<td style="padding:5px 0" id="substance">-</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">NO. SO</td>
						<td style="padding:5px 0">
							<input type="text" name="no_so" id="no_so" class="form-control">
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding:5px 0">
						<button type="button" class="btn btn-success" id="btn-simpan" onclick="addItems()"><i class="fas fa-plus-square"></i> Tambah</button>
						</td>
					</tr>
					<tr>
						<td style="padding:5px;border:00" colspan="2"></td>
					</tr>
				</table>

				<table id="table-nopo" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th style="width:5%">NO.</th>
							<th style="width:35%">ITEMS</th>
							<th style="width:35%">NO. SO</th>
							<th style="width:25%">AKSI</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-outline-secondary" id="btn-print" onclick="Cetak()" style="display:none"><i class="fas fa-print"></i> Print</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		// load_data();
		$('.select2').select2();
	});

	$(".tambah_data").click(function(event) {
		kosong();
		status = "insert";
		$("#modalForm").modal("show");
		$("#judul").html('<h3>Form Tambah Data</h3>');
	});

	function kosong(){
		$("#tgl_so").val()
		$("#idpodetail").val("")
		$("#marketing").val("")
		$("#customer").val("")
		$("#uk_box").html("-")
		$("#uk_sheet").html("-")
		$("#flute").html("-")
		$("#substance").html("-")
		$("#no_so").val("").prop("disabled", true)
		soPlhNoPO()
	}

	function soPlhNoPO(){
		$("#no_po").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$("#items").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$.ajax({
			url: '<?php echo base_url('Transaksi/soPlhNoPO')?>',
			type: "POST",
			success: function(json){
				data = JSON.parse(json)
				// console.log(data)
				let htmlPo = ''
					htmlPo += `<option value="">PILIH</option>`
				data.po.forEach(loadPo);
				function loadPo(r, index) {
					htmlPo += `<option value="${r.no_po}" data-sales="${r.nm_sales}" data-cust="${r.nm_pelanggan}">${r.no_po} | ${r.kode_po}</option>`;
				}
				$("#no_po").prop("disabled", false).html(htmlPo)
			}
		})
	}

	$('#no_po').on('change', function() {
		let no_po = $('#no_po option:selected').val();
		let sales = $('#no_po option:selected').attr('data-sales');
		let cust = $('#no_po option:selected').attr('data-cust');
		// alert(no_po+" - "+sales+" - "+cust)
		$("#uk_box").html("-")
		$("#uk_sheet").html("-")
		$("#flute").html("-")
		$("#substance").html("-")
		$("#no_so").val("").prop("disabled", true)
		$("#marketing").val(sales)
		$("#customer").val(cust)
		soPlhItems(no_po)
	})

	function soPlhItems(no_po){
		$("#no_so").val("").prop("disabled", true)
		// alert(no_po)
		$.ajax({
			url: '<?php echo base_url('Transaksi/soPlhItems')?>',
			type: "POST",
			data: ({
				no_po
			}),
			success: function(json){
				data = JSON.parse(json)
				console.log(data)
				let tf = '';
				(data.po_detail.length == 0) ? tf = true : tf = false
				let htmlDetail = ''
					htmlDetail += `<option value="">PILIH</option>`
				data.po_detail.forEach(loadDetail);
				function loadDetail(r, index) {
					htmlDetail += `<option value="${r.id_produk}" data-idpodetail="${r.id}" data-nm_produk="${r.nm_produk}" data-ukuran="${r.ukuran}" data-ukuran_sheet="${r.ukuran_sheet}" data-flute="${r.flute}" data-kualitas="${r.kualitas}">${r.nm_produk} | ${r.ukuran} | ${r.ukuran_sheet} | ${r.flute} | ${r.kualitas}</option>`;
				}
				$("#items").prop("disabled", tf).html(htmlDetail)
			}
		})
	}

	$('#items').on('change', function() {
		let item = $('#items option:selected').val()
		let idpodetail = $('#items option:selected').attr('data-idpodetail')
		let nm_produk = $('#items option:selected').attr('data-nm_produk')
		let ukuran = $('#items option:selected').attr('data-ukuran')
		let ukuran_sheet = $('#items option:selected').attr('data-ukuran_sheet')
		let flute = $('#items option:selected').attr('data-flute')
		let kualitas = $('#items option:selected').attr('data-kualitas')
		$("#idpodetail").val(idpodetail)
		$("#uk_box").html((item == "") ? '-' : ukuran)
		$("#uk_sheet").html((item == "") ? '-' : ukuran_sheet)
		$("#flute").html((item == "") ? '-' : flute)
		$("#substance").html((item == "") ? '-' : kualitas)
		// $("#no_so").val("").prop("disabled", true)
		soNoSo(item)
	})

	function soNoSo(item){
		// alert(item)
		$.ajax({
			url: '<?php echo base_url('Transaksi/soNoSo')?>',
			type: "POST",
			data: ({
				item
			}),
			success: function(json){
				data = JSON.parse(json)
				console.log(data)
				let tf = ''
				let no_so = ''
				let tmbhNoso = ''
				if(item == ''){
					tf = true
					no_so = ''
				}else{	
					if(data.siu.length == 0){
						tf = false
						no_so = ''
					}else{
						tf = true
						if(data.siu[0].jmlNoSo.length == 1){
							tmbhNoso = `.0${parseInt(data.siu[0].jmlNoSo)+1}`
						}else{
							tmbhNoso = `.${parseInt(data.siu[0].jmlNoSo)+1}`
						}
						no_so = data.siu[0].no_so + tmbhNoso
					}
				}
				$("#no_so").val(no_so).prop("disabled", tf)
			}
		})
	}

	function addItems(){
		let idpodetail = $("#idpodetail").val()
		let no_po = $("#no_po").val()
		let items = $("#items").val()
		let no_so = $("#no_so").val()
		alert(idpodetail+' - '+no_po+" - "+items+" - "+no_so)
		// 6 - PO/2023/X/0003 - 2 - TESTES
		// $.ajax({
		// 	url: '',
		// 	type: "POST",
		// 	data: ({
		// 		idpodetail, no_po, items, no_so
		// 	}),
		// 	success: function(res){

		// 	}
		// })
	}
</script>
