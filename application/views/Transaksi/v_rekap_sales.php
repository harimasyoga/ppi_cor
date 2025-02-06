<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
				<!-- <h1><b>Data Transaksi </b></h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<!-- <li class="breadcrumb-item active" ><a href="#"><?= $judul ?></a></li> -->
				</ol>
			</div>
			</div>
		</div>
	</section>
	
	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PILIH</h3>
						</div>

						<div id="tampil_cek_selisih"></div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
							<div class="col-md-2"></div>
							<div class="col-md-3" >
								<div class="input-group">								
									<button type="button" class="btn btn-block btn-info" onclick="pilihan('tgl','tanggal')"><b>TANGGAL</b></button>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">								
									<button type="button" class="btn btn-block btn-info" onclick="pilihan('all','semua')"><b>SEMUA</b></button>
								</div>
							</div>	
							
							<div class="col-md-3"></div>

							<br>
							<br>
							<br>
						</div>
						
						<div id="tampil-pilihan"></div>

						
						<div id="tampil-rincian"></div>

					</div>
				</div>

				<div class="col-md-12">
					<!-- <div class="card card-info card-outline"> -->
						<div class="col-md-12" id="tampil-data"></div>
					<!-- </div> -->
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalFormDetail">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul-detail"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				<div id="modal-detail-so"></div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="modal_ket">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card-header" style="font-family:Arial;" >
				<h4 class="card-title" style="color:#4e73df;" id="judul">INFO*</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>

			<div class="modal-body">
				<div class="card-body">
					<div class="col-md-12">
						<div class="card-body row" style="padding : 5px;font-weight:bold">
							<div class="col-md-2">1. </div>
							<div class="col-md-7">
								Ada Tonase Yang Tidak Tersimpan
							</div>

							<div class="col-md-2"></div>

						</div>
						<div class="card-body row" style="padding : 5px;font-weight:bold">
							<div class="col-md-2">2. </div>
							<div class="col-md-7">
								Silahkan Cek di menu PO
							</div>

							<div class="col-md-2"></div>

						</div>
						<div class="card-body row" style="padding : 5px;font-weight:bold">
							<div class="col-md-2">3. </div>
							<div class="col-md-7">
								Inputkan manual di "trs_po_detail" untuk tonasenya
							</div>

							<div class="col-md-2"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
	$(document).ready(function () {
		// load_data()
		cek_tonase_kosong()
		$("#tampil_cek_selisih").html(``)
		$("#tampil-pilihan").html(``)
		$("#tampil-rincian").html(``)
		$("#tampil-data").html(``)
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	function open_ket(){
		$('#modal_ket').modal('show');
	}

	function cek_tonase_kosong(ket ,opsi)
	{
		$("#tampil_cek_selisih").html(``)
		$.ajax({
			url: '<?php echo base_url('Transaksi/cek_tonase_kosong')?>',
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
				opsi
			}),
			success: function(res){
				$("#tampil_cek_selisih").html(res)
				swal.close()
			}
		})
	}
	
	function pilihan(ket ,opsi)
	{
		$("#tampil-data").html(``)
		$("#tampil-pilihan").html(``)
		$("#tampil-rincian").html(``)
		if(ket == 'tgl' && opsi == 'tanggal'){
			$("#tampil-pilihan").html(`
			<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
				<div class="col-md-3"></div>
				<div class="col-md-2" >BULAN</div>
				<div class="col-md-3">
					<div class="input-group">								
						<input type="month" class="form-control " name="bulan" id="bulan">
					</div>
				</div>	
				<div class="col-md-3"></div>
			</div>
			<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
				<div class="col-md-5"></div>
				<div class="col-md-3">
					<div class="input-group">								
						<buton class="btn btn-block btn-info" onclick="tampil_data()">CARI</buton>
					</div>
				</div>	
				<div class="col-md-3"></div>
			</div>
			<br>
			`)
			$('.select2').select2();
		}else{
			$.ajax({
				url: '<?php echo base_url('Transaksi/hitung_rekap')?>',
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
					opsi
				}),
				success: function(res){
					$("#tampil-rincian").html(res)
					swal.close()
				}
			})
		}
	}

	function tampil_data()
	{
		var bulan = $("#bulan").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/hitung_rekap')?>',
			type: "POST",
			data: {bulan : bulan},
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
				$("#tampil-rincian").html(res)
				swal.close()
			}
		})
	}

	function kosong(){
		//
	}

	function tampilDataEtaPO(tgl)
	{
		// alert(tgl)
		$.ajax({
			url: '<?php echo base_url('Transaksi/tampilDataEtaPO')?>',
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
				tgl
			}),
			success: function(res){
				$("#tampil-data").html(res)
				swal.close()
			}
		})
	}

</script>
