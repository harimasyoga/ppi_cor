<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1><b>Data Plan</b></h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<!-- <li class="breadcrumb-item active" ><a href="#">Corrugator</a></li> -->
				</ol>
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

		.thdhdz:hover {
			background: #eee;
		}
	</style>

	<section class="content">
		<div class="card card-list-so">
			<div class="card-header">
				<h3 class="card-title">Corrugator</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','PPIC','User','plan'])) { ?>
					<div style="margin-bottom:12px">
						<a href="<?php echo base_url('Plan/Corrugator/Add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a>
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
							<th style="width:10%">SHIFT</th>
							<th style="width:10%">MESIN</th>
							<th style="width:30%">NO. PLAN</th>
							<th style="width:10%">JUMLAH</th>
							<th style="width:15%">AKSI</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>

		<?php if(in_array($this->session->userdata('level'), ['Admin'])) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">COR</h3>
						</div>
						<div class="card-body row" style="padding:12px 6px;font-weight:bold">
							<div class="col-md-1">TGL. PLAN</div>
							<div class="col-md-2">
								<input type="date" id="p_tgl_plan" class="form-control" onchange="planCariCor()">
							</div>
							<div class="col-md-9">
								<button type="button" class="btn btn-primary" onclick="planCariCor()"><i class="fas fa-search"></i></button>
							</div>
						</div>
						<div style="overflow:auto;white-space:nowrap">
							<div class="list-pencarian-plan"></div>
						</div>
						<div class="input-roll"></div>
						<div class="list-roll"></div>
					</div>
				</div>
			</div>
		<?php } ?>
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
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		load_data()
		$('.select2').select2();
	});

	$(".tambah_data").click(function(event) {
		status = "insert";
	})

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
				"url": '<?php echo base_url('Plan/LoaDataCor')?>',
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

	//

	function planCariCor(kosong = '') {
		$(".list-pencarian-plan").html('')
		if(kosong == ''){
			$(".input-roll").html('')
			$(".list-roll").html('')
		}else{
			planCariRoll()
		}
		let p_tgl_plan = $("#p_tgl_plan").val()
		$.ajax({
			url: '<?php echo base_url('Plan/planCariCor')?>',
			type: "POST",
			data: ({ p_tgl_plan }),
			success: function(res){
				data = JSON.parse(res)
				$(".list-pencarian-plan").html(data.html)
			}
		})
	}

	function sLbrRoll(id) {
		let lbr_roll = $("#slbroll"+id).val()
		$.ajax({
			url: '<?php echo base_url('Plan/sLbrRoll')?>',
			type: "POST",
			data: ({ id, lbr_roll }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					planCariCor()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function hitungHasil(id) {
		let rp = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'})
		let hasil = $("#shtgroll"+id).val().split('.').join('');
		(hasil < 0 || hasil == 0 || hasil == '' || hasil == undefined || hasil.length >= 7) ? hasil = 0 : hasil = hasil;
		$("#shtgroll"+id).val(rp.format(hasil));
	}

	function sHtgRoll(id) {
		let tgl_plan = $("#p_tgl_plan").val()
		let htg_roll = $("#shtgroll"+id).val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Plan/sHtgRoll')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({ id, tgl_plan, htg_roll }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					planCariCor()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
				swal.close()
			}
		})
	}

	function addRoll(l, kualitas, gsm, id) {
		$(".input-roll").html('')
		$(".list-roll").html('')
		let lbr_roll = $("#slbroll"+id).val()
		$.ajax({
			url: '<?php echo base_url('Plan/addRoll')?>',
			type: "POST",
			data: ({ l, kualitas, gsm, id, lbr_roll }),
			success: function(res){
				data = JSON.parse(res)
				$(".input-roll").html(data.html)
				$('.select2').select2();
				planCariRoll()
			}
		})
	}

	function planCariRoll() {
		let tgl_plan = $("#p_tgl_plan").val()
		let s_corr = $("#s_corr").val()
		let s_lebar = $("#s_lebar").val()
		let s_roll = $("#s_roll").val()
		let s_l = $("#s_l").val()
		let s_gsm = $("#s_gsm").val()
		let s_id = $("#s_id").val()
		$(".list-roll").html('')
		$.ajax({
			url: '<?php echo base_url('Plan/planCariRoll')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				tgl_plan, s_corr, s_lebar, s_roll, s_l, s_gsm, s_id
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".list-roll").html(data.html)
				if(data.html != ''){
					swal.close()
				}
			}
		})
	}

	function addListRoll(id){
		let s_corr = $("#s_corr").val()
		let s_lebar = $("#s_lebar").val()
		let s_roll = $("#s_roll").val()
		let s_l = $("#s_l").val()
		let s_kualitas = $("#s_kualitas").val()
		let s_id = $("#s_id").val()
		$.ajax({
			url: '<?php echo base_url('Plan/addListRoll')?>',
			type: "POST",
			data: ({ s_corr, s_lebar, s_roll, s_l, s_kualitas, s_id, id }),
			success: function(res){
				data = JSON.parse(res)
				planCariCor('a')
			}
		})
	}

	function delListRoll(id){
		$.ajax({
			url: '<?php echo base_url('Plan/delListRoll')?>',
			type: "POST",
			data: ({ id }),
			success: function(res){
				data = JSON.parse(res)
				planCariCor('a')
			}
		})
	}


</script>
