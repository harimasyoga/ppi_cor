<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<!-- <h1><b>Data Master</b></h1> -->
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
		<div class="card">
			<div class="card-header" style="font-family:Cambria">
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">

			<?php if($this->session->userdata('level') == 'Admin') { ?>
				<button type="button" style="font-family:Cambria;" class="tambah_data btn  btn-info pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
				<br><br>
			<?php } ?>

				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th style="text-align: center; width:5%">NO.</th>
							<th style="text-align: center; width:10%">REQ.</th>
							<th style="text-align: center; width:15%">TGL MASUK</th>
							<th style="text-align: center; width:20%">SUPPLIER</th>
							<th style="text-align: center; width:10%">JENIS</th>
							<th style="text-align: center; width:20%">CATATAN</th>
							<th style="text-align: center; width:10%">BERAT BERSIH</th>
							<th style="text-align: center; width:10%">AKSI</th>
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
						<label class="col-sm-2 col-form-label">INPUT</label>
						<div class="col-sm-10">
							<input type="hidden" id="id_timbangan" value="">
							<input type="hidden" id="urut_t" value="">
							<input type="hidden" id="tgl_t" value="">
							<select id="plh_input" class="form-control select2" onchange="plhInput()"></select>
						</div>
					</div>
					<div id="plh_kiriman"></div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">PERMINTAAN</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="permintaan" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">SUPPLIER</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="supplier" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">ALAMAT</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="alamat" placeholder="-" oninput="this.value = this.value.toUpperCase()"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NO POLISI</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="nopol" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">TGL MASUK</label>
						<div class="col-sm-10">
							<input type="datetime-local" class="form-control" id="tgl_masuk">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">TGL KELUAR</label>
						<div class="col-sm-10">
							<input type="datetime-local" class="form-control" id="tgl_keluar">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">BARANG</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="nm_barang" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">BERAT TRUK</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="bb_truk" placeholder="-" autocomplete="off" maxlength="11">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">BERAT KOTOR</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="bb_kotor" placeholder="-" autocomplete="off" maxlength="11">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">BERAT BERSIH</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="bb_bersih" placeholder="-" autocomplete="off" maxlength="11">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">POTONGAN</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="potongan" placeholder="KG" autocomplete="off" maxlength="11">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">CATATAN</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="catatan" placeholder="-" autocomplete="off" maxlength="100" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">PENIMBANG</label>
						<div class="col-sm-10">
							<select id="nm_penimbang" class="form-control select2"></select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">SOPIR</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="nm_supir" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">KETERANGAN</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="keterangan" placeholder="-" autocomplete="off" maxlength="25" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpanTimbangan()"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-times-circle"></i> <b> Batal</b></button>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	opsiInput = 'insert'
	$(document).ready(function() {
		$(".select2").select2()
		load_data()
	});

	$(".tambah_data").click(function(event) {
		opsiInput = 'insert'
		kosong()
		$("#modalForm").modal("show")
		$("#judul").html('<h3> Form Tambah Data</h3>')
	});

	function close_modal(){
		$('#modalForm').modal('hide');
	}

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Logistik/load_data/Timbangan',
				"type": "POST",
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function kosong() {
		$("#id_timbangan").val("")
		$("#urut_t").val("")
		$("#tgl_t").val("")
		$("#plh_input").html(`<option value="">PILIH</option><option value="MANUAL">MANUAL</option><option value="CORR">CORR</option>`).prop("disabled", false)
		$("#plh_kiriman").html("")
		$("#permintaan").val("").prop("disabled", false)
		$("#supplier").val("").prop("disabled", false)
		$("#alamat").val("").prop("disabled", false)
		$("#nopol").val("").prop("disabled", false)
		$("#tgl_masuk").val("").prop("disabled", false)
		$("#tgl_keluar").val("").prop("disabled", false)
		$("#nm_barang").val("").prop("disabled", false)
		$("#bb_kotor").val("").prop("disabled", false)
		$("#bb_truk").val("").prop("disabled", false)
		$("#bb_bersih").val("").prop("disabled", false)
		$("#potongan").val("").prop("disabled", false)
		$("#catatan").val("").prop("disabled", false)
		$("#nm_penimbang").html(`<option value="">PILIH</option><option value="Feri S">Feri S</option><option value="DWI J">DWI J</option>`).prop("disabled", false)
		$("#nm_supir").val("").prop("disabled", false)
		$("#keterangan").val("").prop("disabled", false)
		$("#btn-simpan").show().prop("disabled", false);
		selectPilihKiriman()
	}

	function plhInput() {
		let plh_input = $("#plh_input").val()
		if(plh_input == 'CORR'){
			loadSJTimbangan(plh_input)
		}else if(plh_input == 'MANUAL'){
			kosong()
			$("#plh_input").val(plh_input)
		}else{
			kosong()
		}
	}

	function loadSJTimbangan(plh_input) {
		kosong()
		$("#plh_input").val(plh_input)
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJTimbangan')?>',
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
				$("#plh_kiriman").html(res)
				$('.select2').select2();
				$("#supplier").val("PT. PRIMA PAPER INDONESIA").prop("disabled", true)
				$("#alamat").val("Timang Kulon, Wonokerto, Wonogiri").prop("disabled", true)
				$("#nm_barang").val("KARTON BOX").prop("disabled", true)
				$("#permintaan").val('KIRIMAN').prop('disabled', true)
				$("#keterangan").val('KIRIM').prop('disabled', true)
				swal.close()
			}
		})
	}

	function selectPilihKiriman(){
		let no_kendaraan = $('#slc_plh_kiriman option:selected').attr('no_kendaraan')
		let urut = $('#slc_plh_kiriman option:selected').attr('urut')
		let tgl = $('#slc_plh_kiriman option:selected').attr('tgl')
		let catatan = $('#slc_plh_kiriman option:selected').attr('catatan');
		(no_kendaraan == undefined) ? prop = false : prop = true;
		$("#nopol").val(no_kendaraan).prop("disabled", prop)
		$("#catatan").val(catatan)
	}

	function simpanTimbangan() {
		let urut = $('#slc_plh_kiriman option:selected').attr('urut')
		let tgl = $('#slc_plh_kiriman option:selected').attr('tgl');
		(urut == undefined) ? urut = '' : urut = urut;
		(tgl == undefined) ? tgl = '' : tgl = tgl;
		let id_timbangan = $("#id_timbangan").val()
		let plh_input = $("#plh_input").val()
		let permintaan = $("#permintaan").val()
		let supplier = $("#supplier").val()
		let alamat = $("#alamat").val()
		let nopol = $("#nopol").val()
		let tgl_masuk = $("#tgl_masuk").val()
		let tgl_keluar = $("#tgl_keluar").val()
		let nm_barang = $("#nm_barang").val()
		let bb_kotor = $("#bb_kotor").val()
		let bb_truk = $("#bb_truk").val()
		let bb_bersih = $("#bb_bersih").val()
		let potongan = $("#potongan").val()
		let catatan = $("#catatan").val()
		let nm_penimbang = $("#nm_penimbang").val()
		let nm_supir = $("#nm_supir").val()
		let keterangan = $("#keterangan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanTimbangan')?>',
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
				plh_input, permintaan, supplier, alamat, nopol, tgl_masuk, tgl_keluar, nm_barang, bb_kotor, bb_truk, bb_bersih, potongan, catatan, nm_penimbang, nm_supir, keterangan, urut, tgl, id_timbangan, opsiInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					kosong()
					reloadTable()
					$("#modalForm").modal("hide")
					toastr.success(`<b>${data.msg}</b>`)
					swal.close()
				}else{
					swal(data.msg, '', 'error')
					return
				}
			}
		})
	}

	function editTimbangan(id_timbangan, act) {
		$("#modalForm").modal("show");
		if(act == 'detail'){
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		}else{
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").show();
		}
		$.ajax({
			url: '<?php echo base_url('Logistik/editTimbangan')?>',
			type: "POST",
			data: ({ id_timbangan }),
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
			success: function(res){
				data = JSON.parse(res)
				$("#id_timbangan").val(id_timbangan)
				$("#urut_t").val(data.data.urut_t)
				$("#tgl_t").val(data.data.tgl_t)
				$("#plh_input").html(`<option value="${data.data.input_t}">${data.data.input_t}</option>`).prop('disabled', true)
				$("#plh_kiriman").html("")
				$("#permintaan").val(data.data.permintaan).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#supplier").val(data.data.suplier).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#alamat").val(data.data.alamat).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#nopol").val(data.data.no_polisi).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#tgl_masuk").val(data.data.date_masuk)
				$("#tgl_keluar").val(data.data.date_keluar)
				$("#nm_barang").val(data.data.nm_barang).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#bb_kotor").val(data.data.berat_kotor)
				$("#bb_truk").val(data.data.berat_truk)
				$("#bb_bersih").val(data.data.berat_bersih)
				$("#potongan").val(data.data.potongan)
				$("#catatan").val(data.data.catatan).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				$("#nm_penimbang").html(`<option value="${data.data.nm_penimbang}">${data.data.nm_penimbang}</option>`).prop('disabled', true)
				$("#nm_supir").val(data.data.nm_sopir)
				$("#keterangan").val(data.data.keterangan).prop('disabled', (data.data.input_t == 'MANUAL') ? false : true)
				opsiInput = 'update'
				swal.close()
			}
		})
	}

	function deleteTimbangan(id_timbangan) {
		swal({
			title : "TIMBANGAN",
			html : "<p> Apakah Anda yakin ingin menghapus file ini ?</p>",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>Hapus</b>',
			cancelButtonText : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?php echo base_url('Logistik/deleteTimbangan') ?>',
				data: ({ id_timbangan }),
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
				success: function(res) {
					data = JSON.parse(res)
					if(data.data){
						reloadTable()
						toastr.success(`<b>BERHASIL HAPUS!</b>`)
						swal.close()
					}
				}
			});
		});
	}
</script>
