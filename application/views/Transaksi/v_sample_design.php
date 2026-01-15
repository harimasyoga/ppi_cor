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
			<div class="row row-input">
				<div class="col-md-6">
					<div class="card card-primary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT FORM SAMPLE & DESIGN</h3>
						</div>
						<div style="margin:12px 6px">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<div id="kode_dg"></div>
						<form role="form" method="POST" id="upload_design" enctype="multipart/form-data">
						<div class="card-body row" style="font-weight:bold;padding:6px">
							<div class="col-md-3">TANGGAL</div>
							<div class="col-md-5">
								<input type="date" name="tgl_s" id="tgl_s" class="form-control" onchange="pilihPilih()">
							</div>
							<div class="col-md-4"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 16px">
							<div class="col-md-3">PILIH</div>
							<div class="col-md-5">
								<select name="pilih_s" id="pilih_s" class="form-control select2" onchange="pilihPilih()">
									<option value="">PILIH</option>
									<option value="N">MULTI NASIONAL</option>
									<option value="B">LOKAL</option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
					</div>
					<div class="col-box-po" style="display:none">
						<div class="card card-info card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PILIH PO</h3>
							</div>
							<div class="card-body" style="font-weight:bold;padding:12px 6px">
								<div class="card-body row" style="font-weight:bold;padding:0 0 6px">
									<div class="col-md-3">CUSTOMER</div>
									<div class="col-md-9">
										<select name="i_customer" id="i_customer" class="form-control select2" onchange="loadNoPoDesign()">
											<option value="">PILIH</option>
										</select>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 0 6px">
									<div class="col-md-3">NO. PO</div>
									<div class="col-md-9">
										<select name="i_po" id="i_po" class="form-control select2" onchange="loadProdukDesign()">
											<option value="">PILIH</option>
										</select>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 0 12px">
									<div class="col-md-3">PRODUK</div>
									<div class="col-md-9">
										<select name="i_produk" id="i_produk" class="form-control select2" onchange="detailProdukDesign()">
											<option value="">PILIH</option>
										</select>
									</div>
								</div>

								<div class="card card-secondary card-outline" style="margin:0">
									<div class="card-header" style="padding:12px">
										<h3 class="card-title" style="font-weight:bold;font-size:18px">DETAIL PRODUK</h3>
									</div>
									<div class="card-body" style="overflow:auto;white-space:nowrap;font-weight:bold;padding:6px">
										<div class="d_produk">-</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-box-upload" style="display:none">
						<div class="card card-success card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">UPLOAD FILE</h3>
							</div>
							<div class="card-body" style="padding:12px 0">
									<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
										<div class="col-md-3">PILIH</div>
										<div class="col-md-6">
											<select name="dsg_pilih" id="dsg_pilih" class="form-control select2" onchange="cekUpload()">
												<option value="">PILIH</option>
											</select>
										</div>
										<div class="col-md-3"></div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 6px">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<input type="file" name="dsg_foto" id="dsg_foto" accept="image/*" onchange="cekUpload()">
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<span style="color:#f00;font-style:italic;font-size:12px">* .jpg .jpeg .png .gif .webp | MAX 2 MB</span>
										</div>
									</div>
									<input type="hidden" name="id_dg" id="id_dg" value="">
									<input type="hidden" name="id_pelanggan" id="id_pelanggan" value="">
									<input type="hidden" name="kode_po" id="kode_po" value="">
									<input type="hidden" name="id_produk" id="id_produk" value="">
									<input type="hidden" name="opt" id="opt" value="">
								</form>
								<div class="preview-upload"></div>
								<div class="simpan-upload"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="row row-verifikasi" style="display:none;position:sticky;top:12px;padding-bottom:16px">
						<div class="col-md-12">
							<div class="card card-info card-outline" style="margin:0">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI FORM</h3>
								</div>
								<div class="card-body" style="font-weight:bold;padding:18px 0 12px">
									<div class="card-body row" style="padding:0 6px 6px">
										<div class="col-md-3">ACUAN WARNA</div>
										<div class="col-md-9">
											<div class="vv verif-acuan"></div>
										</div>
									</div>
									<div class="ii input-acuan"></div>
									<div class="card-body row" style="padding:0 6px 6px">
										<div class="col-md-3">PENAWARAN</div>
										<div class="col-md-9">
											<div class="vv verif-penawaran"></div>
										</div>
									</div>
									<div class="ii input-penawaran"></div>
									<div class="card-body row" style="padding:0 6px 6px">
										<div class="col-md-3">FORM DESIGN</div>
										<div class="col-md-9">
											<div class="vv verif-design"></div>
										</div>
									</div>
									<div class="ii input-design"></div>
									<div class="card-body row" style="padding:0 6px 6px">
										<div class="col-md-3">FORM SAMPLE</div>
										<div class="col-md-9">
											<div class="vv verif-sample"></div>
										</div>
									</div>
									<div class="ii input-sample"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="simpan-save"></div>

			<div class="row row-form" style="display:none">
				<?php (in_array($this->session->userdata('level'), ['Admin', 'Marketing', 'Owner', 'User'])) ? $cc = 'col-md-3' : $cc = 'col-md-4'; ?>
				<div class="<?= $cc ?>">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">ACUAN WARNA</h3>
						</div>
						<div style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-acuan" style="display:flex">-</div>
							</div>
						</div>
						<div class="list-warna"></div>
					</div>
				</div>
				<?php if(in_array($this->session->userdata('level'), ['Admin', 'Marketing', 'Owner', 'User'])) { ?>
					<div class="<?= $cc ?>">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PENAWARAN</h3>
							</div>
							<div style="padding:12px 6px">
								<div style="overflow:auto;white-space:nowrap">
									<div class="list-penawaran" style="display:flex">-</div>
								</div>
							</div>
						</div>
					</div>
				<?php }else{ ?>
					<input type="hidden" class="list-penawaran" value="">
				<?php } ?>
				<div class="<?= $cc ?>">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">FORM DESIGN</h3>
						</div>
						<div style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-design" style="display:flex">-</div>
							</div>
						</div>
						<div class="link-design"></div>
						<div class="pdf-design"></div>
					</div>
				</div>
				<div class="<?= $cc ?>">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">FORM SAMPLE</h3>
						</div>
						<div style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-sample" style="display:flex">-</div>
							</div>
						</div>
						<div class="pdf-sample"></div>
					</div>
				</div>
			</div>

			<div class="row row-ppic" style="display:none">
				<div class="col-md-6">
					<div class="card card-info card-outline" style="margin:0">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DESIGN, SAMPLE DAN KARET PPI</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:18px 0 12px">
							<div class="card-body row" style="padding:0 6px 6px">
								<div class="col-md-3">DESIGN</div>
								<div class="col-md-9">
									<div class="vv verif-xdesign"></div>
								</div>
							</div>
							<div class="ii input-xdesign"></div>
							<div class="card-body row" style="padding:0 6px 6px">
								<div class="col-md-3">SAMPLE</div>
								<div class="col-md-9">
									<div class="vv verif-zsample"></div>
								</div>
							</div>
							<div class="ii input-zsample"></div>
							<div class="card-body row" style="padding:0 6px 6px">
								<div class="col-md-3">KARET</div>
								<div class="col-md-9">
									<div class="vv verif-karet"></div>
								</div>
							</div>
							<div class="ii input-karet"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">DESIGN PPI</h3>
						</div>
						<div style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="ppic-design" style="display:flex">-</div>
							</div>
						</div>
						<div class="link-ppic-design"></div>
					</div>
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">SAMPLE PPI</h3>
						</div>
						<div style="padding:12px 6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="ppic-sample" style="display:flex">-</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST FORM SAMPLE & DESIGN</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'User'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php } ?>
							<div class="card-body row" style="padding:0 0 8px;font-weight:bold">
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="tahun" class="form-control select2" onchange="load_data()">
										<?php 
											$thang = date("Y");
											$thang_maks = $thang + 1;
											$thang_min = $thang - 3;
											for ($th = $thang_min; $th <= $thang_maks; $th++)
											{ ?>
												<?php if ($th==$thang) { ?>
													<option selected value="<?= $th ?>"> <?= $thang ?> </option>
												<?php }else{ ?>
													<option value="<?= $th ?>"> <?= $th ?> </option>
												<?php }
											}
										?>
									</select>
								</div>
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="bulan" class="form-control select2" onchange="load_data()">
										<option value="">BULAN</option>
										<option value="1">JANUARI</option>
										<option value="2">FEBRUARI</option>
										<option value="3">MARET</option>
										<option value="4">APRIL</option>
										<option value="5">MEI</option>
										<option value="6">JUNI</option>
										<option value="7">JULI</option>
										<option value="8">AGUSTUS</option>
										<option value="9">SEPTEMBER</option>
										<option value="10">OKTOBER</option>
										<option value="11">NOVEMBER</option>
										<option value="12">DESEMBER</option>
									</select>
								</div>
								<div class="col-md-8" style="padding-bottom:3px"></div>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center;width:5%">#</th>
											<th style="padding:12px;text-align:center;width:30%">RINCIAN<span style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">(detail)</span></th>
											<th style="padding:12px;text-align:center;width:10%">TGL</th>
											<th style="padding:12px;text-align:center;width:10%">STATUS</th>
											<th style="padding:12px;text-align:center;width:5%">FA</th>
											<th style="padding:12px;text-align:center;width:5%">FP</th>
											<th style="padding:12px;text-align:center;width:5%">FD</th>
											<th style="padding:12px;text-align:center;width:5%">FS</th>
											<th style="padding:12px;text-align:center;width:5%">D</th>
											<th style="padding:12px;text-align:center;width:5%">S</th>
											<th style="padding:12px;text-align:center;width:5%">K</th>
											<th style="padding:12px;text-align:center;width:10%">AKSI</th>
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

<div id="mymodal-img" class="modal-img">
	<img class="modal-img-content" id="img01">
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';
	const urlUser = '<?= $this->session->userdata('username')?>';

	$(document).ready(function ()
	{
		$(".row-input").hide()
		$(".row-list").show()
		load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Transaksi/load_data/form_design')?>',
				"type": "POST",
				"data": ({
					tahun, bulan
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

	function imgClick(klik)
	{
		let modal = document.getElementById('mymodal-img')
		let img = document.getElementById(klik)
		let modalImg = document.getElementById("img01")
		img.onclick = function(){
			modal.style.display = "block";
			modalImg.src = this.src;
			modalImg.alt = this.alt;
		}
		modal.onclick = function() {
			img01.className += " out";
			setTimeout(function() {
				modal.style.display = "none";
				img01.className = "modal-img-content";
			}, 400);
		}
	}

	// PREVIEW
	$("#dsg_foto").change(function() {
        readURL(this);
    });
	function readURL(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$(".preview-upload").html(`
				<div class="card-body row" style="font-weight:bold;padding:12px 6px">
					<div class="col-md-3"></div>
					<div class="col-md-9">
						<img id="prevImg" src="${e.target.result}" alt="preview" width="200" class="shadow-sm" onclick="imgClick('prevImg')">
					</div>
				</div>
			`)
		}
		reader.readAsDataURL(input.files[0]);
		} else {
			$(".preview-upload").html(``)
		}
	}

	function pilihPilih() {
		tmplSave()
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		let tgl_s = $("#tgl_s").val()
		let pilih_s = $("#pilih_s").val()

		$(".row-form").hide()
		$(".list-acuan").html('')
		$(".list-warna").html('')
		$(".list-design").html('')
		$(".link-design").html('')
		$(".pdf-sample").html('')
		$(".pdf-design").html('')
		$(".list-penawaran").html('')
		$(".list-sample").html('')
		
		$(".row-ppic").hide()
		$(".ppic-design").html('')
		$(".link-ppic-design").html('')
		$(".ppic-sample").html('')

		$(".col-box-upload").hide()
		
		if(urlAuth == 'Admin'){
			$("#dsg_pilih").html(`
				<option value="">PILIH</option>
				<option value="FA">ACUAN WARNA</option>
				<option value="FP">PENAWARAN</option>
				<option value="FD">FORM DESIGN</option>
				<option value="FS">FORM SAMPLE</option>
				<option value="XD">DESIGN</option>
				<option value="ZS">SAMPLE</option>
			`)
		}else if(urlAuth == 'User'){
			$("#dsg_pilih").html(`
				<option value="">PILIH</option>
				<option value="FA">ACUAN WARNA</option>
				<option value="FP">PENAWARAN</option>
				<option value="FD">FORM DESIGN</option>
				<option value="FS">FORM SAMPLE</option>
			`)
		}else if(urlAuth == 'Design'){
			$("#dsg_pilih").html(`<option value="">PILIH</option><option value="XD">DESIGN</option>`)
		}else if(urlAuth == 'PPIC'){
			$("#dsg_pilih").html(`<option value="">PILIH</option><option value="ZS">SAMPLE</option>`)
		}else{
			$("#dsg_pilih").html(`<option value="">PILIH</option>`)
		}

		$("#dsg_pilih").val("").trigger('change')
		$("#dsg_foto").val("")
		$(".preview-upload").html('')
		$(".simpan-upload").html('')

		$(".row-verifikasi").hide()

		if(tgl_s != "" && pilih_s == "N"){
			$(".col-box-po").hide()
		}else if(tgl_s != "" && pilih_s == "B"){
			$(".col-box-po").show()
			loadCustDesign()
		}else{
			$(".col-box-po").hide()
		}

		if(id_dg != '' && opsi != ''){
			$(".col-box-upload").show()
			$(".row-form").show()
		}
	}

	function tmplSave(p_id = ''){
		let opt = $("#opt").val()
		let tgl_s = $("#tgl_s").val()
		let pilih_s = $("#pilih_s").val()

		if(tgl_s != '' && pilih_s != '' && (statusInput == 'insert' || (statusInput == 'update' && opt == 'edit' && p_id == ''))){
			$(".simpan-save").html(`<div class="row" style="margin-bottom:16px">
				<div class="col-md-12">
					<button class="btn btn-primary btn-sm" onclick="saveDesign()"><i class="fas fa-save"></i> <b>SIMPAN</b></button>
				</div>
			</div>`)
		}else{
			$(".simpan-save").html('')
		}
	}

	function loadCustDesign() {
		let h_id_pelanggan = $("#id_pelanggan").val()
		let opt = $("#opt").val()

		$("#i_customer").html('<option value="">PILIH</option>')
		$("#i_po").html('<option value="">PILIH</option>')
		$("#i_produk").html('<option value="">PILIH</option>')
		$(".d_produk").html('-')
		$.ajax({
			url: '<?php echo base_url('Transaksi/loadCustDesign')?>',
			type: "POST",
			data: ({ h_id_pelanggan, opt }),
			success: function(res){
				data = JSON.parse(res)
				$("#i_customer").html(data.htmlCust)
			}
		})
	}

	function loadNoPoDesign() {
		let h_id_pelanggan = $("#id_pelanggan").val()
		let kode_po = $("#kode_po").val()
		let id_pelanggan = $("#i_customer").val()
		$("#i_po").html('<option value="">PILIH</option>')
		$("#i_produk").html('<option value="">PILIH</option>')
		$(".d_produk").html('-')
		$.ajax({
			url: '<?php echo base_url('Transaksi/loadNoPoDesign')?>',
			type: "POST",
			data: ({ h_id_pelanggan, kode_po, id_pelanggan }),
			success: function(res){
				data = JSON.parse(res)
				$("#i_po").html(data.htmlNoPo)
			}
		})
	}

	function loadProdukDesign() {
		let h_id_pelanggan = $("#id_pelanggan").val()
		let h_kode_po = $("#kode_po").val()
		let h_id_produk = $("#id_produk").val()
		let id_pelanggan = $("#i_customer").val()
		let kode_po = $("#i_po").val()
		$("#i_produk").html('<option value="">PILIH</option>')
		$(".d_produk").html('-')
		$.ajax({
			url: '<?php echo base_url('Transaksi/loadProdukDesign')?>',
			type: "POST",
			data: ({ h_id_pelanggan, h_kode_po, h_id_produk, id_pelanggan, kode_po }),
			success: function(res){
				data = JSON.parse(res)
				$("#i_produk").html(data.htmlProduk)
			}
		})
	}

	function detailProdukDesign() {
		let h_id_produk = $("#id_produk").val()
		let i_customer = $("#i_customer").val()
		let i_po = $("#i_po").val()
		let i_produk = $("#i_produk").val()
		$(".d_produk").html('-')
		$.ajax({
			url: '<?php echo base_url('Transaksi/detailProdukDesign')?>',
			type: "POST",
			data: ({ h_id_produk, i_produk }),
			success: function(res){
				data = JSON.parse(res)
				$(".d_produk").html(data.htmlDtlProduk)
				tmplSave(data.p)
			}
		})
	}

	function cekUpload() {
		let dsg_pilih = $("#dsg_pilih").val()
		let dsg_foto = $("#dsg_foto").val()
		if (dsg_pilih != '' && dsg_foto != '') {
			$(".simpan-upload").html(`<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button class="btn btn-primary btn-sm" onclick="uploadDesign()"><i class="fas fa-save"></i> <b>SIMPAN</b></button>
				</div>
			</div>`)
		} else {
			$(".simpan-upload").html('')
		}
	}

	function uploadDesign() {
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		$(".simpan-upload").prop('disabled', true)

		var form = $('#upload_design')[0];
		var data = new FormData(form);
		$.ajax({
			url: '<?php echo base_url('Transaksi/uploadDesign') ?>',
			type: "POST",
			enctype: 'multipart/form-data',
			data: data,
			contentType: false,
			cache: false,
			timeout: 600000,
			processData: false,
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
					toastr.success(`<b>${data.msg}</b>`)
					if(statusInput == 'insert'){
						$("#dsg_pilih").val("").trigger('change')
						$("#dsg_foto").val("")
						$(".simpan-upload").html('')
						loadListDesign()
					}else{
						editFormDesign(id_dg, opsi)
					}
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					$(".simpan-upload").prop('disabled', false)
					swal.close()
				}
			}
		});
	}

	function deleteDesign(id_dtl) {
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/deleteDesign')?>',
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
			data: ({ id_dtl }),
			success: function(res){
				data = JSON.parse(res)
				editFormDesign(id_dg, opsi)
			}
		})
	}

	function loadListDesign() {
		let id_dg = $("#id_dg").val()
		let opt = $("#opt").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/loadListDesign')?>',
			type: "POST",
			data: ({ id_dg, opt }),
			success: function(res){
				data = JSON.parse(res)
				$(".list-acuan").html(data.htmlAcuan)
				$(".list-warna").html(data.htmlWarna)
				$(".list-penawaran").html(data.htmlPenawaran)
				$(".link-design").html(data.linkDesign)
				$(".list-design").html(data.htmlDesign)
				$(".list-sample").html(data.htmlSample)
				$(".pdf-sample").html(data.htmlPdfSample)
				$(".pdf-design").html(data.htmlPdfDesign)
				$(".ppic-design").html(data.htmlX)
				$(".link-ppic-design").html(data.htmlXLink)
				$(".ppic-sample").html(data.htmlZ)
				swal.close()
			}
		})
	}

	function formSample(opsi_pdf) {
		let qty_pdf = $("#qty_pdf_"+opsi_pdf).val()
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/formSample')?>',
			type: "POST",
			data: ({ opsi_pdf, qty_pdf, id_dg }),
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
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editFormDesign(id_dg, opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function saveDesign() {
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		let tgl_s = $("#tgl_s").val()
		let pilih_s = $("#pilih_s").val()
		let i_customer = $("#i_customer").val()
		let i_po = $("#i_po").val()
		let i_produk = $("#i_produk").val()
		$(".simpan-save").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/saveDesign')?>',
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
			data: ({
				id_dg, opsi, tgl_s, pilih_s, i_customer, i_po, i_produk, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(statusInput == 'insert'){
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						kembali()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
					}
					swal.close()
				}else{
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						editFormDesign(id_dg, opsi)
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						swal.close()
					}
				}
			}
		})
	}

	function btnAcuanWarna() {
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		let plh_warna = $("#plh_warna").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/btnAcuanWarna')?>',
			type: "POST",
			data: ({ id_dg, plh_warna }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editFormDesign(id_dg, opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function addLinkDesign(id_dg) {
		let id_dgx = $("#id_dg").val()
		let opsi = $("#opt").val()
		let link_design = $("#link_design").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/addLinkDesign')?>',
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
			data: ({ id_dgx, link_design }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editFormDesign(id_dgx, opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function kosong() {
		statusInput = 'insert'

		$("#id_dg").val("")
		$("#id_pelanggan").val("")
		$("#kode_po").val("")
		$("#id_produk").val("")
		$("#opt").val("")

		$("#i_customer").prop('disabled', false)
		$("#i_po").prop('disabled', false)
		$("#i_produk").prop('disabled', false)
		
		$("#kode_dg").html('')
		$("#tgl_s").val("").prop('disabled', false)
		$("#pilih_s").val("").prop('disabled', false).trigger('change')

		$("#ii").html('')
		$("#vv").html('')
	}

	function kembali() {
		kosong()
		$(".row-input").hide()
		$(".row-list").show()
		reloadTable()
	}

	function tambahData() {
		kosong()
		$(".row-list").hide()
		$(".row-input").show()
	}

	function editFormDesign(id_dg, opsi) {
		statusInput = 'update'
		$("#kode_dg").html('')
		$(".row-list").hide()
		$(".row-input").show()

		$.ajax({
			url: '<?php echo base_url('Transaksi/editFormDesign')?>',
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
			data: ({
				id_dg, opsi, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				statusInput = 'update'

				$("#id_dg").val(data.header.id_dg)
				$("#id_pelanggan").val(data.header.id_pelanggan)
				$("#kode_po").val(data.header.kode_po)
				$("#id_produk").val(data.header.id_produk)
				$("#opt").val(opsi)

				$("#i_customer").prop('disabled', true)
				$("#i_po").prop('disabled', true)
				$("#i_produk").prop('disabled', true)

				$("#kode_dg").html(`
					<div class="card-body row" style="font-weight:bold;padding:6px 6px 0">
						<div class="col-md-3">KODE</div>
						<div class="col-md-5">
							<input type="text" class="form-control" style="font-weight:bold" value="${data.header.kode_dg}" disabled>
						</div>
						<div class="col-md-4"></div>
					</div>
				`)

				$("#tgl_s").val(data.header.tgl).prop('disabled', true)
				$("#pilih_s").val(data.header.jenis_dg).prop('disabled', true).trigger('change')

				if(opsi == 'edit'){
					if(urlAuth == 'Admin'){
						$(".col-box-upload").show()
					}else if(urlAuth == 'User' && (data.header.acc_a_stt == 'N' || data.header.acc_d_stt == 'N' || data.header.acc_p_stt == 'N' || data.header.acc_s_stt == 'N')){
						$(".col-box-upload").show()
					}else if((urlAuth == 'Design' || urlAuth == 'PPIC') && data.header.acc_a_stt == 'Y' && data.header.acc_d_stt == 'Y' && data.header.acc_p_stt == 'Y' && data.header.acc_s_stt == 'Y' && (data.header.acc_x_stt == 'N' || data.header.acc_z_stt == 'N' || data.header.acc_k_stt == 'N')){
						$(".col-box-upload").show()
					}else{
						$(".col-box-upload").hide()
					}
				}else{
					$(".col-box-upload").hide()
				}

				$(".row-verifikasi").show()

				if(data.header.jenis_dg == 'B' || (data.header.id_pelanggan != null && data.header.kode_po != null && data.header.id_produk != null)){
					loadCustDesign()
					loadNoPoDesign()
					loadProdukDesign()
					detailProdukDesign()
				}
				loadListDesign()

				// VERIFIKASI DATA

				$(".ii").html('')
				$(".vv").html('')

				// VERIFIFIKASI ACUAN
				if(data.imgA != 0 && (urlAuth == 'Admin' || urlAuth == 'User') && (data.header.acc_a_stt == 'N' || data.header.acc_a_stt == 'H' || data.header.acc_a_stt == 'R')){
					// BUTTON ACUAN
					$(".verif-acuan").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'acuan')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'acuan')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'acuan')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN ACUAN
					if(data.header.acc_a_stt != 'N'){
						if(data.header.acc_a_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-acuan").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_acuan" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_a_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_a_stt}', 'acuan')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON ACUAN
					if(data.header.acc_a_stt == 'N'){
						$(".verif-acuan").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_a_stt == 'H'){
						$(".verif-acuan").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.a_time}`)
					}else if(data.header.acc_a_stt == 'R'){
						$(".verif-acuan").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.a_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'acuan')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-acuan").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.a_time}`)
					}
					// KETERANGAN ACUAN
					if(data.header.acc_a_stt != 'N'){
						if(data.header.acc_a_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_a_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-acuan").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_acuan" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_a_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI FORM DESIGN
				if(data.imgD != 0 && (urlAuth == 'Admin' || urlAuth == 'User') && (data.header.acc_d_stt == 'N' || data.header.acc_d_stt == 'H' || data.header.acc_d_stt == 'R')){
					// BUTTON FORM DESIGN
					$(".verif-design").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'design')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'design')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'design')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN FORM DESIGN
					if(data.header.acc_d_stt != 'N'){
						if(data.header.acc_d_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-design").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_design" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_d_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_d_stt}', 'design')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON FORM DESIGN
					if(data.header.acc_d_stt == 'N'){
						$(".verif-design").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_d_stt == 'H'){
						$(".verif-design").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.d_time}`)
					}else if(data.header.acc_d_stt == 'R'){
						$(".verif-design").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.d_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'design')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-design").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.d_time}`)
					}
					// KETERANGAN FORM DESIGN
					if(data.header.acc_d_stt != 'N'){
						if(data.header.acc_d_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_d_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-design").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_design" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_d_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI PENAWARAN
				if(data.imgP != 0 && (urlAuth == 'Admin' || urlAuth == 'User') && (data.header.acc_p_stt == 'N' || data.header.acc_p_stt == 'H' || data.header.acc_p_stt == 'R')){
					// BUTTON PENAWARAN
					$(".verif-penawaran").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'penawaran')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'penawaran')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'penawaran')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN PENAWARAN
					if(data.header.acc_p_stt != 'N'){
						if(data.header.acc_p_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-penawaran").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_penawaran" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_p_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_p_stt}', 'penawaran')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON PENAWARAN
					if(data.header.acc_p_stt == 'N'){
						$(".verif-penawaran").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_p_stt == 'H'){
						$(".verif-penawaran").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.p_time}`)
					}else if(data.header.acc_p_stt == 'R'){
						$(".verif-penawaran").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.p_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'penawaran')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-penawaran").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.p_time}`)
					}
					// KETERANGAN PENAWARAN
					if(data.header.acc_p_stt != 'N'){
						if(data.header.acc_p_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_p_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-penawaran").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_penawaran" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_p_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI SAMPLE
				if(data.imgS != 0 && (urlAuth == 'Admin' || urlAuth == 'User') && (data.header.acc_s_stt == 'N' || data.header.acc_s_stt == 'H' || data.header.acc_s_stt == 'R')){
					// BUTTON SAMPLE
					$(".verif-sample").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'sample')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'sample')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'sample')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN SAMPLE
					if(data.header.acc_s_stt != 'N'){
						if(data.header.acc_s_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-sample").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_sample" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_s_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_s_stt}', 'sample')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON SAMPLE
					if(data.header.acc_s_stt == 'N'){
						$(".verif-sample").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_s_stt == 'H'){
						$(".verif-sample").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.s_time}`)
					}else if(data.header.acc_s_stt == 'R'){
						$(".verif-sample").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.s_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'sample')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-sample").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.s_time}`)
					}
					// KETERANGAN SAMPLE
					if(data.header.acc_s_stt != 'N'){
						if(data.header.acc_s_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_s_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-sample").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_sample" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_s_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// FORM DESIGN DAN SAMPLE PPIC DAN VERIFIKASI

				if(data.header.acc_a_stt == 'Y' && data.header.acc_d_stt == 'Y' && data.header.acc_p_stt == 'Y' && data.header.acc_s_stt == 'Y'){
					$(".col-box-po").show()
					if(data.header.id_pelanggan != null && data.header.kode_po != null && data.header.id_produk != null){
						$(".row-ppic").show()
					}else{
						if((urlAuth == 'Admin' || urlAuth == 'User') && data.header.jenis_dg == 'N' && opsi == 'edit'){
							$("#i_customer").prop('disabled', false)
							$("#i_po").prop('disabled', false)
							$("#i_produk").prop('disabled', false)
						}
						loadCustDesign()
					}
				}

				// VERIFIFIKASI DESIGN PPIC
				if(data.imgX != 0 && (urlAuth == 'Admin' || urlAuth == 'Design') && (data.header.acc_x_stt == 'N' || data.header.acc_x_stt == 'H' || data.header.acc_x_stt == 'R')){
					// BUTTON DESIGN PPIC
					$(".verif-xdesign").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'xdesign')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'xdesign')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'xdesign')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN DESIGN PPIC
					if(data.header.acc_x_stt != 'N'){
						if(data.header.acc_x_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-xdesign").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_xdesign" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_x_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_x_stt}', 'xdesign')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON DESIGN PPIC
					if(data.header.acc_x_stt == 'N'){
						$(".verif-xdesign").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_x_stt == 'H'){
						$(".verif-xdesign").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.x_time}`)
					}else if(data.header.acc_x_stt == 'R'){
						$(".verif-xdesign").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.x_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'xdesign')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-xdesign").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.x_time}`)
					}
					// KETERANGAN DESIGN PPIC
					if(data.header.acc_x_stt != 'N'){
						if(data.header.acc_x_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_x_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-xdesign").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_xdesign" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_x_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI SAMPLE PPIC
				if(data.imgZ != 0 && (urlAuth == 'Admin' || urlAuth == 'PPIC') && (data.header.acc_z_stt == 'N' || data.header.acc_z_stt == 'H' || data.header.acc_z_stt == 'R')){
					// BUTTON SAMPLE PPIC
					$(".verif-zsample").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'zsample')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'zsample')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'zsample')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN SAMPLE PPIC
					if(data.header.acc_z_stt != 'N'){
						if(data.header.acc_z_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-zsample").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_zsample" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_z_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_z_stt}', 'zsample')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON SAMPLE PPIC
					if(data.header.acc_z_stt == 'N'){
						$(".verif-zsample").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_z_stt == 'H'){
						$(".verif-zsample").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.z_time}`)
					}else if(data.header.acc_z_stt == 'R'){
						$(".verif-zsample").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.z_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'zsample')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-zsample").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.z_time}`)
					}
					// KETERANGAN SAMPLE PPIC
					if(data.header.acc_z_stt != 'N'){
						if(data.header.acc_z_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_z_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-zsample").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_zsample" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_z_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI KARET
				if((urlAuth == 'Admin' || urlAuth == 'Design' || urlAuth == 'PPIC') && (data.header.acc_k_stt == 'N' || data.header.acc_k_stt == 'H' || data.header.acc_k_stt == 'R')){
					// BUTTON KARET
					$(".verif-karet").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifDesign('verifikasi', 'karet')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifDesign('hold', 'karet')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifDesign('reject', 'karet')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN KARET
					if(data.header.acc_k_stt != 'N'){
						if(data.header.acc_k_stt == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$(".input-karet").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_karet" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.acc_k_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${data.header.acc_k_stt}', 'karet')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON KARET
					if(data.header.acc_k_stt == 'N'){
						$(".verif-karet").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_k_stt == 'H'){
						$(".verif-karet").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.k_time}`)
					}else if(data.header.acc_k_stt == 'R'){
						$(".verif-karet").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.k_time}`)
					}else{
						if(urlAuth == 'Admin'){
							vstyle = ``; vclick = `onclick="btnVerifDesign('N', 'karet')"`;
						}else{
							vstyle = `;cursor:default"`; vclick = ``;
						}
						$(".verif-karet").html(`<button title="OKE" style="text-align:center${vstyle}" class="btn btn-sm btn-success" ${vclick}><i class="fas fa-check-circle"></i></button> ${data.k_time}`)
					}
					// KETERANGAN KARET
					if(data.header.acc_k_stt != 'N'){
						if(data.header.acc_k_stt == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_k_stt == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$(".input-karet").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="hidden" id="ket_karet" value="">
									<div class="callout ${callout}" style="font-weight:bold;padding:6px;margin:0">${data.header.acc_k_ket}</div>
								</div>
							</div>
						`)
					}
				}

				$(".simpan-save").html('')
			}
		})
	}

	function verifDesign(aksi, status_verif)
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
		$(".input-"+status_verif).html(`
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<div class="callout ${callout}" style="padding:0;margin:0">
						<textarea class="form-control" id="ket_${status_verif}" style="font-weight:bold;padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifDesign('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
				</div>
			</div>
		`)
	}

	function btnVerifDesign(aksi, status_verif)
	{
		let id_dg = $("#id_dg").val()
		let opsi = $("#opt").val()
		let ket = $("#ket_"+status_verif).val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/btnVerifDesign')?>',
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
			data: ({
				id_dg, ket, aksi, status_verif
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editFormDesign(id_dg, opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusDesign(id_dg, kode_dg)
	{
		swal({
			title : kode_dg,
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
				url: '<?php echo base_url('Transaksi/hapusDesign')?>',
				type: "POST",
				data: ({ id_dg }),
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
					if(data.hhdr && data.hdtl){
						reloadTable()
					}else{
						toastr.error(`<b>TERJADI KESALAHAN!</b>`)
					}
					swal.close()
				}
			})
		})
	}
</script>
