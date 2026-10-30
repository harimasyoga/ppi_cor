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

			<!-- <div class="row card-add-gudang" style="display:none">
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
									</select>
								</div>
							</div>
							<div class="produk" style="padding:0 6px"></div>
						</div>
					</div>
				</div>
			</div> -->

			<div class="row card-add-gudang2" style="display:none">
				<div class="col-md-12">
					<div class="card card-primary card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT DATA STOK GUDANG BARU</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:6px">
							<div style="margin:12px 6px 6px">
								<button type="button" class="btn btn-info" onclick="kembali()"><i class="fas fa-arrow-left"></i> <b>Kembali</b></button>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:20px 6px 6px">
								<div class="col-md-1">CUSTOMER</div>
								<div class="col-md-8">
									<select class="form-control select2" id="id_pelanggan">
										<?php
											$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
											$html ='';
											$html .='<option value="">SEMUA</option>';
											foreach($query->result() as $r){
												($r->attn == "-" || $r->attn == "") ? $attn = '' : $attn = ' | '.$r->attn;
												$html .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.''.$attn.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
								<div class="col-md-1">NAMA ITEM</div>
								<div class="col-md-8">
									<input type="text" id="nm_produk" class="form-control" oninput="this.value=this.value.toUpperCase()" autocomplete="off" placeholder="NAMA ITEM">
								</div>
								<div class="col-md-3"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
								<div class="col-md-1">TGL KELUAR</div>
								<div class="col-md-2">
									<input type="date" id="tgl_keluar" class="form-control">
								</div>
								<div class="col-md-9"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 12px">
								<div class="col-md-1"></div>
								<div class="col-md-11">
									<button type="button" class="btn btn-primary" onclick="cariStokGudang('')"><i class="fas fa-search"></i></button>
								</div>
							</div>
							<div style="padding:6px">
								<div style="overflow:auto;white-space:nowrap">
									<div class="produk2"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="row card-input-gudang" style="display:none">
				<div class="col-md-12">
					<div class="card card-secondary card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT LIST STOK GUDANG</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:6px">
							<div class="card-body row" style="font-weight:bold;padding:20px 6px 0">
								<div class="col-md-2">TGL STOK AWAL</div>
								<div class="col-md-2">
									<input type="date" id="tgl_awal2" name="tgl_awal2" class="form-control" onchange="gdStokAwalCust()">
								</div>
								<div class="col-md-8"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:6px 6px 20px">
								<div class="col-md-2">PILIH TANGGAL</div>
								<div class="col-md-2">
									<input type="date" id="pilih_tgl22" name="pilih_tgl22" class="form-control" onchange="gdStokAwalCust()">
								</div>
								<div class="col-md-8"></div>
							</div>
							<div class="gudang" style="padding:0 6px"></div>
						</div>
					</div>
				</div>
			</div> -->

			<div class="card card-list-gudang">
				<div class="card-header">
					<h3 class="card-title"><b>GUDANG</b></h3>
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
					<!-- <div>
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
					</div> -->
					<div style="overflow:auto;white-space:nowrap">
						<!-- <table id="datatable" class="table table-bordered table-striped" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="width:5%">#</th>
									<th style="width:20%">ITEM</th>
									<th style="width:5%">TANGGAL</th>
									<th style="width:10%">STOK AWAL</th>
									<th style="width:5%">IN</th>
									<th style="width:10%">IN RETUR</th>
									<th style="width:5%">OUT</th>
									<th style="width:10%">OUT RETUR</th>
									<th style="width:10%">STOK AKHIR</th>
									<th style="width:10%">KETERANGAN</th>
									<th style="width:10%">LAST UPDATE</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table> -->

						<div class="alist-gudang"></div>

					</div>
				</div>
			</div>

			<!-- <div class="row card-list-gudang2">
				<div class="col-md-12">
					<div class="card card-primary card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST GUDANG</h3>
						</div>
						<div class="card-body" style="font-weight:bold;padding:12px 6px">
							<div>
								<table>
									<tr>
										<td style="font-weight:bold;padding:0 0 12px">
											<input type="month" id="all_plh_tgl" value="" class="form-control" onchange="allListGudang()">
										</td>
										<td style="font-weight:bold;padding:0 0 12px 12px">
											<div class="all-btn-pdf"></div>
										</td>
									</tr>
								</table>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="all-list-gudang2"></div>
							</div>
						</div>
					</div>
				</div>
			</div> -->

		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight:bold">RINCIAN DATA</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="card-body" style="padding:12px">
				<div style="overflow:auto;white-space:nowrap">
					<div class="list-nopo"></div>
				</div>
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
		cariStokGudang('LIST')
		// load_data()
		// allListGudang()
	});

	function load_data() {
		// let plh_tgl = $("#plh_tgl").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/loadDataGDCorr')?>',
				"type": "POST",
				// "data": ({ plh_tgl }),
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
		// pdfGDCorr()
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
		$("#id_pelanggan").val('').trigger('change')
		$(".produk2").html('')
		$(".card-list-gudang").hide()
		$(".card-list-gudang2").hide()
		$(".card-add-gudang").show()
		$(".card-add-gudang2").show()
		$(".card-input-gudang").show()
	}

	function kembali() {
		kosong()
		cariStokGudang('LIST')
		$(".card-list-gudang").show()
		$(".card-list-gudang2").show()
		$(".card-add-gudang").hide()
		$(".card-add-gudang2").hide()
		$(".card-input-gudang").hide()
	}

	function kosong() {
		$(".produk2").html('')
		$(".alist-gudang").html('')
		$("#tgl_awal2").val('')
		$("#nm_produk").val('')
		$("#tgl_keluar").val('')
		$("#pilih_tgl22").val('')
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
				$(".all-list-gudang2").html(data.html2)
				swal.close()
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

	function listPO(id_pelanggan, id_produk, opsi){
		$(".list-nopo").html('...')
		$("#modalForm").modal("show")
		$.ajax({
			url: '<?php echo base_url('Logistik/listPO')?>',
			type: "POST",
			data: ({
				id_pelanggan, id_produk, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".list-nopo").html(data.html)
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
		(stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal_"+i).val(rupiah.format(stok_awal));

		let inin = $("#in_"+i).val().split('.').join('');
		(inin == '' || inin < 0 || inin.length >= 7) ? inin = 0 : inin = inin;
		$("#in_"+i).val(rupiah.format(inin));

		let inrtr = $("#inrtr_"+i).val().split('.').join('');
		(inrtr == '' || inrtr < 0 || inrtr.length >= 7) ? inrtr = 0 : inrtr = inrtr;
		$("#inrtr_"+i).val(rupiah.format(inrtr));

		let out = $("#out_"+i).val().split('.').join('');
		(out == '' || out < 0 || out.length >= 7) ? out = 0 : out = out;
		$("#out_"+i).val(rupiah.format(out));

		let outrtr = $("#outrtr_"+i).val().split('.').join('');
		(outrtr == '' || outrtr < 0 || outrtr.length >= 7) ? outrtr = 0 : outrtr = outrtr;
		$("#outrtr_"+i).val(rupiah.format(outrtr));

		let hitung = (parseInt(stok_awal, 10) + parseInt(inin, 10) + parseInt(inrtr, 10)) - (parseInt(out, 10) + parseInt(outrtr, 10));
		(isNaN(hitung)) ? hitung = '' : hitung = hitung;
		$("#stok_akhir_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir_"+i).val(hitung);

		let bb = $("#hTTON_"+i).val();
		let ton = parseInt(hitung * bb, 10);
		(ton.length >= 7 || ton < 0) ? ton = 0 : ton = ton;
		$("#tton_"+i).val(rupiah.format(ton));
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

		let inrtr = $("#inrtr2_"+i).val().split('.').join('');
		(inrtr < 0 || inrtr == '' || inrtr.length >= 7) ? inrtr = 0 : inrtr = inrtr;
		$("#inrtr2_"+i).val(rupiah.format(inrtr));

		let out = $("#out2_"+i).val().split('.').join('');
		(out < 0 || out == '' || out.length >= 7) ? out = 0 : out = out;
		$("#out2_"+i).val(rupiah.format(out));

		let outrtr = $("#outrtr2_"+i).val().split('.').join('');
		(outrtr < 0 || outrtr == '' || outrtr.length >= 7) ? outrtr = 0 : outrtr = outrtr;
		$("#outrtr2_"+i).val(rupiah.format(outrtr));

		let hitung = (parseInt(stok_awal, 10) + parseInt(inin, 10) + parseInt(inrtr, 10)) - (parseInt(out, 10) + parseInt(outrtr, 10));
		(isNaN(hitung)) ? hitung = '' : hitung = hitung;
		$("#stok_akhir2_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir2_"+i).val(hitung);

		let bb = $("#hTTON2_"+i).val();
		let ton = parseInt(hitung * bb, 10);
		(ton.length >= 7 || ton < 0) ? ton = 0 : ton = ton;
		$("#tton2_"+i).val(rupiah.format(ton));
	}

	function keyUpGD3(i,z)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let stok_awal = $("#vSA_"+i+"_"+z).val().split('.').join('');
		(stok_awal.length >= 7 || stok_awal == '') ? stok_awal = 0 : stok_awal = stok_awal;
		$("#vSA_"+i+"_"+z).val(rupiah.format(stok_awal));

		let inin = $("#vIN_"+i+"_"+z).val().split('.').join('');
		(inin.length >= 7 || inin == '' || inin < 0) ? inin = 0 : inin = inin;
		$("#vIN_"+i+"_"+z).val(rupiah.format(inin));

		let inrtr = $("#vINrtr_"+i+"_"+z).val().split('.').join('');
		(inrtr.length >= 7 || inrtr == '' || inrtr < 0) ? inrtr = 0 : inrtr = inrtr;
		$("#vINrtr_"+i+"_"+z).val(rupiah.format(inrtr));

		let outrtr = $("#vOUTrtr_"+i+"_"+z).val().split('.').join('');
		(outrtr.length >= 7 || outrtr == '' || outrtr < 0) ? outrtr = 0 : outrtr = outrtr;
		$("#vOUTrtr_"+i+"_"+z).val(rupiah.format(outrtr));

		let out = $("#vOUT_"+i+"_"+z).val().split('.').join('');
		(out.length >= 7 || out == '' || out < 0) ? out = 0 : out = out;
		$("#vOUT_"+i+"_"+z).val(rupiah.format(out));

		let hitung = (parseInt(stok_awal, 10) + parseInt(inin, 10) + parseInt(inrtr, 10)) - (parseInt(out, 10) + parseInt(outrtr, 10));
		(isNaN(hitung)) ? hitung = 0 : hitung = hitung;
		$("#vSK_"+i+"_"+z).val(rupiah.format(hitung));

		let bb = $("#hTON_"+i+"_"+z).val();
		let ton = parseInt(hitung * bb, 10);
		(ton.length >= 7 || ton < 0) ? ton = 0 : ton = ton;
		$("#vTON_"+i+"_"+z).val(rupiah.format(ton));

		// edit-gdgd
		if((isNaN(hitung)) || hitung == 0 || hitung == ''){
			$(".edit-gdgd-"+i+"_"+z).html('')
		}else{
			$(".edit-gdgd-"+i+"_"+z).html(`<button type="button" class="btn btn-xs btn-warning" style="padding:0 2px" onclick="editGDGD('${i}', '${z}')"><i class="fas fa-pen"></i></button>`)
		}
	}

	function editGDGD(i, z)
	{
		let btnthn = $("#xBLNTHN").val()
		let id_pelanggan = $("#xCUST"+i+"_"+z).val()
		let stok_awal = $("#vSA_"+i+"_"+z).val().split('.').join('')
		let inin = $("#vIN_"+i+"_"+z).val().split('.').join('')
		let inrtr = $("#vINrtr_"+i+"_"+z).val().split('.').join('')
		let outrtr = $("#vOUTrtr_"+i+"_"+z).val().split('.').join('')
		let out = $("#vOUT_"+i+"_"+z).val().split('.').join('')
		let hitung = $("#vSK_"+i+"_"+z).val().split('.').join('')
		let keterangan = $("#vKET_"+i+"_"+z).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/editGDGD')?>',
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
				id_produk: i, hari: z, btnthn, id_pelanggan, stok_awal, inin, inrtr, outrtr, out, hitung, keterangan
			}),
			success: function(res){
				data = JSON.parse(res)
				allListGudang()
			}
		})
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
		let pilih_tgl22 = $("#pilih_tgl22").val()
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
			data: ({ tgl_awal2, pilih_tgl22 }),
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
		let pilih_tgl22 = $("#pilih_tgl22").val()
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
			data: ({ tgl_awal2, pilih_tgl22 }),
			success: function(res){
				data = JSON.parse(res)
				$(".gudang").html(data.html)
				swal.close()
			}
		})
	}

	function simpanGDListCorr()
	{
		$(".btn-lsave").prop('disabled', true)
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
					$("#tgl_awal2").val('')
					$("#pilih_tgl22").val('')
					loadGC()
				}else{
					$(".btn-lsave").prop('disabled', false)
					toastr.error(`<b>${data.msg}</b>`);
					swal.close()
				}
			}
		})
	}

	function cariStokGudang(opsi)
	{
		$(".produk2").html('')
		$(".alist-gudang").html('')
		let id_pelanggan = ''
		let nm_produk = ''
		let tgl_keluar = ''
		if(opsi == ''){
			id_pelanggan = $("#id_pelanggan").val()
			nm_produk = $("#nm_produk").val()
			tgl_keluar = $("#tgl_keluar").val()
		}
		$.ajax({
			url: '<?php echo base_url('Logistik/cariStokGudang')?>',
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
			data: ({ id_pelanggan, nm_produk, tgl_keluar, opsi }),
			success: function(res){
				data = JSON.parse(res)
				$((opsi == '') ? ".produk2" : ".alist-gudang").html(data.html)
				if(data.html){
					swal.close()
				}
			}
		})
	}

	function btnAksiGudang(id_gudang, tgl, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/btnAksiGudang')?>',
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
			data: ({ id_gudang, opsi }),
			success: function(res){
				data = JSON.parse(res)
				$("#tgl_lama_"+data.g.id_produk).val(tgl)
				$("#idx_"+data.g.id_produk).val(id_gudang)
				$("#stok_awal2_"+data.g.id_produk).val((opsi == 'PILIH') ? data.stokAkhir : data.stokAwal).prop('disabled', (opsi == 'PILIH') ? true : false)
				$("#in2_"+data.g.id_produk).val((opsi == 'PILIH') ? 0 : data.in).prop('disabled', false)
				$("#inrtr2_"+data.g.id_produk).val((opsi == 'PILIH') ? 0 : data.inRetur).prop('disabled', false)
				$("#out2_"+data.g.id_produk).val((opsi == 'PILIH') ? 0 : data.out).prop('disabled', false)
				$("#outrtr2_"+data.g.id_produk).val((opsi == 'PILIH') ? 0 : data.outRetur).prop('disabled', false)
				$("#stok_akhir2_"+data.g.id_produk).val(data.stokAkhir).prop('disabled', true)
				$("#tton2_"+data.g.id_produk).val(data.tonase).prop('disabled', true)
				$("#ket2_"+data.g.id_produk).val((opsi == 'PILIH') ? '' : data.g.ket).prop('disabled', false);
				$("#tgl_input_"+data.g.id_produk).val((opsi == 'EDIT') ? data.g.tgl : '').prop('disabled', (opsi == 'EDIT') ? true : false);
				$(".b-aksi-gudang-"+data.g.id_produk).html(data.button);
				$("#modalForm").modal("hide")
				swal.close()
			}
		})
	}

	function clickGudang(id_pelanggan, id_produk, opsi)
	{
		$(".b-aksi-gudang-"+id_produk).prop('disabled', true)
		let tgl_lama = $("#tgl_lama_"+id_produk).val()
		let id_gudang = $("#idx_"+id_produk).val()
		let stok_awal = $("#stok_awal2_"+id_produk).val().split('.').join('')
		let in2 = $("#in2_"+id_produk).val().split('.').join('')
		let inrtr = $("#inrtr2_"+id_produk).val().split('.').join('')
		let out = $("#out2_"+id_produk).val().split('.').join('')
		let outrtr = $("#outrtr2_"+id_produk).val().split('.').join('')
		let stok_akhir = $("#stok_akhir2_"+id_produk).val().split('.').join('')
		let ket = $("#ket2_"+id_produk).val()
		let tgl_input = $("#tgl_input_"+id_produk).val()

		$.ajax({
			url: '<?php echo base_url('Logistik/clickGudang')?>',
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
			data: ({ tgl_lama, id_gudang, id_pelanggan, id_produk, opsi, stok_awal, in2, inrtr, out, outrtr, stok_akhir, ket, tgl_input }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					reloadRow(id_pelanggan, id_produk, opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					$(".b-aksi-gudang-"+id_produk).prop('disabled', false)
					swal.close()
				}
			}
		})
	}

	function reloadRow(id_pelanggan, id_produk, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/reloadRow')?>',
			type: "POST",
			data: ({ id_pelanggan, id_produk, opsi }),
			success: function(res){
				data = JSON.parse(res)
				$(".u-info-po-stok-"+id_produk).html(data.info)
				$("#stok_awal2_"+id_produk).val(0).prop('disabled', true)
				$("#in2_"+id_produk).val(0).prop('disabled', true)
				$("#inrtr2_"+id_produk).val(0).prop('disabled', true)
				$("#out2_"+id_produk).val(0).prop('disabled', true)
				$("#outrtr2_"+id_produk).val(0).prop('disabled', true)
				$("#stok_akhir2_"+id_produk).val('').prop('disabled', true)
				$("#tton2_"+id_produk).val('').prop('disabled', true)
				$("#ket2_"+id_produk).val('').prop('disabled', true)
				$("#tgl_input_"+id_produk).val('').prop('disabled', true)
				$(".b-aksi-gudang-"+id_produk).html('')
				swal.close()
			}
		})
	}

</script>
