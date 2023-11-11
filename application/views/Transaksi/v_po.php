<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
					<!-- <h1><b>Data Transaksi</b> </h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card shadow mb-3">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if (!in_array($this->session->userdata('level'), ['Marketing','PPIC','Owner'])): ?>
					<button type="button" style="font-family:Cambria;" class="tambah_data btn  btn-info "><i class="fa fa-plus" ></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
				<?php endif ?>
				<br><br>

				<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
					<thead>
						<tr>
							<th style="text-align: center; width:3%">No</th>
							<th style="text-align: center; width:15%">No PO</th>
							<th style="text-align: center; width:17%">Tgl PO</th>
							<th style="text-align: center; width:5%">Status</th>
							<th style="text-align: center; width:10%">Kode PO</th>
							<!-- <th style="text-align: center">Total Qty</th> -->
							<th style="text-align: center; width:15%">Customer</th>
							<th style="text-align: center; width:5%">Mkt</th>
							<th style="text-align: center; width:5%">PPIC</th>
							<th style="text-align: center; width:5%">Owner</th>
							<th style="text-align: center; width:20%;">Aksi</th>
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
	<div class="modal-dialog modal-full">
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
						<table width="95%" border="0">
							<tr>
								<td width="15%">No PO</td>
								<td>
									<input type="hidden" class="form-control" value="trs_po" name="jenis" id="jenis">
									<input type="hidden" class="form-control" value="" name="status" id="status">
									<input type="text" class="form-control" name="no_po" id="no_po" value="AUTO" readonly>
								</td>
								<td width="15%"></td>
								<td width="15%">Nama Pelanggan</td>
								<td width="30%">
									<select class="form-control select2" name="id_pelanggan" id="id_pelanggan" style="width: 100%;" onchange="setProduk('new',this.value,0)">
										<!-- <option value="">Pilih</option> -->
										<?php foreach ($pelanggan as $r) : ?>
											<option value="<?= $r->id_pelanggan ?>" detail="
											<?=$r->kab_name."|".$r->no_telp . "|" . $r->fax . "|" . $r->top . "|" . $r->nm_sales ?>">
												<?= $r->id_pelanggan . "|" . $r->nm_pelanggan ?>
											</option>
										<?php endforeach ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="15%">Tgl PO</td>
								<td><input type="date" class="form-control" name="tgl_po" id="tgl_po" value="<?= date('Y-m-d') ?>" readonly></td>
								<td width="15%"></td>
								<td width="15%">
									Kota
								</td>
								<td>
									<!-- <font id=""></font> -->
									<input type="text" class="form-control" name="txt_kota" id="txt_kota" value="" readonly>
								</td>
							</tr>
							<tr>
								<td width="15%">Kode PO</td>
								<td>
									<input type="text" class="form-control" name="kode_po" id="kode_po" onchange="cek_kode_po(this.value)" oninput="this.value = this.value.toUpperCase(), this.value = this.value.trim(); " >
								</td>
								<td width="15%"></td>
								<td width="15%">
									No Telepon 
								</td>
								<td>
									<input type="text" class="form-control" name="txt_no_telp" id="txt_no_telp" value="" readonly>
								</td>
								
							</tr>
							<tr>
								<td width="15%">ETA</td>
								<td>
									<input type="date" class="form-control" name="eta" id="eta" value="" >
								</td>
								<td width="15%"></td>
								<td width="15%">
									FAX
								</td>
								<td>
									<input type="text" class="form-control" name="txt_fax" id="txt_fax" value="" readonly>
								</td>
							</tr>
							<tr>
							<td width="15%">Marketing</td>
								<td>
									<!-- <select class="form-control select2" name="id_sales" id="id_sales" style="width: 100%;" >
										<option value="">Pilih</option>
										<?php foreach ($sales as $r) : ?>
											<option value="<?= $r->id_sales ?>">
												<?= $r->nm_sales ?>
											</option>
										<?php endforeach ?>
									</select> -->
									<!-- <font id="txt_marketing"></font> -->
									<input type="text" class="form-control" name="txt_marketing" id="txt_marketing" value="" readonly>
								</td>
								<td width="15%"></td>
								<td width="15%">
									TOP
								</td>
								<td>
									<input type="text" class="form-control" name="txt_top" id="txt_top" value="" readonly>
								</td>
							</tr>
						</table>
					</div>
					<hr>

					<div class="form-group row">
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table-produk" style="width: 100%" align="center">
							<thead class="color-tabel">
								<tr>
									<th width="10%" id="header_del">Delete</th>
									<th width="10%">Item</th>
									<th width="10%">Qty</th>
									<th width="10%">PPN</th>

									<?php if ($this->session->userdata('level') != "PPIC"): ?>
										
										<th width="10%">Price Exclude</th>
										<th width="10%">Price Include</th>

									<?php endif ?>

									<?php if ($this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "Owner")  {
										?>
										
											<th width="10%" id="header_p11" >P11</th>
										
									<?php } else { ?>

											<th type="hidden" width="10%" id="header_p11" >P11</th>

									<?php } ?>
									<th width="20%">Detail Item</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td id="detail-hapus-0">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)"><i class="far fa-trash-alt" style="color:#fff"></i> </a>
										</div>
									</td>
									<td>
										<select class="form-control select2 narrow wrap wrap" name="id_produk[0]" id="id_produk0" style="width: 100%;" onchange="setDetailProduk(this.value,0)">
										</select>
									</td>
									<td>
										<input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0'  onchange="Hitung_rm(this.value,this.id)">
									</td>
									<td>
										<select class="form-control select2" name="ppn[0]" id="ppn0" >
											<option value="">-- Pilih --</option>
											<!-- <option value="KB">KB</option> -->
											<option value="PP">PP</option>
											<option value="NP">NP</option>
										</select>
									</td>
									<?php if ($this->session->userdata('level') != "PPIC"): ?>
									
									<td>
										<input type="text" name="price_exc[0]" id="price_exc0" class="angka form-control" onkeyup="Hitung_price(this.value,this.id)" onchange="hitung_p11(this.value,this.id)" value='0'>

										<input class="form-control input-border-none" type="text" name="price_exc_rp[0]" id="price_exc_rp0" style="color:red" readonly>
									</td>
									<td>
										<input type="text" name="price_inc[0]" id="price_inc0" class="angka form-control" onkeyup="Hitung_price(this.value,this.id)" onchange="hitung_p11(this.value,this.id)" value='0'>

										<input class="form-control input-border-none" type="text" name="price_inc_rp[0]" id="price_inc_rp0" style="color:red">
									</td>
									<?php endif ?>

										<td id="p11_det0">
											<input type="text" name="p11[0]" id="p110"  class="angka form-control" readonly value="0" >
										
										</td>

									
									<td id="txt_detail_produk0">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-group row" style="justify-content: left; ">
						<!-- <label class="col-sm-2 col-form-label"></label> -->
						<div class="col-sm-4">
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i> Tambah Produk</b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
					</div>
			</div>
					<div class="modal-footer">

						<button type="button" class="btn btn-outline-success btn-verif" style="display: none;" onclick="prosesData('Y')"><i class="fas fa-check"></i> Verifikasi</button>

						<button type="button" class="btn btn-outline-danger btn-verif" style="display: none;" onclick="prosesData('R')"><i class="fas fa-times"></i> Reject</button>

						<button type="button" class="btn btn-outline-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i><b> Simpan</b></button>

						<button type="button" class="btn btn-outline-danger" id="btn-print" onclick="Cetak()" style="display:none"><i class="fas fa-print"></i> Print</button>

						<button type="button" class="btn btn-outline-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-times-circle"></i> <b> Batal</b></button>
					</div>
			</form>
			<input type="hidden" name="bucket" id="bucket" value="0">
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- modal keterangan -->
<div class="modal fade" id="modalket">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="color:green" id="judul2"></h4>
			</div>
			<div class="modal-body">
				<table border="0">
					<tr>
						<td width="35%" ><h3>No PO</h3></td>
						<td width="10%" ><h3> : </h3></td>
						<td width="55%"  id="nopo_ket"></td>
					</tr>
					<tr>
						<td><h3>Tanggal Verifikasi</h3></td>
						<td><h3> : </h3></td>
						<td id="tgl_ket"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- end modal keterangan -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		load_data();
		// getMax();
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";
	$(".tambah_data").click(function(event) 
	{
		kosong();
		$("#modalForm").modal("show");
		$("#judul").html('<h3> Form Tambah Data</h3>');
		status = "insert";
		$("#status").val("insert");
		$("#id_produk0").val("").prop("disabled", true).html(`<option value="">-- Pilih --</option>`);
	});

	function close_modal(){
		$('#modalForm').modal('hide');
	}

	function setProduk(cek,pelanggan,id) 
	{
		if(cek=='new'){
			clearRow();
		}
		if (status == 'insert' ){

			$("#id_produk"+id).val("").prop("disabled", false);
			if (pelanggan!=''){
				option = "";
				$.ajax({
					type: 'POST',
					url: "<?= base_url(); ?>Transaksi/load_produk",
					data: { idp: pelanggan, kd: '' },
					dataType: 'json',
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
					success:function(data){			
						if(data.message == "Success"){						
							option = "<option>-- Pilih --</option>";
							$.each(data.data, function(index, val) {
							option += "<option value='"+val.id_produk+"'>"+val.nm_produk+"</option>";
							});
		
							$('#id_produk'+id).html(option);
							swal.close();
						}else{	
							option += "<option value=''></option>";
							$('#id_produk'+id).html(option);						
							$("#txt_detail_produk"+id).html("");	
							swal.close();
						}
					}
				});
			}
		}
		
	}

	function load_data() 
	{


		var table = $('#datatable').DataTable();

		table.destroy();

		tabel = $('#datatable').DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?= base_url(); ?>Transaksi/load_data/po',
				"type": "POST",
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"] // change per page values here
			],		

			responsive: true,
			"pageLength": 5,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function simpan() 
	{
		// show_loading();
		swal({
			title: 'loading ...',
			allowEscapeKey    : false,
			allowOutsideClick : false,
			onOpen: () => {
				swal.showLoading();
			} 
		})
		id_pelanggan    = $("#id_id_pelanggan").val();
		kode_po         = $("#kode_po").val();
		eta             = $("#eta").val();
		sales           = $("#id_sales").val();

		if (id_pelanggan == '' || kode_po == '' || eta == '' || eta == 'undefined' || sales=='' ) {
			// toastr.info('Harap Lengkapi Form');
			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			// close_loading();
			return;
		}

		arr_produk = [];
		for (var i = 0; i <= rowNum; i++) {

			produk   = $("#id_produk" + i).val();
			qty      = $("#qty" + i).val();
			p11      = $("#p11" + i).val();

			if (produk == '' || qty == '' || qty == '0') {
				// toastr.info('Harap Lengkapi Form');
				// return;
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Harap Lengkapi Form Dahulu",
					type                : "info",
					confirmButtonText   : "OK"
				});
				// close_loading();
				return;
			}

			arr_produk.push(produk);
		}
		let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)

		if (findDuplicates(arr_produk).length > 0) {
			// toastr.info('Tidak boleh ada produk yang sama');
			// return;
			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Tidak boleh ada produk yang sama",
				type                : "info",
				confirmButtonText   : "OK"
			});
			// close_loading();
			return;
		}

		// console.log($('#myForm').serialize());

		$.ajax({
			url        : '<?= base_url(); ?>Transaksi/insert',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if (data) {
					// toastr.success('Berhasil Disimpan');
					swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					// close_loading();
					kosong();
					$("#modalForm").modal("hide");
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					// close_loading();
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				// close_loading();
				return;
			}
		});

	}

	function kosong(c = '') 
	{
		$("#tgl_po").val("<?= date('Y-m-d') ?>");

		if (c != 's') {
			// getMax();

		}
		$("#btn-print").hide();

		$("#id_pelanggan").select2("val", "");
		$('#id_pelanggan').val("").trigger('change');

		$("#kode_po").val("");
		$("#eta").val("");

		$("#txt_kota").val("");
		$("#txt_no_telp").val("");
		$("#txt_fax").val("");
		$("#txt_top").val("");
		$("#txt_marketing").val("");

		clearRow();
		status = 'insert';
		$("#status").val(status);

		$("#btn-simpan").show();

		$(".btn-tambah-produk").show();
		$('#removeRow').show();
		$("#header_del").show();
	}

	function btn_verif(data)
	{
		
		$(".btn-verif").hide()

		if (data[0].status == 'Open') {
			if ('<?= $this->session->userdata('level') ?>' == 'Admin'){
				$(".btn-verif").show()
			}

			if ('<?= $this->session->userdata('level') ?>' == 'Marketing' && data[0].status_app1 == 'N' ) 
			{
				$(".btn-verif").show()
			}

			if ('<?= $this->session->userdata('level') ?>' == 'PPIC' && data[0].status_app1 == 'Y' && data[0].status_app2 == 'N' ) 
			{
				$(".btn-verif").show()
			}

			if ('<?= $this->session->userdata('level') ?>' == 'Owner' && data[0].status_app1 == 'Y' && data[0].status_app2 == 'Y'  && data[0].status_app3 == 'N' ) 
			{
				$(".btn-verif").show()
			}
		}
		

	}

	var no_po = ''

	function tampil_edit(id, act) 
	{
		// kosong('s');
		kosong();
		var cek = '<?= $this->session->userdata('level') ?>';
		$(".btn-tambah-produk").hide();
		$("#btn-print").show();
		$("#status").val("update");
		status    = 'update';

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
				url: '<?= base_url('Transaksi/get_edit'); ?>',
				type: 'POST',
				data: {
					id       : id,
					jenis    : "trs_po",
					field    : 'id'
				},
				dataType: "JSON",
			})
			.done(function(data) {
				
				btn_verif(data)
				no_po = data[0].no_po

				$("#no_po").val(data[0].no_po);
				$("#tgl_po").val(data[0].tgl_po);
				$('#id_pelanggan').val(data[0].id_pelanggan).trigger('change');

				kodepo    = (data[0].kode_po == '' ) ? '-' : data[0].kode_po ;
				eta       = (data[0].eta == '' ) ? '-' : data[0].eta ;
				
				$("#kode_po").val(kodepo);
				$("#eta").val(eta); 
				
				$("#header_del").hide();

				if (cek == 'Admin' || cek == 'Owner')
				{
					$("#header_p11").show();
				}else{
					$("#header_p11").hide();
				}

				$.each(data, function(index, value) {
					$("#detail-hapus-0").hide();
					$("#detail-hapus-"+index).hide();
					$("#btn-hapus-"+index).hide();

					if (cek == 'Admin' || cek == 'Owner')
					{
						$("#p11_det"+index).show();
					}else{
						$("#p11_det"+index).hide();
					}
					
					
					var opt_produk = $("<option selected></option>").val(value.id_produk).text(value.nm_produk);

					var opt_ppn = $("<option selected></option>").val(value.ppn).text(value.ppn);
					
					$('#id_produk'+index).append(opt_produk).trigger('change');
					$("#qty"+index).val(value.qty);
					$('#ppn'+index).append(opt_ppn).trigger('change');
					// $("#ppn"+index).val(value.ppn);
					$("#price_inc"+index).val(value.price_inc);
					$("#price_exc"+index).val(value.price_exc);
					
					$('#price_exc_rp'+index).val(format_angka(value.price_exc));
					$('#price_inc_rp'+index).val(format_angka(value.price_inc));
					
					$("#p11"+index).val(value.p11);

					if (act == 'detail') {
						$("#qty"+index).prop("disabled", true);
						$("#id_produk"+index).prop("disabled", true);
						$("#ppn"+index).prop("disabled", true);
						$("#price_inc"+index).prop("disabled", true);
						$("#price_exc"+index).prop("disabled", true);
					} else {
						$("#qty"+index).prop("disabled", false);
						$("#id_produk"+index).prop("disabled", false);
						$("#ppn"+index).prop("disabled", false);
						$("#price_inc"+index).prop("disabled", false);
						$("#price_exc"+index).prop("disabled", false);
					}
					
					if (index != (data.length) - 1) {
						addRow();
					}
					// console.log(index, data.length);
				});
			})
	}

	function getMax() 
	{
		$.ajax({
			url: '<?= base_url('Transaksi/getMax'); ?>',
			type: 'POST',
			data: {
				table: "trs_po",
				fieald: 'no_po'
			},
			dataType: "JSON",
			success: function(data) {
				$("#no_po").val("PO/" + data.tahun + "/" + data.bln + "/" + data.no);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				return;
			}
		});

	}

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "PO",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no+ " </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url: '<?= base_url(); ?>Transaksi/hapus',
				data: ({
					id: id,
					jenis: 'trs_po',
					field: 'no_po'
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
					// toastr.success('Data Berhasil Di Hapus');
					swal({
						title               : "Data",
						html                : "Data Berhasil Di Hapus",
						type                : "success",
						confirmButtonText   : "OK"
					});
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}

	function data_sementara(data,tgl,nopo){
		$("#modalket").modal("show");
		$("#judul2").html('<b>'+data+'</b>');
		$("#nopo_ket").html('<h3><b>'+nopo+'</b></h3>');
		$("#tgl_ket").html('<h3><b>'+tgl+'</b></h3>');
	}

	function prosesData(tipe) 
	{
		// let cek = confirm("Apakah Anda Yakin?");

		swal({
            //title: 'PENDAFTARAN',
            text                : "Alasan di Reject : ",
            type                : 'info',
            input               : 'text',
            showCancelButton    : true,			
			confirmButtonClass : 'btn btn-danger',
			cancelButtonClass  : 'btn btn-secondary',
			confirmButtonColor  : '#d33',
			cancelButtonColor  : '#d33',
            confirmButtonText   : '<b> Reject </b>',
            cancelButtonText    : '<b> Batal </b>'
        }).then(function(alasan) {

				$.ajax({
					url: '<?= base_url(); ?>Transaksi/prosesData',
					data: ({
						id: no_po,
						status: tipe,
						jenis: 'verifPO'
					}),
					type: "POST",
					success: function(data) {
						// toastr.success('Data Berhasil Diproses');
						swal({
							title               : "Data",
							html                : "Data Berhasil Diproses",
							type                : "success",
							confirmButtonText   : "OK"
						});
						reloadTable();
						$("#modalForm").modal("hide");
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// toastr.error('Terjadi Kesalahan');
						swal({
							title               : "Cek Kembali",
							html                : "Terjadi Kesalahan",
							type                : "error",
							confirmButtonText   : "OK"
						});
						return;
					}
				});
		
		});


	}

	$("#id_pelanggan").change(function() 
	{
		if ($("#id_pelanggan").val() == "") {
			return;
		}

		arr_detail = $('#id_pelanggan option:selected').attr('detail');

		if (typeof arr_detail === 'undefined') {
			return;
		}

		arr_detail = arr_detail.split("|");
		// console.log(arr_detail);

		// var kab_name  = (arr_detail[0] == '' ) ? '-' : arr_detail[0] ;
		var kab_name  = (arr_detail[0] == '' || arr_detail[0] == null ) ? '-' : arr_detail[0].trim() ;
		var telp      = (arr_detail[1] == '' ) ? '-' : arr_detail[1] ;
		var fax       = (arr_detail[2] == '' || arr_detail[2] == null ) ? '-' : arr_detail[2] ;
		var top       = (arr_detail[3] == '' || arr_detail[3] == null ) ? '-' : arr_detail[3] ;
		var sales     = (arr_detail[4] == '' || arr_detail[4] == null ) ? '-' : arr_detail[4] ;
		
		$("#txt_kota").val(kab_name);
		$("#txt_no_telp").val(telp);
		$("#txt_fax").val(fax);
		$("#txt_top").val(top);
		$("#txt_marketing").val(sales);

	});

	function setDetailProduk(kd,id) 
	{
		// if ($("#id_produk" + e).val() == "") {
		// 	return;
		// }

		// arr_detail = $('#id_produk' + e + ' option:selected').attr('detail');

		// if (typeof arr_detail === 'undefined') {
		// 	return;
		// }

		// arr_detail = arr_detail.split("|");
		// // console.log(arr_detail);
		if(kd!=''){
			// show_loading();
			html_produk="";
			$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Transaksi/load_produk_1",
				data        : { idp: '', kd: kd },
				dataType    : 'json',
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
				success:function(val){			
							
						(val.kategori =='K_BOX')? uk = val.ukuran : uk = val.ukuran_sheet;

						html_produk = `
						<table class='table' border='0' style='font-size:12px'>
						<tr> 
							<tr> 
								<td style=list-style:none;><b>Nama Item : </b>${ val.nm_produk }</td>
								<td style=list-style:none;><b>Ukuran : </b>${ uk }</td>
								<td style=list-style:none;><b>Kualitas : </b>${ val.kualitas }</td>
							</tr>
							<tr> 
								<td style=list-style:none;><b>Flute : </b>${ val.flute }</td> 
								<td style=list-style:none;><b>Creasing : </b>${ val.creasing }-${ val.creasing2 }-${ val.creasing3 }</td> 
								<td style=list-style:none;><b>Toleransi : </b>${ val.toleransi_kirim }</td> 
							</tr> 
							<tr> 
								<td style=list-style:none;><b>RM : <input type="text" class="input-border-none" name="rm[${id}]" id="rm${id}" readonly >
								</b>
								</td> 

								<td style=list-style:none;><b>BB : <input type="text" class="input-border-none" name="bb[${id}]" id="bb${id}" value="${val.berat_bersih}" readonly ></b>
								</td> 

								<td style=list-style:none;><b>Ton : <input type="text" class="input-border-none" name="ton[${id}]" id="ton${id}" readonly >
								</b></td>  
							</tr> 
							<tr> 
								<td colspan="3" style=list-style:none;>
									<b>Harga / Kg : 
									</b>
									<input type="text" class="input-border-none" name="hrg_kg[${id}]" id="hrg_kg${id}" readonly >
								</td> 
							</tr> 
						<tr> </table>`;

						if(status=='update'){
							
							var inc= $('#price_inc'+id).val();
							var qty= $('#qty'+id).val();

							hitung_p11(inc,'price_inc'+id);
							Hitung_rm(qty,'qty'+id);
						}
	
						$('#txt_detail_produk'+id).html(html_produk);	
						// close_loading();
						swal.close();
					
				}
			});
		}

	}

	var rowNum = 0;

	function addRow() 
	{

		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var s           = $('#qty' + b).val();
		var ppn         = $('#ppn' + b).val();
		var price_inc   = $('#price_inc' + b).val();
		var price_exc   = $('#price_exc' + b).val();
		var p11         = $('#p11' + b).val();
		var ss          = $('#id_produk' + b).val();
		var user_lev    = "<?= $this->session->userdata('level') ?>";

		var idp         = $('#id_pelanggan').val();
		setProduk('addrow',idp,rowNum+1);
			
		if (s != '0' && s != '' && ss != '' && ppn != '' && price_inc != '' && price_exc != '' && price_inc != '0' && price_exc != '0') {
			$('#removeRow').show();
			rowNum++;
			if (rowNum <= 4) {
				var x = rowNum + 1;

				td_harga = ''

				if ('<?= $this->session->userdata('level') ?>' != 'PPIC') {
					td_harga = `
						<td>
							<input type="text" name="price_exc[${rowNum}]" id="price_exc${rowNum}"  class="angka form-control" onkeyup="Hitung_price(this.value,this.id)" onchange="hitung_p11(this.value,this.id)" value="0" >

							<input class="form-control input-border-none" type="text" name="price_exc_rp[${rowNum}]" id="price_exc_rp${rowNum}" style="color:red" readonly>
						 
						</td>
						<td>
							<input type="text" name="price_inc[${rowNum}]" id="price_inc${rowNum}"  class="angka form-control" onkeyup="Hitung_price(this.value,this.id)" onchange="hitung_p11(this.value,this.id)" value="0" >

							<input class="form-control input-border-none" type="text" name="price_inc_rp[${rowNum}]" id="price_inc_rp${rowNum}" style="color:red">
						</td>
					`
				}

				// if (user_lev == 'Owner' || user_lev == 'Admin') 
				// {
					p11_tambahan = `
						<td id="p11_det${rowNum}">
							<input type="text" name="p11[${rowNum}]" id="p11${rowNum}"  class="angka form-control" readonly value="0">
						 
						</td>
					`;
				// }else{
				// 	p11_tambahan = ``;
				// }
				

				$('#table-produk').append(
					`<tr id="itemRow${ rowNum }">
					<td id="detail-hapus-${ rowNum }">
						<div class="text-center">
						<a class="btn btn-danger"  id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })"><i class="far fa-trash-alt" style="color:#fff"></i> </a>
						</div>
					</td>
					<td>
						<select class="form-control select2" name="id_produk[${ rowNum }]" id="id_produk${ rowNum }" style="width: 100%;" onchange="setDetailProduk(this.value,${ rowNum })">
						</select>
					</td>
					<td>
						 <input type="text" name="qty[${ rowNum }]" id="qty${ rowNum }"  class="angka form-control" value="0" onchange="Hitung_rm(this.value,this.id)">

					</td>

					<td>
						<select class="form-control select2" name="ppn[${ rowNum }]" id="ppn${ rowNum }">
							<option value="PP">PP</option>
							<option value="NP">NP</option>
						</select>
					</td>
					${ td_harga }
					${ p11_tambahan }
					<td id="txt_detail_produk${ rowNum }"> 
					</td>
					</tr>)`);
				$('.select2').select2({
					placeholder: '--- Pilih ---',
					dropdownAutoWidth: true
				});
				$('#bucket').val(rowNum);
				$('#qty' + rowNum).focus();
			} else {
				// toastr.info('Maksimal 5 Produk');
				swal({
						title               : "Cek Kembali",
						html                : "Maksimal 5 Produk",
						type                : "info",
						confirmButtonText   : "OK"
					});
				return;
			}
		} else {
			// toastr.info('Isi form diatas terlebih dahulu');
			// return;
			swal({
					title               : "Cek Kembali",
					html                : "Isi form diatas terlebih dahulu",
					type                : "info",
					confirmButtonText   : "OK"
				});
			return;
		}
	}

	function removeRow(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		} else {
			// toastr.error('Baris pertama tidak bisa dihapus');
			// return;

			swal({
					title               : "Cek Kembali",
					html                : "Baris pertama tidak bisa dihapus",
					type                : "error",
					confirmButtonText   : "OK"
				});
			return;
		}
		$('#bucket').val(rowNum);
	}

	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}

		$('#removeRow').hide();
		$('#bucket').val(rowNum);
		$('#id_produk0').val('').trigger('change');
		$('#qty0').val('0');
		$('#p110').val('0');
		$('#price_inc0').val('0');
		$('#price_exc0').val('0');
		$('#price_exc_rp0').val('0');
		$('#price_inc_rp0').val('0');
		$('#txt_detail_produk0').html('');
		$("#btn-hapus-0").show();
		$("#detail-hapus-0").show();
		$("#p11_det0").show();

		$("#qty0").prop("disabled", false);
		$("#id_produk0").prop("disabled", false);
		$("#price_inc0").prop("disabled", false);
		$("#price_exc0").prop("disabled", false);		
		$("#ppn0").prop("disabled", false);
	}

	function Hitung_price(val,id) 
	{
		var cek = id.substr(0,9);
		var id2 = id.substr(9,1);
		
		if(cek=='price_exc')
		{
			inc = Math.trunc(val *1.11);
			$('#price_inc'+id2).val(inc);

			$('#price_exc_rp'+id2).val(format_angka(val));
			$('#price_inc_rp'+id2).val(format_angka(inc));
		}else {
			exc = Math.trunc(val /1.11);
			$('#price_exc'+id2).val(exc);

			$('#price_exc_rp'+id2).val(format_angka(exc));
			$('#price_inc_rp'+id2).val(format_angka(val));
		}
	}


	function hitung_p11(val,id)
	{		
		
		var cek = id.substr(0,9);
		var id2 = id.substr(9,1);

		if(cek=='price_exc')
		{
			var inc = $('#price_inc'+id2).val();
			var exc = val;
		}else {
			var inc = val;
			var exc = $('#price_exc'+id2).val();
		}

		var produk   = $('#id_produk'+id2).val();

		$.ajax({
			type        : 'POST',
			url         : "<?= base_url(); ?>Transaksi/load_produk_1",
			data        : { idp: '', kd: produk },
			dataType    : 'json',
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
			success:function(val){			
				
						hrg_kg   = Math.trunc(exc / val.berat_bersih);
						$('#hrg_kg'+id2).val(hrg_kg);	

						if(val.kategori=='K_SHEET')
						{
							if(val.flute=='BCF')
							{
								$.ajax({
									type        : 'POST',
									url         : "<?= base_url(); ?>Transaksi/cek_bcf",
									data        : {kd: val.kualitas },
									dataType    : 'json',
									success:function(data){		
										
										var subs    = val.kualitas.split("/");
										var subs2   = subs[1].substring(1,4);
										var subs3   = subs[2].substring(1,4);
										var subs4   = subs[3].substring(1,4);

										var cek1    = (subs2=='150') ? 300 : 0;
										var cek2    = (subs3=='150') ? 300 : 0;
										var cek3    = (subs4=='150') ? 300 : 0;

										var totsub      = cek1 + cek2 + cek3 + data.bcf;

										var rumus = totsub * (val.ukuran_sheet_p/1000) * (val.ukuran_sheet_l/1000);

										var selisih = rumus - inc;

										p11 = selisih / rumus * 100;

										$('#p11'+id2).val('- '+ p11.toFixed(1)+' %');
										swal.close();


									}
								});
								
							} else {
								$.ajax({
									type        : 'POST',
									url         : "<?= base_url(); ?>Transaksi/cek_flute",
									data        : {kd: val.kualitas, flute : val.flute },
									dataType    : 'json',
									success:function(data2){		
										
										var subs    = val.kualitas.split("/");
										var subs2   = subs[1].substring(1,4);

										var cek1    = (subs2=='150') ? 300 : 0;

										var totsub  = cek1 + data2.flute;

										var rumus   = totsub * (val.ukuran_sheet_p/1000) * (val.ukuran_sheet_l/1000);

										var selisih = rumus - inc;

										p11         = selisih / rumus * 100;

										$('#p11'+id2).val('- '+ p11.toFixed(1)+' %');
										swal.close();

									}
								});
							}
						} else {
							p11 = exc/ val.berat_bersih;
							$('#p11'+id2).val( '- 0 %');
							swal.close();

						}
					
			}
		});
	}

	function Hitung_rm(qty,id) 
	{
		var cek       = id.substr(0,3);
		var id2       = id.substr(3,1);
		
		var produk   = $('#id_produk'+id2).val();
		
		if(produk=='' || produk=='undefined' || produk=='-- Pilih --'){
			// toastr.error('Pilih Produk Dahulu');
			swal({
				title: "Produk Kosong",
				text: "Pilih Produk Dahulu !",
				type: "error",
				confirmButtonText: "OK"
			});
			
			$('#'+id).val(0);
			$('#'+id).focus();
			return;
		}else{
			// hitung out
			
			$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Transaksi/load_produk_1",
				data        : { idp: '', kd: produk },
				dataType    : 'json',
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
				success:function(val){		
					
					out = Math.trunc(1800/val.ukuran_sheet_l);
					if(out >= 5){
						out = 5;
					}

					rm       = Math.ceil(val.ukuran_sheet_p * qty / out / 1000);
					ton      = Math.ceil(qty * val.berat_bersih);
					

					if(rm < 500 && status !=='update'){			
						// toastr.error(
						// 	'RM tidak boleh di Bawah 500, <br> Hubungi Marketing'
						// );

						swal({
							title               : "Cek Kembali",
							html                : " Tidak boleh di Bawah 500 ! <br> Hubungi Marketing </b> ",
							type                : "error",
							confirmButtonText   : "OK"
						});
						$("#"+id).val("0");
						$("#qty"+id2).val("0");
						return;
					}	

					$('#rm'+id2).val(rm);	
					$('#ton'+id2).val(ton);
					swal.close();	
						
				}
			});

		}
		
	}

	function cek_kode_po(kode_po)
	{
		$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Transaksi/cek_kode",
				data        : { kode_po },
				dataType    : 'json',
				success:function(val){		

					if(val.jum>0){
						swal({
							title               : "Cek Kembali",
							html                : "KODE PO SUDAH PERNAH DI PAKAI",
							type                : "error",
							confirmButtonText   : "OK"
						});
						$('#kode_po').val('');
						$('#kode_po').focus();
						return; 
					}
						
				}
			});
	}

	function Cetak() 
	{
		no_po = $("#no_po").val();
		var url = "<?= base_url('Transaksi/Cetak_PO'); ?>";
		window.open(url + '?no_po=' + no_po, '_blank');
	}
	
</script>
