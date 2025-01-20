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
					<div class="card card-success card-outline" style="position:sticky;top:12px;padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT PO ROLL PAPER</h3>
						</div>
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick=""><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<form role="form" method="post" id="myForm" action="<?php echo base_url('Transaksi/UploadFilePORoll')?>" enctype="multipart/form-data">
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TGL. INPUT PO</div>
								<div class="col-md-9">
									<input type="date" id="tgl" name="tgl" class="form-control" value="<?= date('Y-m-d')?>">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">NO. PO</div>
								<div class="col-md-9">
									<input type="text" id="no_po" name="no_po" class="form-control" placeholder="NO. PO" autocomplete="off" oninput="this.value=this.value.toUpperCase()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">CUSTOMER</div>
								<div class="col-md-9">
									<select id="nm_pelanggan" name="nm_pelanggan" class="form-control select2">
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
								<div class="col-md-3">FILE</div>
								<div class="col-md-9">
									<input type="file" data-max-size="2048" name="filefoto" id="filefoto" accept=".jpg,.png,.pdf">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="submit" class="btn btn-primary">Upload</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card card-success card-outline" style="position:sticky;top:12px;padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI PO</h3>
						</div>
					</div>
				</div>
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
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'User', 'Keuangan1'])){
								if($this->session->userdata('username') != 'usman'){
							?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick=""><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php }} ?>
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
											<th style="padding:12px;text-align:center">LAPORAN</th>
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

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';
	const urlUser = '<?= $this->session->userdata('username')?>';

	$(document).ready(function ()
	{
		// kosong()
		// load_data()
		$('.select2').select2();
	});

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	// function load_data() {
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Transaksi/load_data/trs_po_laminasi')?>',
	// 			"type": "POST",
	// 			// "data": ({
	// 			// 	po: 'list', tahun, jenis, hub, bulan, status_kiriman
	// 			// }),
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 50, 100, -1],
	// 			[5, 10, 50, 100, "Semua"]
	// 		],	
	// 		responsive: false,
	// 		"pageLength": 10,
	// 		"language": {
	// 			"emptyTable": "TIDAK ADA DATA.."
	// 		}
	// 	})
	// }

	// function kosong()
	// {
	// 	statusInput = 'insert'
	// 	swal.close()
	// }

	// function UploadFilePORoll()
	// {
	// 	// let tgl = $("#tgl").val()
	// 	// let nm_pelanggan = $("#nm_pelanggan").val()
	// 	// let file = $('#filefoto').prop('files')[0];

	// 	let form = $('#myForm')[0];
	// 	let data = new FormData(form);

	// 	$.ajax({
	// 		url: '<?php echo base_url('Transaksi/UploadFilePORoll')?>',
	// 		type: "POST",
	// 		enctype: 'multipart/form-data',
	// 		data: new FormData($('#myForm')[0]),
	// 		// data: ({
	// 		// 	tgl, nm_pelanggan
	// 		// }),
	// 		success: function(res){
	// 			data = JSON.parse(res)
	// 			alert(data)
	// 		}
	// 	})
	// }

	// function editInvoiceLaminasi(id_header, opsi) {
	// 	$(".row-list-invoice-laminasi").hide()
	// 	$(".row-input-invoice-laminasi").show()
	// 	$(".col-verif-invoice-laminasi").attr('style', 'position:sticky;top:12px;margin-bottom:16px')
	// 	$(".row-item-invoice-laminasi").show()
	// 	$.ajax({
	// 		url: '<?php echo base_url('Logistik/editInvoiceLaminasi')?>',
	// 		type: "POST",
	// 		beforeSend: function() {
	// 			swal({
	// 				title: 'Loading',
	// 				allowEscapeKey: false,
	// 				allowOutsideClick: false,
	// 				onOpen: () => {
	// 					swal.showLoading();
	// 				}
	// 			});
	// 		},
	// 		data: ({
	// 			id_header, opsi
	// 		}),
	// 		success: function(res){
	// 			data = JSON.parse(res)
	// 			// $("#h_id_header").val(id_header)
	// 			let prop = true;
	// 			(opsi == 'edit') ? prop = false : prop = true;
	// 			// VERIFIKASI DATA
	// 			$("#verif-admin").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.oke_admin}`)
	// 			// VERIFIFIKASI OWNER
	// 			if((urlAuth == 'Admin' || (urlAuth == 'Keuangan1' && urlUser == 'bumagda')) && data.header.acc_admin == 'Y' && (data.header.acc_owner == 'N' || data.header.acc_owner == 'H' || data.header.acc_owner == 'R')){
	// 				// BUTTON OWNER
	// 				let lock = ''
	// 				if(urlAuth == 'Admin' && data.header.acc_owner != 'N'){
	// 					lock = `<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvLaminasi('lock','owner')"><i class="fas fa-lock"></i> Lock</button>`
	// 				}else{
	// 					lock = ''
	// 				}
	// 				$("#verif-owner").html(`
	// 					${lock}
	// 					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifInvLaminasi('verifikasi','owner')"><i class="fas fa-check"></i> Verifikasi</button>
	// 					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvLaminasi('hold','owner')"><i class="far fa-hand-paper"></i> Hold</button>
	// 					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifInvLaminasi('reject','owner')"><i class="fas fa-times"></i> Reject</button>
	// 				`)
	// 				// KETERANGAN OWNER
	// 				if(data.header.acc_owner != 'N'){
	// 					if(data.header.acc_owner == 'H'){
	// 						callout = 'callout-warning'
	// 						colorbtn = 'btn-warning'
	// 						txtsave = 'HOLD!'
	// 					}else{
	// 						callout = 'callout-danger'
	// 						colorbtn = 'btn-danger'
	// 						txtsave = 'REJECT!'
	// 					}
	// 					$("#input-owner").html(`
	// 						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
	// 							<div class="col-md-3"></div>
	// 							<div class="col-md-9">
	// 								<div class="callout ${callout}" style="padding:0;margin:0">
	// 									<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.ket_owner}</textarea>
	// 								</div>
	// 							</div>
	// 						</div>
	// 						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
	// 							<div class="col-md-3"></div>
	// 							<div class="col-md-9">
	// 								<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifInvLaminasi('${data.header.acc_owner}', 'owner')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
	// 							</div>
	// 						</div>
	// 					`)
	// 				}
	// 			}else{
	// 				// BUTTON OWNER
	// 				if(data.header.acc_owner == 'N'){
	// 					$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
	// 				}else if(data.header.acc_owner == 'H'){
	// 					$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.time_owner}`)
	// 				}else if(data.header.acc_owner == 'R'){
	// 					$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.time_owner}`)
	// 				}else{
	// 					$("#verif-owner").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.time_owner}`)
	// 				}
	// 				// KETERANGAN OWNER
	// 				if(data.header.acc_owner != 'N'){
	// 					if(data.header.acc_owner == 'H'){
	// 						callout = 'callout-warning'
	// 					}else if(data.header.acc_owner == 'R'){
	// 						callout = 'callout-danger'
	// 					}else{
	// 						callout = 'callout-success'
	// 					}
	// 					$("#input-owner").html(`
	// 						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
	// 							<div class="col-md-3"></div>
	// 							<div class="col-md-9">
	// 								<div class="callout ${callout}" style="padding:6px;margin:0">${data.header.ket_owner}</div>
	// 							</div>
	// 						</div>
	// 					`)
	// 				}
	// 			}
	// 			statusInput = 'update'
	// 			swal.close()
	// 		}
	// 	})
	// }

	// function verifLaminasi(aksi, status_verif)
	// {
	// 	if(aksi == 'verifikasi'){
	// 		vrf = 'Y'
	// 		callout = 'callout-success'
	// 		colorbtn = 'btn-success'
	// 		txtsave = 'VERIFIKASI!'
	// 	}else if(aksi == 'hold'){
	// 		vrf = 'H'
	// 		callout = 'callout-warning'
	// 		colorbtn = 'btn-warning'
	// 		txtsave = 'HOLD!'
	// 	}else if(aksi == 'reject'){
	// 		vrf = 'R'
	// 		callout = 'callout-danger'
	// 		colorbtn = 'btn-danger'
	// 		txtsave = 'REJECT!'
	// 	}
	// 	(status_verif == 'marketing') ? input_verif = 'input-marketing' : input_verif ='input-owner';
	// 	$("#"+input_verif).html(`
	// 		<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
	// 			<div class="col-md-3"></div>
	// 			<div class="col-md-9">
	// 				<div class="callout ${callout}" style="padding:0;margin:0">
	// 					<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
	// 				</div>
	// 			</div>
	// 		</div>
	// 		<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
	// 			<div class="col-md-3"></div>
	// 			<div class="col-md-9">
	// 				<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifLaminasi('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
	// 			</div>
	// 		</div>
	// 	`)
	// }

	// function btnVerifLaminasi(aksi, status_verif)
	// {
	// 	let id_po_lm = $("#id_po_header").val()
	// 	let ket_laminasi = $("#ket_laminasi").val()
	// 	$.ajax({
	// 		url: '<?php echo base_url('Transaksi/btnVerifLaminasi')?>',
	// 		type: "POST",
	// 		beforeSend: function() {
	// 			swal({
	// 				title: 'Loading',
	// 				allowEscapeKey: false,
	// 				allowOutsideClick: false,
	// 				onOpen: () => {
	// 					swal.showLoading();
	// 				}
	// 			});
	// 		},
	// 		data: ({
	// 			id_po_lm, ket_laminasi, aksi, status_verif
	// 		}),
	// 		success: function(res){
	// 			data = JSON.parse(res)
	// 			if(data.result){
	// 				kembaliListPOLaminasi()
	// 			}else{
	// 				toastr.error(`<b>KETERANGAN TIDAK BOLEH KOSONG!</b>`)
	// 				swal.close()
	// 			}
	// 		}
	// 	})
	// }
</script>
