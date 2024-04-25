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
								<input type="date" id="tgl_sj" class="form-control" onchange="cariSJJasa()">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SURAT JALAN</div>
							<div class="col-md-9">
								<select id="no_surat_jalan" class="form-control select2" onchange="pilihSJInvJasa()" disabled>
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">NO. INVOICE</div>
							<div class="col-md-8">
								<input type="text" class="form-control" style="font-weight:bold" id="txt_no_invoice" value="AUTO" disabled>
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
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3">ALAMAT</div>
							<div class="col-md-9">
								<textarea id="alamat" class="form-control" style="resize:none" rows="3" placeholder="Alamat" autocomplete="off" oninput="this.value=this.value.toUpperCase()"></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="col-verif-invoice-laminasi">
						<div class="card card-info card-outline" style="padding-bottom:18px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">ADMIN</div>
								<div class="col-md-9">
									<div id="verif-admin"></div>
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
			</div>

			<div class="row row-item-invoice-laminasi">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-item">LIST ITEM KOSONG</div>
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
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center">NO.</th>
											<th style="padding:12px;text-align:center">DESKRIPSI</th>
											<th style="padding:12px;text-align:center">JATUH TEMPO</th>
											<th style="padding:12px;text-align:center">ADMIN</th>
											<th style="padding:12px;text-align:center">OWNER</th>
											<th style="padding:12px;text-align:center">TOTAL</th>
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
	// 			"url": '<?php echo base_url('Logistik/load_data/loadDataInvoiceLaminasi')?>',
	// 			"type": "POST",
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
		$("#tgl_invoice").val("")
		$("#tgl_sj").val("")
		$("#no_surat_jalan").val("")
		$("#txt_no_invoice").val("")
		$("#no_invoice").val("")
		$("#tgl_jatuh_tempo").val("")
		$("#h_id_pelanggan_lm").val("")
		$("#kepada").val("")
		$("#alamat").val("")

		statusInput = 'insert'
		swal.close()
	}

	// function tambahData() {
	// 	kosong()
	// }

	// function kembali() {
	// 	kosong()
	// 	reloadTable()
	// }

	function cariSJJasa()
	{
		let tgl_sj = $("#tgl_sj").val()
		console.log("tgl_sj : ", tgl_sj)
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".list-item").html('LIST ITEM KOSONG')
		$.ajax({
			url: '<?php echo base_url('Logistik/cariSJJasa')?>',
			type: "POST",
			data: ({ tgl_sj }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#no_surat_jalan").html(data.htmlSJ).prop('disabled', (data.numRows == 0) ? true : false)
			}
		})
	}

	
</script>
