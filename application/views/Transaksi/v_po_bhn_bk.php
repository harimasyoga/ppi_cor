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
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi','User'])){ ?>
						<div class="col-md-12" style="">			
							<div class="card-body row" style="padding-left:0px;padding-right:0px;padding-bottom:1px;font-weight:bold">
								<div class="col-md-2">
									<button type="button" class="btn btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
								<div class="col-md-3">
									<button type="button" class="btn btn-danger" onclick="rekap_penjualan()"><i class="fa fa-file-invoice"></i> <b>REKAP PENJUALAN</b></button>
								</div>
								<div class="col-md-3"></div>
								<div class="col-md-4">
									<select id="list_hub" class="form-control select2" onchange="load_data()">
									<?php
											$query = $this->db->query("SELECT*FROM m_hub order by id_hub");
											$html ='';
											$html .='<option value="">SEMUA</option>';
											foreach($query->result() as $r){
												$html .='<option value="'.$r->id_hub.'">'.$r->nm_hub.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
							</div>
						</div>
						
					<?php } ?>
					<br>
					
					<!-- <div style="overflow:auto;white-space:nowrap"> -->
						<table id="datatable_list" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center title-white">NO </th>
									<th class="text-center title-white">NO PO</th>
									<th class="text-center title-white">TGL PO</th>
									<th class="text-center title-white">HUB</th>
									<th class="text-center title-white">TONASE PO</th>
									<th class="text-center title-white">TERKIRIM</th>
									<th class="text-center title-white">SISA</th>
									<th class="text-center title-white">HARGA</th>
									<th class="text-center title-white">TOTAL</th>
									<th class="text-center title-white">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					<!-- </div> -->
				</div>
			</div>			
		</div>
	</section>

	
	
	<section class="content">
		<!-- Default box -->
		<div class="card shadow row_rekap_jual" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT PO BAHAN BAKU</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="col-md-12">
							
				<br>
					
				<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
					
					<div class="col-md-2">JENIS</div>
					<div class="col-md-3">
						<select name="jns" id="jns" class="form-control">
							<option value="BOX">BOX</option>
							<option value="LAMINASI">LAMINASI</option>
						</select>
					</div>
					<div class="col-md-6"></div>
		
				</div>
										
				<div class="card-body row" style="padding-bottom:1px;font-weight:bold">

					<div class="col-md-2">BULAN</div>
					<div class="col-md-3">
						<input type="month" class="form-control" name="bulan" id="bulan" value ="<?= date('m-d') ?>" >
					</div>
					<div class="col-md-6"></div>
				</div>
				
			
				<div class="card-body row"style="font-weight:bold">
					<div class="col-md-4">
						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-secondary"><b>
							<i class="fa fa-arrow-left" ></i> Kembali</b>
						</button>

						<button onclick="Cetak(0)"  class="btn btn-primary">
							<i class="fa fa-print"></i> <b>LAYAR</b></button>
							

						<button type="button" class="btn btn-danger" id="btn-print" onclick="Cetak(1)"><i class="fas fa-print"></i> <b>PDF</b></button>


					</div>
					
					<div class="col-md-6"></div>
					
				</div>

				<br>
				
			</div>
		</div>
		<!-- /.card -->
	</section>
	
	<section class="content">
		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT PO BAHAN BAKU</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-2">NO PO BAHAN</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="no_po_old" id="no_po_old">
							<input type="hidden" name="id_po_bhn" id="id_po_bhn">
							<input type="text" class="angka form-control" name="no_po" id="no_po" value="AUTO" readonly>

						</div>
						<div class="col-md-1"></div>
			
						<div class="col-md-2">TONASE</div>
						<div class="col-md-3">
							<div class="input-group">
								<input type="text" class="form-control" name="ton" id="ton" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_total()">
								<div class="input-group-append">
									<span class="input-group-text">Kg</span>
								</div>
							</div>
						</div>
					</div>
											
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">

						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_po" id="tgl_po" value ="<?= date('Y-m-d') ?>" >
						</div>

						<div class="col-md-1"></div>

						<div class="col-md-2">HARGA / Kg</div>
						<div class="col-md-3">
							<div class="input-group">								
								<div class="input-group-append">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="text" class="form-control" name="harga" id="harga" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_total()">
							</div>
						</div>

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
										
						<div class="col-md-2">HUB</div>
						<div class="col-md-3">
							<select class="form-control select2" onchange="load_aka()" name="hub" id="hub" style="width: 100%;">
							</select>
							<input type="hidden" name="aka" id="aka">
						</div>

						<div class="col-md-1"></div>
									
						<div class="col-md-2">TOTAL</div>
						<div class="col-md-3">
							<div class="input-group">								
								<div class="input-group-append">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="text" class="form-control" name="total_po" id="total_po" value ="0" readonly>
							</div>
						</div>
						

					</div>
					
					<br>
					<!-- detail PO-->
					<hr>
					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-4" style="padding-right:0">List Item PO</div>
						<div class="col-md-8">&nbsp;
						</div>
					</div>

					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_po" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 70px" >PO PENJUALAN</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td id="detail-hapus-0">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)">
												<i class="far fa-trash-alt" style="color:#fff"></i> 
											</a>
										</div>
									</td>
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<select name="po_jual[0]"  id="po_jual0" class="form-control select2" style="width: 100%">
											</select>	
										</div>
									</td>			
								</tr>
							</tbody>
						</table>
						<div id="add_button" >
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
						<br>
					</div>

					<!-- end detail PO-->

				
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
</div>

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
		po_juall(0)
		$('.select2').select2();
	});

	var rowNum = 0;

	function load_hub() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_hub",
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
					option += `<option value="${val.id_hub}" data-aka="${val.aka}" >${val.nm_hub}</option>`;

					});

					$('#hub').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";			
					$('#hub').html(option);					
					swal.close();
				}
			}
		});
	}

	function po_juall(rowNum) 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Transaksi/load_po_jual",
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
					option += `<option value="${val.kode}" >${val.kode}</option>`;

					});

					$('#po_jual'+rowNum).html(option);
					$('.select2').select2({
						containerCssClass: "wrap",
						placeholder: '--- Pilih ---',
						dropdownAutoWidth: true
					});
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#po_jual'+rowNum).html(option);					
					swal.close();
				}
			}
		});
	}

	function po_juall2(rowNum,kode_po) 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Transaksi/load_po_jual",
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
					if(val.kode==kode_po)
					{
						option += `<option value="${val.kode}" selected >${val.kode}</option>`;
					}else{
						option += `<option value="${val.kode}" >${val.kode}</option>`;
					}

					});

					$('#po_jual'+rowNum).html(option);
					$('.select2').select2({
						containerCssClass: "wrap",
						placeholder: '--- Pilih ---',
						dropdownAutoWidth: true
					});
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#po_jual'+rowNum).html(option);					
					swal.close();
				}
			}
		});
	}
	

	function load_aka()
	{
		var aka = $('#hub option:selected').attr('data-aka');
		$("#aka").val(aka)
	}

	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var po_jual   = $('#po_jual' + b).val();
			
		if (po_jual != '') 
		{			
			rowNum++;
			var x = rowNum + 1;
				$('#table_list_po').append(
					`<tr id="itemRow${ rowNum }">
						<td id="detail-hapus-${ rowNum }">
							<div class="text-center">
								<a class="btn btn-danger" id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })">
									<i class="far fa-trash-alt" style="color:#fff"></i> 
								</a>
							</div>
						</td>
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<select name="po_jual[${ rowNum }]"  id="po_jual${ rowNum }" class="form-control select2" style="width: 100%">
								</select>	
							</div>
						</td>	
					</tr>
					`);
				po_juall(rowNum);
				$('#bucket').val(rowNum);
				$('#po_jual' + rowNum).focus();
				
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

	function hitung_total()
	{
		var ton   = $("#ton").val().split('.').join('')
		var harga = $("#harga").val().split('.').join('')

		var total = ton*harga		
		$("#total_po").val(format_angka(total))
		
	}

	function reloadTable() 
	{
		table = $('#datatable_list').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		var list_hub    = $("#list_hub").val()
		let table       = $('#datatable_list').DataTable();
		table.destroy();
		tabel = $('#datatable_list').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Transaksi/load_data/po_bahan')?>',
				"type": "POST", 
				"data"  : { id_hub:list_hub },
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			"responsive": true,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
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
		$('#bucket').val(rowNum);
	}
	
	function edit_data(id,kd_po,cek)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		if(cek=='editt')
		{
			$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)
		}else{
			$("#btn-simpan").html(``)
		}
		

		$.ajax({
			url        : '<?= base_url(); ?>Transaksi/load_data_1',
			type       : "POST",
			data       : { id, tbl:'trs_po_bhnbk', jenis :'po_bahan_baku',field :'id_po_bhn' },
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
					$("#hub").val(data.header.hub).trigger('change');
					$("#id_po_bhn").val(data.header.id_po_bhn);
					$("#no_po_old").val(data.header.no_po_bhn);
					$("#no_po").val(data.header.no_po_bhn);
					$("#tgl_po").val(data.header.tgl_bhn);
					$("#ton").val(format_angka(data.header.ton_bhn));
					$("#harga").val(format_angka(data.header.hrg_bhn));
					$("#aka").val(data.header.aka);
					$("#total_po").val(format_angka(data.header.total));

					swal.close();

					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_po" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 70px" >PO PENJUALAN</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
						
						po_juall2(no,val.kode_po)	
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<select name="po_jual[${ no }]"  id="po_jual${ no }" class="form-control select2" style="width: 100%">
											<option value="${val.kode_po}" selected >${val.kode_po}</option>
										</select>	
									</div>
								</td>		
							</tr>
						`;
						no ++;
					})
					
					rowNum = no-1 
					$('#bucket').val(rowNum);					
					$("#table_list_po").html(list);
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

	function kosong()
	{
		var tgl_now = '<?= date('Y-m-d') ?>'
		$("#no_po_old").val("")
		$("#id_po_bhn").val("")
		$("#no_po").val("AUTO")
		$("#ton").val("")
		// $("#tgl_po").val(tgl_now)
		$("#harga").val("")
		$("#hub").val("")
		$("#total_po").val("")		
		swal.close()
	}

	function simpan() 
	{
		var no_po     = $("#no_po").val();
		var tgl_po    = $("#tgl_po").val();
		var ton       = $("#ton").val().split('.').join('');
		var harga     = $("#harga").val().split('.').join('');
		var total_po  = $("#total_po").val().split('.').join('');
		var hub       = $("#hub").val();
		
		if ( ton == '' || ton == 0 || no_po == '' || harga == '' || tgl_po == '' || total_po == '' || total_po == 0 || hub == '' ) 
		{			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Transaksi/insert_po_bb',
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
					location.href = "<?= base_url()?>Transaksi/PO_bhn_bk";
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

	function Cetak(ctk)
	{		
		var jns   = $('#jns').val()
		var bulan = $('#bulan').val()

		var url   = "<?php echo base_url('Transaksi/Cetak_rekap_penjualan'); ?>";
		window.open(url+'?jns='+jns+'&bulan='+bulan+'&ctk='+ctk, '_blank');   
		 
	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}
	
	function rekap_penjualan()
	{
		$(".row_rekap_jual").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row_rekap_jual").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(id,no_po) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_po+ " </strong> ",
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
				url: '<?= base_url(); ?>Transaksi/hapus',
				data: ({
					id       : id,
					jenis    : 'trs_po_bhnbk',
					field    : 'id_po_bhn',
					no_po    : no_po
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
					toastr.success('Data Berhasil Di Hapus');
					swal.close();

					// swal({
					// 	title               : "Data",
					// 	html                : "Data Berhasil Di Hapus",
					// 	type                : "success",
					// 	confirmButtonText   : "OK"
					// });
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
