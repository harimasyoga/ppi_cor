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
	</style>

	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">GUDANG</h3>
						</div>
						<div class="card-body card-body-gudang" style="padding:6px"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-info">
						<div class="card-header" style="padding:12px;font-weight:bold">RENCANA KIRIM</div>
						<div class="card-body card-body-rk">
							RENCANA KIRIM
						</div>
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
	$(document).ready(function() {
		loadSJGudang()
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function loadSJGudang() {
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJGudang') ?>',
			type: "POST",
			// beforeSend: function() {
			// 	swal({
			// 		title: 'Loading',
			// 		allowEscapeKey: false,
			// 		allowOutsideClick: false,
			// 		onOpen: () => {
			// 			swal.showLoading();
			// 		}
			// 	});
			// },
			success: function(res) {
				$(".card-body-gudang").html(res)
				// swal.close()
			}
		})
	}

	function loadSJItems(gd_id_pelanggan) {
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJItems') ?>',
			type: "POST",
			data: ({ gd_id_pelanggan }),
			success: function(res) {
				$("#tampilItems-"+gd_id_pelanggan).html(res)
			}
		})
	}
</script>
