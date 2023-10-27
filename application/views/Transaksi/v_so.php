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
		<div class="card card-list-so">
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
							<th style="width:10%">TGL. SO</th>
							<th style="width:30%">ITEM</th>
							<th style="width:15%">NO. PO</th>
							<th style="width:30%">NO. SO</th>
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

			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				<table style="width:100%">
					<tr>
						<td style="width:10%;padding:0;border:0">
							<input type="hidden" id="h_id">
							<input type="hidden" id="h_no_po">
							<input type="hidden" id="h_kodepo">
						</td>
						<td style="width:90%;padding:0;border:0"></td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">TANGGAL SO</td>
						<td style="padding:5px 0">
							<input type="date" name="tgl_so" id="tgl_so" class="form-control" value="<?= date('Y-m-d')?>">
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">NO. PO</td>
						<td style="padding:5px 0">
							<input type="hidden" id="h_kode_po">
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
						<td style="padding:5px 0;font-weight:bold">ITEM</td>
						<td style="padding:5px 0">
							<input type="hidden" id="idpodetail">
							<select name="items" id="items" class="form-control select2"></select>
						</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">KODE. MC</td>
						<td style="padding:5px 0" id="kode_mc">-</td>
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
						<td style="padding:5px 0;font-weight:bold">QTY PO</td>
						<td style="padding:5px 0" id="qty_po">-</td>
					</tr>
					<tr>
						<td style="padding:5px 0;font-weight:bold">NO. SO</td>
						<td style="padding:5px 0">
							<input type="text" name="no_so" id="no_so" class="form-control" autocomplete="off" oninput="this.value = this.value.toUpperCase()">
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="padding:5px 0">
							<button type="button" class="btn btn-success" id="btn-show-simpan" onclick="addItems()"><i class="fas fa-plus-square"></i> Tambah</button>
						</td>
					</tr>
					<tr>
						<td style="padding:5px;border:00" colspan="2"></td>
					</tr>
				</table>
				<div id="table-nopo"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFormDetail">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul-detail"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				<div id="modal-detail-so"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	$(".tambah_data").click(function(event) {
		$("#table-nopo").load("<?php echo base_url('Transaksi/destroySO') ?>")
		kosong();
		status = "insert";
		$("#modalForm").modal("show");
		$("#judul").html('<h3>Form Tambah Data</h3>');
	});

	function load_data() {
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Transaksi/load_data/trs_so_detail',
				"type": "POST",
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function kosong(){
		$("#tgl_so").val()
		$("#h_kode_po").val("")
		$("#idpodetail").val("")
		$("#marketing").val("")
		$("#customer").val("")
		$("#uk_box").html("-")
		$("#uk_sheet").html("-")
		$("#flute").html("-")
		$("#substance").html("-")
		$("#kode_mc").html("-")
		$("#qty_po").html("-")
		$("#no_so").val("").prop("disabled", true)
		$("#btn-simpan").prop("disabled", false);
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
					htmlPo += `<option value="${r.no_po}" data-sales="${r.nm_sales}" data-cust="${r.nm_pelanggan}" data-idpelanggan="${r.id_pelanggan}" data-kdpo="${r.kode_po}" data-kdunik="${r.kode_unik}">${r.no_po} . KODE : ${r.kode_po}</option>`;
				}
				$("#no_po").prop("disabled", false).html(htmlPo)
				$("#h_kode_po").val("")
			}
		})
	}

	$('#no_po').on('change', function() {
		$("#items").prop("disabled", true).html(`<option value="">PILIH</option>`)
		let no_po = $('#no_po option:selected').val();
		let sales = $('#no_po option:selected').attr('data-sales');
		let cust = $('#no_po option:selected').attr('data-cust');
		let kdpo = $('#no_po option:selected').attr('data-kdpo');
		// alert(no_po+" - "+sales+" - "+cust)
		$("#uk_box").html("-")
		$("#uk_sheet").html("-")
		$("#flute").html("-")
		$("#substance").html("-")
		$("#kode_mc").html("-")
		$("#qty_po").html("-")
		$("#no_so").val("").prop("disabled", true)
		$("#marketing").val(sales)
		$("#customer").val(cust)
		$("#h_kode_po").val(kdpo)
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
				// console.log(data)
				let tf = '';
				(data.po_detail.length == 0) ? tf = true : tf = false
				let htmlDetail = ''
					htmlDetail += `<option value="">PILIH</option>`
				data.po_detail.forEach(loadDetail);
				function loadDetail(r, index) {
					htmlDetail += `<option value="${r.id_produk}" data-idpodetail="${r.id}" data-nm_produk="${r.nm_produk}" data-ukuran="${r.ukuran}" data-ukuran_sheet="${r.ukuran_sheet}" data-flute="${r.flute}" data-kualitas="${r.kualitas}" data-kode_mc="${r.kode_mc}" data-qty="${r.qty}" rm="${r.rm}" ton="${r.ton}">${r.nm_produk} | ${r.kode_mc} | ${r.ukuran} | ${r.ukuran_sheet} | ${r.flute} | ${r.kualitas} | ${r.qty}</option>`;
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
		let kode_mc = $('#items option:selected').attr('data-kode_mc')
		let qty = $('#items option:selected').attr('data-qty')
		$("#idpodetail").val(idpodetail)
		$("#uk_box").html((item == "") ? '-' : ukuran)
		$("#uk_sheet").html((item == "") ? '-' : ukuran_sheet)
		$("#flute").html((item == "") ? '-' : flute)
		$("#substance").html((item == "") ? '-' : kualitas)
		$("#kode_mc").html((item == "") ? '-' : kode_mc)
		$("#qty_po").html((item == "") ? '-' : qty)
		// $("#no_so").val("").prop("disabled", true)
		soNoSo(item)
	})

	function soNoSo(item){
		// alert(item)
		let kdunik = $('#no_po option:selected').attr('data-kdunik')

		$("#btn-show-simpan").prop("disabled", true)
		$("#no_so").val("CEK NO SO . . .").prop("disabled", true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/soNoSo')?>',
			type: "POST",
			data: ({
				item
			}),
			success: function(json){
				data = JSON.parse(json)
				// console.log(data)
				if(data.data == null){
					no_so = ''
				}else{
					no_so = `${kdunik}-${data.data.kode_po}`
				}
				$("#no_so").val(no_so).prop("disabled", true)
				$("#btn-show-simpan").prop("disabled", false)
			}
		})
	}

	function addItems(){
		let nm_produk = $('#items option:selected').attr('data-nm_produk')
		let idpodetail = $("#idpodetail").val()
		let no_po = $("#no_po").val()
		let kode_po = $("#h_kode_po").val()
		let item = $("#items").val()
		let no_so = $("#no_so").val()
		let jml_so = $('#items option:selected').attr('data-qty')
		let rm = $('#items option:selected').attr('rm')
		let ton = $('#items option:selected').attr('ton')
		let idpelanggan = $('#no_po option:selected').attr('data-idpelanggan')

		$("#btn-show-simpan").prop("disabled", true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/addItems')?>',
			type: "POST",
			data: ({
				idpodetail, idpelanggan, nm_produk, no_po, kode_po, item, no_so, jml_so, rm, ton
			}),
			success: function(res){
				data = JSON.parse(res);
				// console.log(data)
				if(data.data){
					toastr.success("BERHASIL")
					$('#table-nopo').load("<?php echo base_url('Transaksi/showCartItem')?>")
				}else{
					swal(data.isi, "", "error")
				}
				$("#btn-show-simpan").prop("disabled", false)
			}
		})
	}

	function hapusCartItem(rowid, i, opsi){
		// alert(rowid)
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusCartItem')?>',
			type: "POST",
			data: ({
				rowid
			}),
			success: function(res){
				if(opsi == 'ListAddBagiSO'){
					$('#list-bagi-so-'+i).load("<?php echo base_url('Transaksi/ListAddBagiSO')?>")
				}else{
					$('#table-nopo').load("<?php echo base_url('Transaksi/showCartItem')?>")
				}
			}
		})
	}

	function simpan(){
		let vvvv = $("#table-nopo-value").val()
		let tgl_so = $("#tgl_so").val()
		
		if(vvvv === undefined){
			toastr.error('DATA KOSONG!');
			return
		}

		$("#btn-simpan").prop("disabled", true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/simpanSO')?>',
			type: "POST",
			data: ({
				tgl_so
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data) {
					swal("BERHASIL DISIMPAN!", "", "success")
					$("#modalForm").modal("hide");
					reloadTable();
				}else{
					swal("ADA YANG SALAH!", "", "error")
					$("#btn-simpan").prop("disabled", false);
				}
			}
		})
	}

	function tampilEditSO(id, no_po, kode_po, aksi){
		$("#h_id").val(id)
		$("#h_no_po").val(no_po)
		$("#h_kodepo").val(kode_po)
		let judul = `NO PO : <b>${no_po}</b> . KODE PO : <b>${kode_po}</b>`
		$("#judul-detail").html(`. . .`)
		$("#modal-detail-so").html(`. . .`)
		$("#modalFormDetail").modal("show");
		$("#table-nopo").load("<?php echo base_url('Transaksi/destroySO') ?>")

		$.ajax({
			url: '<?php echo base_url('Transaksi/detailSO')?>',
			type: "POST",
			data: ({
				id, no_po, kode_po, aksi
			}),
			success: function(res){
				$("#judul-detail").html(judul)
				$("#modal-detail-so").html(res)
			}
		})
	}

	function addBagiSO(i){
		// console.log(i)
		// $("#addBagiSO").prop('disabled', true)
		let htmlBagiSo = ''
		htmlBagiSo += `<table style="font-weight:bold;margin-top:10px">
			<tr>
				<td style="border:0">ETA SO</td>
				<td style="border:0">:</td>
				<td style="border:0"><input type="date" class="form-control" id="form-bagi-eta-so" value=""></td>
			</tr>
			<tr>
				<td style="border:0">QTY SO</td>
				<td style="border:0">:</td>
				<td style="border:0"><input type="number" class="form-control" id="form-bagi-qty-so" autocomplete="off" placeholder="QTY"></td>
			</tr>
			<tr>
				<td style="border:0">KETERANGAN</td>
				<td style="border:0">:</td>
				<td style="border:0"><textarea class="form-control" id="form-bagi-ket-so" rows="2" style="resize:none"></textarea></td>
			</tr>
			<tr>
				<td style="border:0" colspan="2"></td>
				<td style="border:0"><button type="button" class="btn btn-success btn-sm" id="btnAddBagiSO" onclick="btnAddBagiSO(${i})"><i class="fas fa-plus"></i> BAGI</button></td>
			</tr>
		</table>`
		$("#add-bagi-so-"+i).html(htmlBagiSo)
	}

	function btnAddBagiSO(i){
		let fBagiEtaSo = $("#form-bagi-eta-so").val()
		let fBagiQtySo = $("#form-bagi-qty-so").val()
		let fBagiKetSo = $("#form-bagi-ket-so").val()
		$("#btnAddBagiSO").prop('disabled', true)
		$("#hapusCartItemSO").prop('disabled', true)
		$("#simpanCartItemSO").prop('disabled', true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/btnAddBagiSO')?>',
			type: "POST",
			data: ({
				i, fBagiEtaSo, fBagiQtySo, fBagiKetSo
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					$("#form-bagi-eta-so").val("")
					$("#form-bagi-qty-so").val("")
					$("#form-bagi-ket-so").val("")
					$("#list-bagi-so-"+i).load("<?php echo base_url('Transaksi/ListAddBagiSO')?>")
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
				$("#btnAddBagiSO").prop('disabled', false)
				$("#hapusCartItemSO").prop('disabled', false)
				$("#simpanCartItemSO").prop('disabled', false)
			}
		})
	}

	function editBagiSO(i){
		// alert('edit so')
		let id = $("#h_id").val()
		let no_po = $("#h_no_po").val()
		let kode_po = $("#h_kodepo").val()

		let editTglSo = $("#edit-tgl-so"+i).val()
		let editQtySo = $("#edit-qty-so"+i).val()
		let editKetSo = $("#edit-ket-so"+i).val()
		let editQtypoSo = $("#edit-qtypo-so"+i).val()
		$("#editBagiSO"+i).prop('disabled', true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/editBagiSO')?>',
			type: "POST",
			data: ({
				i, editTglSo, editQtySo, editKetSo, editQtypoSo
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					swal("EDIT BERHASIL!", "", "success")
					tampilEditSO(id, no_po, kode_po, 'edit')
				}else{
					toastr.error(`<b>${data.msg}</b>`);
				}
				$("#editBagiSO"+i).prop('disabled', false)
			}
		})
	}

	function simpanCartItemSO(){
		// alert('simpanSO')
		let id = $("#h_id").val()
		let no_po = $("#h_no_po").val()
		let kode_po = $("#h_kodepo").val()

		$("#btnAddBagiSO").prop('disabled', true)
		$("#hapusCartItemSO").prop('disabled', true)
		$("#simpanCartItemSO").prop('disabled', true)
		$.ajax({
			url: '<?php echo base_url('Transaksi/simpanCartItemSO')?>',
			type: "POST",
			// data: ({}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data){
					swal("BERHASIL BAGI DATA SO!", "", "success")
					tampilEditSO(id, no_po, kode_po, 'edit')
				}else{
					toastr.error('Ada kesalahan!');
				}
				$("#btnAddBagiSO").prop('disabled', false)
				$("#hapusCartItemSO").prop('disabled', false)
				$("#simpanCartItemSO").prop('disabled', false)
			}
		})
	}

	function batalDataSO(i){
		// alert('batal: '+i)
		let id = $("#h_id").val()
		let no_po = $("#h_no_po").val()
		let kode_po = $("#h_kodepo").val()

		let cek = confirm("Apakah Anda Yakin?");
		if(cek){
			$.ajax({
				url: '<?php echo base_url('Transaksi/batalDataSO')?>',
				type: "POST",
				data: ({
					i
				}),
				success: function(res){
					data = JSON.parse(res)
					// console.log(data)
					if(data.data){
						swal(data.msg, "", "success")
						tampilEditSO(id, no_po, kode_po, 'edit')
					}
				}
			})
		}else{
			toastr.info('BATAL SO TIDAK JADI!')
		}
	}

</script>
