<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6"></div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">TANGGAL</h3>
						</div>
						<div class="card-body row" style="padding:6px 7px">
							<div class="col-md-12">
								<input type="date" id="tgl" class="form-control" onchange="pilihTanggal()">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST LAPORAN PENGIRIMAN <span class="span-tanggal"></span></h3>
						</div>
						<div class="card-body row" style="padding:6px 7px">
							<div class="col-md-12">
								<div id="list-laporan">
									PILIH TANGGAL
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".select2").select2()
	});

	function pilihTanggal(){
		let tgl = $("#tgl").val()
		$.ajax({
			url: '<?php echo base_url('Laporan/plhTglLapPengiriman')?>',
			type: "POST",
			data: ({ tgl }),
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
			success: function(res){
				data = JSON.parse(res)
				$(".span-tanggal").html(data.tgl)
				$("#list-laporan").html(data.html)
				swal.close()
			}
		})
	}
</script>
