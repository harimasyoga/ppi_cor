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
		<div class="row card-add-gudang">
			<div class="col-md-12">
				<div class="card card-primary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST STOK PRODUK</h3>
					</div>
					<div class="card-body" style="font-weight:bold;padding:6px">
						<div style="margin-bottom:6px">
							<button type="button" class="btn btn-info" onclick="kembali()"><i class="fas fa-arrow-left"></i> <b>Kembali</b></button>
						</div>
						<div style="margin-bottom:12px">
							<input type="text" id="cari" class="form-control" placeholder="CARI . . ." autocomplete="off" oninput="this.value = this.value.toUpperCase()" onchange="cariProduk()">
						</div>
						<div class="hasil-cari"></div>
						<div class="produk">
							<table>
								<tr>
									<td style="padding:6px 0 16px">TGL STOK AWAL</td>
									<td style="padding:6px 6px 16px">:</td>
									<td style="padding:6px 0 16px">
										<input type="date" id="tgl_awal" name="tgl_awal" class="form-control" onchange="sList()">
									</td>
								</tr>
							</table>
							<div class="list-produk"></div>
							<div style="display:none">
								<table>
									<tr>
										<td style="padding:6px 0 16px">PILIH TANGGAL</td>
										<td style="padding:6px 6px 16px">:</td>
										<td style="padding:6px 0 16px">
											<input type="date" id="tgl_awal" name="tgl_awal" class="form-control">
										</td>
									</tr>
								</table>
							</div>
						</div>
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
				<?php if(in_array($this->session->userdata('level'), ['Admin', 'User'])) { ?>
					<div style="margin-bottom:16px">
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
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">#</th>
							<th style="width:25%">NAMA PRODUK</th>
							<th style="width:10%">UKURAN</th>
							<th style="width:10%">SUBSTANCE</th>
							<th style="width:10%">FLUTE</th>
							<th style="width:10%">STOK AWAL</th>
							<th style="width:10%">IN</th>
							<th style="width:10%">OUT</th>
							<th style="width:10%">STOK AKHIR</th>
							<th style="width:20%">KETERANGAN</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		$(".select2").select2()
		// load_data()
	});

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	// function load_data() {
	// 	let plh_tgl = $("#plh_tgl").val()
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Logistik/loadDataGDLaminasi')?>',
	// 			"type": "POST",
	// 			"data": ({ plh_tgl }),
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 15, 20, -1],
	// 			[5, 10, 15, 20, "Semua"]
	// 		],
	// 		responsive: true,
	// 		"pageLength": 10,
	// 		"language": {
	// 			"emptyTable": "Tidak ada data.."
	// 		}
	// 	})
	// }

	function cariProduk()
	{
		$(".hasil-cari").html('')
		let cari = $("#cari").val()
		console.log(cari)
		$.ajax({
			url: '<?php echo base_url('Logistik/CariGProduk')?>',
			type: "POST",
			data: ({ cari }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".hasil-cari").html(data.html)
			}
		})
	}

	function sList()
	{
		$(".list-produk").html('')
		let tgl_awal = $("#tgl_awal").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/sList')?>',
			type: "POST",
			data: ({ tgl_awal }),
			success: function(res){
				data = JSON.parse(res)
				// $(".list-produk").html(data.html)
				console.log(data)
			}
		})
	}

</script>
