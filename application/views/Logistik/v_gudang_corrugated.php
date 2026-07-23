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

		.gd-grid31 {
			display: grid;
			grid-template-columns: repeat(34, 1fr);
		}
		.gd-grid30 {
			display: grid;
			grid-template-columns: repeat(33, 1fr);
		}
		.gd-grid29 {
			display: grid;
			grid-template-columns: repeat(32, 1fr);
		}
		.gd-grid28 {
			display: grid;
			grid-template-columns: repeat(31, 1fr);
		}

		.title-grid {
			display: grid;
			grid-template-columns: 80px repeat(7, 80px);
			/* grid-auto-columns: 80px; */
		}

		.list-gd:hover {
			background-color: rgba(222, 222, 222, 0.5);
		}

		/* .gd-grid31:hover, .gd-grid30:hover, .gd-grid29:hover, .gd-grid28:hover > div {
			background: #e3f2fd;
		} */
	</style>

	<section class="content">
		<div class="container-fluid">

		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST GUDANG</h3>
					</div>
					<div class="card-body" style="font-weight:bold;padding:6px">
						<div>
							<table>
								<tr>
									<td style="font-weight:bold;padding:0 0 16px">
										<input type="month" id="all_plh_tgl" value="<?php echo date('Y-m')?>" class="form-control" onchange="allListGudang()">
									</td>
									<td style="font-weight:bold;padding:0 0 16px 12px">
										<div class="all-btn-pdf"></div>
									</td>
								</tr>
							</table>
						</div>
						<div style="overflow:auto;white-space:nowrap">
							<div class="all-list-gudang"></div>
						</div>
						<br><br>
						<div style="overflow:auto;white-space:nowrap">
							<div class="all-list-gudang2"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

			<div class="row card-add-gudang" style="display:none">
				<div class="col-md-12">
					<div class="card card-primary card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT DATA STOK GUDANG</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:6px">
							<div style="margin:12px 6px 6px">
								<button type="button" class="btn btn-info" onclick="kembali()"><i class="fas fa-arrow-left"></i> <b>Kembali</b></button>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:20px 6px 6px">
								<div class="col-md-2">TGL STOK AWAL</div>
								<div class="col-md-2">
									<input type="date" id="tgl_awal_cust" name="tgl_awal_cust" value="<?= date('Y-m-d') ?>" class="form-control" onchange="plhStokAwalCust()">
								</div>
								<div class="col-md-8"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 30px">
								<div class="col-md-2">CUSTOMER</div>
								<div class="col-md-10">
									<select class="form-control select2" id="pelanggan" onchange="plhGCPelanggan()">
										<?php
											$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
											$html ='';
											$html .='<option value="">PILIH</option>';
											foreach($query->result() as $r){
												($r->attn == "-" || $r->attn == "") ? $attn = '' : $attn = ' | '.$r->attn;
												$html .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.''.$attn.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
							</div>
							<div class="produk" style="padding:0 6px"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row card-input-gudang" style="display:none">
				<div class="col-md-12">
					<div class="card card-secondary card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT LIST STOK GUDANG</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:6px">
							<div class="card-body row" style="font-weight:bold;padding:20px 6px">
								<div class="col-md-2">TGL STOK AWAL</div>
								<div class="col-md-2">
									<input type="date" id="tgl_awal2" name="tgl_awal2" value="<?= date('Y-m-d') ?>" class="form-control" onchange="gdStokAwalCust()">
								</div>
								<div class="col-md-8"></div>
							</div>
							<div class="gudang" style="padding:0 6px"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="card card-list-gudang">
				<div class="card-header">
					<h3 class="card-title">Gudang</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="padding:12px 6px">
					<?php if(in_array($this->session->userdata('level'), ['Admin', 'Gudang'])) { ?>
						<div style="margin:12px 0">
							<button type="button" class="btn btn-info" onclick="tambah()"><i class="fa fa-plus"></i> <b>Tambah Data</b></button>
						</div>
					<?php } ?>
					<div>
						<table>
							<tr>
								<td style="font-weight:bold;padding:0 0 16px">
									<input type="date" id="plh_tgl" name="plh_tgl" value="<?php echo date('Y-m-d')?>" class="form-control" onchange="load_data()">
								</td>
								<td style="font-weight:bold;padding:0 0 16px 12px">
									<div class="btn-pdf"></div>
								</td>
							</tr>
						</table>
					</div>
					<div style="overflow:auto;white-space:nowrap">
						<table id="datatable" class="table table-bordered table-striped" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="width:5%">#</th>
									<th style="width:20%">CUSTOMER</th>
									<th style="width:25%">ITEM</th>
									<th style="width:10%">STOK AWAL</th>
									<th style="width:10%">IN</th>
									<th style="width:10%">OUT</th>
									<th style="width:10%">STOK AKHIR</th>
									<th style="width:10%">KETERANGAN</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight:bold">NO. PO</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="card-body">
				<div class="list-nopo"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";
	const tglNow = '<?= date('Y-m-d') ?>';
	const urlAuth = '<?= $this->session->userdata('level') ?>';
	const urlUser = '<?= $this->session->userdata('username') ?>';

	$(document).ready(function () {
		$(".select2").select2()
		// load_data()
		allListGudang()
	});

	function load_data() {
		let plh_tgl = $("#plh_tgl").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/loadDataGDCorr')?>',
				"type": "POST",
				"data": ({ plh_tgl }),
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		})
		pdfGDCorr()
	}

	function pdfGDCorr()
	{
		$(".btn-pdf").html('')
		let plh_tgl = $("#plh_tgl").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/pdfGDCorr')?>',
			type: "POST",
			data: ({ plh_tgl }),
			success: function(res){
				data = JSON.parse(res)
				$(".btn-pdf").html(data.pdf)
			}
		})
	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function tambah() {
		kosong()
		loadGC()
		// $("#tgl_awal_cust").val()
		$("#pelanggan").val('').trigger('change')
		$(".card-list-gudang").hide()
		$(".card-add-gudang").show()
		$(".card-input-gudang").show()
	}

	function kembali() {
		kosong()
		load_data()
		$(".card-list-gudang").show()
		$(".card-add-gudang").hide()
		$(".card-input-gudang").hide()
	}

	function kosong() {
		$(".produk").html('')
		$(".gudang").html('')
	}

	function allListGudang(){
		let all_plh_tgl = $("#all_plh_tgl").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/allListGudang')?>',
			type: "POST",
			data: ({
				all_plh_tgl
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".all-list-gudang").html(data.html)
				$(".all-list-gudang2").html(data.html2)
				// console.log(data)
			}
		})
	}

	function plhGCPelanggan() {
		$(".produk").html('')
		let id_pelanggan = $("#pelanggan").val()
		let tgl_awal_cust = $("#tgl_awal_cust").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/plhGCPelanggan')?>',
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
				id_pelanggan, tgl_awal_cust
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".produk").html(data.html)
				swal.close()
			}
		})
	}

	function listPO(id_pelanggan, id_produk){
		$(".list-nopo").html('')
		$("#modalForm").modal("show")
		$.ajax({
			url: '<?php echo base_url('Logistik/listPO')?>',
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
				id_pelanggan, id_produk
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".list-nopo").html(data.html)
				swal.close()
			}
		})
	}

	function btnMinMin(i){
		$(".spn-tmpl").html('[ HIDE SEMUA ]')
		$(".tr1").show()
		$(".ab1").removeClass("btn-success").addClass("btn-warning")
		$(".af1").removeClass("fa-plus").addClass("fa-minus")
		let ts0 = $("#ts0").val()
		if (parseInt(ts0) == parseInt(i)) {
			$("#ts0").val("")
		} else {
			$(".spn-tmpl").html('[ TAMPIL SEMUA ]')
			$(".ab1").removeClass("btn-warning").addClass("btn-success")
			$(".af1").removeClass("fa-minus").addClass("fa-plus")
			$("#ts0").val(i)
			$(".tr1").hide()
		}
	}

	function btnPlusPlus(i) {
		$(".spn-tmpl").html('[ TAMPIL SEMUA ]')
		$(".tr1").hide()
		$(".ab1").removeClass("btn-warning").addClass("btn-success")
		$(".af1").removeClass("fa-minus").addClass("fa-plus")
		let ts1 = $("#ts1").val()
		if (parseInt(ts1) == parseInt(i)) {
			$("#ts1").val("")
		} else {
			$(".b1-" + i).removeClass("btn-success").addClass("btn-warning")
			$(".f1-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts1").val(i)
			$(".t" + i).show()
		}
	}

	function keyUpGD(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let stok_awal = $("#stok_awal_"+i).val().split('.').join('');
		(stok_awal < 0 || stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal_"+i).val(rupiah.format(stok_awal));

		let inin = $("#in_"+i).val().split('.').join('');
		(inin < 0 || inin == '' || inin.length >= 7) ? inin = 0 : inin = inin;
		$("#in_"+i).val(rupiah.format(inin));

		let out = $("#out_"+i).val().split('.').join('');
		let stokAwalIn = parseInt(stok_awal) + parseInt(inin);
		(out < 0 || out == '' || out.length >= 7 || out > stokAwalIn) ? out = 0 : out = out;
		$("#out_"+i).val(rupiah.format(out));

		let hitung = (parseInt(stok_awal) + parseInt(inin)) - parseInt(out);
		(isNaN(hitung) || hitung < 0) ? hitung = '' : hitung = hitung;
		$("#stok_akhir_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir_"+i).val(hitung);
	}

	function keyUpGD2(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let stok_awal = $("#stok_awal2_"+i).val().split('.').join('');
		(stok_awal < 0 || stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal2_"+i).val(rupiah.format(stok_awal));

		let inin = $("#in2_"+i).val().split('.').join('');
		(inin < 0 || inin == '' || inin.length >= 7) ? inin = 0 : inin = inin;
		$("#in2_"+i).val(rupiah.format(inin));

		let out = $("#out2_"+i).val().split('.').join('');
		let stokAwalIn = parseInt(stok_awal) + parseInt(inin);
		(out < 0 || out == '' || out.length >= 7 || out > stokAwalIn) ? out = 0 : out = out;
		$("#out2_"+i).val(rupiah.format(out));

		let hitung = (parseInt(stok_awal) + parseInt(inin)) - parseInt(out);
		(isNaN(hitung) || hitung < 0) ? hitung = '' : hitung = hitung;
		$("#stok_akhir2_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir2_"+i).val(hitung);
	}

	function simpanGCcorrugated()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanGCcorrugated')?>',
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
			data: $('#myForm').serialize(),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success('<b>BERHASIL!</b>');
					$("#pelanggan").val('').trigger('change')
					loadGC()
				}else{
					toastr.error(`<b>${data.msg}</b>`);
					swal.close()
				}
			}
		})
	}

	function plhStokAwalCust()
	{
		let tgl_awal_cust = $("#tgl_awal_cust").val()
		let id_pelanggan = $("#pelanggan").val()
		$(".produk").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/plhGCPelanggan')?>',
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
				id_pelanggan, tgl_awal_cust
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".produk").html(data.html)
				swal.close()
			}
		})
	}

	function loadGC()
	{
		$(".gudang").html('')
		let tgl_awal2 = $("#tgl_awal2").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/loadGC')?>',
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
			data: ({ tgl_awal2 }),
			success: function(res){
				data = JSON.parse(res)
				$(".gudang").html(data.html)
				swal.close()
			}
		})
	}

	function gdStokAwalCust()
	{
		$(".gudang").html('')
		let tgl_awal2 = $("#tgl_awal2").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/loadGC')?>',
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
			data: ({ tgl_awal2 }),
			success: function(res){
				data = JSON.parse(res)
				$(".gudang").html(data.html)
				swal.close()
			}
		})
	}

	function simpanGDListCorr()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanGDListCorr')?>',
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
			data: $('#listForm').serialize(),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success('<b>BERHASIL!</b>');
					loadGC()
				}else{
					toastr.error(`<b>${data.msg}</b>`);
					swal.close()
				}
			}
		})
	}

</script>
