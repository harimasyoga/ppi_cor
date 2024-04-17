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

			<div class="row row-input-invoice-laminasi">
				<div class="col-md-7">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT PO LAMINASI</h3>
						</div>
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. INVOICE</div>
							<div class="col-md-8">
								<input type="date" id="tgl_invoice" class="form-control" value="<?= date('Y-m-d')?>">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. SJ</div>
							<div class="col-md-8">
								<input type="date" id="tgl_sj" class="form-control" onchange="cariSJLaminasi()">
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-primary" onclick="cariSJLaminasi()"><i class="fas fa-search"></i><b></b></button>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SURAT JALAN</div>
							<div class="col-md-9">
								<select id="no_surat_jalan" class="form-control select2" onchange="pilihSJInvLam()" disabled>
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">NO. INVOICE</div>
							<div class="col-md-8">
								<input type="text" class="form-control" style="font-weight:bold" value="AUTO" disabled>
								<input type="hidden" id="no_invoice" value="">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">TGL. JATUH TEMPO</div>
							<div class="col-md-8">
								<input type="date" id="tgl_jatuh_tempo" class="form-control">
							</div>
							<div class="col-md-1"></div>
						</div>
					</div>

					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">DIKIRIM KE</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
							<div class="col-md-3">KEPADA</div>
							<div class="col-md-9">
								<input type="hidden" id="h_id_pelanggan_lm" value="">
								<input type="text" id="kepada" class="form-control" placeholder="Kepada" autocomplete="off" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">ALAMAT</div>
							<div class="col-md-9">
								<textarea id="alamat" class="form-control" style="resize:none" rows="3" placeholder="Alamat" autocomplete="off" oninput="this.value=this.value.toUpperCase()"></textarea>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">PILIHAN BANK</div>
							<div class="col-md-9">
								<select id="pilihan_bank" class="form-control select2">
									<option value="">PILIH</option>
									<option value="BCA">BCA</option>
									<option value="BNI">BNI</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="col-verif-invoice-laminasi">
						<div class="card card-info card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body" style="padding:6px">
								Verif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-invoice-laminasi">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-item">LIST ITEM KOSONG</div>

								<!-- DISCOUNT DAN POTONGAN -->
								<div class="disc-potongan" style="display:none">
									<div class="card-body row" style="font-weight:bold;padding:12px 6px 6px">
										<div class="col-md-1">JENIS</div>
										<div class="col-md-2">
											<select id="dc_jenis" class="form-control select2">
												<option value="">PILIH</option>
												<option value="DISCOUNT">DISCOUNT</option>
												<option value="POTONGAN">POTONGAN</option>
											</select>
										</div>
										<div class="col-md-9"></div>
									</div>
									<!-- DISCOUNT -->
									<div class="pdc-discount">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<div class="input-group">
													<input type="number" id="dc_disc_persen" class="form-control" autocomplete="off" placeholder="%">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">%</span>
													</div>
												</div>
											</div>
											<div class="col-md-9"></div>
										</div>
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<div class="input-group">
													<input type="number" id="dc_disc_hari" class="form-control" autocomplete="off" placeholder="HARI">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">HARI</span>
													</div>
												</div>
											</div>
											<div class="col-md-9"></div>
										</div>
									</div>
									<!-- POTONGAN -->
									<div class="pdc-potongan">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<div class="input-group">
													<input type="number" id="dc_pot_rp" class="form-control" autocomplete="off" placeholder="Rp.">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">Rp</span>
													</div>
												</div>
											</div>
											<div class="col-md-9"></div>
										</div>
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<div class="input-group">
													<input type="number" id="dc_pot_bal" class="form-control" autocomplete="off" placeholder="BALL">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">BALL</span>
													</div>
												</div>
											</div>
											<div class="col-md-9"></div>
										</div>
									</div>

									<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
										<div class="col-md-1">KET</div>
										<div class="col-md-4">
											<input type="text" id="dc_ket" class="form-control" autocomplete="off" placeholder="Keterangan">
										</div>
										<div class="col-md-7"></div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 6px 16px">
										<div class="col-md-1"></div>
										<div class="col-md-11">
											<button type="button" class="btn btn-sm btn-success">ADD</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-invoice-laminasi">
				<div class="col-md-12">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>INVOICE LAMINASI</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body" style="padding:6px">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'User'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="width:47%;padding:12px;text-align:center">CUSTOMER</th>
											<th style="width:47%;padding:12px;text-align:center">NO. PO</th>
											<th style="width:6%;padding:12px;text-align:center">AKSI</th>
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

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight:bold">LIST SURAT JALAN</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">
					<div class="list-cari-sj"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		// kosong()
		// load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

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
	// 			"data": ({
	// 				po: 'list',
	// 			}),
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

	function kosong()
	{
		let tanggal = '<?= date("Y-m-d")?>'
		$("#tgl_invoice").val(tanggal)
		$("#tgl_sj").val("")
		$("#no_surat_jalan").val("").prop('disabled', true).trigger('change')
		$("#no_invoice").val("")
		$("#tgl_jatuh_tempo").val("")

		$("#h_id_pelanggan_lm").val("")
		$("#kepada").val("")
		$("#alamat").val("")
		$("#pilihan_bank").val("").trigger('change')

		$(".list-item").html('LIST ITEM KOSONG')

		$("#dc_jenis").val("").trigger('change')
		$("#dc_disc_persen").val("")
		$("#dc_disc_hari").val("")
		$("#dc_pot_rp").val("")
		$("#dc_pot_bal").val("")
		$("#dc_ket").val("")

		statusInput = 'insert'
		// swal.close()
	}

	function tambahData() {
		kosong()
	}

	function kembali() {
		kosong()
	}

	function cariSJLaminasi(){
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".list-item").html('LIST ITEM KOSONG')
		let tgl_sj= $("#tgl_sj").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariSJLaminasi')?>',
			type: "POST",
			data: ({ tgl_sj }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#no_surat_jalan").html(data.htmlSJ).prop('disabled', (data.numRows == 0) ? true : false)
			}
		})
	}

	function pilihSJInvLam() {
		$(".list-item").html('LOAD DATA LIST ITEM')
		let no_surat = $("#no_surat_jalan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/pilihSJInvLam')?>',
			type: "POST",
			data: ({ no_surat }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(no_surat != ''){
					$("#no_invoice").val(data.no_invoice)
					$("#h_id_pelanggan_lm").val(data.id_pelanggan_lm)
					$("#kepada").val(data.kepada)
					$("#alamat").val(data.alamat)	
					$(".list-item").html(data.htmlItem)
				}
			}
		})
	}

	function simpanInvLam() {
		let tgl_invoice = $("#tgl_invoice").val()
		let tgl_sj = $("#tgl_sj").val()
		let no_surat_jalan = $("#no_surat_jalan").val()
		let no_invoice = $("#no_invoice").val()
		let tgl_jatuh_tempo = $("#tgl_jatuh_tempo").val()
		let h_id_pelanggan_lm = $("#h_id_pelanggan_lm").val()
		let kepada = $("#kepada").val()
		let alamat = $("#alamat").val()
		let pilihan_bank = $("#pilihan_bank").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanInvLam')?>',
			type: "POST",
			data: ({
				tgl_invoice, tgl_sj, no_surat_jalan, no_invoice, tgl_jatuh_tempo, h_id_pelanggan_lm, kepada, alamat, pilihan_bank
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.data){
					kosong()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
			}
		})
	}

	// function cari_sj(){
	// 	$("#modalForm").modal("show");
	// }

</script>
