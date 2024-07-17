<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1><b>Data Plan</b></h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<!-- <li class="breadcrumb-item active" ><a href="#">Finishing</a></li> -->
				</ol>
			</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="card card-list-so">
			<div class="card-header">
				<h3 class="card-title">Finishing</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'PPIC','User','plan'])) { ?>
					<div style="margin-bottom:12px">
						<a href="<?php echo base_url('Plan/Finishing/Add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a>
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
					<div class="col-md-10"></div>
				</div>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">#</th>
							<th style="width:20%">TANGGAL</th>
							<th style="width:20%">SHIFT</th>
							<th style="width:20%">JOINT</th>
							<th style="width:20%">JUMLAH</th>
							<th style="width:15%">AKSI</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
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
				"url": '<?php echo base_url('Plan/LoaDataFinishing')?>',
				"type": "POST",
				"data": ({
					tahun
				}),
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		})
	}
</script>
