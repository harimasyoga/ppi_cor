<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<!-- <h1><b>Data Master</b></h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	
	<!-- input konten -->
	<section class="content">
		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<form role="form" method="post" id="myForm">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-info card-outline">
							<div class="card-header" style="font-family:Cambria">
								<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
										<i class="fas fa-minus"></i></button>
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
								<div class="col-md-2">NO TIMBANGAN</div>
								<div class="col-md-3">
									<input type="hidden" id="id_timbangan" name="id_timbangan" value="">
									<input type="hidden" id="sts_input" name="sts_input" value="add">
									<input type="text" class="form-control" id="no_timbangan" name="no_timbangan" value="OTOMATIS" readonly>
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">PERMINTAAN</div>
								<div class="col-md-3">
									<input type="text" name="permintaan" id="permintaan" class="form-control" value="PPI" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>
							
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
								<div class="col-md-2">JENIS</div>
								<div class="col-md-3">
									<select id="jns" name="jns" class="form-control select2" style="width: 100%" >
										<option value="TERIMA">TERIMA</option>
										<option value="KIRIM">KIRIM</option>
										<option value="SUPLAI">SUPLAI</option>
										<!-- <option value="STOK">STOK PPI</option> -->
									</select>
								</div>
								<div class="col-md-1"></div>
		
								<div class="col-md-2">PENIMBANG</div>
								<div class="col-md-3">
									<select id="penimbang" name="penimbang" class="form-control select2">
										<option value="Feri S">Feri S</option>
										<option value="DWI J">DWI J</option>
									</select>
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
								<div class="col-md-2">INPUT</div>
								<div class="col-md-3">
									<input type="hidden" id="urut_t" name="urut_t" value="">
									<input type="hidden" id="tgl_t" name="tgl_t" value="">
									<select id="plh_input" name="plh_input" class="form-control select2" onchange="pilih_inp()">
										<option value="MANUAL">MANUAL</option>
										<option value="CORR">CORR</option>
									</select>
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">DENGAN PO</div>
								<div class="col-md-3">
									<select name="pilih_po" id="pilih_po" name="pilih_po"  class="form-control" onchange="cek_po()">
										<!-- <option value="YA">YA</option> -->
										<option value="TIDAK">TIDAK</option>
									</select>
								
								</div>		
													
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold;display:none" id="pil_kiriman" >		
								<div class="col-md-2" >PILIH KIRIMAN</div>
								<div class="col-md-9">
									<select id="pilih_kiriman" name="pilih_kiriman" class="form-control select2" onchange="selectPilihKiriman()" >
									</select>
								</div>		
																	
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
								<div class="col-md-2">MASUK</div>
								<div class="col-md-3">
									<input type="datetime-local" name="masuk" id="masuk" class="form-control" >
								</div>	
								<div class="col-md-1"></div>
								
								<div class="col-md-2">CATATAN</div>
								<div class="col-md-3">
									<input type="text" name="cttn" id="cttn" class="form-control" oninput="this.value = this.value.toUpperCase() ">
								</div>
								
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
								<div class="col-md-2">KELUAR</div>
								<div class="col-md-3">
									<input type="datetime-local" name="keluar" id="keluar" class="form-control" >
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">SUPPLIER</div>
								<div class="col-md-3">
									<input type="text" name="supplier" id="supplier" class="form-control" value="PT. PRIMA PAPER INDONESIA" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">										
								<div class="col-md-2">BERAT KOTOR</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="b_kotor" id="b_kotor" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">ALAMAT</div>
								<div class="col-md-3">
									<input type="text" name="alamat" id="alamat" class="form-control" value="Timang Kulon, Wonokerto, Wonogiri" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">	
								<div class="col-md-2">BERAT TRUK</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="berat_truk" id="berat_truk" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>								
								</div>
									
								<div class="col-md-1"></div>

								<div class="col-md-2">NO POLISI</div>
								<div class="col-md-3">
									<input type="text" name="nopol" id="nopol" class="form-control" oninput="this.value = this.value.toUpperCase() ">
								</div>	
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">										
								<div class="col-md-2">BERAT BERSIH</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="berat_bersih" id="berat_bersih" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)">
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>
									
								</div>	
								<div class="col-md-1"></div>
								
								<div class="col-md-2">BARANG</div>
								<div class="col-md-3">
									<input type="text" name="barang" id="barang" class="form-control" value="OCC LOKAL" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">	
								<div class="col-md-2">POTONGAN</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="pot" id="pot" class="angka form-control" onkeyup="ubah_angka(this.value,this.id)">
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>
								</div>				
								
								<div class="col-md-1"></div>

								<div class="col-md-2">SOPIR</div>
								<div class="col-md-3">
									<input type="text" name="sopir" id="sopir" class="form-control" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<br>
							<hr>
							<!-- <div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-5">List PO</div>
								
								<div class="col-md-6"></div>					
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-11"	style="overflow:auto;white-space:nowrap;" width="100%">										
									<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table-produk" width="100%">
										<thead class="color-tabel">
											<th style="text-align: center" >DELETE</th>
											<th style="text-align: center" >NO PO / ITEM</th>
											<th style="text-align: center" >KEBUTUHAN</th>
											<th style="text-align: center" >BAHAN</th>
										</thead>
										<tbody>
											<tr id="itemRow0">
												<td id="detail-hapus-0">
													<div class="text-center">
														<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)"><i class="far fa-trash-alt" style="color:#fff"></i> </a>
													</div>
												</td>
												<td>
													<select class="form-control select2 narrow wrap wrap" name="item_po[0]" id="item_po0" style="width: 100%;" onchange="set_qty(this.value,0)">
														<option value="">-- Pilih --</option>
													</select>
												</td>
												<td>
													<input type="text" name="qty_po[0]" id="qty_po0" class="angka form-control" value='0' onkeyup="ubah_angka(this.value,this.id)" readonly>
												</td>
												<td>
													<input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0' onkeyup="ubah_angka(this.value,this.id),hitung_bb(),cek_bb(this.value,0)">	
												</td>
											</tr>
										</tbody>
									</table>
									<div id="add_button" >
										<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
									</div>
									<input type="hidden" name="bucket" id="bucket" value="0">
								</div>
						
							</div> -->
							
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-5">
									<!-- <a href="<?= base_url('Logistik/Timbangan')?>" class="btn btn-danger"><i class="fa fa-undo"></i> <b>Kembali</b></a> -->
									<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
										<i class="fa fa-undo" ></i> Kembali</b>
									</button>
									
									<!-- <button type="button" onclick="simpanTimbangan()" class="btn-tambah-produk btn  btn-primary"><b>
										<i class="fa fa-save" ></i> Simpan</b>
									</button> -->
									<span id="btn-simpan"></span>
								</div>
								
								<div class="col-md-6"></div>					
							</div>

							<br>
						</div>
					</div>
				</div>
			</form>	
		</div>
	</section>
	<!-- input konten -->

	<!-- Main content -->
	<section class="content">
		<div class="card shadow mb-3">
			<div class="row-list">
			<!-- Default box -->
			<div class="card-header" style="font-family:Cambria">
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','User','Pembayaran'])){ ?>
					<!-- <a href="<?php echo base_url('Logistik/Timbangan/Add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a> -->

					<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
					<br><br>
				<?php } ?>
				<div style="overflow:auto;white-space:nowrap">
					<table id="datatable" class="table table-bordered table-striped" width="100%">
						<thead class="color-tabel">
							<tr>
								<th style="text-align: center; width:5%">NO.</th>
								<th style="text-align: center; width:10%">NO TIMBANGAN</th>
								<th style="text-align: center; width:10%">REQ</th>
								<th style="text-align: center; width:15%">TGL MASUK</th>
								<th style="text-align: center; width:20%">SUPPLIER</th>
								<th style="text-align: center; width:10%">JENIS</th>
								<th style="text-align: center; width:20%">CATATAN</th>
								<th style="text-align: center; width:10%">BERAT BERSIH</th>
								<th style="text-align: center; width:10%">AKSI</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.card -->
			</div>			
		</div>
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
	opsiInput = 'insert'
	$(document).ready(function() {
		$(".select2").select2()
		load_data()
	});

	function lampiranTimbangan(id_timbangan){
		console.log(id_timbangan)
		$.ajax({
			url: '<?php echo base_url('Logistik/lampiranTimbangan')?>',
			type: "POST",
			data: ({ id_timbangan }),
			success: function(res){
				console.log(data)
			}
		})
	}

	function close_modal(){
		$('#modalLampiran').modal('hide');
	}

	function load_data() 
	{
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Logistik/load_data/Timbangan',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	function cek_po()
	{
		var pilih_po = $("#pilih_po").val();
		if(pilih_po=='YA'){
			$("#berat_bersih").prop("readonly", true)		
			$("#qty0").prop("readonly", false)		
			$('#add_button').show("1000")
			// customer();

		}else{
			$("#berat_bersih").prop("readonly", false)			
			$("#qty0").prop("readonly", true)		
			$("#berat_bersih").val(0)			
			$('#add_button').hide("1000")
			// clearRow();
			option = `<option value="">-- Pilih --</option>`;	
			$('#item_po0').html(option);
			// customer();
		}
		
	}

	function kosong() 
	{
		$("#permintaan").val('PPI')
		$("#supplier").val('PT. PRIMA PAPER INDONESIA')
		$("#masuk").val('')
		$("#alamat").val('Timang Kulon, Wonokerto, Wonogiri')
		$("#keluar").val('')
		$("#nopol").val('')
		$("#b_kotor").val('')
		$("#barang").val('OCC LOKAL')
		$("#berat_truk").val('')
		$("#sopir").val('')
		$("#berat_bersih").val('')
		$("#cttn").val('')
		$("#pot").val('')
		$("#nm_penimbang").html(`<option value="">PILIH</option><option value="Feri S">Feri S</option><option value="DWI J">DWI J</option>`).prop("readonly", false)
		// customer();
	}
	
	function simpanTimbangan() 
	{
		var jns             = $("#jns").val()
		var penimbang       = $("#penimbang").val()
		var permintaan      = $("#permintaan").val()
		var supplier        = $("#supplier").val()
		var masuk           = $("#masuk").val()
		var alamat          = $("#alamat").val()
		var keluar          = $("#keluar").val()
		var nopol           = $("#nopol").val()
		var b_kotor         = $("#b_kotor").val()
		var barang          = $("#barang").val()
		var berat_truk      = $("#berat_truk").val()
		var sopir           = $("#sopir").val()
		var berat_bersih    = $("#berat_bersih").val()
		var cttn            = $("#cttn").val()
		// var cust            = $("#cust").val()
		var pot             = $("#pot").val()
		var plh_input       = $("#plh_input").val()

		if (jns == '' || penimbang == '' || permintaan == '' || supplier == '' || masuk == '' || alamat == '' || keluar == '' || nopol == '' || b_kotor == '' || barang == '' || berat_truk == '' || sopir == '' || berat_bersih == '' || cttn == '' || pot == '' ) 
		{
			// toastr.info('Harap Lengkapi Form');
			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			// close_loading();
			return;
		}
		
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanTimbangan2')?>',
			type: "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
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
			success: function(data) 
			{
				if(data){
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success"
						// confirmButtonText   : "OK"
					});
					location.href = "<?= base_url()?>Logistik/Timbangan";

				} else {
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				// reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		})
	}

	function pilih_inp() 
	{
		var plh_input = $("#plh_input").val()

		if(plh_input == 'CORR'){
			loadSJTimbangan(plh_input)
			$('#pil_kiriman').show("1000");
		}else if(plh_input == 'MANUAL'){
			$("#nopol").prop("readonly", false)
			$('#pil_kiriman').hide("1000");
		}else{
			kosong()
		}
	}

	function loadSJTimbangan(plh_input) 
	{
		option = "";
		$.ajax({
			url        : '<?php echo base_url('Logistik/load_sj_kirim')?>',
			type       : "POST",
			dataType   : 'json',
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
			success: function(data){

				if(data.message == "Success")
				{						
					option = "<option>--- Pilih ---</option>";
					$.each(data.data, function(index, val) 
					{
						option += `<option value="${val.id_perusahaan}" 
						no_kendaraan="${val.no_kendaraan}" 
						urut="${val.rk_urut}" 
						tgl="${val.rk_tgl}" 
						catatan="${val.nm_pelanggan}">
						[ "${val.rk_tgl}" ] - [ "${val.no_kendaraan}" ] - [ "${val.nm_pelanggan}" ]
						</option>`;
					});

					$('#pilih_kiriman').html(option);
					swal.close();
				}else{	
					option += "<option value=''>Data Kosong</option>";
					$('#pilih_kiriman').html(option);		
					swal.close();
				}


				// $("#pilih_kiriman").html(res)
				// $('.select2').select2();
				// $("#supplier").val("PT. PRIMA PAPER INDONESIA").prop("disabled", true)
				// $("#alamat").val("Timang Kulon, Wonokerto, Wonogiri").prop("disabled", true)
				// $("#nm_barang").val("KARTON BOX").prop("disabled", true)
				// $("#permintaan").val('KIRIMAN').prop('disabled', true)
				// $("#keterangan").val('KIRIM').prop('disabled', true)
				swal.close()
			}
		})
	}

	function selectPilihKiriman()
	{
		var no_kendaraan    = $('#pilih_kiriman option:selected').attr('no_kendaraan')
		var urut            = $('#pilih_kiriman option:selected').attr('urut')
		var tgl             = $('#pilih_kiriman option:selected').attr('tgl')
		var catatan         = $('#pilih_kiriman option:selected').attr('catatan');
		(no_kendaraan == undefined) ? prop = false : prop = true;
		$("#nopol").val(no_kendaraan).prop("readonly", prop)
		$("#urut").val(catatan)
		$("#tgl").val(catatan)
		$("#catatan").val(catatan)
	}

	function editTimbangan(id_timb, no_timb,cek) 
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		if(cek=='editt'){

			$("#btn-simpan").html(`<button type="button" onclick="simpanTimbangan()" class="btn-tambah-produk btn  btn-primary"><b> <i class="fa fa-save" ></i> UPDATE</b> </button>`)
			lock(cek);
		}else{
			$("#btn-simpan").html(``)
			lock(cek);

		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_timbangan_1',
			type       : "POST",
			data       : { id_timb: id_timb, no_timb: no_timb },
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
				// console.log(data)
				
				if(data){
					// header
					$("#jns").val(data.header.keterangan).trigger('change');
					$("#penimbang").val(data.header.nm_penimbang).trigger('change');
					$("#plh_input").val(data.header.input_t).trigger('change');
					$("#pilih_po").val(data.header.pilih_po).trigger('change');
					// $("#pilih_kiriman").val(data.header.pilih_kiriman).trigger('change');
					// $("#cust").val(data.header.id_pelanggan).trigger('change');
					// customer('edit',data.header.id_pelanggan)

					$("#id_timbangan").val(data.header.id_timbangan);
					$("#no_timbangan").val(data.header.no_timbangan);
					$("#permintaan").val(data.header.permintaan);					
					$("#supplier").val(data.header.suplier);					
					$("#masuk").val(data.header.date_masuk);					
					$("#alamat").val(data.header.alamat);					
					$("#keluar").val(data.header.date_keluar);					
					$("#nopol").val(data.header.no_polisi);					
					$("#b_kotor").val(format_angka(data.header.berat_kotor));					
					$("#barang").val(data.header.nm_barang);					
					$("#berat_truk").val(format_angka(data.header.berat_truk));					
					$("#sopir").val(data.header.nm_sopir);					
					$("#berat_bersih").val(format_angka(data.header.berat_bersih));					
					$("#cttn").val(data.header.catatan);					
					$("#pot").val(format_angka(data.header.potongan));					
					$("#urut_t").val(data.header.urut_t);					
					$("#tgl_t").val(data.header.tgl_t);					
					// $("#tgl_sj").prop("readonly", true);	
					swal.close();

				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
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

	function lock(cek)
	{
		if(cek=='editt')
		{
			$("#no_timbangan").prop("disabled", false);
			$("#permintaan").prop("disabled", false);
			$("#supplier").prop("disabled", false);
			$("#masuk").prop("disabled", false);					
			$("#alamat").prop("disabled", false);					
			$("#keluar").prop("disabled", false);					
			$("#nopol").prop("disabled", false);					
			$("#b_kotor").prop("disabled", false);					
			$("#barang").prop("disabled", false);					
			$("#berat_truk").prop("disabled", false);					
			$("#sopir").prop("disabled", false);					
			$("#berat_bersih").prop("disabled", false);					
			$("#cttn").prop("disabled", false);					
			$("#pot").prop("disabled", false);					
			$("#urut_t").prop("disabled", false);					
			$("#tgl_t").prop("disabled", false);
		}else{
			$("#no_timbangan").prop("disabled", true);
			$("#permintaan").prop("disabled", true);
			$("#supplier").prop("disabled", true);
			$("#masuk").prop("disabled", true);
			$("#alamat").prop("disabled", true);
			$("#keluar").prop("disabled", true);					
			$("#nopol").prop("disabled", true);					
			$("#b_kotor").prop("disabled", true);					
			$("#barang").prop("disabled", true);					
			$("#berat_truk").prop("disabled", true);					
			$("#sopir").prop("disabled", true);					
			$("#berat_bersih").prop("disabled", true);					
			$("#cttn").prop("disabled", true);					
			$("#pot").prop("disabled", true);					
			$("#urut_t").prop("disabled", true);					
			$("#tgl_t").prop("disabled", true);	
		}

	}
	
	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpanTimbangan()" class="btn-tambah-produk btn  btn-primary"><b> <i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}
	
	function deleteTimbangan(id_timbangan,no_timb) 
	{
		swal({
			title : "TIMBANGAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_timb+ " </strong> ",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>Hapus</b>',
			cancelButtonText : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?php echo base_url('Logistik/deleteTimbangan') ?>',
				data: ({ id_timbangan }),
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
				success: function(res) {
					data = JSON.parse(res)
					if(data.data){
						reloadTable()
						toastr.success(`<b>BERHASIL HAPUS!</b>`)
						swal.close()
					}
				}
			});
		});
	}
</script>
