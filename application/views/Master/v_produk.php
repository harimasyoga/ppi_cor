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
							<th style="width:5%">NO.</th>
							<th style="width:20%">CUSTOMER</th>
							<th style="width:23%">ITEM</th>
							<th style="width:14%">BOX</th>
							<th style="width:14%">SHEET</th>
							<th style="width:5%">FLUTE</th>
							<th style="width:14%">KUALITAS</th>
							<th style="width:5%">AKSI</th>
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
							<td style="padding:5px 0;font-weight:bold">CUSTOMER</td>
							<td style="padding:5px 0" colspan="9">
								<select class="form-control select2" id="no_customer"></select>
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">ATTN</td>
							<td style="padding:5px 0" colspan="4" id="attn"></td>
							<td style="padding:5px 0;font-weight:bold">PROVINSI</td>
							<td style="padding:5px 0" colspan="4" id="provinsi"></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">ALAMAT</td>
							<td style="padding:5px 5px 5px 0;vertical-align:top" colspan="4" rowspan="4" id="alamat"></td>
							<td style="padding:5px 0;font-weight:bold">KABUPATEN</td>
							<td style="padding:5px 0" colspan="4" id="kabupaten">
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0"></td>
							<td style="padding:5px 0;font-weight:bold">KECAMATAN</td>
							<td style="padding:5px 0" colspan="4" id="kecamatan">
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0"></td>
							<td style="padding:5px 0;font-weight:bold">KELURAHAN</td>
							<td style="padding:5px 0" colspan="4" id="kelurahan">
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0"></td>
							<td style="padding:5px 0;color:#fff" colspan="5">-</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">NAMA ITEM</td>
							<td style="padding:5px 0" colspan="7">
								<input type="text" class="form-control" id="nm_produk" placeholder="NAMA PRODUK" autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">KODE MC</td>
							<td style="padding:5px 0" colspan="7">
								<!-- <input type="hidden" class="form-control" id="customer"> -->
								<input type="hidden" class="form-control" id="id">
								<input type="text" class="form-control" id="kode_mc" placeholder="KODE MC" autocomplete="off">
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">KATEGORI</td>
							<td style="padding:5px 0" colspan="3">
								<select class="form-control" id="kategori">
									<option value="">PILIH</option>
									<option value="K_BOX">PRODUK BOX</option>
									<option value="K_SHEET">PRODUK SHEET</option>
								</select>
							</td>
							<td></td>
							<td style="padding:5px 0;font-weight:bold">TYPE</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="tipe" placeholder="-" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">P / L / T</td>
							<td style="padding:5px 2px 5px 0"><input type="text" class="form-control" id="l_panjang" placeholder="P" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td style="padding:5px 2px"><input type="text" class="form-control" id="l_lebar" placeholder="L" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td style="padding:5px 0 5px 2px"><input type="text" class="form-control" id="l_tinggi" placeholder="T" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off" onchange="berhitung()"></td>
							<td></td>
							<td style="padding:5px 0;font-weight:bold">UKURAN BOX</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="ukuran" placeholder="-" autocomplete="off" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">CREASING</td>
							<td style="padding:5px 2px 5px 0"><input type="text" class="form-control" id="creasing" placeholder="1" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td style="padding:5px 2px"><input type="text" class="form-control" id="creasing2" placeholder="2" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td style="padding:5px 0 5px 2px"><input type="text" class="form-control" id="creasing3" placeholder="3" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete="off"></td>
							<td></td>
							<td style="padding:5px 0;font-weight:bold">UKURAN SHEET</td>
							<td style="padding:5px 5px 5px 0">
								<input type="text" class="form-control" placeholder="PANJANG" name="ukuran_sheet_p" id="ukuran_sheet_p" disabled>
							</td>
							<td style="padding:5px 0 5px 5px">
								<input type="text" class="form-control" placeholder="LEBAR" name="ukuran_sheet_l" id="ukuran_sheet_l" disabled>
								<input type="hidden" class="form-control" id="ukuran_sheet" placeholder="-" autocomplete="off" disabled>
							</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">FLUTE</td>
							<td style="padding:5px 0">
								<select class="form-control" id="flute">
									<option value="">PILIH</option>
									<option value="BCF">BCF</option>
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
							<td style="padding:5px 0;font-weight:bold">KUALITAS</td>
							<td style="padding:5px 0" colspan="3"><input type="text" class="form-control" id="kualitas" placeholder="-" disabled></td>
							<td></td>
							<td style="padding:5px 0;font-weight:bold">MATERIAL</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="material" placeholder="-" disabled></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">BERAT BERSIH</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="berat_bersih" placeholder="-" disabled></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">LUAS BERSIH</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="luas_bersih" placeholder="-" disabled></td>
							<td></td>
							<td style="padding:5px 0;font-weight:bold">TOLERANSI KIRIM</td>
							<td style="padding:5px 0"><input type="text" class="form-control" id="toleransi_kirim" maxlength="3" onkeypress="return hanyaAngka(event)" placeholder="-"></td>
							<td style="padding:5px 0 5px 5px">%</td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">SAMBUNGAN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="sambungan" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">NO DESIGN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_design" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">TIPE BOX</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="tipe_box" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">WARNA</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="warna" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">DESIGN</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="design" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">JENIS PRODUK</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jenis_produk" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0;font-weight:bold">JML IKAT</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_ikat" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">JML PALET</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_palet" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">JML PAKU</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="jml_paku" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0 5px 5px;font-weight:bold">NO KARET</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_karet" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">NO PISAU</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="no_pisau" placeholder="-" autocomplete="off"></td>
						</tr>
						<tr>
							<td style="padding:5px 0 5px 5px;font-weight:bold">SPESIAL REQUEST</td>
							<td style="padding:5px 0" colspan="2"><input type="text" class="form-control" id="spesial_req" placeholder="-" autocomplete="off"></td>
							<td style="padding:5px 0 5px 5px;font-weight:bold">COA</td>
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
		$('.select2').select2({
			dropdownAutoWidth: true
		});
	});

	status = "insert";
	$(".tambah_data").click(function(event) {
		status = "insert";
		kosong();
		getPlhCustomer()
		$("#judul").html('<h3> Form Tambah Data</h3>');
		$("#modalForm").modal("show");
	});

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Transaksi/load_data/produk',
				"type": "POST",
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}),
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
		id = $("#id").val();
		kode_mc = $("#kode_mc").val();
		nm_produk = $("#nm_produk").val();
		no_customer = $("#no_customer").val();
		// customer = $("#customer").val();
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

		if (kode_mc == '' || nm_produk == '' || no_customer == '' || ukuran == '' || ukuran_sheet == '' || sambungan == '' || tipe == '' || material == '' || wall == '' || creasing == '' || creasing2 == '' || creasing3 == '' || flute == '' || berat_bersih == '' || luas_bersih == '' || kualitas == '' || warna == '' || no_design == '' || design == '' || tipe_box == '' || jenis_produk == '' || kategori == '' || cCOA == '' || jml_ikat == '' || jml_palet == '' || jml_paku == '' || no_pisau == '' || no_karet == '' || toleransi_kirim == '' || spesial_req == '') {
			toastr.info('Harap Lengkapi Form');
			$("#btn-simpan").prop("disabled", false);
			return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/Insert') ?>',
			type: "POST",
			data: ({
				id, kode_mc, nm_produk, no_customer, ukuran, ukuran_sheet, sambungan, tipe, material, wall, l_panjang, l_lebar, l_tinggi, creasing, creasing2, creasing3, flute, berat_bersih, luas_bersih, kualitas, warna, no_design, design, tipe_box, jenis_produk, kategori, COA:cCOA, jml_ikat, jml_palet, jml_paku, no_pisau, no_karet, toleransi_kirim, spesial_req, ukuran_sheet_p, ukuran_sheet_l, jenis: 'm_produk', status: status
			}),
			success: function(json) {
				data = JSON.parse(json)
				// console.log(data)
				if(data.result == true) {
					toastr.success('BERHASIL DISIMPAN!');
					kosong();
					$("#modalForm").modal("hide");
					reloadTable();
				}else{
					toastr.error('ITEM SUDAH ADA!');
					$("#btn-simpan").prop("disabled", false);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('TERJADI KESALAHAN!');
			}
		});
	}

	$('#no_customer').on('change', function() {
		let detail = $('#no_customer option:selected').attr('data-detail');
		let attn = $('#no_customer option:selected').attr('attn');
		let prov = $('#no_customer option:selected').attr('prov');
		let kab = $('#no_customer option:selected').attr('kab');
		let kec = $('#no_customer option:selected').attr('kec');
		let kel = $('#no_customer option:selected').attr('kel');
		let alamat = $('#no_customer option:selected').attr('alamat');
		// alert(detail+" - "+attn+" - "+prov+" - "+kab+" - "+kec+" - "+kel+" - "+alamat)
		$("#attn").html(attn);
		$("#provinsi").html(prov);
		$("#kabupaten").html(kab);
		$("#kecamatan").html(kec);
		$("#kelurahan").html(kel);
		$("#alamat").html(alamat);

		$("#customer").val(detail);
		let cust = $("#no_customer").val();
		if(cust == ""){
			kosong()
		}
	})

	function getPlhCustomer() {
		$.ajax({
			url: '<?php echo base_url('Master/getPlhCustomer')?>',
			type: "POST",
			success: function(json) {
				data = JSON.parse(json)
				// console.log(data)

				let htmlCust = ''	
				htmlCust += `<option value="">PILIH</option>`
				data.forEach(loadCust)
				function loadCust(r, index) {
					htmlCust += `<option value="${r.id_pelanggan}" data-detail="${(r.nm_pelanggan == null) ? '-' : r.nm_pelanggan}" attn="${(r.attn == null) ? '-' : r.attn}" prov="${(r.prov_name == null) ? '-' : r.prov_name}" kab="${(r.kab_name == null) ? '-' : r.kab_name}" kec="${(r.kec_name == null) ? '-' : r.kec_name}" kel="${(r.kel_name == null) ? '-' : r.kel_name}" alamat="${(r.alamat == null) ? '-' : r.alamat}">${r.nm_pelanggan}</option>`
				}
				$("#no_customer").prop("disabled", false).html(htmlCust)
			}
		})
	}

	function kosong() {
		$("#attn").html("-");
		$("#alamat").html("-");
		$("#provinsi").html("-");
		$("#kabupaten").html("-");
		$("#kecamatan").html("-");
		$("#kelurahan").html("-");

		$("#id").val("");
		$("#kode_mc").val("");
		$("#nm_produk").val("");
		$("#no_customer").val("").prop("disabled", true);
		// $("#customer").val("");
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
		$("#creasing").val("").prop("disabled", false);
		$("#creasing2").val("").prop("disabled", false);
		$("#creasing3").val("").prop("disabled", false);
		$("#flute").val("").prop("disabled", false);
		$("#berat_bersih").val("");
		$("#luas_bersih").val("");
		$("#kualitas").val("");
		$("#warna").val("-");
		$("#no_design").val("-");
		$("#design").val("-");
		$("#tipe_box").val("-");
		$("#jenis_produk").val("-");
		$("#kategori").val("").prop("disabled", false);
		$("#COA").val("-");
		$("#jml_ikat").val("-");
		$("#jml_palet").val("-");
		$("#jml_paku").val("-");
		$("#no_pisau").val("-");
		$("#no_karet").val("-");
		$("#toleransi_kirim").val(0);
		$("#spesial_req").val("-");
		status = 'insert';
		$("#btn-simpan").show().prop("disabled", false);
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
			url: '<?php echo base_url('Master/getEditProduk'); ?>',
			type: 'POST',
			data: ({
				id
			})
		})
		.done(function(json) {
			data = JSON.parse(json)
			// console.log(data)
			$("#id").val(data.produk.id_produk);
			// $("#customer").val(data.produk.customer);
			
			let htmlCust = ''
			htmlCust += `<option value="${data.produk.no_customer}"
				data-detail="${data.produk.customer}"
				attn="${data.wilayah.attn}"
				prov="${data.wilayah.prov_name}"
				kab="${data.wilayah.kab_name}"
				kec="${data.wilayah.kec_name}"
				kel="${data.wilayah.kel_name}"
				alamat="${data.wilayah.alamat}">
					${data.produk.customer}
			</option>`
			if(data.poDetail.length == 0){
				data.pelanggan.forEach(loadCust)
				function loadCust(r, index) {
					htmlCust += `<option value="${r.id_pelanggan}" data-detail="${r.nm_pelanggan}" attn="${r.attn}" prov="${(r.prov_name == null) ? '-' : r.prov_name}" kab="${(r.kab_name == null) ? '-' : r.kab_name}" kec="${(r.kec_name == null) ? '-' : r.kec_name}" kel="${(r.kel_name == null) ? '-' : r.kel_name}" alamat="${r.alamat}">
						${r.nm_pelanggan}
					</option>`
				}
			}
			$("#no_customer").html(htmlCust).prop("disabled", (data.poDetail.length == 0) ? false : true);

			$("#attn").html(data.wilayah.attn);
			$("#alamat").html(data.wilayah.alamat);
			$("#provinsi").html((data.wilayah.prov_name == null) ? '-' : data.wilayah.prov_name);
			$("#kabupaten").html((data.wilayah.kab_name == null) ? '-' : data.wilayah.kab_name);
			$("#kecamatan").html((data.wilayah.kec_name == null) ? '-' : data.wilayah.kec_name);
			$("#kelurahan").html((data.wilayah.kel_name == null) ? '-' : data.wilayah.kel_name);

			$("#kode_mc").val(data.produk.kode_mc);
			// $("#kode_mc_lama").val(data.produk.kode_mc);
			$("#nm_produk").val(data.produk.nm_produk);
			$("#ukuran").val(data.produk.ukuran);
			$("#ukuran_sheet_p").val(data.produk.ukuran_sheet_p);
			$("#ukuran_sheet_l").val(data.produk.ukuran_sheet_l);
			$("#sambungan").val(data.produk.sambungan);
			$("#tipe").val(data.produk.tipe);
			$("#material").val(data.produk.material);
			$("#wall").val(data.produk.wall);
			$("#l_panjang").val(data.produk.l_panjang);
			$("#l_lebar").val(data.produk.l_lebar);
			$("#l_tinggi").val(data.produk.l_tinggi);
			$("#creasing").val(data.produk.creasing).prop("disabled", (data.poDetail.length == 0) ? false : true);
			$("#creasing2").val(data.produk.creasing2).prop("disabled", (data.poDetail.length == 0) ? false : true);
			$("#creasing3").val(data.produk.creasing3).prop("disabled", (data.poDetail.length == 0) ? false : true);
			$("#flute").val(data.produk.flute).prop("disabled", (data.poDetail.length == 0) ? false : true);
			$("#berat_bersih").val(data.produk.berat_bersih);
			$("#luas_bersih").val(data.produk.luas_bersih);
			$("#kualitas").val(data.produk.kualitas);
			$("#warna").val(data.produk.warna);
			$("#no_design").val(data.produk.no_design);
			$("#design").val(data.produk.design);
			$("#tipe_box").val(data.produk.tipe_box);
			$("#jenis_produk").val(data.produk.jenis_produk);
			$("#kategori").val(data.produk.kategori).prop("disabled", (data.poDetail.length == 0) ? false : true);
			$("#COA").val(data.produk.COA);
			$("#jml_ikat").val(data.produk.jml_ikat);
			$("#jml_palet").val(data.produk.jml_palet);
			$("#jml_paku").val(data.produk.jml_paku);
			$("#no_pisau").val(data.produk.no_pisau);
			$("#no_karet").val(data.produk.no_karet);
			$("#toleransi_kirim").val(data.produk.toleransi_kirim);
			$("#spesial_req").val(data.produk.spesial_req);
		})
	}


	function deleteData(id) {
		let cek = confirm("Apakah Anda Yakin?");

		if (cek) {
			$.ajax({
				url: '<?php echo base_url(); ?>Master/hapus',
				data: ({
					id: id,
					jenis: 'm_produk',
					field: 'id_produk'
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
			$("#ukuran_sheet_p").val("");
			$("#ukuran_sheet_l").val("");
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
			$("#ukuran_sheet_p").val("");
			$("#ukuran_sheet_l").val("");
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
		} else if(plh_flute == "BCF"){
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
		} else if(plh_flute == "BCF"){
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
