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
				<!-- <button type="button" class="btn-cetak btn  btn-outline-success pull-right" onclick="cetak(1)">Export Excel</button> -->
				<br><br>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th style="width:12%">Kode MC</th>
							<th style="width:16%">Nama Produk</th>
							<th style="width:12%">Ukuran Box</th>
							<th style="width:12%">Material</th>
							<th style="width:12%">Flute</th>
							<th style="width:12%">Creasing</th>
							<th style="width:12%">Warna</th>
							<th style="width:12%">Aksi</th>
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
					<table width="100%" cellspacing="5">
						<tr>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
							<td style="width:10%;border:0;padding:0"></td>
						</tr>
						<tr>
							<td style="padding:5px 0">KODE MC</td>
							<td colspan="3">
								<input type="hidden" class="form-control" id="id">
								<input type="hidden" class="form-control" id="kode_mc_lama">
								<input type="text" class="form-control" id="kode_mc" placeholder="KODE MC" autocomplete="off">
							</td>
							<td></td>
							<td style="padding:5px 0">NAMA PRODUK</td>
							<td style="padding:5px 0" colspan="3"><input type="text" class="form-control" id="nm_produk" placeholder="NAMA PRODUK" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0">NO CUSTOMER</td>
							<td style="padding:5px 0" colspan="3">
								<select class="form-control select2" id="no_customer">
									<option value="">PILIH</option>
									<?php foreach ($pelanggan as $r) : ?>
										<option value="<?= $r->id_pelanggan ?>" data-detail="<?= $r->nm_pelanggan?>"><?= $r->id_pelanggan . ' | ' . $r->nm_pelanggan ?></option>
									<?php endforeach ?>
								</select>
							</td>
							<td></td>
							<td style="padding:5px 0">CUSTOMER</td>
							<td style="padding:5px 0" colspan="3"><input type="text" class="form-control" id="customer" placeholder="" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0">KATEGORI</td>
							<td style="padding:5px 0" colspan="3">
								<select class="form-control" id="kategori">
									<option value="">PILIH</option>
									<option value="K_BOX">PRODUK BOX</option>
									<option value="K_SHEET">PRODUK SHEET</option>
								</select>
							</td>
							<td></td>
							<td style="padding:5px 0">TYPE</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="tipe" placeholder="-" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0">P / L / T</td>
							<td style="padding:5px 2px 5px 0"><input type="text" class="form-control" id="l_panjang" placeholder="P" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td style="padding:5px 2px"><input type="text" class="form-control" id="l_lebar" placeholder="L" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td style="padding:5px 0 5px 2px"><input type="text" class="form-control" id="l_tinggi" placeholder="T" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td></td>
							<td style="padding:5px 0">UKURAN BOX</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="ukuran" placeholder="-" autocomplete="off" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0">CREASING</td>
							<td style="padding:5px 2px 5px 0"><input type="text" class="form-control" id="creasing" placeholder="1" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td style="padding:5px 2px"><input type="text" class="form-control" id="creasing2" placeholder="2" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td style="padding:5px 0 5px 2px"><input type="text" class="form-control" id="creasing3" placeholder="3" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td></td>
							<td style="padding:5px 0">UKURAN SHEET</td>
							<td style="padding:5px 5px 5px 0">
								<input type="number" class="form-control" placeholder="PANJANG" name="ukuran_sheet_p" id="ukuran_sheet_p" disabled>
							</td>
							<td style="padding:5px 0 5px 5px">
								<input type="number" class="form-control" placeholder="LEBAR" name="ukuran_sheet_l" id="ukuran_sheet_l" disabled>
								<input type="hidden" class="form-control" id="ukuran_sheet" placeholder="-" autocomplete="off" disabled>
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0">FLUTE</td>
							<td style="padding:5px 0">
								<select class="form-control" id="flute">
									<option value="">PILIH</option>
									<option value="CB">CB</option>
									<option value="CF">CF</option>
									<option value="BF">BF</option>
								</select>
							</td>
							<td colspan="3"><input type="hidden" id="nilai_flute"></td>
							<td colspan="3"><input type="hidden" id="nilai_sheet_panjang"></td>
							<td colspan="3"><input type="hidden" id="nilai_sheet_lebar"></td>
							<td colspan="3"><input type="hidden" id="wall"></td>
						</tr>
						<tr>
							<td style="padding:5px">
								<select class="form-control" id="M_K" onchange="cflute()">
									<option value="">TIPE</option>
									<option value="M">M</option>
									<option value="K">K</option>
								</select>
							<td style="padding:5px"><input style="text-align:center" type="text" class="form-control" id="F_K" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="K" onchange="cflute()" autocomplete="off"></td>
							</td>
							<td style="padding:5px">
								<select class="form-control" id="M_B" onchange="cflute()">
									<option value="">TIPE</option>
									<option value="M">M</option>
									<option value="K">K</option>
								</select>
							<td style="padding:5px"><input style="text-align:center" type="text" class="form-control" id="F_B" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="B" onchange="cflute()" autocomplete="off"></td>
							</td>
							<td style="padding:5px">
								<select class="form-control" id="M_CL" onchange="cflute()">
									<option value="">TIPE</option>
									<option value="M">M</option>
									<option value="K">K</option>
								</select>
							<td style="padding:5px"><input style="text-align:center" type="text" class="form-control" id="F_CL" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="CL" onchange="cflute()" autocomplete="off"></td>
							</td>
							<td style="padding:5px">
								<select class="form-control" id="M_C" onchange="cflute()">
									<option value="">TIPE</option>
									<option value="M">M</option>
									<option value="K">K</option>
								</select>
							<td style="padding:5px"><input style="text-align:center" type="text" class="form-control" id="F_C" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="C" onchange="cflute()" autocomplete="off"></td>
							</td>
							<td style="padding:5px">
								<select class="form-control" id="M_BL" onchange="cflute()">
									<option value="">TIPE</option>
									<option value="M">M</option>
									<option value="K">K</option>
								</select>
							<td style="padding:5px"><input style="text-align:center" type="text" class="form-control" id="F_BL" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="BL" onchange="cflute()" autocomplete="off"></td>
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0">KUALITAS</td>
							<td style="padding:5px 0" colspan="3"><input type="text" class="form-control" id="kualitas" placeholder="-" disabled></td>
							<td></td>
							<td style="padding:5px 0">MATERIAL</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="material" placeholder="-" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0">BERAT BERSIH</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="berat_bersih" placeholder="-" disabled></td>
							<td style="padding:5px 0 5px 5px">LUAS BERSIH</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="luas_bersih" placeholder="-" disabled></td>
							<td></td>
							<td style="padding:5px 0">TOLERANSI KIRIM</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="toleransi_kirim" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="-"></td>
							<td style="padding:5px 0 5px 5px">%</td>
						</tr>
						<tr>
							<td style="padding:5px 0">SAMBUNGAN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="sambungan" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">NO DESIGN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_design" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">TIPE BOX</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="tipe_box" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0">WARNA</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="warna" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">DESIGN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="design" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">JENIS PRODUK</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jenis_produk" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0">JML IKAT</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_ikat" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">JML PALET</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_palet" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">JML PAKU</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_paku" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0 5px 5px">NO KARET</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_karet" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">NO PISAU</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_pisau" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0 5px 5px">SPESIAL REQUEST</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="spesial_req" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px">COA</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="COA" placeholder="-" autocomplete="off"></td>
						</tr>
					</table>
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
		load_data();
	});

	status = "insert";
	$(".tambah_data").click(function(event) {
		kosong();
		$("#modalForm").modal("show");
		$("#judul").html('<h3> Form Tambah Data</h3>');
		status = "insert";
		$('.select2').select2({
			// placeholder: 'PILIH',
			dropdownAutoWidth: true
		});
	});

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/produk',
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
		id = $("#id").val();
		kode_mc = $("#kode_mc").val();
		kode_mc_lama = $("#kode_mc_lama").val();
		nm_produk = $("#nm_produk").val();
		no_customer = $("#no_customer").val();
		customer = $("#customer").val();
		ukuran = $("#ukuran").val();
		ukuran_sheet = $("#ukuran_sheet").val();
		sambungan = $("#sambungan").val();
		tipe = $("#tipe").val();
		material = $("#material").val();
		wall = $("#wall").val();
		l_panjang = $("#l_panjang").val();
		l_lebar = $("#l_lebar").val();
		l_tinggi = $("#l_tinggi").val();
		creasing = $("#creasing").val();
		creasing2 = $("#creasing2").val();
		creasing3 = $("#creasing3").val();
		flute = $("#flute").val();
		berat_bersih = $("#berat_bersih").val();
		luas_bersih = $("#luas_bersih").val();
		kualitas = $("#kualitas").val();
		warna = $("#warna").val();
		no_design = $("#no_design").val();
		design = $("#design").val();
		tipe_box = $("#tipe_box").val();
		jenis_produk = $("#jenis_produk").val();
		kategori = $("#kategori").val();
		cCOA = $("#COA").val();
		jml_ikat = $("#jml_ikat").val();
		jml_palet = $("#jml_palet").val();
		jml_paku = $("#jml_paku").val();
		no_pisau = $("#no_pisau").val();
		no_karet = $("#no_karet").val();
		toleransi_kirim = $("#toleransi_kirim").val();
		spesial_req = $("#spesial_req").val();
		ukuran_sheet_p = $("#ukuran_sheet_p").val();
		ukuran_sheet_l = $("#ukuran_sheet_l").val();

		ukuran_sheet = ukuran_sheet_p + ' X '+ukuran_sheet_l
		$("#ukuran_sheet").val(ukuran_sheet)

		if(kategori == 'K_SHEET' && (l_panjang == '' || l_lebar == '')){
			toastr.info('Harap Lengkapi Form');
			return;
		}
		if(kategori == 'K_BOX' && (l_panjang == '' || l_lebar == '' || l_tinggi == '')){
			toastr.info('Harap Lengkapi Form');
			return;
		}

		if (kode_mc == '' || nm_produk == '' || no_customer == '' || customer == '' || ukuran == '' || ukuran_sheet == '' || sambungan == '' || tipe == '' || material == '' || wall == '' || creasing == '' || creasing2 == '' || creasing3 == '' || flute == '' || berat_bersih == '' || luas_bersih == '' || kualitas == '' || warna == '' || no_design == '' || design == '' || tipe_box == '' || jenis_produk == '' || kategori == '' || cCOA == '' || jml_ikat == '' || jml_palet == '' || jml_paku == '' || no_pisau == '' || no_karet == '' || toleransi_kirim == '' || spesial_req == '') {
			toastr.info('Harap Lengkapi Form');
			return;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>/master/insert/' + status,
			type: "POST",
			data: ({
				id, kode_mc, kode_mc_lama, nm_produk, no_customer, customer, ukuran, ukuran_sheet, sambungan, tipe, material, wall, l_panjang, l_lebar, l_tinggi, creasing, creasing2, creasing3, flute, berat_bersih, luas_bersih, kualitas, warna, no_design, design, tipe_box, jenis_produk, kategori, COA:cCOA, jml_ikat, jml_palet, jml_paku, no_pisau, no_karet, toleransi_kirim, spesial_req, ukuran_sheet_p, ukuran_sheet_l, jenis: 'm_produk', status: status
			}),
			dataType: "JSON",
			success: function(data) {
				if (data) {
					toastr.success('Berhasil Disimpan');
					kosong();
					$("#modalForm").modal("hide");
				} else {
					toastr.error('Gagal Simpan / Kode MC sudah tersedia');
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan');
			}
		});
	}

	function kosong() {
		$("#id").val("");
		$("#kode_mc").val("");
		$("#nm_produk").val("");
		$("#no_customer").val("");
		$("#customer").val("");
		$("#ukuran").val("");
		$("#ukuran_sheet").val("");
		$("#ukuran_sheet_p").val("");
		$("#ukuran_sheet_l").val("");
		$("#sambungan").val("-");
		$("#tipe").val("");
		$("#material").val("");
		$("#wall").val("");
		$("#l_panjang").val("").prop("disabled", true);
		$("#l_lebar").val("").prop("disabled", true);
		$("#l_tinggi").val("").prop("disabled", true);
		$("#nilai_sheet_panjang").val("");
		$("#nilai_sheet_lebar").val("");
		$("#nilai_flute").val("");
		$("#creasing").val("");
		$("#creasing2").val("");
		$("#creasing3").val("");
		$("#flute").val("");
		$("#berat_bersih").val("");
		$("#luas_bersih").val("");
		$("#kualitas").val("");
		$("#warna").val("-");
		$("#no_design").val("-");
		$("#design").val("-");
		$("#tipe_box").val("-");
		$("#jenis_produk").val("-");
		$("#kategori").val("");
		$("#COA").val("-");
		$("#jml_ikat").val("-");
		$("#jml_palet").val("-");
		$("#jml_paku").val("-");
		$("#no_pisau").val("-");
		$("#no_karet").val("-");
		$("#toleransi_kirim").val(0);
		$("#spesial_req").val("-");
		status = 'insert';
		$("#btn-simpan").show();
		zFlute("disable");
	}

	function zFlute(opsi) {
		if(opsi == "disable"){
			ket = true
		} else {
			ket = false
		}

		$("#M_K").val("").prop("disabled", ket);
		$("#F_K").val("").prop("disabled", ket);
		$("#M_B").val("").prop("disabled", ket);
		$("#F_B").val("").prop("disabled", ket);
		$("#M_CL").val("").prop("disabled", ket);
		$("#F_CL").val("").prop("disabled", ket);
		$("#M_C").val("").prop("disabled", ket);
		$("#F_C").val("").prop("disabled", ket);
		$("#M_BL").val("").prop("disabled", ket);
		$("#F_BL").val("").prop("disabled", ket);
		$("#wall").val("-");
		$("#material").val("-");
		$("#kualitas").val("-");
		$("#berat_bersih").val("-");
		$("#luas_bersih").val("-");
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
				id,
				jenis: "m_produk",
				field: 'id'
			},
			dataType: "JSON",
		})
		.done(function(data) {
			$("#id").val(data.id);
			$("#kode_mc").val(data.kode_mc);
			$("#kode_mc_lama").val(data.kode_mc);
			$("#nm_produk").val(data.nm_produk);
			$("#no_customer").val(data.no_customer);
			$("#customer").val(data.customer);
			$("#ukuran").val(data.ukuran);
			// $("#ukuran_sheet").val(data.ukuran_sheet);
			$("#ukuran_sheet_p").val(data.ukuran_sheet_p);
			$("#ukuran_sheet_l").val(data.ukuran_sheet_l);
			$("#sambungan").val(data.sambungan);
			$("#tipe").val(data.tipe);
			$("#material").val(data.material);
			$("#wall").val(data.wall);
			$("#l_panjang").val(data.l_panjang);
			$("#l_lebar").val(data.l_lebar);
			$("#l_tinggi").val(data.l_tinggi);
			$("#creasing").val(data.creasing);
			$("#creasing2").val(data.creasing2);
			$("#creasing3").val(data.creasing3);
			$("#flute").val(data.flute);
			$("#berat_bersih").val(data.berat_bersih);
			$("#luas_bersih").val(data.luas_bersih);
			$("#kualitas").val(data.kualitas);
			$("#warna").val(data.warna);
			$("#no_design").val(data.no_design);
			$("#design").val(data.design);
			$("#tipe_box").val(data.tipe_box);
			$("#jenis_produk").val(data.jenis_produk);
			$("#kategori").val(data.kategori);
			$("#COA").val(data.COA);
			$("#jml_ikat").val(data.jml_ikat);
			$("#jml_palet").val(data.jml_palet);
			$("#jml_paku").val(data.jml_paku);
			$("#no_pisau").val(data.no_pisau);
			$("#no_karet").val(data.no_karet);
			$("#toleransi_kirim").val(data.toleransi_kirim);
			$("#spesial_req").val(data.spesial_req);
		})
	}


	function deleteData(id) {
		// alert(id);
		let cek = confirm("Apakah Anda Yakin?");

		if (cek) {
			$.ajax({
				url: '<?php echo base_url(); ?>Master/hapus',
				data: ({
					id: id,
					jenis: 'm_produk',
					// field: 'kode_mc'
					field: 'id'
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

	function cetak(ctk) {
		var url = "<?php echo base_url('Laporan/Laporan_Stok'); ?>";
		window.open(url, '_blank');
	}

	$('#no_customer').on('change', function() {
		let detail = $('#no_customer option:selected').attr('data-detail');
		$("#customer").val(detail);
		let cust = $("#no_customer").val();
		if(cust == ""){
			kosong()
		}
	})

	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
		return true;
	}

	$('#kategori').on('change', function() {
		let plh_tipe = $("#kategori").val();
		let l_panjang = $("#l_panjang").val();
		let l_lebar = $("#l_lebar").val();
		let l_tinggi = $("#l_tinggi").val();

		if(plh_tipe == ""){
			zFlute("disable");
			$("#tipe").val("-");
			$("#ukuran").val("-");
			$("#ukuran_sheet_p").val("");
			$("#ukuran_sheet_l").val("");
			$("#creasing").val(0);
			$("#creasing2").val(0);
			$("#creasing3").val(0);

			$("#l_panjang").val("").prop("disabled", true);
			$("#l_lebar").val("").prop("disabled", true);
			$("#l_tinggi").val("").prop("disabled", true);
			$("#nilai_sheet_panjang").val("");
			$("#nilai_sheet_lebar").val("");
			$("#nilai_flute").val("");
		} else if(plh_tipe == "K_BOX"){
			zFlute("disable");
			$("#flute").val("");
			$("#tipe").val("BOX");
			$("#ukuran").val("-");
			$("#ukuran_sheet_p").val("-");
			$("#ukuran_sheet_l").val("-");
			$("#creasing").val(0);
			$("#creasing2").val(0);
			$("#creasing3").val(0);

			$("#l_panjang").val("").prop("disabled", false);
			$("#l_lebar").val("").prop("disabled", false);
			$("#l_tinggi").val("").prop("disabled", false);
			$("#nilai_sheet_panjang").val("");
			$("#nilai_sheet_lebar").val("");
			$("#nilai_flute").val("");
		} else if(plh_tipe == "K_SHEET"){
			zFlute("disable");
			$("#flute").val("");
			$("#tipe").val("SHEET");
			$("#ukuran").val("-");
			$("#ukuran_sheet_p").val("-");
			$("#ukuran_sheet_l").val("-");
			$("#creasing").val(0);
			$("#creasing2").val(0);
			$("#creasing3").val(0);

			$("#l_panjang").val("").prop("disabled", false);
			$("#l_lebar").val("").prop("disabled", false);
			$("#l_tinggi").val("").prop("disabled", true);
			$("#nilai_sheet_panjang").val("");
			$("#nilai_sheet_lebar").val("");
			$("#nilai_flute").val("");
		} else {
			zFlute("disable");
			$("#flute").val("");
			$("#tipe").val("-");
		}
	})

	$('#flute').on('change', function() {
		let tipee = $("#kategori").val();
		let plh_flute = $("#flute").val();

		let r_panjang = parseInt(document.getElementById('l_panjang').value);
		let r_lebar = parseInt(document.getElementById('l_lebar').value);
		let r_tinggi = parseInt(document.getElementById('l_tinggi').value);

		if(isNaN(r_panjang)){
			r_panjang = 0;
		}
		if(isNaN(r_lebar)){
			r_lebar = 0;
		}
		if(isNaN(r_tinggi)){
			r_tinggi = 0;
		}

		if(plh_flute == ""){
			zFlute("disable");
			ruk_p = 0;
			ruk_l = 0;
		} else if(plh_flute == "CB"){
			zFlute("false");
			$("#wall").val("DOUBLE");
			ruk_p = 2 * (r_panjang + r_lebar) + 61;
			ruk_l = r_lebar + r_tinggi + 23;
		} else if(plh_flute == "CF") {
			zFlute("disable");
			$("#M_K").val("").prop("disabled", false);
			$("#F_K").val("").prop("disabled", false);
			$("#M_C").val("").prop("disabled", false);
			$("#F_C").val("").prop("disabled", false);
			$("#M_BL").val("").prop("disabled", false);
			$("#F_BL").val("").prop("disabled", false);
			$("#wall").val("SINGLE");
			ruk_p = 2 * (r_panjang + r_lebar) + 43;
			ruk_l = r_lebar + r_tinggi + 13;
		} else if(plh_flute == "BF") {
			zFlute("disable");
			$("#M_K").val("").prop("disabled", false);
			$("#F_K").val("").prop("disabled", false);
			$("#M_B").val("").prop("disabled", false);
			$("#F_B").val("").prop("disabled", false);
			$("#M_BL").val("").prop("disabled", false);
			$("#F_BL").val("").prop("disabled", false);
			$("#wall").val("SINGLE");
			ruk_p = 2 * (r_panjang + r_lebar) + 39;
			ruk_l = r_lebar + r_tinggi + 9;
		} else {
			zFlute("disable");
			ruk_p = 0;
			ruk_l = 0;
		}

		if(tipee == "K_BOX"){
			$("#ukuran_sheet_p").val(ruk_p);
			$("#ukuran_sheet_l").val(ruk_l);
		}else{ // SHEET
			$("#ukuran_sheet_p").val(r_panjang);
			$("#ukuran_sheet_l").val(r_lebar);
		}
		
		document.getElementById('nilai_sheet_panjang').value = ruk_p;
		document.getElementById('nilai_sheet_lebar').value = ruk_l;
	})

	function cflute(){
		let k = document.getElementById('M_K').value;
		let kk = document.getElementById('F_K').value;
		let b = document.getElementById('M_B').value;
		let bb = document.getElementById('F_B').value;
		let cl = document.getElementById('M_CL').value;
		let clcl = document.getElementById('F_CL').value;
		let c = document.getElementById('M_C').value;
		let cc = document.getElementById('F_C').value;
		let bl = document.getElementById('M_BL').value;
		let blbl = document.getElementById('F_BL').value;

		if(k == "" || kk == ""){
			gabKK = "";
			txtK = "";
		}else{
			gabKK = k + kk;
			txtK = k;
		}

		if(b == "" || bb == ""){
			gabBB = "";
			txtB = "";
		}else{
			gabBB = "/" + b + bb;
			txtB = "/" + b;
		}

		if(cl == "" || clcl == ""){
			gabCL = "";
			txtCL = "";
		}else{
			gabCL = "/" + cl + clcl;
			txtCL = "/" + cl;
		}
		
		if(c == "" || cc == ""){
			gabCC = "";
			txtCC = "";
		}else{
			gabCC = "/" + c + cc;
			txtCC = "/" + c;
		}

		if(bl == "" || blbl == ""){
			gabBL = "";
			txtBL = "";
		}else{
			gabBL = "/" + bl + blbl;
			txtBL = "/" + bl;
		}

		document.getElementById('kualitas').value = gabKK + gabBB + gabCL + gabCC + gabBL;
		document.getElementById('material').value = txtK + txtB + txtCL + txtCC + txtBL;

		let cariBF = Math.round(bb  * 1.36);
		let cariCF = Math.round(cc  * 1.46);

		let plh_flute = $("#flute").val();
		if(plh_flute == ""){
			getNilaiFlute = 0;
		} else if(plh_flute == "CB"){
			getNilaiFlute = parseFloat((parseInt(kk) + cariBF + parseInt(clcl) + cariCF + parseInt(blbl)) / 1000).toFixed(4);
		} else if(plh_flute == "CF") {
			getNilaiFlute = parseFloat((parseInt(kk) + cariCF + parseInt(blbl)) / 1000).toFixed(4);
		} else if(plh_flute == "BF") {
			getNilaiFlute = parseFloat((parseInt(kk) + cariBF + parseInt(blbl)) / 1000).toFixed(4);
		} else {
			getNilaiFlute = 0;
		}

		document.getElementById('nilai_flute').value = getNilaiFlute;
		// alert(getNilaiFlute)
		berhitung()
	}

	function berhitung(){
		let plh_tipe = $("#kategori").val();
		let l_panjang = $("#l_panjang").val();
		let l_lebar = $("#l_lebar").val();
		let l_tinggi = $("#l_tinggi").val();
		let l_qty = $("#l_qty").val();

		if(plh_tipe == "K_BOX"){
			if(l_panjang == '' || l_panjang == 0 || l_lebar == '' || l_lebar == 0 || l_tinggi == '' || l_tinggi == 0){
				txtPL = "";
			}else{
				txtPL = l_panjang + " X " + l_lebar + " X " + l_tinggi;
			}
		}else if(plh_tipe == "K_SHEET"){
			if(l_panjang == '' || l_panjang == 0 || l_lebar == '' || l_lebar == 0){
				txtPL = "";
			}else{
				txtPL = l_panjang + " X " + l_lebar;
			}
		}else{
			txtPL = "";
		}

		if(plh_tipe == ""){
			zFlute("disable");
		} else if(plh_tipe == "K_BOX"){
			$("#ukuran").val(txtPL);
			uSPjg = "nilai_sheet_panjang"
			uSLbr = "nilai_sheet_lebar";
		} else if(plh_tipe == "K_SHEET"){
			$("#ukuran").val("-");
			uSPjg = "l_panjang"
			uSLbr = "l_lebar";
		} else {		
			$("#ukuran").val("-");
		}

		///////

		let nilaiFlute = document.getElementById('nilai_flute').value;

		let h_panjang = parseFloat(document.getElementById(uSPjg).value / 1000);
		let h_lebar = parseFloat(document.getElementById(uSLbr).value / 1000);

		let nilaiBeratBersih = parseFloat(nilaiFlute * h_panjang * h_lebar).toFixed(3);
		let nilaiLuasBersih = parseFloat(h_panjang * h_lebar).toFixed(3);

		if(isNaN(nilaiFlute) || isNaN(h_panjang) || isNaN(h_lebar) || isNaN(nilaiBeratBersih) || nilaiBeratBersih == 0 || isNaN(nilaiLuasBersih) || nilaiLuasBersih == 0){
			document.getElementById('berat_bersih').value = "";
			document.getElementById('luas_bersih').value = "";
		} else {
			document.getElementById('berat_bersih').value = nilaiBeratBersih;
			document.getElementById('luas_bersih').value = nilaiLuasBersih;
		}
    }

</script>
