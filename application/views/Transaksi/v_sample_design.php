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
				<div class="col-md-12">
					<div class="card card-primary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT FORM SAMPLE & DESIGN</h3>
						</div>
						<div style="margin:12px 6px">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<form role="form" method="POST" id="upload_design" enctype="multipart/form-data">
						<div class="card-body row" style="font-weight:bold;padding:6px">
							<div class="col-md-1">TANGGAL</div>
							<div class="col-md-2">
								<input type="date" name="tgl_s" id="tgl_s" class="form-control" onchange="pilihPilih()">
							</div>
							<div class="col-md-9"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 12px">
							<div class="col-md-1">PILIH</div>
							<div class="col-md-2">
								<select name="pilih_s" id="pilih_s" class="form-control select2" onchange="pilihPilih()">
									<option value="">PILIH</option>
									<option value="N">MULTI NASIONAL</option>
									<option value="B">LOKAL</option>
								</select>
							</div>
							<div class="col-md-9"></div>
						</div>
					</div>
				</div>

				<!-- <div class="col-md-6">
					<div class="col-verifikasi">
						<div class="card card-info card-outline" style="position:sticky;top:12px;padding-bottom:12px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">ACUAN WARNA / SAMPLE CUST</div>
								<div class="col-md-9">
									<div id="verif-admin"></div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">DESIGN</div>
								<div class="col-md-9">
									<div id="verif-marketing"></div>
								</div>
							</div>
							<div id="input-marketing"></div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">SAMPLE BOX</div>
								<div class="col-md-9">
									<div id="verif-owner"></div>
								</div>
							</div>
							<div id="input-owner"></div>
							<div id="input-po"></div>
						</div>
					</div>
				</div> -->

				<div class="col-md-12">
					<div class="col-box-po" style="display:none">
						<div class="card card-info card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PILIH PO</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:12px 6px">
								<div class="col-md-12 row">
									<div class="col-md-6" style="padding:0">
										<div class="card-body row" style="font-weight:bold;padding:0 0 6px">
											<div class="col-md-2">CUSTOMER</div>
											<div class="col-md-10">
												<select name="i_customer" id="i_customer" class="form-control select2">
													<option value="">PILIH</option>
												</select>
											</div>
										</div>
										<div class="card-body row" style="font-weight:bold;padding:0 0 6px">
											<div class="col-md-2">NO. PO</div>
											<div class="col-md-10">
												<select name="i_po" id="i_po" class="form-control select2">
													<option value="">PILIH</option>
												</select>
											</div>
										</div>
										<div class="card-body row" style="font-weight:bold;padding:0 0 12px">
											<div class="col-md-2">PRODUK</div>
											<div class="col-md-10">
												<select name="i_produk" id="i_produk" class="form-control select2">
													<option value="">PILIH</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="card card-secondary card-outline" style="margin:0">
											<div class="card-header" style="padding:12px">
												<h3 class="card-title" style="font-weight:bold;font-size:18px">DETAIL PRODUK</h3>
											</div>
											<div class="card-body" style="font-weight:bold;padding:6px 6px 12px">
												-
											</div>
										</div>
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
										<div class="col-md-1">PILIH</div>
										<div class="col-md-2">
											<select name="dsg_pilih" id="dsg_pilih" class="form-control select2" onchange="cekUpload()">
												<option value="">PILIH</option>
												<option value="AW">ACUAN WARNA / SAMPLE CUSTOMER</option>
												<option value="DG">DESIGN</option>
												<option value="PW">PENAWARAN</option>
												<option value="SP">SAMPLE</option>
											</select>
										</div>
										<div class="col-md-9"></div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
										<div class="col-md-1"></div>
										<div class="col-md-11">
											<input type="file" name="dsg_foto" id="dsg_foto" accept="image/*" onchange="cekUpload()">
										</div>
									</div>
									<input type="hidden" name="id_cart" id="id_cart" value="0">
									<input type="hidden" name="nm64" id="nm64" value="">
								</form>
								<div class="simpan-upload"></div>
								<div class="list-sementara"></div>
							</div>
						</div>
					</div>

					<div class="col-box-acuan" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">ACUAN WARNA / SAMPLE CUSTOMER</h3>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-acuan" style="display:flex;padding:12px 6px"></div>
							</div>
						</div>
					</div>

					<div class="col-box-design" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">DESIGN</h3>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-design" style="display:flex;padding:12px 6px"></div>
							</div>
						</div>
					</div>

					<div class="col-box-penawaran" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PENAWARAN</h3>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-penawaran" style="display:flex;padding:12px 6px"></div>
							</div>
						</div>
					</div>

					<div class="col-box-sample" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">SAMPLE</h3>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-sample" style="display:flex;padding:12px 6px"></div>
							</div>
						</div>
					</div>
				</div>

				<input type="hidden" id="id_hdr" value="">
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
											<th style="padding:12px;text-align:center">#</th>
											<th style="padding:12px;text-align:center">RINCIAN<span style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">(order)</span></th>
											<th style="padding:12px;text-align:center">TGL</th>
											<th style="padding:12px;text-align:center">STATUS</th>
											<th style="padding:12px;text-align:center">DESIGN</th>
											<th style="padding:12px;text-align:center">S. CUST</th>
											<th style="padding:12px;text-align:center">S. BOX</th>
											<th style="padding:12px;text-align:center">AKSI</th>
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
		// load_data()
		$('.select2').select2();
		$(".list-sementara").load("<?php echo base_url('Transaksi/destroyDesign') ?>")
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
				"url": '<?php echo base_url('Transaksi/load_data/trs_po_roll')?>',
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

	document.getElementById("dsg_foto").addEventListener("change", function(event) {
		const file = event.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(e) {
				$("#nm64").val(e.target.result)
			}
			reader.readAsDataURL(file);
		}
	});

	function pilihPilih() {
		let tgl_s = $("#tgl_s").val()
		let pilih_s = $("#pilih_s").val()
		$(".list-sementara").load("<?php echo base_url('Transaksi/destroyDesign') ?>")

		$(".list-acuan").html('')
		$(".list-design").html('')
		$(".list-penawaran").html('')
		$(".list-sample").html('')

		$("#dsg_pilih").val("").trigger('change')
		$("#dsg_foto").val("")
		$(".simpan-upload").html('')

		if(tgl_s != "" && pilih_s == "N"){
			$(".col-box-po").hide()
			$(".col-box-upload").show()
			$(".col-box-acuan").show()
			$(".col-box-design").show()
			$(".col-box-penawaran").show()
			$(".col-box-sample").show()
		}else if(tgl_s != "" && pilih_s == "B"){
			$(".col-box-po").show()
			$(".col-box-upload").show()
			$(".col-box-acuan").show()
			$(".col-box-design").show()
			$(".col-box-penawaran").show()
			$(".col-box-sample").show()
		}else{
			$(".col-box-po").hide()
			$(".col-box-upload").hide()
			$(".col-box-acuan").hide()
			$(".col-box-design").hide()
			$(".col-box-penawaran").hide()
			$(".col-box-sample").hide()
		}
	}

	function cekUpload() {
		let dsg_pilih = $("#dsg_pilih").val()
		let dsg_foto = $("#dsg_foto").val()
		if (dsg_pilih != '' && dsg_foto != '') {
			$(".simpan-upload").html(`<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
				<div class="col-md-1"></div>
				<div class="col-md-11">
					<button class="btn btn-success btn-sm" onclick="addCartDesign()"><i class="fas fa-plus"></i> <b>ADD</b></button>
				</div>
			</div>`)
		} else {
			$(".simpan-upload").html('')
		}
	}

	function addCartDesign() {
		let tgl_s = $("#tgl_s").val()
		let pilih_s = $("#pilih_s").val()
		let dsg_pilih = $("#dsg_pilih").val()

		var form = $('#upload_design')[0];
		var data2 = new FormData(form);
		// let dsg_foto = $("#dsg_foto").val()

		let id_cart = parseInt($("#id_cart").val()) + 1
		$("#id_cart").val(id_cart)
		$.ajax({
			url: '<?php echo base_url('Transaksi/addCartDesign')?>',
			type: "POST",
			enctype: 'multipart/form-data',
			contentType: false,
			processData: false,
			data: data2,
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#dsg_pilih").val("").trigger('change')
				$("#dsg_foto").val("")
				$(".simpan-upload").html('')
				tampilAllList()
			}
		})
	}

	function tampilAllList() {
		$.ajax({
			url: '<?php echo base_url('Transaksi/tampilAllList')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".list-acuan").html(data.htmlAcuan)
				$(".list-design").html(data.htmlDesign)
				$(".list-penawaran").html(data.htmlPenawaran)
				$(".list-sample").html(data.htmlSample)
			}
		})
	}

	function hapusCartDesign(rowid)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusCartDesign')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				tampilAllList()
			}
		})
	}
</script>
