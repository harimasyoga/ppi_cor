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
			<form role="form" method="post" id="myForm">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-info card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">TIMBANGAN</h3>
							</div>
							<!-- <div id="card-body-cor" style="overflow:auto;white-space:nowrap"> -->
							
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
								<div class="col-md-2">JENIS</div>
								<div class="col-md-3">
									<select id="jns" name="jns" class="form-control select2" style="width: 100%" >
										<option value="TERIMA">TERIMA</option>
										<option value="KIRIM">KIRIM</option>
										<option value="SUPLAI">SUPLAI</option>
										<option value="STOK">STOK PPI</option>
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
									<input type="hidden" id="id_timbangan" value="">
									<input type="hidden" id="urut_t" value="">
									<input type="hidden" id="tgl_t" value="">
									<select id="plh_input" name="plh_input" class="form-control select2" onchange="pilih_inp()">
										<option value="MANUAL">MANUAL</option>
										<option value="CORR">CORR</option>
									</select>
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">DENGAN PO</div>
								<div class="col-md-3">
									<select name="pilih_po" id="pilih_po" class="form-control" onchange="cek_po()">
										<option value="YA">YA</option>
										<option value="TIDAK">TIDAK</option>
									</select>
								
								</div>		
													
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold;display:none" id="pil_kiriman" >		
								<div class="col-md-2" >PILIH KIRIMAN</div>
								<div class="col-md-9">
									<select id="pilih_kiriman" class="form-control select2" onchange="selectPilihKiriman()" >
									</select>
								</div>		
																	
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
								<div class="col-md-2">PERMINTAAN</div>
								<div class="col-md-3">
									<input type="text" name="permintaan" id="permintaan" class="form-control" value="PPI" oninput="this.value = this.value.toUpperCase() ">
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">SUPPLIER</div>
								<div class="col-md-3">
									<input type="text" name="supplier" id="supplier" class="form-control" value="PT. PRIMA PAPER INDONESIA" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-2">MASUK</div>
								<div class="col-md-3">
									<input type="datetime-local" name="masuk" id="masuk" class="form-control" >
								</div>	
								<div class="col-md-1"></div>

								<div class="col-md-2">ALAMAT</div>
								<div class="col-md-3">
									<input type="text" name="alamat" id="alamat" class="form-control" value="Timang Kulon, Wonokerto, Wonogiri" oninput="this.value = this.value.toUpperCase() ">
								</div>

								
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
								<div class="col-md-2">KELUAR</div>
								<div class="col-md-3">
									<input type="datetime-local" name="keluar" id="keluar" class="form-control" >
								</div>
								<div class="col-md-1"></div>

								<div class="col-md-2">NO POLISI</div>
								<div class="col-md-3">
									<input type="text" name="nopol" id="nopol" class="form-control" oninput="this.value = this.value.toUpperCase() ">
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

								<div class="col-md-2">BARANG</div>
								<div class="col-md-3">
									<input type="text" name="barang" id="barang" class="form-control" value="KARTON BOX" oninput="this.value = this.value.toUpperCase() ">
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
								<div class="col-md-2">SOPIR</div>
								<div class="col-md-3">
									<input type="text" name="sopir" id="sopir" class="form-control" oninput="this.value = this.value.toUpperCase() ">
								</div>

								
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">	
								<div class="col-md-2">BERAT BERSIH</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="berat_bersih" id="berat_bersih" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)" readonly>
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>
									
								</div>					
								
								<div class="col-md-1"></div>

								<div class="col-md-2">CATATAN</div>
								<div class="col-md-3">
									<input type="text" name="cttn" id="cttn" class="form-control" oninput="this.value = this.value.toUpperCase() ">
								</div>
							</div>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-2">CUSTOMER</div>
								<div class="col-md-3">
									<select class="form-control select2 narrow wrap wrap" name="cust" id="cust" style="width: 100%;" onchange="set_po('new',this.value,0)">
									</select>
								</div>			
								
								<div class="col-md-1"></div>
								<div class="col-md-2">POTONGAN</div>
								<div class="col-md-3">
									<div class="input-group mb-3">
										<input type="text" name="pot" id="pot" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_bb()">
										<div class="input-group-append">
											<span class="input-group-text">Kg</span>
										</div>
									</div>
								</div>
								
							</div>

							<br>
							<hr>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
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
						
							</div>
							
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
								<div class="col-md-5">
									<a href="<?= base_url('Logistik/Timbangan')?>" class="btn btn-danger"><i class="fa fa-undo"></i> <b>Kembali</b></a>
									
									<button type="button" onclick="simpanTimbangan()" class="btn-tambah-produk btn  btn-primary"><b>
										<i class="fa fa-save" ></i> Simpan</b>
									</button>
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
</div>

<script type="text/javascript">

	$(document).ready(function ()
	{
		
		$('.select2').select2({
			dropdownAutoWidth: true
		})
		customer();
	})

	function customer() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_cs",
			// data       : { idp: pelanggan, kd: '' },
			dataType   : 'json',
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
			success:function(data){			
				if(data.message == "Success"){					
					option = `<option value="">-- Pilih --</option>`;	

					$.each(data.data, function(index, val) {
					option += "<option value='"+val.id_pelanggan+"'>"+val.nm_pelanggan+"</option>";
					});

					$('#cust').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#cust').html(option);					
					swal.close();
				}
			}
		});
		
	}

	function set_po(cek,pelanggan,id) 
	{
		if(cek=='new'){
			clearRow();
		}

		$("#item_po"+id).val("").prop("readonly", false);
		if (pelanggan!='')
		{
			option = "";
			$.ajax({
				type       : 'POST',
				url        : "<?= base_url(); ?>Logistik/load_po",
				data       : { idp: pelanggan },
				dataType   : 'json',
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
				success:function(data){			
					if(data.message == "Success"){						
						option = "<option>-- Pilih --</option>";
						$.each(data.data, function(index, val) {
						option += `<option value='${val.id}' detail=${val.bhn_bk}>
						[ ${val.kode_po} ] [${val.nm_produk} ] [${val.bhn_bk}]</option>`;
						});
	
						$('#item_po'+id).html(option);
						swal.close();
					}else{	
						option += "<option value=''></option>";
						$('#item_po'+id).html(option);			
						swal.close();
					}
				}
			});
		}
		
	}

	var rowNum = 0;

	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}

		var qty   = $('#qty' + b).val();
		var item  = $('#item_po' + b).val();
		var idp   = $('#cust').val();
		
		set_po('addrow',idp,rowNum+1);
			
		if (qty != '0' && qty != '' && item != '') 
		{
			$('#removeRow').show();
			rowNum++;
			
				var x = rowNum + 1;
				$('#table-produk').append(
					`<tr id="itemRow${ rowNum }">
						<td id="detail-hapus-${ rowNum }">
							<div class="text-center">
							<a class="btn btn-danger"  id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })"><i class="far fa-trash-alt" style="color:#fff"></i> </a>
							</div>
						</td>
						<td>
							<select class="form-control select2 narrow wrap wrap" style="width: 100%;" name="item_po[${ rowNum }]" id="item_po${ rowNum }"  onchange="set_qty(this.value,${ rowNum })">
							</select>
						</td>
						<td>
							<input type="text" name="qty_po[0${ rowNum }]" id="qty_po${ rowNum }" class="angka form-control" value='0' onkeyup="ubah_angka(this.value,this.id)" readonly>
						</td>
						<td>
							<input type="text" name="qty[${ rowNum }]" id="qty${ rowNum }"  class="angka form-control" value="0" onkeyup="ubah_angka(this.value,this.id),hitung_bb(),cek_bb(this.value,${rowNum})" 
							>
						</td>

					</tr>				
					`);
				$('.select2').select2({
					placeholder: '--- Pilih ---',
					dropdownAutoWidth: true
				});
				$('#bucket').val(rowNum);
				$('#qty' + rowNum).focus();
		}else{
			swal({
				title               : "Cek Kembali",
				html                : "Isi form diatas terlebih dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
	}
	
	function removeRow(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		} else {
			// toastr.error('Baris pertama tidak bisa dihapus');
			// return;

			swal({
					title               : "Cek Kembali",
					html                : "Baris pertama tidak bisa dihapus",
					type                : "error",
					confirmButtonText   : "OK"
				});
			return;
		}
		$('#bucket').val(rowNum);
	}

	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}

		$('#removeRow').hide();
		$('#bucket').val(rowNum);
		$('#item_po0').val('').trigger('change');
		$('#qty0').val('');

	}

	function set_qty(val,id)
	{
		bhn_bk = $(`#item_po${id} option:selected`).attr('detail');
		$('#qty_po'+id).val(format_angka(parseFloat(bhn_bk)));

	}
	
	function hitung_bb()
	{
		var pilih_po = $('#pilih_po').val()
		if(pilih_po=='YA'){
			var total_bersih    = 0
			var pot             = $("#pot").val().split('.').join('')

			for (var loop = 0; loop <= rowNum; loop++) 
			{
				var jumqty   = $('#qty' + loop).val().split('.').join('');
				total_bersih += parseInt(jumqty)
			}
			tb = total_bersih - pot
			$('#berat_bersih').val(format_angka(parseFloat(tb)));
		}
		

	}
	
	
	function cek_bb(val,id)
	{
		var qty_po    = parseInt($("#qty_po" + id).val().split('.').join(''))
		var jumqty    = parseInt($('#qty' + id).val().split('.').join(''))

		if(jumqty > qty_po)
		{
			swal({
				title               : "Cek Kembali",
				html                : "Qty Bahan Tidak boleh lebih dari kebutuhan",
				type                : "info",
				confirmButtonText   : "OK"
			});
			$('#qty' + id).val(0)
		}

	}

	function cek_po()
	{
		var pilih_po = $("#pilih_po").val();
		if(pilih_po=='YA'){
			$("#berat_bersih").prop("readonly", true)		
			$("#qty0").prop("readonly", false)		
			$('#add_button').show("1000")
			customer();

		}else{
			$("#berat_bersih").prop("readonly", false)			
			$("#qty0").prop("readonly", true)		
			$("#berat_bersih").val(0)			
			$('#add_button').hide("1000")
			clearRow();
			option = `<option value="">-- Pilih --</option>`;	
			$('#item_po0').html(option);
			customer();
		}
		
	}
	
	function kosong() 
	{
		$("#jns").val('')
		$("#penimbang").val('')
		$("#permintaan").val('')
		$("#supplier").val('')
		$("#masuk").val('')
		$("#alamat").val('')
		$("#keluar").val('')
		$("#nopol").val('')
		$("#b_kotor").val('')
		$("#barang").val('')
		$("#berat_truk").val('')
		$("#sopir").val('')
		$("#berat_bersih").val('')
		$("#cttn").val('')
		$("#cust").val('')
		$("#pot").val('')
		$("#plh_input").val('')
		$("#nm_penimbang").html(`<option value="">PILIH</option><option value="Feri S">Feri S</option><option value="DWI J">DWI J</option>`).prop("readonly", false)
		customer();
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
		var cust            = $("#cust").val()
		var pot             = $("#pot").val()
		var plh_input       = $("#plh_input").val()

		if (jns == '' || penimbang == '' || permintaan == '' || supplier == '' || masuk == '' || alamat == '' || keluar == '' || nopol == '' || b_kotor == '' || barang == '' || berat_truk == '' || sopir == '' || berat_bersih == '' || cttn == '' || cust == '' || pot == '' ) 
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

</script>
