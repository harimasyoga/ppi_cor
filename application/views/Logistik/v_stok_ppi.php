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

	<!-- Default box -->
	<div class="card shadow row-input" style="display: none;">
		<div class="card-header" style="font-family:Cambria;" >
			<h3 class="card-title" style="color:#4e73df;"><b>INPUT STOK PPI</b></h3>

			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
			</div>
		</div>
		<form role="form" method="post" id="myForm">
			<div class="col-md-12">
							
				<br>
					
				<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
					<div class="col-md-2">NOMER</div>
					<div class="col-md-3">
						<input type="hidden" class="form-control" name="sts_input" id="sts_input" >
						<input type="hidden" class="form-control" name="id_stok_ppi" id="id_stok_ppi" >
						<input type="text" class="form-control" name="no_stok_ppi" id="no_stok_ppi" value ="AUTO" readonly>
					</div>	
					
					<div class="col-md-6"></div>

				</div>
				
				<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
					<div class="col-md-2">TANGGAL</div>
					<div class="col-md-3">
						<input type="date" class="form-control" name="tgl_stok" id="tgl_stok" value ="<?= date('Y-m-d') ?>" >
					</div>	
					
					<div class="col-md-1"></div>
					<div class="col-md-2">KETERANGAN</div>
					<div class="col-md-3">
						<input type="text" class="form-control" name="ket_header" id="ket_header" value ="-" >
						<input type="hidden" class="form-control" name="jam_stok" id="jam_stok" value ="" >
					</div>	

				</div>
				<br>					
				
				<div style="overflow:auto;white-space:nowrap">
					<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table-produk" width="100%">
						<thead class="color-tabel">
							<tr>
								<th style="padding : 12px 50px">NAMA</th>
								<th style="padding : 12px 15px" >STOK AWAL</th>
								<th style="padding : 12px 15px" >MASUK</th>
								<th style="padding : 12px 15px" >KELUAR</th>
								<th style="padding : 12px 15px" >STOK AKHIR</th>
							</tr>
						</thead>
						<tbody>
							<tr id="1">
								<td>
									<div>
										<b>LOCAL OCC</b>
										<input type="hidden" name="ket1" id="ket1" value="local_occ" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal1" id="stok_awal1" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk1" id="masuk1" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar1" id="keluar1" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir1" id="stok_akhir1" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>
							
							<tr id="2">
								<td>
									<div>
										<b>LOCAL MIX WASTE</b>
										<input type="hidden" name="ket2" id="ket2" value="mix_waste" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal2" id="stok_awal2" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk2" id="masuk2" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar2" id="keluar2" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir2" id="stok_akhir2" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>
							
							<tr id="3">
								<td>
									<div>
										<b>LOCAL PLUMPUNG</b>
										<input type="hidden" name="ket3" id="ket3" value="plumpung" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal3" id="stok_awal3" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk3" id="masuk3" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar3" id="keluar3" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir3" id="stok_akhir3" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>

							<tr id="4">
								<td>
									<div>
										<b>LOCAL LAMINATING</b>
										<input type="hidden" name="ket4" id="ket4" value="laminating" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal4" id="stok_awal4" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk4" id="masuk4" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar4" id="keluar4" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir4" id="stok_akhir4" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>

							<tr id="5">
								<td>
									<div>
										<b>LOCAL SLUDGE</b>
										<input type="hidden" name="ket5" id="ket5" value="sludge" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal5" id="stok_awal5" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk5" id="masuk5" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar5" id="keluar5" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir5" id="stok_akhir5" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>

							<tr id="6">
								<td>
									<div>
										<b>LOCAL BROKE LAMINASI</b>
										<input type="hidden" name="ket6" id="ket6" value="broke_lam" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal6" id="stok_awal6" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk6" id="masuk6" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar6" id="keluar6" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir6" id="stok_akhir6" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>

							<tr id="7">
								<td>
									<div>
										<b>LOCAL BROKE CORR</b>
										<input type="hidden" name="ket7" id="ket7" value="broke_corr" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal7" id="stok_awal7" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk7" id="masuk7" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar7" id="keluar7" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir7" id="stok_akhir7" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>

							<tr id="8">
								<td>
									<div>
										<b>LOCAL BROKE PM</b>
										<input type="hidden" name="ket8" id="ket8" value="broke_pm" >
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_awal8" id="stok_awal8" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="masuk8" id="masuk8" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">

										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="keluar8" id="keluar8" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_stok()">
										<div class="input-group-append">

											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
								<td>
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="stok_akhir8" id="stok_akhir8" value ="0" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>
							</tr>
						</tbody>

						<tfoot>
							<tr>
								<td class="text-center">
									<label for="total"><b>TOTAL</b></label>
								</td>	
								<td>
									<div class="input-group mb-1">
										<input type="text" size="5" name="total_stok_awal" id="total_stok_awal" class="angka form-control" value='0' readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
									
								</td>	
								<td>
									<div class="input-group mb-1">
										<input type="text" size="5" name="total_masuk" id="total_masuk" class="angka form-control" value='0' readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
									
								</td>	
								<td>
									<div class="input-group mb-1">
										<input type="text" size="5" name="total_keluar" id="total_keluar" class="angka form-control" value='0' readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
									
								</td>	
								<td>
									<div class="input-group mb-1">
										<input type="text" size="5" name="total_stok_akhir" id="total_stok_akhir" class="angka form-control" value='0' readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
									
								</td>	
							</tr>
						</tfoot>
					</table>						
				</div>
				
				
				<div class="card-body row"style="font-weight:bold">
					<div class="col-md-4">
						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-undo" ></i> Kembali</b>
						</button>

						<span id="btn-simpan"></span>

					</div>
					
					<div class="col-md-6"></div>
					
				</div>

				<br>
				
			</div>
		</form>	
	</div>
	<!-- /.card -->
	</section>

	<section class="content">
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center">NO</th>
									<th class="text-center">NO STOK</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">JAM</th>
									<th class="text-center">KET</th>
									<th class="text-center">MASUK</th>
									<th class="text-center" style="padding : 12px 50px">KELUAR</th>
									<th class="text-center">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>

</div>


<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
	});

	function load_data() 
	{
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/stok_ppi')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			"responsive": false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function hitung_sal_awal() 
	{
		var tgll        = $("#tgl_stok").val()
		var jam_stok    = $("#jam_stok").val()
		var sts_input   = $("#sts_input").val()
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id : '', no : '', jenis :'load_sal_awal', tgll :tgll, jam_stok, sts_input },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data){
					// detail
					var no   = 1;
					$.each(data.detail, function(index, val) 
					{
						var masuk    = parseInt($('#masuk'+no).val().split('.').join(''))
						var keluar   = parseInt($('#keluar'+no).val().split('.').join(''))
						if(jam_stok=='')
						{
							sal_awal = val.sal_awal
						}else{
							sal_awal = val.sal_awal - masuk + keluar
						}
						$("#stok_awal"+no).val(format_angka(sal_awal))
						hitung_stok()
						no ++;
					})
					swal.close();

				} else {

					swal({
						title               : "Cek Kembali",
						html                : "Gagal Load Data",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}


	var rowNum = 0;


	function cetak_inv_bb(id) 
	{		
		var id2         = id.substr(9,1);
		var id_stok_h   = $("#id_stok_h").val();
		var no_stok     = $("#no_stok").val();

		if(id_stok_h=='' || id_stok_h == null)
		{
			swal({
				title               : "Cek Kembali",
				html                : "SIMPAN INPUTAN TERLEBIH DAHULU",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		var no_po       = $("#no_po"+id2).val();
		var url         = "<?= base_url('Logistik/cetak_inv_bb'); ?>";

		window.open(url + '?no_po='+no_po+'&no_stok='+no_stok+'&id_stok_h='+id_stok_h, '_blank');
		  
	}

	function hitung_stok()
	{
		// OCC
		var stok_awal1         = parseInt($("#stok_awal1").val().split('.').join(''))
		var masuk1             = parseInt($("#masuk1").val().split('.').join(''))
		var keluar1            = parseInt($("#keluar1").val().split('.').join(''))
		stok_akhir1            = stok_awal1 + masuk1 - keluar1
		$("#stok_akhir1").val(format_angka(stok_akhir1))
		
		// mix
		var stok_awal2         = parseInt($("#stok_awal2").val().split('.').join(''))
		var masuk2             = parseInt($("#masuk2").val().split('.').join(''))
		var keluar2            = parseInt($("#keluar2").val().split('.').join(''))
		stok_akhir2            = stok_awal2 + masuk2 - keluar2
		$("#stok_akhir2").val(format_angka(stok_akhir2))

		// plumpung
		var stok_awal3    = parseInt($("#stok_awal3").val().split('.').join(''))
		var masuk3        = parseInt($("#masuk3").val().split('.').join(''))
		var keluar3       = parseInt($("#keluar3").val().split('.').join(''))
		stok_akhir3       = stok_awal3 + masuk3 - keluar3
		$("#stok_akhir3").val(format_angka(stok_akhir3))

		// laminating
		var stok_awal4  = parseInt($("#stok_awal4").val().split('.').join(''))
		var masuk4      = parseInt($("#masuk4").val().split('.').join(''))
		var keluar4     = parseInt($("#keluar4").val().split('.').join(''))
		stok_akhir4     = stok_awal4 + masuk4 - keluar4
		$("#stok_akhir4").val(format_angka(stok_akhir4))

		// sludge
		var stok_awal5      = parseInt($("#stok_awal5").val().split('.').join(''))
		var masuk5          = parseInt($("#masuk5").val().split('.').join(''))
		var keluar5         = parseInt($("#keluar5").val().split('.').join(''))
		stok_akhir5         = stok_awal5 + masuk5 - keluar5
		$("#stok_akhir5").val(format_angka(stok_akhir5))

		// broke_lam
		var stok_awal6   = parseInt($("#stok_awal6").val().split('.').join(''))
		var masuk6       = parseInt($("#masuk6").val().split('.').join(''))
		var keluar6      = parseInt($("#keluar6").val().split('.').join(''))
		stok_akhir6      = stok_awal6 + masuk6 - keluar6
		$("#stok_akhir6").val(format_angka(stok_akhir6))

		// broke_corr
		var stok_awal7  = parseInt($("#stok_awal7").val().split('.').join(''))
		var masuk7      = parseInt($("#masuk7").val().split('.').join(''))
		var keluar7     = parseInt($("#keluar7").val().split('.').join(''))
		stok_akhir7     = stok_awal7 + masuk7 - keluar7
		$("#stok_akhir7").val(format_angka(stok_akhir7))

		// broke_pm
		var stok_awal8    = parseInt($("#stok_awal8").val().split('.').join(''))
		var masuk8        = parseInt($("#masuk8").val().split('.').join(''))
		var keluar8       = parseInt($("#keluar8").val().split('.').join(''))
		stok_akhir8       = stok_awal8 + masuk8 - keluar8
		$("#stok_akhir8").val(format_angka(stok_akhir8))
		

		// TOTAL
		total_stok_awal     = stok_awal1 + stok_awal2 + stok_awal3 + stok_awal4 + stok_awal5 + stok_awal6 + stok_awal7 + stok_awal8

		total_masuk         = masuk1 + masuk2 + masuk3 + masuk4 + masuk5 + masuk6 + masuk7 + masuk8 

		total_keluar        = keluar1 + keluar2 + keluar3 + keluar4 + keluar5 + keluar6 + keluar7 + keluar8 
		
		total_stok_akhir    = stok_akhir1 + stok_akhir2 + stok_akhir3 + stok_akhir4 + stok_akhir5 + stok_akhir6 + stok_akhir7 + stok_akhir8 

		$("#total_stok_awal").val(format_angka(total_stok_awal))
		$("#total_masuk").val(format_angka(total_masuk))
		$("#total_keluar").val(format_angka(total_keluar))
		$("#total_stok_akhir").val(format_angka(total_stok_akhir))
		
	}

	function cek_muat_ppi()
	{
		var cek = $('#muat_ppi').val()
		if(cek=='ADA')
		{	
			$("#tonase_ppi").prop("readonly", false);
		}else{
			$("#tonase_ppi").prop("readonly", true);
			$("#tonase_ppi").val(0);

		}
		hitung_total()
	}


	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	function edit_data(no_stok)
	{ 
		kosong()
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id : no_stok, no : no_stok, jenis :'edit_stok_ppi' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data){
					// header
					$("#id_stok_ppi").val(data.header.id_stok_ppi);
					$("#no_stok_ppi").val(data.header.no_stok_ppi);
					$("#tgl_stok").val(data.header.tgl_stok);
					$("#ket_header").val(data.header.ket_header);
					$("#jam_stok").val(data.header.jam_stok);

					// detail
					var no   = 1;
					$.each(data.detail, function(index, val) {
						
						// $("#stok_awal"+no).val(format_angka(val.tonase_masuk));
						$("#masuk"+no).val(format_angka(val.tonase_masuk));
						$("#keluar"+no).val(format_angka(val.tonase_keluar));
						$("#stok_akhir"+no).val(format_angka(val.tonase_keluar));
						
						no ++;
					})
					hitung_sal_awal()
					hitung_stok()


					swal.close();

				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Load Data",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}

	function kosong()
	{
		var tgl = '<?= date('Y-m-d') ?>'
		$("#no_stok_ppi").val("AUTO") 		
		$("#ket_header").val("-") 		
		$("#jam_stok").val("") 		
		$("#tgl_stok").val(tgl) 
			
		$("#total_stok_awal").val(0) 		
		$("#total_masuk").val(0) 		
		$("#total_keluar").val(0) 		
		$("#total_stok_akhir").val(0) 	

		for(loop = 1; loop <= 8; loop++)
		{
			$("#stok_awal"+loop).val(0) 
			$("#masuk"+loop).val(0) 
			$("#keluar"+loop).val(0) 
			$("#stok_akhir"+loop).val(0) 
		}
		swal.close()
	}

	function simpan() 
	{
		var tgl_stok    = $("#tgl_stok").val();		
		
		if ( tgl_stok=='' ) 
		{			
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/Insert_stok_ppi',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
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
			success: function(data) {
				if(data == true){
					// toastr.success('Berhasil Disimpan');
					// swal.close();								
					kosong();
					location.href = "<?= base_url()?>Logistik/stok_ppi";
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function add_data()
	{
		
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		kosong()
		hitung_sal_awal()
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(no_stok) 
	{
		swal({
			title: "HAPUS STOK",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_stok+ " </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url: '<?= base_url(); ?>Logistik/hapus',
				data: ({
					id         : no_stok,
					jenis      : 'trs_stok_ppi',
					field      : 'no_stok_ppi'
				}),
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
				success: function(data) {
					// toastr.success('Data Berhasil Di Hapus');
					swal.close();

					swal({
						title               : "Data",
						html                : "Data Berhasil Di Hapus",
						type                : "success",
						confirmButtonText   : "OK"
					});
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}
</script>
