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
				
				<div class="col-md-4">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title">COR</h3>
						</div>
						<div id="card-body-cor" style="overflow:auto;white-space:nowrap">
							<div style="padding:20px;text-align:center;font-size:8px;background:#bbb">
								<i class="fas fa-3x fa-sync-alt fa-spin"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title">FLEXO</h3>
						</div>
						<div id="card-body-flexo" style="overflow:auto;white-space:nowrap">
							<div style="padding:20px;text-align:center;font-size:8px;background:#bbb">
								<i class="fas fa-3x fa-sync-alt fa-spin"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title">FINISHING</h3>
						</div>
						<div id="card-body-finishing" style="overflow:auto;white-space:nowrap">
							<div style="padding:20px;text-align:center;font-size:8px;background:#bbb">
								<i class="fas fa-3x fa-sync-alt fa-spin"></i>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-md-12">
					<div id="list-produksi"></div>
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
			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function ()
	{
		loadGudang('cor', '', '')
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function loadGudang(opsi, id_pelanggan, id_produk)
	{
		$(".bgtd").attr('style', 'padding:6px;border-width:0 0 1px;background:#fff')
		$.ajax({
			url: '<?php echo base_url('Logistik/loadGudang')?>',
			type: "POST",
			data: ({
				opsi, id_pelanggan, id_produk
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)

				let htmlGG = ''
				let bgTd = ''
				htmlGG += `<table class="table table-bordered" style="margin:0;border:0">
					<thead>`
						data.data.forEach(loadHtml)
						function loadHtml(r, index) {
							if(data.opsi == opsi && id_pelanggan == r.gd_id_pelanggan && id_produk == r.gd_id_produk){
								bgTd = ';background:#ffd700;color:#000;font-weight:bold'
							}else{
								bgTd = ';background:#fff'
							}

							htmlGG += `<tr>
								<td class="bgtd" style="padding:6px;border-width:0 0 1px${bgTd}">
									<a href="javascript:void(0)" style="color:#212529" onclick="loadGudang('${opsi}', ${r.gd_id_pelanggan}, ${r.gd_id_produk})">
										${r.nm_pelanggan} - ${r.nm_produk}
									</a>
									<span class="bg-primary" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px;border-radius:4px">${r.jml}</span>
								</td>
							</tr>`
						}
					htmlGG += `</thead>
				</table>`
				$("#card-body-"+data.opsi).html(htmlGG)

				if(opsi == 'cor' && id_pelanggan == '' && id_produk == ''){
					loadGudang('flexo', '', '')
				}else if(opsi == 'flexo' && id_pelanggan == '' && id_produk == ''){
					loadGudang('finishing', '', '')
				}

				if(data.opsi != '' && data.id_pelanggan != '' && data.id_pelanggan != ''){
					loadListProduksiPlan(data.opsi, data.id_pelanggan, data.id_produk)
				}
			}
		})
	}

	function loadListProduksiPlan(opsi, id_pelanggan, id_produk)
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/loadListProduksiPlan')?>',
			type: "POST",
			data: ({
				opsi, id_pelanggan, id_produk
			}),
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
				$("#list-produksi").html(res)
				swal.close()
			}
		})
	}

</script>
