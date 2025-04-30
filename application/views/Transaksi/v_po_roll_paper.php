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
			<?php if(in_array($this->session->userdata('level'), ['Admin', 'Owner'])){ ?>
				<div class="row row-input" style="display: none;">
					<div class="col-md-6">
						<div class="card card-primary card-outline" style="position:sticky;top:12px;padding-bottom:12px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PO ROLL PAPER</h3>
							</div>
							<div style="margin:12px 6px;display:flex">
								<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
							</div>
							<form role="form" method="post" id="myForm" action="<?php echo base_url('Transaksi/UploadFilePORoll')?>" enctype="multipart/form-data">
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">TGL. PO</div>
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
												// $db = $this->load->database('database_simroll', TRUE);
												$query = $this->db->query("SELECT*FROM m_perusahaan WHERE jns='ROLL' GROUP BY nm_perusahaan, pimpinan");
												$html = '';
												foreach($query->result() as $r){
													if($r->pimpinan == '-' && $r->nm_perusahaan != '-'){
														$nm = $r->nm_perusahaan;
													}else if($r->pimpinan != '-' && $r->nm_perusahaan == '-'){
														$nm = $r->pimpinan;
													}else if($r->pimpinan != '-' && $r->nm_perusahaan != '-'){
														$nm = $r->nm_perusahaan.' - '.$r->pimpinan;
													}
													$html .= '<option value="'.$nm.'" idpt="'.$r->id.'">'.$nm.'</option>';
												}
												echo $html;
											?>
										</select>
										<input type="hidden" id="id_pt" name="id_pt" value="">
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
											<input type="file" name="filefoto" id="filefoto" accept=".jpg,.jpeg,.png,.pdf" onchange="diPilih()">
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-3"></div>
										<div class="col-md-9" style="color:#f00;font-size:12px;font-style:italic">
											* .jpg, .jpeg, .png, .pdf
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<div class="simpan-save"></div>
										</div>
									</div>
								</div>
								<input type="hidden" name="hidhdr" id="hidhdr" value="">
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
								<div id="input-po"></div>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="col-detail" style="display: none;">
							<div class="card card-secondary card-outline">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">FILE PO</h3>
								</div>
								<div class="card-body" style="padding:12px 6px">
									<div style="overflow:auto;white-space:nowrap">
										<div class="detail-po"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="col-roll-input">
							<div class="card card-secondary card-outline">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT DETAIL PO</h3>
								</div>
								<div class="list-sementara"></div>
								<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
									<div class="col-md-1">JENIS</div>
									<div class="col-md-3">
										<input type="text" id="i_jenis" class="form-control" autocomplete="off" placeholder="-" oninput="this.value=this.value.toUpperCase()">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-1">GSM</div>
									<div class="col-md-3">
										<input type="number" id="i_gsm" class="form-control" autocomplete="off" placeholder="0">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-1">WIDTH</div>
									<div class="col-md-3">
										<input type="number" id="i_ukuran" class="form-control" autocomplete="off" placeholder="0">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-1">BERAT</div>
									<div class="col-md-3">
										<input type="number" id="i_berat" class="form-control" autocomplete="off" placeholder="0">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-1">QTY</div>
									<div class="col-md-3">
										<input type="number" id="i_qty" class="form-control" autocomplete="off" placeholder="0">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-1">KET</div>
									<div class="col-md-3">
										<input type="text" id="i_ket" class="form-control" autocomplete="off" placeholder="-" oninput="this.value=this.value.toUpperCase()">
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 12px">
									<div class="col-md-1"></div>
									<div class="col-md-3">
										<button type="button" class="btn btn-sm btn-success" style="font-weight:bold" onclick="addListUK()">ADD</button>
									</div>
									<div class="col-md-8"></div>
								</div>
							</div>
						</div>

						<div class="col-roll-list">
							<div class="card card-secondary card-outline">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST DETAIL PO</h3>
								</div>
								<?php if($this->session->userdata('level') == 'Admin'){?>
									<div style="overflow:auto;white-space:nowrap">
										<div class="list-edit-roll" style="padding:5px"></div>
									</div>
								<?php } ?>
								<div style="overflow:auto;white-space:nowrap">
									<div class="list-roll" style="padding:5px"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:12px 6px 6px">
									<div class="col-md-1">NOTE</div>
									<div class="col-md-5">
										<textarea id="note_po_roll" class="form-control" style="font-weight:bold;resize:none" rows="3" oninput="this.value=this.value.toUpperCase()"></textarea>
									</div>
									<div class="col-md-6"></div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 6px 12px">
									<div class="col-md-1"></div>
									<div class="col-md-11">
										<div class="simpan-note"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<input type="hidden" id="id_hdr" value="">
					<input type="hidden" id="id_cart" value="0">
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
			<?php } ?>

			<?php if(in_array($this->session->userdata('level'), ['Admin', 'User'])){ ?>
				<div class="row row-lap">
					<div class="col-md-12">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">LAPORAN PO ROLL PAPER</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
								<div class="col-md-2">CUSTOMER</div>
								<div class="col-md-8">
									<select id="lap_id_pt" class="form-control select2" onchange="plhCustomer()">
										<option value="">PILIH</option>
										<?php
											$db3 = $this->load->database('database_simroll', TRUE);
											$query3 = $db3->query("SELECT c.id,c.pimpinan,c.nm_perusahaan FROM po_master po
												INNER JOIN m_perusahaan c ON po.id_perusahaan=c.id
												WHERE po.id_perusahaan!='210' AND po.id_perusahaan!='217'
												AND po.tgl BETWEEN '2024-12-01' AND '9999-01-01'
												AND po.status='Open'
												GROUP BY c.id
												ORDER BY c.nm_perusahaan");
											$html3 = '';
											foreach($query3->result() as $r3){
												$html3 .= '<option value="'.$r3->id.'"> '.$r3->pimpinan.' | '.$r3->nm_perusahaan.'</option>';
											}
											echo $html3;
										?>
									</select>
								</div>
								<div class="col-md-2"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">STATUS</div>
								<div class="col-md-8">
									<select id="lap_status" class="form-control select2" onchange="plhStatus()" disabled>
										<option value="">OPEN</option>
										<option value="ALL">ALL</option>
									</select>
								</div>
								<div class="col-md-2"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">NO. PO</div>
								<div class="col-md-8">
									<select id="lap_no_po" class="form-control select2" disabled>
										<option value="">PILIH</option>
									</select>
								</div>
								<div class="col-md-2"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">OPSI</div>
								<div class="col-md-8">
									<select id="lap_opsi" class="form-control select2" disabled>
										<option value="">SEMUA</option>
										<option value="TSDN">TIDAK SAMA DENGAN NOL</option>
									</select>
								</div>
								<div class="col-md-2"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">ORDER BY</div>
								<div class="col-md-8">
									<select id="lap_order" class="form-control select2" disabled>
										<option value="">JENIS - GSM - UKURAN</option>
										<option value="TNP">TGL - NO. PO</option>
									</select>
								</div>
								<div class="col-md-2"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2"></div>
								<div class="col-md-10">
									<button type="button" class="btn btn-sm btn-primary" onclick="cariLaporanPORoll()"><b>CARI</b></button>
								</div>
							</div>
							<div class="card-body" style="padding:6px">
								<div style="overflow:auto;white-space:nowrap">
									<div id="lap_list_po"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
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
		$(".list-sementara").load("<?php echo base_url('Transaksi/destroyPORoll') ?>")
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
		$(".row-lap").hide()
		$(".col-roll-input").show()
		$(".col-roll-list").hide()
		$(".list-roll").html('')
		if(urlAuth == 'Admin'){
			$(".list-edit-roll").html('')
		}
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
		let id_pt = $('#nm_pelanggan option:selected').attr('idpt')
		$("#id_pt").val(id_pt)

		let no_po = $("#no_po").val()
		let id_sales = $("#id_sales").val()
		let filefoto = $("#filefoto").val()
		let id_cart = $("#id_cart").val()
		if(tgl != '' && nm_pelanggan != '' && no_po != '' && id_sales != '' && filefoto != '' && id_cart != 0){
			$(".simpan-save").html('<button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> <b>SIMPAN</b></button>')
		}else{
			$(".simpan-save").html('')
		}
	}

	function diPilihUpdate(){
		let filefoto = $("#updatefilefoto").val()
		if(filefoto != ''){
			$(".update-save").html('<button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> <b>SIMPAN</b></button>')
		}else{
			$(".update-save").html('')
		}
	}

	function backList()
	{
		$(".row-input").hide()
		$(".row-list").show()
		$(".row-lap").show()
		reloadTable()
	}

	function addListUK()
	{
		let jenis = $("#i_jenis").val()
		let gsm = $("#i_gsm").val()
		let ukuran = $("#i_ukuran").val()
		let berat = $("#i_berat").val()
		let qty = $("#i_qty").val()
		let ket = $("#i_ket").val()

		let id_cart = parseInt($("#id_cart").val()) + 1
		$("#id_cart").val(id_cart)
		$.ajax({
			url: '<?php echo base_url('Transaksi/addListUK')?>',
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
				jenis, gsm, ukuran, berat, qty, ket, id_cart
			}),
			success: function(res){
				data = JSON.parse(res)
				cartListPORoll()
			}
		})
	}

	function cartListPORoll()
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/cartListPORoll')?>',
			type: "POST",
			success: function(res){
				$(".list-sementara").html(res)
				if(res == ''){
					$("#id_cart").val(0)
				}
				diPilih()
				swal.close()
			}
		})
	}

	function hapusCartPORoll(rowid)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusCartPORoll')?>',
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
			data: ({ rowid }),
			success: function(res){
				cartListPORoll()
			}
		})
	}

	function addNotePORoll()
	{
		let id_hdr = $("#id_hdr").val()
		let note_po_roll = $("#note_po_roll").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/addNotePORoll')?>',
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
			data: ({ id_hdr, note_po_roll }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editPORoll(id_hdr, 'verif')
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function editPORoll(id_hdr, opsi)
	{
		$(".detail-po").html('')
		$(".add-file").html('')
		$("#input-marketing").html('')
		$("#input-owner").html('')
		$(".row-list").hide()
		$(".row-lap").hide()
		$(".row-input").show()
		$(".col-verifikasi").show()
		$(".col-detail").show()
		$(".col-roll-input").hide()
		$(".col-roll-list").show()
		$(".list-roll").html('')
		if(urlAuth == 'Admin'){
			$(".list-edit-roll").html('')
		}
		$("#input-po").html('')
		$("#hidhdr").val('')

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
				$("#id_hdr").val(data.header.id_hdr)
				$("#tgl").val(data.header.tgl_po).prop('disabled', true)
				$("#nm_pelanggan").val(data.header.nm_pelanggan).prop('disabled', true).trigger('change')
				$("#no_po").val(data.header.no_po).prop('disabled', true)
				$("#id_sales").val(data.header.id_sales).prop('disabled', true).trigger('change')
				$(".detail-po").html(data.htmlDtl)
				$(".list-roll").html(data.htmlI)
				// EDIT LIST DETAIL PO
				if(urlAuth == 'Admin'){
					$(".list-edit-roll").html(data.htmlE)
				}

				// UPLOAD
				if(urlAuth == 'Admin' && data.header.owner_status != 'Y' && data.opsi != 'detail'){
					$("#hidhdr").val(data.header.id_hdr)
					$(".add-file").html(`
						<div class="card-body row" style="font-weight:bold;padding:0 12px">
							<div class="col-md-3">FILE</div>
							<div class="col-md-9">
								<input type="file" name="updatefilefoto" id="updatefilefoto" accept=".jpg,.jpeg,.png,.pdf" onchange="diPilihUpdate()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9" style="color:#f00;font-size:12px;font-style:italic">
								* .jpg, .jpeg, .png, .pdf
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<div class="update-save"></div>
							</div>
						</div>
					`)
				}

				// NOTE
				$("#note_po_roll").val(data.header.note_po).prop('disabled', (data.opsi != 'detail' && data.header.owner_status != 'Y') ? false : true)
				if((data.header.note_po == null || data.header.note_po == '') && (data.opsi != 'detail') && data.header.owner_status != 'Y'){
					$(".simpan-note").html('<button type="button" class="btn btn-sm btn-success" style="font-weight:bold" onclick="addNotePORoll()">ADD</button>')
				}else if(data.header.note_po != '' && (data.opsi != 'detail') && data.header.owner_status != 'Y'){
					$(".simpan-note").html('<button type="button" class="btn btn-sm btn-warning" style="font-weight:bold" onclick="addNotePORoll()">EDIT</button>')
				}else{
					$(".simpan-note").html('')
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

				// INPUT PO KE SIMROLLPPI
				if(data.header.owner_status == 'Y' && urlAuth == 'Admin' && data.header.input_po == 'N'){
					$("#input-po").html(`
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<button type="button" title="INPUT PO" class="btn btn-danger btn-sm" style="font-weight:bold" onclick="inputPO('${data.header.id_hdr}')"><i class="fas fa-file-upload"></i> UPLOAD</button>
							</div>
						</div>
					`)
				}

				statusInput = 'update'
				swal.close()
			}
		})
	}

	function hapusFilePO(id_dtl)
	{
		let id_hdr = $("#hidhdr").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusFilePO')?>',
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
				if(data.hdtl){
					editPORoll(id_hdr, 'edit')
				}
			}
		})
	}

	function editPORollList(id_hdr, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/editPORoll')?>',
			type: "POST",
			data: ({ id_hdr, opsi }),
			success: function(res){
				data = JSON.parse(res)
				$(".list-roll").html(data.htmlI)
				$(".list-edit-roll").html(data.htmlE)
				swal.close()
			}
		})
	}

	function editListPORoll(id_item)
	{
		let id_hdr = $("#hidhdr").val()
		let e_nm_ker = $('#e_nm_ker'+id_item).val()
		let e_g_label = $('#e_g_label'+id_item).val()
		let e_width = $('#e_width'+id_item).val()
		let e_tonase = $('#e_tonase'+id_item).val().split('.').join('')
		let e_jml_roll = $('#e_jml_roll'+id_item).val().split('.').join('')
		let e_ket = $('#e_ket'+id_item).val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/editListPORoll')?>',
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
				id_hdr, id_item, e_nm_ker, e_g_label, e_width, e_tonase, e_jml_roll, e_ket
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editPORollList(id_hdr, 'edit')
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusListPORoll(id_item)
	{
		let id_hdr = $("#hidhdr").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusListPORoll')?>',
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
			data: ({ id_item }),
			success: function(res){
				data = JSON.parse(res)
				if(data.del){
					editPORollList(id_hdr, 'edit')
				}
			}
		})
	}

	function addListPORoll()
	{
		let id_hdr = $("#hidhdr").val()
		let n_nm_ker = $('#n_nm_ker').val()
		let n_g_label = $('#n_g_label').val()
		let n_width = $('#n_width').val()
		let n_tonase = $('#n_tonase').val()
		let n_jml_roll = $('#n_jml_roll').val()
		let n_ket = $('#n_ket').val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/addListPORoll')?>',
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
				id_hdr, n_nm_ker, n_g_label, n_width, n_tonase, n_jml_roll, n_ket
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					editPORollList(id_hdr, 'edit')
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
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

	function inputPO(id_hdr)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/InputPORoll') ?>',
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
			data: ({ id_hdr }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					backList()
				}
				swal.close()
			}
		})
	}

	// laporan

	function plhCustomer()
	{
		let id_pt = $("#lap_id_pt").val()
		$("#lap_status").prop('disabled', (id_pt == '') ? true : false).trigger('change')
		$("#lap_no_po").prop('disabled', (id_pt == '') ? true : false)
		$("#lap_order").prop('disabled', (id_pt == '') ? true : false)
		$("#lap_opsi").prop('disabled', (id_pt == '') ? true : false)
	}

	function plhStatus()
	{
		$("#lap_no_po").html('<option value="">LOADING</option>')
		let id_pt = $("#lap_id_pt").val()
		let lap_status = $("#lap_status").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/plhStatus') ?>',
			type: "POST",
			data: ({ id_pt, lap_status }),
			success: function(res){
				data = JSON.parse(res)
				$("#lap_no_po").html(data.noPO)
			}
		})
	}

	function cariLaporanPORoll()
	{
		$("#lap_list_po").html('Loading...')
		let id_pt = $("#lap_id_pt").val()
		let status = $("#lap_status").val()
		let no_po = $("#lap_no_po").val()
		let order = $("#lap_order").val()
		let opsi = $("#lap_opsi").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/cariLaporanPORoll') ?>',
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
			data: ({ id_pt, status, no_po, order, opsi }),
			success: function(res){
				data = JSON.parse(res)
				$("#lap_list_po").html(data.html)
				swal.close()
			}
		})
	}
</script>
