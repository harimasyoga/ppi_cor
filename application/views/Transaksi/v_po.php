<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><b>Data Transaksi</b> </h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= $judul ?></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if (!in_array($this->session->userdata('level'), ['Marketing','PPIC','Owner'])): ?>
					<button type="button" class="tambah_data btn  btn-outline-primary pull-right"><i class="fa fa-plus" ></i> <b>Tambah Data</b></button>
				<?php endif ?>
				<br><br>

				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th style="width:5%">No</th>
							<th>No PO</th>
							<th>Tgl PO</th>
							<th>Status</th>
							<th>Kode PO</th>
							<th>Total Qty</th>
							<th>ID Pelanggan</th>
							<th>Nama Pelanggan</th>
							<th>Approval</th>
							<th style="width:10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
				<form role="form" method="post" id="myForm">
					<div class="form-group row">
						<table width="100%" border="0">
							<tr>
								<td width="15%">No PO</td>
								<td>
									<input type="hidden" class="form-control" value="trs_po" name="jenis" id="jenis">
									<input type="hidden" class="form-control" value="" name="status" id="status">
									<input type="text" class="form-control" name="no_po" id="no_po" readonly>
								</td>
								<td width="15%"></td>
								<td width="15%">Nama Pelanggan</td>
								<td width="30%">
									<select class="form-control select2" name="id_pelanggan" id="id_pelanggan" style="width: 100%;">
										<option value="">Pilih</option>
										<?php foreach ($pelanggan as $r) : ?>
											<option value="<?= $r->id_pelanggan ?>" detail="<?= $r->kota . "|" . $r->no_telp . "|" . $r->fax . "|" . $r->top ?>">
												<?= $r->id_pelanggan . " | " . $r->nm_pelanggan ?>
											</option>
										<?php endforeach ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="15%">Tgl PO</td>
								<td><input type="date" class="form-control" name="tgl_po" id="tgl_po" value="<?= date('Y-m-d') ?>" readonly></td>
								<td width="15%"></td>
								<td width="15%" rowspan="2" style="padding-left: 20px;" valign="top">
									Kota <br>
									No Telepon <br>
									FAX <br>
									TOP
								</td>
								<td rowspan="2" valign="top">
									<font id="txt_kota"> </font> <br>
									<font id="txt_no_telp"> </font> <br>
									<font id="txt_fax"> </font> <br>
									<font id="txt_top"> </font> <br>
								</td>
							</tr>
							<tr>
								<td width="15%">Kode PO</td>
								<td>
									<input type="text" class="form-control" name="kode_po" id="kode_po">
								</td>
								<td width="15%"></td>
							</tr>
							<tr>
								<td width="15%">ETA</td>
								<td>
									<input type="date" class="form-control" name="eta" id="eta">
								</td>
								<td></td>
							</tr>
						</table>
					</div>

					<div class="form-group row">
						<table class="table" id="table-produk" style="width: 90%" align="center">
							<thead>
								<tr>
									<th width="10%">#</th>
									<th>Nama Produk</th>
									<th width="10%">Qty</th>
									<th width="15%">PPN</th>
									<?php if ($this->session->userdata('level') != "PPIC"): ?>
										
										<th width="10%">Price Include</th>
										<th width="10%">Price Exlude</th>

									<?php endif ?>
									<th width="50%">Detail Produk</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td><a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)"><i class="fa fa-trash"></i> </a></td>
									<td>
										<select class="form-control select2" name="id_produk[0]" id="id_produk0" style="width: 100%;" onchange="setDetailProduk(0)">
											<option value="">Pilih</option>
											<?php foreach ($produk as $r) : ?>
												<option value="<?= $r->kode_mc ?>" detail="<?= $r->kode_mc . "|" . $r->nm_produk . "|" . $r->ukuran . "|" . $r->material . "|" . $r->flute . "|" . $r->creasing . "|" . $r->warna ?>"><?= $r->kode_mc ?></option>
											<?php endforeach ?>
										</select>
									</td>
									<td>
										<input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0'>
									</td>
									<td>
										<select class="form-control" name="ppn[0]" id="ppn0">
											<option value="">Pilih</option>
											<option value="KB">KB</option>
											<option value="PP">PP</option>
											<option value="NP">NP</option>
										</select>
									</td>
									<?php if ($this->session->userdata('level') != "PPIC"): ?>
									<td>
										<input type="text" name="price_inc[0]" id="price_inc0" class="angka form-control" value='0'>
									</td>
									<td>
										<input type="text" name="price_exc[0]" id="price_exc0" class="angka form-control" value='0'>
									</td>
									<?php endif ?>
									<td id="txt_detail_produk0">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label"></label>
						<div class="col-sm-4">
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-outline-primary">Tambah Produk</button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
					</div>
			</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-success btn-verif" style="display: none;" onclick="prosesData('Y')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" class="btn btn-outline-danger btn-verif" style="display: none;" onclick="prosesData('R')"><i class="fas fa-times"></i> Reject</button>
						<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
						<button type="button" class="btn btn-outline-secondary" id="btn-print" onclick="Cetak()" style="display:none"><i class="fas fa-print"></i> Print</button>
					</div>
			</form>
			<input type="hidden" name="bucket" id="bucket" value="0">
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		load_data();
		getMax();
		$('.select2').select2();
	});

	status = "insert";
	$(".tambah_data").click(function(event) {
		kosong();
		$("#modalForm").modal("show");
		$("#judul").html('<h3> Form Tambah Data</h3>');
		status = "insert";
		$("#status").val("insert");
	});


	function load_data() {


		var table = $('#datatable').DataTable();

		table.destroy();

		tabel = $('#datatable').DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Transaksi/load_data/po',
				"type": "POST",
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
			},
			responsive: true,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function simpan() {
		id_pelanggan = $("#id_id_pelanggan" + i).val();
		kode_po = $("#kode_po" + i).val();
		eta = $("#eta" + i).val();

		if (id_pelanggan == '' || kode_po == '' || eta == '') {
			toastr.info('Harap Lengkapi Form');
			return;
		}

		arr_produk = [];
		for (var i = 0; i <= rowNum; i++) {

			produk = $("#id_produk" + i).val();
			qty = $("#qty" + i).val();

			if (produk == '' || qty == '' || qty == '0') {
				toastr.info('Harap Lengkapi Form');
				return;
			}

			arr_produk.push(produk);
		}

		let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)

		if (findDuplicates(arr_produk).length > 0) {
			toastr.info('Tidak boleh ada produk yang sama');
			return;
		}

		// console.log($('#myForm').serialize());

		$.ajax({
			url: '<?php echo base_url(); ?>Transaksi/insert',
			type: "POST",
			data: $('#myForm').serialize(),
			dataType: "JSON",
			success: function(data) {
				if (data) {
					toastr.success('Berhasil Disimpan');
					kosong();
					$("#modalForm").modal("hide");
				} else {
					toastr.error('Gagal Simpan');
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan');
			}
		});

	}

	function kosong(c = '') {
		$("#tgl_po").val("<?= date('Y-m-d') ?>");

		if (c != 's') {
			getMax();

		}
		$("#btn-print").hide();

		$("#id_pelanggan").select2("val", "");
		$('#id_pelanggan').val("").trigger('change');

		$("#kode_po").val("");
		$("#eta").val("");

		$("#txt_kota").html(": -");
		$("#txt_no_telp").html(": -");
		$("#txt_fax").html(": -");
		$("#txt_top").html(": -");

		clearRow();
		status = 'insert';
		$("#status").val(status);

		$("#btn-simpan").show();

		$(".btn-tambah-produk").show();
	}

	function btn_verif(data){
		
		$(".btn-verif").hide()


		if (data[0].status == 'Open') {
			if ('<?= $this->session->userdata('level') ?>' == 'Marketing' && data[0].status_app1 == 'N' ) {
				$(".btn-verif").show()
			}
			if ('<?= $this->session->userdata('level') ?>' == 'PPIC' && data[0].status_app1 == 'Y' && data[0].status_app2 == 'N' ) {
				$(".btn-verif").show()
			}
			if ('<?= $this->session->userdata('level') ?>' == 'Owner' && data[0].status_app1 == 'Y' && data[0].status_app2 == 'Y'  && data[0].status_app3 == 'N' ) {
				$(".btn-verif").show()
			}
		}
		

	}

	var no_po = ''
	function tampil_edit(id, act) {
		kosong('s');
		$(".btn-tambah-produk").hide();
		

		$("#btn-print").show();

		$("#status").val("update");
		status = 'update';
		$("#modalForm").modal("show");
		if (act == 'detail') {
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		} else {
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").show();
		}

		status = "update";

		$.ajax({
				url: '<?php echo base_url('Transaksi/get_edit'); ?>',
				type: 'POST',
				data: {
					id: id,
					jenis: "trs_po",
					field: 'id'
				},
				dataType: "JSON",
			})
			.done(function(data) {
				btn_verif(data)
				no_po = data[0].no_po

				$("#no_po").val(data[0].no_po);
				$("#tgl_po").val(data[0].tgl_po);
				$('#id_pelanggan').val(data[0].id_pelanggan).trigger('change');

				$("#kode_po").val(data[0].kode_po);
				$("#eta").val(data[0].eta);

				$("#txt_kota").html(": " + data[0].kota);
				$("#txt_no_telp").html(": " + data[0].no_telp);
				$("#txt_fax").html(": " + data[0].fax);
				$("#txt_top").html(": " + data[0].top);

				$.each(data, function(index, value) {
					$("#btn-hapus-" + index).hide();

					$('#id_produk' + index).val(value.kode_mc).trigger('change');
					$("#qty" + index).val(value.qty);
					$("#ppn" + index).val(value.ppn);
					$("#price_inc" + index).val(value.price_inc);
					$("#price_exc" + index).val(value.price_exc);

					if (act == 'detail') {
						$("#qty" + index).prop("disabled", true);
						$("#id_produk" + index).prop("disabled", true);
						$("#ppn" + index).prop("disabled", true);
						$("#price_inc" + index).prop("disabled", true);
						$("#price_exc" + index).prop("disabled", true);
					} else {
						$("#qty" + index).prop("disabled", false);
						$("#id_produk" + index).prop("disabled", false);
						$("#ppn" + index).prop("disabled", false);
						$("#price_inc" + index).prop("disabled", false);
						$("#price_exc" + index).prop("disabled", false);
					}

					if (index != (data.length) - 1) {
						addRow();
					}
					// console.log(index, data.length);
				});
			})
	}

	function getMax() {
		$.ajax({
			url: '<?php echo base_url('Transaksi/getMax'); ?>',
			type: 'POST',
			data: {
				table: "trs_po",
				fieald: 'no_po'
			},
			dataType: "JSON",
			success: function(data) {
				$("#no_po").val("PO-" + data.tahun + "-" + "000000" + data.no);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan');
			}
		});

	}

	function deleteData(id) {
		let cek = confirm("Apakah Anda Yakin?");

		if (cek) {
			$.ajax({
				url: '<?php echo base_url(); ?>Transaksi/hapus',
				data: ({
					id: id,
					jenis: 'trs_po',
					field: 'no_po'
				}),
				type: "POST",
				success: function(data) {
					toastr.success('Data Berhasil Di Hapus');
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					toastr.error('Terjadi Kesalahan');
				}
			});
		}


	}

	function prosesData(tipe) {
		let cek = confirm("Apakah Anda Yakin?");

		if (cek) {
			$.ajax({
				url: '<?php echo base_url(); ?>Transaksi/prosesData',
				data: ({
					id: no_po,
					status: tipe,
					jenis: 'verifPO'
				}),
				type: "POST",
				success: function(data) {
					toastr.success('Data Berhasil Diproses');
					reloadTable();
					$("#modalForm").modal("hide");
				},
				error: function(jqXHR, textStatus, errorThrown) {
					toastr.error('Terjadi Kesalahan');
				}
			});
		}


	}

	$("#id_pelanggan").change(function() {
		if ($("#id_pelanggan").val() == "") {
			return;
		}

		arr_detail = $('#id_pelanggan option:selected').attr('detail');

		if (typeof arr_detail === 'undefined') {
			return;
		}

		arr_detail = arr_detail.split("|");
		// console.log(arr_detail);

		$("#txt_kota").html(": " + arr_detail[0]);
		$("#txt_no_telp").html(": " + arr_detail[1]);
		$("#txt_fax").html(": " + arr_detail[2]);
		$("#txt_top").html(": " + arr_detail[3]);

	});

	function setDetailProduk(e) {
		if ($("#id_produk" + e).val() == "") {
			return;
		}

		arr_detail = $('#id_produk' + e + ' option:selected').attr('detail');

		if (typeof arr_detail === 'undefined') {
			return;
		}

		arr_detail = arr_detail.split("|");
		// console.log(arr_detail);

		$("#txt_detail_produk" + e).html(
			'<table width="100%" style="font-size:12px">' +
			'<tr>' +
			'<td>' +
			'<ul>' +
			'<li>Nama Produk : ' + arr_detail[1] + '</li>' +
			'<li>Ukuran : ' + arr_detail[2] + '</li>' +
			'<li>Material : ' + arr_detail[3] + '</li>' +
			'</ul>' +
			'</td>' +
			'<td>' +
			'<ul>' +
			'<li>Flute : ' + arr_detail[4] + '</li>' +
			'<li>Creasing : ' + arr_detail[5] + '</li>' +
			'<li>Warna : ' + arr_detail[6] + '</li>' +
			'</ul>' +
			'</td>' +
			'<tr>' +
			'</table>'
		);
	}

	var rowNum = 0;

	function addRow() {
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var s = $('#qty' + b).val();
		var ppn = $('#ppn' + b).val();
		var price_inc = $('#price_inc' + b).val();
		var price_exc = $('#price_exc' + b).val();
		var ss = $('#id_produk' + b).val();

			
		if (s != '0' && s != '' && ss != '' && ppn != '' && price_inc != '' && price_exc != '' && price_inc != '0' && price_exc != '0') {
			$('#removeRow').show();
			rowNum++;
			if (rowNum <= 4) {
				var x = rowNum + 1;

				td_harga = ''

				if ('<?= $this->session->userdata('level') ?>' != 'PPIC') {
					td_harga = `
						<td>
						 <input type="text" name="price_inc[${rowNum}]" id="price_inc${rowNum}"  class="angka form-control" value="0" >' +
						</td>
						<td>
						 <input type="text" name="price_exc[${rowNum}]" id="price_exc${rowNum}"  class="angka form-control" value="0" >' +
						</td>
					`
				}


				$('#table-produk').append(
					'<tr id="itemRow' + rowNum + '">' +
					'<td><a class="btn btn-danger"  id="btn-hapus-' + rowNum + '" onclick="removeRow(' + rowNum + ')"><i class="fa fa-trash"></i> </a></td>' +
					'<td>' +
					'<select class="form-control select2" name="id_produk[' + rowNum + ']" id="id_produk' + rowNum + '" style="width: 100%;" onchange="setDetailProduk(' + rowNum + ')">' +
					'<option value="">Pilih</option>' +
					'<?php foreach ($produk as $r) : ?>' +
					'<option value="<?= $r->kode_mc ?>" detail="<?= $r->kode_mc . "|" . $r->nm_produk . "|" . $r->ukuran . "|" . $r->material . "|" . $r->flute . "|" . $r->creasing . "|" . $r->warna ?>"><?= $r->kode_mc ?></option>' +
					'<?php endforeach ?>' +
					'</select>' +
					'</td>' +
					'<td>' +
					' <input type="text" name="qty[' + rowNum + ']" id="qty' + rowNum + '"  class="angka form-control" value="0" >' +
					'</td>' +
					'<td>' +
					'<select class="form-control" name="ppn[' + rowNum + ']" id="ppn' + rowNum + '">' +
					'<option value="">Pilih</option>' +
					'<option value="KB">KB</option>' +
					'<option value="PP">PP</option>' +
					'<option value="NP">NP</option>' +
					'</select>' +
					'</td>' +
					
					td_harga
					+
					'<td id="txt_detail_produk' + rowNum + '">' +
					'</td>' +
					'</tr>)');
				$('#bucket').val(rowNum);
				$('#qty' + rowNum).focus();
			} else {
				toastr.info('Maksimal 5 Produk');
			}
		} else {
			toastr.info('Isi form diatas terlebih dahulu');
		}
	}

	function removeRow(e) {
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		} else {
			toastr.error('Baris pertama tidak bisa dihapus');
			return;
		}
		$('#bucket').val(rowNum);
	}

	function clearRow() {
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}

		$('#removeRow').hide();
		$('#bucket').val(rowNum);
		$('#id_produk0').val('').trigger('change');
		$('#qty0').val('0');
		$('#txt_detail_produk0').html('');
		$("#btn-hapus-0").show();

		$("#qty0").prop("disabled", false);
		$("#id_produk0").prop("disabled", false);
	}

	function Cetak() {
		no_po = $("#no_po").val();
		var url = "<?php echo base_url('Transaksi/Cetak_PO'); ?>";
		window.open(url + '?no_po=' + no_po, '_blank');
	}
</script>
