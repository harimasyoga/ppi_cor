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
  							<th style="width:5%">NO.</th>
  							<th style="width:13%">NAMA</th>
  							<th style="width:12%">ATTN</th>
  							<th style="width:12%">ALAMAT</th>
  							<th style="width:12%">PROVINSI</th>
  							<th style="width:12%">KAB.</th>
  							<th style="width:12%">KEC.</th>
  							<th style="width:12%">KEL.</th>
  							<th style="width:10%">AKSI</th>
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

  					<!-- <div class="form-group row">
  						<label class="col-sm-2 col-form-label">ID PELANGGAN</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="no_pelanggan" placeholder="ID PELANGGAN" maxlength="6" autocomplete="off">
  						</div>
  					</div> -->
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">NAMA PELANGGAN</label>
  						<div class="col-sm-10">
  							<input type="hidden" class="form-control" id="idx">
  							<input type="hidden" class="form-control" id="no_pelanggan">
  							<input type="text" class="form-control" id="nm_pelanggan" placeholder="NAMA PELANGGAN" autocomplete="off">
  						</div>
  					</div>
					  <div class="form-group row">
  						<label class="col-sm-2 col-form-label">ATTN</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="attn" placeholder="ATAS NAMA" autocomplete="off">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">ALAMAT</label>
  						<div class="col-sm-10">
  							<textarea class="form-control" id="alamat" placeholder="ALAMAT KANTOR"></textarea>
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">ALAMAT KIRIM</label>
  						<div class="col-sm-10">
  							<textarea class="form-control" id="alamat_kirim" placeholder="ALAMAT KIRIM"></textarea>
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
  						<label class="col-sm-2 col-form-label">KABUPATEN / KOTA</label>
  						<div class="col-sm-10 kota_kab">
							<select class="form-control select2" id="kota_kab"></select>
							<input type="hidden" id="hide_kota_kab_id">
							<input type="hidden" id="hide_kota_kab_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KECAMATAN</label>
  						<div class="col-sm-10">
							<select class="form-control select2" id="kecamatan"></select>
							<input type="hidden" id="hide_kec_id">
							<input type="hidden" id="hide_kec_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KELURAHAN</label>
  						<div class="col-sm-10">
							<select class="form-control select2" id="kelurahan"></select>
							<input type="hidden" id="hide_kel_id">
							<input type="hidden" id="hide_kel_nama">
  						</div>
  					</div>
					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">KODE POS</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="kode_pos" placeholder="-" autocomplete="off">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">NO TELP. / NO. HP</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="no_telp" placeholder="-" autocomplete="off">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">FAX</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="fax" placeholder="-" autocomplete="off">
  						</div>
  					</div>
  					<div class="form-group row">
  						<label class="col-sm-2 col-form-label">TOP</label>
  						<div class="col-sm-10">
  							<input type="text" class="form-control" id="top" placeholder="-" autocomplete="off">
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
		plhWilayah(0,0,0,0);
  	});

  	status = "insert";
  	$(".tambah_data").click(function(event) {
  		kosong();
  		$("#modalForm").modal("show");
  		$("#judul").html('<h3> Form Tambah Data</h3>');
  		status = "insert";
  	});

	function plhWilayah(prov = 0, kab = 0, kec = 0, kel = 0) {
		hide_prov_id = $('#hide_prov_id').val()
		hide_prov_nama = $('#hide_prov_nama').val()
		hide_kota_kab_id = $('#hide_kota_kab_id').val()
		hide_kota_kab_nama = $('#hide_kota_kab_nama').val()
		hide_kec_id = $('#hide_kec_id').val()
		hide_kec_nama = $('#hide_kec_nama').val()
		hide_kel_id = $('#hide_kel_id').val()
		hide_kel_nama = $('#hide_kel_nama').val()
		// alert(hide_prov_id+" - "+hide_prov_nama+" - "+hide_kota_kab_id+" - "+hide_kota_kab_nama+" - "+hide_kec_id+" - "+hide_kec_nama+" - "+hide_kel_id+" - "+hide_kel_nama)

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
				// console.log(data.prov)
				// console.log(data.kab)
				// console.log(data.kec)
				// console.log(data.kel)

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
				let htmlKel = ''
				if(prov != 0 && kab != 0 && kec != 0){
					if(kel == ""){
						htmlKel += `<option value="">PILIH</option>`
					}else{
						htmlKel += `<option value="${hide_kel_id}" data-nama="${hide_kel_nama}">${hide_kel_nama}</option>`
					}
					data.kel.forEach(loadKel);
					function loadKel(r, index) {
						htmlKel += `<option value="${r.kel_id}" data-nama="${r.kel_name}">${r.kel_name}</option>`;
					}
					$("#kelurahan").prop("disabled", false).html(htmlKel)
				}
			}
		})
	}

	$('#provinsi').on('change', function() {
		let prov = $('#provinsi option:selected').val();
		let prov_name = $('#provinsi option:selected').attr('data-nama');
		$('#hide_prov_id').val(prov)
		$('#hide_prov_nama').val(prov_name)
		plhWilayah(prov,0,0,0);
	})

	$('#kota_kab').on('change', function() {
		let provinsi = $('#provinsi').val()
		let kab = $('#kota_kab option:selected').val();
		let kab_name = $('#kota_kab option:selected').attr('data-nama');
		$('#hide_kota_kab_id').val(kab)
		$('#hide_kota_kab_nama').val(kab_name)
		plhWilayah(provinsi,kab,0,0);
	})

	$('#kecamatan').on('change', function() {
		let provinsi = $('#provinsi').val()
		let kab = $('#kota_kab').val()
		let kec = $('#kecamatan option:selected').val();
		let kec_name = $('#kecamatan option:selected').attr('data-nama');
		$('#hide_kec_id').val(kec)
		$('#hide_kec_nama').val(kec_name)
		plhWilayah(provinsi,kab,kec,0);
	})

	$('#kelurahan').on('change', function() {
		let provinsi = $('#provinsi').val()
		let kab = $('#kota_kab').val()
		let kec = $('#kecamatan').val()
		let kel = $('#kelurahan option:selected').val();
		let kel_name = $('#kelurahan option:selected').attr('data-nama');
		// alert(provinsi+" - "+kab+" - "+kec+" - "+kel+" - "+kel_name)
		// $('#hide_kel_id').val(kel)
		// $('#hide_kel_nama').val(kel_name)
		// plhWilayah(provinsi,kab,kec,kel);
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

	function simpan() {
		$("#btn-simpan").prop("disabled", true);
		idx = $("#idx").val();
		id_pelanggan = $("#no_pelanggan").val();
		nm_pelanggan = $("#nm_pelanggan").val();
		attn = $("#attn").val();
		alamat = $("textarea#alamat").val();
		alamat_kirim = $("textarea#alamat_kirim").val();
		provinsi = $("#provinsi").val();
		kota_kab = $("#kota_kab").val();
		kecamatan = $("#kecamatan").val();
		kelurahan = $("#kelurahan").val();
		kode_pos = $("#kode_pos").val();
		fax = $("#fax").val();
		top1 = $("#top").val();
		no_telp = $("#no_telp").val();
		// alert(idx+"-"+no_pelanggan+"-"+nm_pelanggan+"-"+attn+"-"+alamat+"-"+alamat_kirim+"-"+provinsi+"-"+kota_kab+"-"+kecamatan+"-"+kelurahan+"-"+kode_pos+"-"+fax+"-"+top1+"-"+no_telp)

		if ( nm_pelanggan == "" || attn == "" || alamat == "" || alamat_kirim == "" || kode_pos == "" || fax == "" || top1 == "" || no_telp == "") {
			toastr.info('Harap Lengkapi Form');
			$("#btn-simpan").prop("disabled", false);
			return;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>/master/insert/'+status,
			type: "POST",
			data: ({
				idx, id_pelanggan, nm_pelanggan, attn, alamat, alamat_kirim, provinsi, kota_kab, kecamatan, kelurahan, kode_pos, fax, top1, no_telp, jenis: 'm_pelanggan', status: status
			}),
			dataType: "JSON",
			success: function(data) {
				// alert(data.data)
				if (data == true) {
					toastr.success('Berhasil Disimpan');
					kosong();
					$("#modalForm").modal("hide");
				} else {
					toastr.error('ID Pelanggan Sudah Ada!!!');
					$("#btn-simpan").prop("disabled", false);
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan');
			}
		});
	}

	function kosong() {
		plhWilayah(0,0,0,0);
		$("#no_pelanggan").val("");
		$("#nm_pelanggan").val("");
		$("#attn").val("");
		$("textarea#alamat").val("");
		$("textarea#alamat_kirim").val("");
		$("#kode_pos").val("");
		$("#fax").val("");
		$("#top").val("");
		$("#no_telp").val("");
		status = 'insert';
		$("#btn-simpan").show().prop("disabled", false);
	}

	function tampil_edit(id, act) {
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

		$.ajax({
			url: '<?php echo base_url('Master/getEditPelanggan'); ?>',
			type: 'POST',
			data: ({
				id,
			}),
		})
		.done(function(json) {
			data = JSON.parse(json)
			// console.log(data)

			$("#idx").val(data.pelanggan.id_pelanggan);
			$("#no_pelanggan").val(data.pelanggan.id_pelanggan);
			$("#nm_pelanggan").val(data.pelanggan.nm_pelanggan);
			$("#attn").val(data.pelanggan.attn);
			$("textarea#alamat").val(data.pelanggan.alamat);
			$("textarea#alamat_kirim").val(data.pelanggan.alamat_kirim);
			$("#kode_pos").val(data.pelanggan.kode_pos)
			$("#fax").val(data.pelanggan.fax)
			$("#top").val(data.pelanggan.top)
			$("#no_telp").val(data.pelanggan.no_telp)

			let htmlProv = ''
			htmlProv += `<option value="${(data.wilayah.prov === null) ? 0 : data.wilayah.prov }" data-nama="${(data.wilayah.prov_name === null) ? "PILIH" : data.wilayah.prov_name}">${(data.wilayah.prov_name === null) ? "PILIH" : data.wilayah.prov_name}</option>`
			htmlProv += `<option value="" data-nama="PILIH">PILIH</option>`
			data.prov.forEach(loadProv);
			function loadProv(r, index) {
				htmlProv += `<option value="${r.prov_id}" data-nama="${r.prov_name}">${r.prov_name}</option>`
			}
			$("#provinsi").html(htmlProv)
			$("#kota_kab").prop("disabled", true).html(`<option value="${(data.wilayah.kab === null) ? 0 : data.wilayah.kab}" data-nama="${(data.wilayah.kab_name === null) ? "PILIH" : data.wilayah.kab_name}">${(data.wilayah.kab_name === null) ? "PILIH" : data.wilayah.kab_name}</option>`)
			$("#kecamatan").prop("disabled", true).html(`<option value="${(data.wilayah.kec === null) ? 0 : data.wilayah.kec}" data-nama="${(data.wilayah.kec_name === null) ? "PILIH" : data.wilayah.kec_name}">${(data.wilayah.kec_name === null) ? "PILIH" : data.wilayah.kec_name}</option>`)
			$("#kelurahan").prop("disabled", true).html(`<option value="${(data.wilayah.kel === null) ? 0 : data.wilayah.kel}" data-nama="${(data.wilayah.kel_name === null) ? "PILIH" : data.wilayah.kel_name}">${(data.wilayah.kel_name === null) ? "PILIH" : data.wilayah.kel_name}</option>`)			
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
