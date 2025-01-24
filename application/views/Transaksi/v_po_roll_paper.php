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
			<div class="row row-input" style="display: none;">
				<div class="col-md-6">
					<div class="card card-primary card-outline" style="position:sticky;top:12px;padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT PO ROLL PAPER</h3>
						</div>
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<form role="form" method="post" id="myForm" action="<?php echo base_url('Transaksi/UploadFilePORoll')?>" enctype="multipart/form-data">
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TGL. INPUT PO</div>
								<div class="col-md-9">
									<input type="date" id="tgl" name="tgl" class="form-control" value="<?= date('Y-m-d')?>" onchange="diPilih()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">CUSTOMER</div>
								<div class="col-md-9">
									<select id="nm_pelanggan" name="nm_pelanggan" class="form-control select2" onchange="diPilih()">
										<option value="">PILIH</option>
										<?php
											$db = $this->load->database('database_simroll', TRUE);
											$query = $db->query("SELECT*FROM m_perusahaan WHERE jns='ROLL' GROUP BY nm_perusahaan, pimpinan");
											$html = '';
											foreach($query->result() as $r){
												if($r->pimpinan == '-' && $r->nm_perusahaan != '-'){
													$nm = $r->nm_perusahaan;
												}else if($r->pimpinan != '-' && $r->nm_perusahaan == '-'){
													$nm = $r->pimpinan;
												}else if($r->pimpinan != '-' && $r->nm_perusahaan != '-'){
													$nm = $r->nm_perusahaan.' - '.$r->pimpinan;
												}
												$html .= '<option value="'.$nm.'">'.$nm.'</option>';
											}
											echo $html;
										?>
									</select>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">NO. PO</div>
								<div class="col-md-9">
									<input type="text" id="no_po" name="no_po" class="form-control" placeholder="NO. PO" autocomplete="off" oninput="this.value=this.value.toUpperCase()" onkeyup="diPilih()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MARKETING</div>
								<div class="col-md-9">
									<select id="id_sales" name="id_sales" class="form-control select2" onchange="diPilih()">
										<option value="">PILIH</option>
										<?php
											$query2 = $this->db->query("SELECT*FROM m_sales GROUP BY nm_sales");
											$html2 = '';
											foreach($query2->result() as $r2){
												$html2 .= '<option value="'.$r2->id_sales.'">'.$r2->nm_sales.'</option>';
											}
											echo $html2;
										?>
									</select>
								</div>
							</div>
							<div class="add-file">
								<div class="card-body row" style="font-weight:bold;padding:0 12px">
									<div class="col-md-3">FILE</div>
									<div class="col-md-9">
										<input type="file" name="filefoto" id="filefoto" accept=".jpg,.png,.pdf" onchange="diPilih()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9" style="color:#f00;font-size:12px;font-style:italic">
										* .jpg, .png, .pdf
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<div class="simpan-save"></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="col-md-6">
					<div class="col-verifikasi" style="display: none;">
						<div class="card card-info card-outline" style="position:sticky;top:12px;padding-bottom:12px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">ADMIN</div>
								<div class="col-md-9">
									<div id="verif-admin"></div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MARKETING</div>
								<div class="col-md-9">
									<div id="verif-marketing"></div>
								</div>
							</div>
							<div id="input-marketing"></div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">OWNER</div>
								<div class="col-md-9">
									<div id="verif-owner"></div>
								</div>
							</div>
							<div id="input-owner"></div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-detail" style="display: none;">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">DETAIL PO</h3>
							</div>
							<div class="card-body" style="padding:12px 6px">
								<div class="detail-po"></div>
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
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PO ROLL PAPER</h3>
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
											$thang_maks = $thang + 2;
											$thang_min = $thang - 2;
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
											<th style="padding:12px;text-align:center">NO. PO</th>
											<th style="padding:12px;text-align:center">TGL</th>
											<th style="padding:12px;text-align:center">STATUS</th>
											<th style="padding:12px;text-align:center">CUSTOMER</th>
											<th style="padding:12px;text-align:center">MKT</th>
											<th style="padding:12px;text-align:center">OWNER</th>
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
	const betul = '<?= $data ?>';
	const msg = '<?= $msg ?>';

	$(document).ready(function ()
	{
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

	function tambahData()
	{
		$(".row-input").show()
		$(".row-list").hide()
	}

	function kembali()
	{
		if(urlAuth == 'MR' || urlAuth == 'Owner'){
			backList()
		}else{
			window.location.href = '<?php echo base_url('Transaksi/PO_Roll_Paper')?>'
		}
	}

	function diPilih(){
		let tgl = $("#tgl").val()
		let nm_pelanggan = $("#nm_pelanggan").val()
		let no_po = $("#no_po").val()
		let id_sales = $("#id_sales").val()
		let filefoto = $("#filefoto").val()

		if(tgl != '' && nm_pelanggan != '' && no_po != '' && id_sales != '' && filefoto != ''){
			$(".simpan-save").html('<button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> <b>SIMPAN</b></button>')
		}else{
			$(".simpan-save").html('')
		}
	}

	function backList()
	{
		$(".row-input").hide()
		$(".row-list").show()
		reloadTable()
	}

	function editPORoll(id_hdr, opsi)
	{
		$(".detail-po").html('')
		$(".add-file").html('')
		$("#input-marketing").html('')
		$("#input-owner").html('')
		$(".row-list").hide()
		$(".row-input").show()
		$(".col-verifikasi").show()
		$(".col-detail").show()

		$.ajax({
			url: '<?php echo base_url('Transaksi/editPORoll')?>',
			type: "POST",
			data: ({ id_hdr, opsi }),
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
				console.log(data)

				$("#id_hdr").val(data.header.id_hdr)
				$("#tgl").val(data.header.tgl_po).prop('disabled', true)
				$("#nm_pelanggan").val(data.header.nm_pelanggan).prop('disabled', true).trigger('change')
				$("#no_po").val(data.header.no_po).prop('disabled', true)
				$("#id_sales").val(data.header.id_sales).prop('disabled', true).trigger('change')
				$(".detail-po").html(data.htmlDtl)

				if(data.ext != 'pdf'){
					let modal = document.getElementById('mymodal-img')
					let img = document.getElementById('preview_img')
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

				// VERIFIKASI DATA
				$("#verif-admin").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.oke_admin}`)
				// VERIFIFIKASI MARKETING
				if((urlAuth == 'Admin' || urlAuth == 'MR') && data.opsi == 'verif' && data.header.owner_status == 'N' && (data.header.mkt_status == 'N' || data.header.mkt_status == 'H' || data.header.mkt_status == 'R')){
					// BUTTON MARKETING
					$("#verif-marketing").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifPORoll('verifikasi','marketing')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifPORoll('hold','marketing')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifPORoll('reject','marketing')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN MARKETING
					if(data.header.mkt_status != 'N'){
						if(data.header.mkt_status == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$("#input-marketing").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_roll" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.mkt_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifPORoll('${data.header.mkt_status}', 'marketing')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON MARKETING
					if(data.header.mkt_status == 'N'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.mkt_status == 'H'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.mkt_time}`)
					}else if(data.header.mkt_status == 'R'){
						$("#verif-marketing").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.mkt_time}`)
					}else{
						$("#verif-marketing").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.mkt_time}`)
					}
					// KETERANGAN MARKETING
					if(data.header.mkt_status != 'N'){
						if(data.header.mkt_status == 'H'){
							callout = 'callout-warning'
						}else if(data.header.mkt_status == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$("#input-marketing").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:6px;margin:0">${data.header.mkt_ket}</div>
								</div>
							</div>
						`)
					}
				}

				// VERIFIFIKASI OWNER
				if((urlAuth == 'Admin' || urlAuth == 'Owner') && data.opsi == 'verif' && data.header.mkt_status == 'Y' && (data.header.owner_status == 'N' || data.header.owner_status == 'H' || data.header.owner_status == 'R')){
					// BUTTON OWNER
					$("#verif-owner").html(`
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifPORoll('verifikasi','owner')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifPORoll('hold','owner')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifPORoll('reject','owner')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN OWNER
					if(data.header.owner_status != 'N'){
						if(data.header.owner_status == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.owner_ket}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifPORoll('${data.header.owner_status}', 'owner')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON OWNER
					if(data.header.owner_status == 'N'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.owner_status == 'H'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.owner_time}`)
					}else if(data.header.owner_status == 'R'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.owner_time}`)
					}else{
						$("#verif-owner").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.owner_time}`)
					}
					// KETERANGAN OWNER
					if(data.header.owner_status != 'N'){
						if(data.header.owner_status == 'H'){
							callout = 'callout-warning'
						}else if(data.header.owner_status == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:6px;margin:0">${data.header.owner_ket}</div>
								</div>
							</div>
						`)
					}
				}
				swal.close()
			}
		})
	}

	function verifPORoll(aksi, status_verif)
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
		(status_verif == 'marketing') ? input_verif = 'input-marketing' : input_verif ='input-owner';
		$("#"+input_verif).html(`
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<div class="callout ${callout}" style="padding:0;margin:0">
						<textarea class="form-control" id="ket_roll" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifPORoll('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
				</div>
			</div>
		`)
	}

	function btnVerifPORoll(aksi, status_verif)
	{
		let id_hdr = $("#id_hdr").val()
		let ket_roll = $("#ket_roll").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/btnVerifPORoll')?>',
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
				id_hdr, ket_roll, aksi, status_verif
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.result){
					backList()
				}else{
					toastr.error(`<b>KETERANGAN TIDAK BOLEH KOSONG!</b>`)
				}
				swal.close()
			}
		})
	}

	function hapusPORoll(id_hdr)
	{
		swal({
			title : "PO Roll Paper",
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
				url: '<?php echo base_url('Transaksi/hapusPORoll')?>',
				type: "POST",
				data: ({ id_hdr }),
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
					console.log(data)
					if(data.hhdr){
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
