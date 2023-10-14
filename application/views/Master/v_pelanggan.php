  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	<!-- Content Header (Page header) -->
  	<section class="content-header">
  		<div class="container-fluid">
  			<div class="row mb-2">
  				<div class="col-sm-6">
  					<h1>Data Master </h1>
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

  				<button type="button" class="tambah_data btn  btn-outline-primary pull-right">Tambah Data</button>
  				<br><br>

  				<table id="datatable" class="table table-bordered table-striped" width="100%">
  					<thead>
  						<tr>
  							<th style="width:5%">ID</th>
  							<th style="width:15%">Nama pelanggan</th>
  							<th style="width:22%">Alamat</th>
  							<th style="width:15%">Kota</th>
  							<th style="width:10%">No Telepon</th>
  							<th style="width:15%">FAX</th>
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
  						<label class="col-sm-2 col-form-label">ID PELANGGAN</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="no_pelanggan" placeholder="Masukan.." maxlength="6">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">NAMA PELANGGAN</label>
  						<div class="col-sm-10">
  							<input type="hidden" class="form-control" id="id_pelanggan">
  							<input type="text" class="form-control" id="nm_pelanggan" placeholder="Masukan..">
  						</div>
  					</div>
					  <div class="form-group row">
  						<label class="col-sm-2 col-form-label">ATTN</label>
  						<div class="col-sm-10">
  							<input type="hidden" class="form-control" id="id_pelanggan">
  							<input type="text" class="form-control" id="nm_pelanggan" placeholder="Masukan..">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">PROVINSI</label>
  						<div class="col-sm-10">
							<select class="form-control select2" id="provinsi"></select>
							<input type="hidden" id="hide_prov_id">
							<input type="hidden" id="hide_prov_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KOTA / KABUPATEN</label>
  						<div class="col-sm-10 kota_kab">
							<select class="form-control select2" id="kota_kab"></select>
							<input type="hidden" id="hide_kota_kab_id">
							<input type="hidden" id="hide_kota_kab_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KECAMATAN</label>
  						<div class="col-sm-10">
  							<!-- <input type="text" class="form-control" id="kecamatan" placeholder="Masukan.."> -->
							<select class="form-control select2" id="kecamatan"></select>
							<input type="hidden" id="hide_kec_id">
							<input type="hidden" id="hide_kec_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KELURAHAN</label>
  						<div class="col-sm-10">
  							<!-- <input type="text" class="form-control" id="kelurahan" placeholder="Masukan.."> -->
							  <select class="form-control select2" id="kelurahan"></select>
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">DESA</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="desa" placeholder="Masukan..">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KODE POS</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="kode_pos" placeholder="Masukan..">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">ALAMAT</label>
  						<div class="col-sm-10">
  							<textarea class="form-control" id="alamat" placeholder="Masukan.."></textarea>
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">ALAMAT KIRIM</label>
  						<div class="col-sm-10">
  							<textarea class="form-control" id="alamat_kirim" placeholder="Masukan.."></textarea>
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">NO TELP. / NO. HP</label>
  						<div class="col-sm-10">
  							<input type="text" class="angka form-control" id="no_telp" placeholder="Masukan..">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">FAX</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="fax" placeholder="Masukan..">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">TOP</label>
  						<div class="col-sm-10">
  							<input type="text" class="angka form-control" id="top" placeholder="Masukan..">
  						</div>
  					</div>
  			</div>
  			<div class="modal-footer">
  				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
  			</div>
  			</form>
  		</div>
  		<!-- /.modal-content -->
  	</div>
  	<!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <script type="text/javascript">
  	rowNum = 0;
  	$(document).ready(function() {
		$(".select2").select2();
		load_data();
		plhWilayah(0,0,0);
  	});

  	status = "insert";
  	$(".tambah_data").click(function(event) {
  		kosong();
  		$("#modalForm").modal("show");
  		$("#judul").html('<h3> Form Tambah Data</h3>');
  		status = "insert";
  	});

	function plhWilayah(prov = 0, kab = 0, kec = 0) {
		hide_prov_id = $('#hide_prov_id').val()
		hide_prov_nama = $('#hide_prov_nama').val()
		hide_kota_kab_id = $('#hide_kota_kab_id').val()
		hide_kota_kab_nama = $('#hide_kota_kab_nama').val()
		hide_kec_id = $('#hide_kec_id').val()
		hide_kec_nama = $('#hide_kec_nama').val()
		alert("prov: "+hide_prov_id+" - "+hide_prov_nama+". kab: "+hide_kota_kab_id+" - "+hide_kota_kab_nama+". kec: "+hide_kec_id+" - "+hide_kec_nama)

		if(prov == 0){
			$("#kota_kab").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
			$("#kecamatan").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
			$("#kelurahan").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
		}
		if(kab == 0){
			$("#kecamatan").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
			$("#kelurahan").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
		}
		if(kec == 0){
			$("#kelurahan").val("").prop("disabled", true).html(`<option value="">PILIH</option>`);
		}

		$.ajax({
			url: '<?php echo base_url("/Master/plhWilayah")?>',
			type: "POST",
			data: ({
				prov,kab,kec
			}),
			success: function(json){
				data = JSON.parse(json)
				console.log(data.prov)
				console.log(data.kab)
				console.log(data.kec)
				console.log(data.kel)

				// PROVINSI
				let htmlProv = ''
				if(prov == ""){
					htmlProv += `<option value="">PILIH</option>`
				}else{
					htmlProv += `<option value="${hide_prov_id}" data-nama="${hide_prov_nama}">${hide_prov_nama}</option>`
				}
				data.prov.forEach(loadProv);
				function loadProv(r, index) {
					htmlProv += `<option value="${r.prov_id}" data-nama="${r.prov_name}">${r.prov_name}</option>`;
				}
				$("#provinsi").html(htmlProv)

				// KABUPATEN
				let htmlKab = ''
				if(prov != 0 && kab == 0 && kec == 0){
					if(kab == ""){
						htmlKab += `<option value="">PILIH</option>`
					}else{
						htmlKab += `<option value="${hide_kota_kab_id}" data-nama="${hide_kota_kab_nama}">${hide_kota_kab_nama}</option>`
					}
					data.kab.forEach(loadKab);
					function loadKab(r, index) {
						htmlKab += `<option value="${r.kab_id}" data-nama="${r.kab_name}">${r.kab_name}</option>`;
					}
					$("#kota_kab").prop("disabled", false).html(htmlKab)
				}

				// KECAMATAN
				let htmlKec = ''
				if(prov != 0 && kab != 0 && kec == 0){
					if(kec == ""){
						htmlKec += `<option value="">PILIH</option>`
					}else{
						htmlKec += `<option value="${hide_kec_id}" data-nama="${hide_kec_nama}">${hide_kec_nama}</option>`
					}
					data.kec.forEach(loadKec);
					function loadKec(r, index) {
						htmlKec += `<option value="${r.kec_id}" data-nama="${r.kec_name}">${r.kec_name}</option>`;
					}
					$("#kecamatan").prop("disabled", false).html(htmlKec)
				}

				// KELURAHAN
				// let htmlKec = ''
				if(prov != 0 && kab != 0 && kec != 0){
					alert('kel')
					// if(kec == ""){
					// 	htmlKec += `<option value="">PILIH</option>`
					// }else{
					// 	htmlKec += `<option value="${hide_kec_id}" data-nama="${hide_kec_nama}">${hide_kec_nama}</option>`
					// }
					// data.kec.forEach(loadKec);
					// function loadKec(r, index) {
					// 	htmlKec += `<option value="${r.kec_id}" data-nama="${r.kec_name}">${r.kec_name}</option>`;
					// }
					// $("#kelurahan").prop("disabled", false).html(htmlKec)
				}
			}
		})
	}

	$('#provinsi').on('change', function() {
		let prov = $('#provinsi option:selected').val();
		let prov_name = $('#provinsi option:selected').attr('data-nama');
		$('#hide_prov_id').val(prov)
		$('#hide_prov_nama').val(prov_name)
		plhWilayah(prov,0,0);
	})

	$('#kota_kab').on('change', function() {
		let provinsi = $('#provinsi').val()
		let kab = $('#kota_kab option:selected').val();
		let kab_name = $('#kota_kab option:selected').attr('data-nama');
		$('#hide_kota_kab_id').val(kab)
		$('#hide_kota_kab_nama').val(kab_name)
		plhWilayah(provinsi,kab,0);
	})

	$('#kecamatan').on('change', function() {
		let provinsi = $('#provinsi').val()
		let kab = $('#kota_kab').val()
		let kec = $('#kecamatan option:selected').val();
		let kec_name = $('#kecamatan option:selected').attr('data-nama');
		$('#hide_kec_id').val(kec)
		$('#hide_kec_nama').val(kec_name)
		plhWilayah(provinsi,kab,kec);
	})

  	function load_data() {
  		var table = $('#datatable').DataTable();
  		table.destroy();
  		tabel = $('#datatable').DataTable({
  			"processing": true,
  			"pageLength": true,
  			"paging": true,
  			"ajax": {
  				"url": '<?php echo base_url(); ?>Master/load_data/pelanggan',
  				"type": "POST",
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
  		id_pelanggan = $("#id_pelanggan").val();
  		no_pelanggan = $("#no_pelanggan").val();
  		nm_pelanggan = $("#nm_pelanggan").val();
  		no_telp = $("#no_telp").val();
		provinsi = $("#provinsi").val();
		kota_kab = $("#kota_kab").val();
		kecamatan = $("#kecamatan").val();
		kelurahan = $("#kelurahan").val();
		desa = $("#desa").val();
		kode_pos = $("#kode_pos").val();
  		// kota = $("#kota").val();
  		fax = $("#fax").val();
  		top1 = $("#top").val();
  		alamat = $("textarea#alamat").val();
  		alamat_kirim = $("textarea#alamat_kirim").val();
  		// lokasi = $("#lokasi").val();

  		if (no_pelanggan == '' || nm_pelanggan == '' || fax == '' || no_telp == '' || top1 == '' || alamat == '' ||  alamat_kirim == '' || provinsi == '' || kota_kab == '' || kecamatan == '' || kelurahan == '' || desa == '' || kode_pos == '') {
  			toastr.info('Harap Lengkapi Form');
  			return;
  		}

  		$.ajax({
  			url: '<?php echo base_url(); ?>/master/insert/' + status,
  			type: "POST",
  			data: ({
  				id_pelanggan,
  				no_pelanggan,
  				nm_pelanggan,
  				no_telp,
  				alamat,
  				alamat_kirim,
  				fax,
  				top1,
  				lokasi,
  				jenis: 'm_pelanggan',
  				status: status
  			}),
  			dataType: "JSON",
  			success: function(data) {
  				if (data.data == true) {
  					toastr.success('Berhasil Disimpan');
  					kosong();
  					$("#modalForm").modal("hide");
  				} else {
  					toastr.error('Id Pelanggan Sudah Ada!!!');
  				}
  				reloadTable();
  			},
  			error: function(jqXHR, textStatus, errorThrown) {
  				toastr.error('Terjadi Kesalahan');
  			}
  		});
  	}

  	function kosong() {
  		$("#no_pelanggan").val('');
  		$("#nm_pelanggan").val('');
  		$("#no_telp").val('');
  		$("textarea#alamat").val('');
  		$("textarea#alamat_kirim").val('');
  		$("#lokasi").val('');
  		$("#kota").val('');
  		$("#fax").val('');
  		$("#top").val('');
  		$("#ttl").val('');
  		status = 'insert';
  		$("#btn-simpan").show();
  	}


  	function tampil_edit(id, act) {
  		kosong();
  		status = 'update';
  		$("#modalForm").modal("show");
  		if (act == 'detail') {
  			$("#judul").html('<h3> Detail Data</h3>');
  			$("#btn-simpan").hide();
  		} else {
  			$("#judul").html('<h3> Form Edit Data</h3>');
  			$("#btn-simpan").show();
  		}
  		$("#jenis").val('Update');

  		status = "update";

  		$.ajax({
  				url: '<?php echo base_url('Master/get_edit'); ?>',
  				type: 'POST',
  				data: {
  					id: id,
  					jenis: "m_pelanggan",
  					field: 'id_pelanggan'
  				},
  				dataType: "JSON",
  			})
  			.done(function(data) {
  				$("#id_pelanggan").val(data.id_pelanggan);
  				$("#no_pelanggan").val(data.id_pelanggan);
  				$("#nm_pelanggan").val(data.nm_pelanggan);
  				$("#no_telp").val(data.no_telp);
  				$("textarea#alamat").val(data.alamat);
  				$("textarea#alamat_kirim").val(data.alamat_kirim);
  				$("#lokasi").val(data.lokasi);
  				$("#kota").val(data.kota);
  				$("#fax").val(data.fax);
  				$("#ttl").val(data.ttl);
  				$("#top").val(data.top);
  			})
  	}


  	function deleteData(id) {
  		let cek = confirm("Apakah Anda Yakin?");

  		if (cek) {
  			$.ajax({
  				url: '<?php echo base_url(); ?>Master/hapus',
  				data: ({
  					id: id,
  					jenis: 'm_pelanggan',
  					field: 'id_pelanggan'
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
  </script>
