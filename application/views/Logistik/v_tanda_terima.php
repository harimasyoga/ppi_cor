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

			<div class="row row-list">
				<div class="col-md-12 col-list">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>TANDA TERIMA & KWITANSI</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div style="margin-bottom:12px">
								<?php if(in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'Pembayaran', 'Keuangan1'])){ ?>
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								<?php } ?>
							</div>
							<div class="card-body row" style="padding:0 0 8px;font-weight:bold">
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="tahun" class="form-control select2" onchange="load_data()">
										<?php
											$thang = date("Y");
											$thang_maks = $thang + 1;
											$thang_min = $thang - 5;
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
								<div class="col-md-10"></div>
							</div>
							<div style="overflow:auto;">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center">NO.</th>
											<th style="padding:12px 200px;text-align:center">DESKRIPSI</th>
											<th style="padding:12px;text-align:center">NOMINAL</th>
											<th style="padding:12px;text-align:center">CETAK</th>
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

			<div class="row row-input">
				<div class="col-md-12">
					<div class="card card-success card-outline" style="padding-bottom:16px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT TANDA TERIMA</h3>
						</div>
						<div class="card-body">
							<div style="margin:12px 6px;display:flex">
								<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
								<div class="col-md-2">TANGGAL</div>
								<div class="col-md-3">
									<input type="date" id="tgl" class="form-control">
								</div>
								<div class="col-md-7"></div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
								<div class="col-md-2">PILIH</div>
								<div class="col-md-3">
									<select id="slt_jenis" class="form-control select2" onchange="loadCustAkses()">
										<option value="">PILIH</option>
										<option value="BOX">BOX</option>
										<option value="ROLL">ROLL</option>
									</select>
								</div>
								<div class="col-md-7"></div>
							</div>
							<div class="axs akses_cust"></div>
							<div class="axs akses_sj_inv"></div>
							<div class="axs akses_add"></div>
							<input type="hidden" id="cart-akses" value="">
							<div style="overflow:auto;white-space:nowrap">
								<div class="axs akses_list"></div>
							</div>
							<div class="axs akses_simpan"></div>
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
		kosong()
		load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let tahun = $("#tahun").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/tandaTerima')?>',
				"type": "POST",
				"data": ({
					tahun
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

	function kosong()
	{
		statusInput = 'insert'
		$("#cart-akses").load("<?php echo base_url('Logistik/destroyAkses') ?>")
		$("#tgl").val('')
		$("#slt_jenis").val('').prop('disabled', false).trigger('change')
		$(".akses_cust").html('')
		$(".akses_sj_inv").html('')
		$(".akses_add").html('')
		$(".akses_list").html('')
		$(".akses_simpan").html('')
	}

	function tambahData() {
		kosong()
		// $(".row-list").hide()
		// $(".row-input").show()
	}

	function kembali() {
		reloadTable()
		kosong()
		// $(".row-list").show()
		// $(".row-input").hide()
	}

	function loadCustAkses() {
		let jenis = $("#slt_jenis").val()
		$(".akses_cust").html('')
		$(".akses_sj_inv").html('')
		$(".akses_add").html('')
		$(".akses_simpan").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/loadCustAkses') ?>',
			type: "POST",
			data: ({ jenis }),
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
				$(".akses_cust").html(data.htmlCust)
				$('.select2').select2()
				swal.close()
			}
		})
	}

	function loadSJInvAkses() {
		$(".akses_sj_inv").html('')
		$(".akses_add").html('')
		let jenis = $("#slt_jenis").val()
		let axs_cust = $("#axs_cust").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJInvAkses') ?>',
			type: "POST",
			data: ({ jenis, axs_cust, opsi: 'tt' }),
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
				$(".akses_sj_inv").html(data.htmlSJInv)
				$('.select2').select2()
				swal.close()
			}
		})
	}

	function btnCartAkses() {
		$(".akses_add").html('')
		let slt_pilih = 'TT'
		let id_pelanggan = $("#axs_cust").val()
		let id_invoice = $("#axs_inv").val()
		if(id_pelanggan != '' && id_invoice != ''){
			if(slt_pilih != ''){
				$(".akses_add").html(`
					<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
						<div class="col-md-2"></div>
						<div class="col-md-10">
							<button type="button" class="btn btn-sm btn-success" style="font-weight:bold" onclick="addCartAkses()"><i class="fas fa-plus"></i> ADD</button>
						</div>
					</div>
				`)
			}else{
				$(".akses_add").html('')
			}
		}else{
			$(".akses_add").html('')
		}
	}

	function addCartAkses() {
		let jenis = $("#slt_jenis").val()
		let slt_pilih = 'TT'
		let id_pelanggan = $("#axs_cust").val()
		let id_invoice = $("#axs_inv").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/addCartAkses') ?>',
			type: "POST",
			data: ({ jenis, slt_pilih, id_pelanggan, id_invoice }),
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
					listCartAkses()
					$("#slt_jenis").prop('disabled', true)
					$("#axs_cust").prop('disabled', true)
				}else{
					toastr.error(`<b>${data.isi}</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusCartAkses(rowid){
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusCartAkses')?>',
			type: "POST",
			data: ({ rowid }),
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
				listCartAkses()
			}
		})
	}

	function listCartAkses() {
		$(".akses_list").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/listCartAkses') ?>',
			type: "POST",
			data: ({
				opsi: "TT"
			}),
			success: function(res) {
				data = JSON.parse(res)
				$(".akses_list").html(data.html)
				if(data.simpan){
					$(".akses_simpan").html(`<button type="button" class="btn btn-sm btn-primary" style="font-weight:bold" onclick="simpanAkses()"><i class="fas fa-save"></i> SIMPAN</button>`);
				}else{
					$(".akses_simpan").html('');
				}
				swal.close()
			}
		})
	}

	function simpanAkses() {
		let jenis = $("#slt_jenis").val()
		let tgl = $("#tgl").val()
		let id_pelanggan = $("#axs_cust").val()
		$(".akses_simpan").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanAksesTT') ?>',
			type: "POST",
			data: ({
				jenis, tgl, id_pelanggan
			}),
			// beforeSend: function() {
			// 	swal({
			// 		title: 'loading ...',
			// 		allowEscapeKey    : false,
			// 		allowOutsideClick : false,
			// 		onOpen: () => {
			// 			swal.showLoading();
			// 		}
			// 	})
			// },
			success: function(res) {
				data = JSON.parse(res)
				console.log(data)
				// toastr.success(`<b>BERHASIL!</b>`)
				// kembali()
			}
		})
	}
</script>
