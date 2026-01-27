<div class="content-wrapper">
	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>
	<section class="content" style="padding:24px 12px">
		<!-- INPUT -->
		<div class="card-inpt" style="display:none">
			<div class="card card-primary card-outline">
				<div class="card-header" style="padding:12px">
					<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT MASTER EKSPEDISI</h3>
				</div>
				<div style="margin:12px 6px">
					<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
				</div>
				<div class="card-body" style="padding:12px">
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1">PLAT</div>
						<div class="col-md-3">
							<input type="hidden" id="h_id_ex" value="">
							<input type="text" id="i_plat" class="form-control" autocomplete="off" placeholder="PLAT" oninput="this.value=this.value.toUpperCase()">
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1">EKSPEDISI</div>
						<div class="col-md-3">
							<input type="text" id="i_ekspedisi" class="form-control" autocomplete="off" placeholder="EKSPEDISI" oninput="this.value=this.value.toUpperCase()">
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1">PANJANG</div>
						<div class="col-md-3">
							<input type="number" id="i_panjang" class="form-control" autocomplete="off" placeholder="PANJANG">
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1">LEBAR</div>
						<div class="col-md-3">
							<input type="number" id="i_lebar" class="form-control" autocomplete="off" placeholder="LEBAR">
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1">TINGGI</div>
						<div class="col-md-3">
							<input type="number" id="i_tinggi" class="form-control" autocomplete="off" placeholder="TINGGI">
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:6px 0">
						<div class="col-md-1"></div>
						<div class="col-md-3">
							<button class="btn btn-primary btn-sm" onclick="simpanEkspedisi()"><i class="fas fa-save"></i> <b>SIMPAN</b></button>
						</div>
						<div class="col-md-8"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- LIST -->
		<div class="card-list">
			<div class="card card-secondary card-outline">
				<div class="card-header">
					<h3 class="card-title" style="font-weight:bold"><?= $judul ?></h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					<?php if (in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User'])) { ?>
						<button type="button" class="btn btn-info pull-right" onclick="tambahData()"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
						<br><br>
					<?php } ?>
					<table id="datatable" class="table table-bordered table-striped" width="100%">
						<thead>
							<tr>
								<th style="text-align:center">#</th>
								<th style="text-align:center">PLAT</th>
								<th style="text-align:center">EKSPEDISI</th>
								<th style="text-align:center">PANJANG (m)</th>
								<th style="text-align:center">LABAR (m)</th>
								<th style="text-align:center">TINGGI (m)</th>
								<th style="text-align:center">Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	statInput = "insert"
	$(document).ready(function() {
		load_data();
	});

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/ekspedisi',
				"type": "POST",
			},
			responsive: true,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function kosong() {
		statInput = "insert"
		$("#h_id_ex").val("")
		$("#i_plat").val("")
		$("#i_ekspedisi").val("")
		$("#i_panjang").val("")
		$("#i_lebar").val("")
		$("#i_tinggi").val("")
	}

	function tambahData() {
		kosong()
		$(".card-inpt").show()
		$(".card-list").hide()
	}

	function kembali() {
		kosong()
		reloadTable()
		$(".card-inpt").hide()
		$(".card-list").show()
	}

	function simpanEkspedisi() {
		let h_id_ex = $("#h_id_ex").val()
		let i_plat = $("#i_plat").val()
		let i_ekspedisi = $("#i_ekspedisi").val()
		let i_panjang = $("#i_panjang").val()
		let i_lebar = $("#i_lebar").val()
		let i_tinggi = $("#i_tinggi").val()
		$.ajax({
			url: '<?php echo base_url('Master/simpanEkspedisi')?>',
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
				h_id_ex, i_plat, i_ekspedisi, i_panjang, i_lebar, i_tinggi, statInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					kembali()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
				swal.close()
			}
		})
	}

	function editEkspedisi(id_ex) {
		$(".card-inpt").show()
		$(".card-list").hide()
		$.ajax({
			url: '<?php echo base_url('Master/editEkspedisi')?>',
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
			data: ({ id_ex }),
			success: function(res){
				data = JSON.parse(res)
				statInput = "update"
				$("#h_id_ex").val(data.ekspedisi.id_ex)
				$("#i_plat").val(data.ekspedisi.plat)
				$("#i_ekspedisi").val(data.ekspedisi.ekspedisi)
				$("#i_panjang").val(data.ekspedisi.panjang)
				$("#i_lebar").val(data.ekspedisi.lebar)
				$("#i_tinggi").val(data.ekspedisi.tinggi)
				swal.close()
			}
		})
	}

	function hapusEkspedisi(id_ex, plat)
	{
		swal({
			title : plat,
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
				url: '<?php echo base_url('Master/hapusEkspedisi')?>',
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
				data: ({ id_ex }),
				success: function(res){
					data = JSON.parse(res)
					if(data.data){
						toastr.success(`<b>BERHASIL HAPUS!</b>`)
						reloadTable()
					}else{
						toastr.error(`<b>TERJADI KESALAHAN!</b>`)
					}
					swal.close()
				}
			})
		})
	}
</script>
