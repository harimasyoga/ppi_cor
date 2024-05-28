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
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','User'])){ ?>
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
									<th class="text-center">STATUS</th>
									<th class="text-center">NO TIMB</th>
									<th class="text-center">TIMBANGAN</th>
									<th class="text-center">TONASE</th>
									<th class="text-center" style="padding : 12px 50px">CUST</th>
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

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT STOK BAHAN BAKU</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">NO STOK</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_stok_h" id="id_stok_h">

							<input type="text" class="angka form-control" name="no_stok" id="no_stok" value="AUTO" readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">TOTAL TIMBANGAN</div>
						<div class="col-md-3">
							<div class="input-group">
								<input type="text" class="form-control" name="jum_timb" id="jum_timb" value ="0" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>	
							</div>
						</div>

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						<div class="col-md-2">NO TIMBANGAN</div>
						<div class="col-md-3">

							<div class="input-group">								
								<input type="hidden" name="id_timb" id="id_timb">

								<input type="text" name="no_timb" id="no_timb" class="form-control angka" onkeyup="ubah_angka(this.value,this.id)" readonly>

								<div class="input-group-append">
									<span class="input-group-text">
										<a onclick="search_timbangan(0)">
											<i class="fas fa-search" style="color:red"></i> 
										</a>
									</span>
								</div>
							</div>
						</div>	
						<div class="col-md-1"></div>

						<div class="col-md-2">HISTORY TIMB</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="history_timb" id="history_timb" value ="0" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</div>
						

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						
						<div class="col-md-6"></div>

						<div class="col-md-2">TOTAL ITEM</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="total_bb_item" id="total_bb_item" value ="0" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</div>
						

					</div>
					
											
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
								
						<div class="col-md-2">MUATAN PPI ?</div>
						<div class="col-md-3">
							<select name="muat_ppi" id="muat_ppi" class="form-control" onchange="cek_muat_ppi()">
								<option value="TIDAK">TIDAK</option>
								<option value="ADA">ADA</option>
							</select>
						</div>
						<div class="col-md-1"></div>
						
						<div class="col-md-2">TONASE PPI</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="tonase_ppi" id="tonase_ppi" value ="0" onkeyup="ubah_angka(this.value,this.id),hitung_total()" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</div>
						
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_stok" id="tgl_stok" value ="<?= date('Y-m-d') ?>" >
						</div>					
						
						<div class="col-md-1"></div>
						<div class="col-md-2">Sisa Timbangan</div>
						<div class="col-md-3">
							<div class="input-group mb-1">
								<input type="text" style="color:red;font-weight:bold" class="form-control" name="sisa_timb" id="sisa_timb" value ="0" readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</div>
					</div>
					
					<br>
					
					<!-- detail PO-->
					<hr>
					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-2" style="padding-right:0">List Item PO</div>
						<div class="col-md-10">&nbsp;
						</div>
					</div>


					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 20px" >LIST </th>
									<th style="padding : 12px 150px">PO</th>
									<th style="padding : 12px 50px">Tonase PO</th>
									<th style="padding : 12px 70px" >History PO</th>
									<th style="padding : 12px 70px" >Sisa</th>
									<th style="padding : 12px 50px" >Kedatangan</th>
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
									<td>
										<div class="text-center">
											<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[0]" id="list0">
												<i class="fas fa-search"></i>
											</button> 
											
											<!-- <button style="display: none;" type="button" title="PILIH"  onclick="cetak_inv_bb(this.id)" class="btn btn-danger btn-sm" name="print_inv[0]" id="print_inv0">
												<i class="fas fa-print"></i>
											</button>  -->
											
										</div>
									</td>
									<td style="padding : 12px 20px" >
										<input type="hidden" name="id_po_bhn[0]" id="id_po_bhn0" >
										
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
												</span>
											</div>
											<input type="hidden" name="id_hub[0]" id="id_hub0" class="angka form-control" readonly>
											<input type="text" name="nm_hub[0]" id="nm_hub0" class="angka form-control" readonly>
										</div>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>NO PO</b>
												</span>
											</div>
											
											<input type="text" name="no_po[0]" id="no_po0" class="angka form-control" readonly>
										</div>
									</td>	

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" size="5" name="ton[0]" id="ton0" class="angka form-control" value='0' readonly>
											<div class="input-group-append">
												<span class="input-group-text"><b>Kg</b>
												</span>
											</div>		
										</div>
									</td>		

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" size="5" name="history[0]" id="history0" class="angka form-control" value='0' readonly>
											<div class="input-group-append">
												<span class="input-group-text"><b>Kg</b>
												</span>
											</div>		
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" size="5" name="sisa[0]" id="sisa0" class="angka form-control" value='0' readonly>
											<div class="input-group-append">
												<span class="input-group-text"><b>Kg</b>
												</span>
											</div>		
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" size="5" name="datang[0]" id="datang0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
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
									<td colspan="6" class="text-center">
										<label for="total">TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<input type="text" size="5" name="total_bb" id="total_bb" class="angka form-control" value='0' readonly>
											<div class="input-group-append">
												<span class="input-group-text"><b>Kg</b>
												</span>
											</div>		
										</div>
										
									</td>	
								</tr>
							</tfoot>
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

<!-- Modal item -->
<div class="modal fade list_item" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" style="width:100%;margin:auto">

        <div class="modal-content">
            <div class="modal-header">
                <h5><b>Pilih PO</b></h5>
            </div>
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">

                <table class="table table-bordered table-striped" id="tbl_po" style="margin:auto !important">
                    <thead>
                        <tr class="color-tabel">
                            <th class="text-center title-white">NO </th>
                            <th class="text-center title-white">CUSTOMER</th>
                            <th class="text-center title-white">NO PO</th>
                            <th class="text-center title-white">TGL PO</th>
                            <th class="text-center title-white">TONASE ORDER</th>
                            <th class="text-center title-white">HISTORY DATANG</th>
							<th class="text-center title-white">SISA</th>
                            <th class="text-center title-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal item -->

<!-- Modal search timbangan -->
<div class="modal fade list_timbangan" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" style="width:100%;margin:auto">

        <div class="modal-content">
            <div class="modal-header">
                <h5><b>PILIH TIMBANGAN</b></h5>
            </div>
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">

                <table class="table table-bordered table-striped" id="tbl_timbangan" style="margin:auto !important">
                    <thead>
                        <tr class="color-tabel">
                            <th class="text-center title-white">NO </th>
                            <th class="text-center title-white">NO TIMBANGAN</th>
                            <th class="text-center title-white">TGL MASUK</th>
                            <!-- <th class="text-center title-white">TGL KELUAR</th> -->
                            <th class="text-center title-white">NO POLISI</th>
                            <th class="text-center title-white">NAMA BARANG</th>
                            <th class="text-center title-white">BERAT BERSIH</th>
                            <th class="text-center title-white">HISTORY DATANG</th>
                            <th class="text-center title-white">CATATAN</th>
                            <th class="text-center title-white">NAMA SOPIR</th>
                            <th class="text-center title-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal search timbangan -->

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
		$('.select2').select2();
	});

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
					option += "<option value='"+val.id_hub+"'>"+val.nm_hub+"</option>";
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

	var rowNum = 0;

	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}

		var datang    = $('#datang' + b).val();
		var id_po_bhn = $('#id_po_bhn' + b).val();
		var id_produk = $('#id_produk' + b).val();
		var idp       = $('#id_pelanggan' + b).val();
			
		if (datang != '0' && datang != '' && id_po_bhn != '' && id_produk != '' && idp != '') 
		{
			rowNum++;
			
				var x = rowNum + 1;
				$('#table_list_item').append(
					`<tr id="itemRow${ rowNum }">
						<td id="detail-hapus-${ rowNum }">
							<div class="text-center">
								<a class="btn btn-danger" id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })">
									<i class="far fa-trash-alt" style="color:#fff"></i> 
								</a>
							</div>
						</td>
						<td>
							<div class="text-center">
								<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ rowNum }]" id="list${ rowNum }">
									<i class="fas fa-search"></i>
								</button>
								
							</div>
						</td>
						<td style="padding : 12px 20px" >
							<input type="hidden" name="id_po_bhn[${ rowNum }]" id="id_po_bhn${ rowNum }" >
							
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
									</span>
								</div>								
								<input type="hidden" name="id_hub[${ rowNum }]" id="id_hub${ rowNum }" class="angka form-control" readonly>
								
								<input type="text" name="nm_hub[${ rowNum }]" id="nm_hub${ rowNum }" class="angka form-control" readonly>
							</div>
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>NO PO</b>
									</span>
								</div>
								
								<input type="text" name="no_po[${ rowNum }]" id="no_po${ rowNum }" class="angka form-control" readonly>
							</div>
						</td>	

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" size="5" name="ton[${ rowNum }]" id="ton${ rowNum }" class="angka form-control" value='0' readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" size="5" name="history[${ rowNum }]" id="history${ rowNum }" class="angka form-control" value='0' readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" size="5" name="sisa[${ rowNum }]" id="sisa${ rowNum }" class="angka form-control" value='0' readonly>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" size="5" name="datang[${ rowNum }]" id="datang${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
								<div class="input-group-append">
									<span class="input-group-text"><b>Kg</b>
									</span>
								</div>		
							</div>
						</td>		
					</tr>
					`);
				$('.select2').select2({
					placeholder: '--- Pilih ---',
					dropdownAutoWidth: true
				});
				$('#bucket').val(rowNum);
				$('#list' + rowNum).focus();
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

	function clear_data()
	{
		clearRow()
		hitung_total()
	}
	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}
		
		$('#bucket').val(rowNum);

		$("#id_pelanggan0").val("")
		$("#nm_hub0").val("")
		$("#kode_po0").val("")
		$("#id_po_bhn0").val("")
		$("#id_produk0").val("")
		$("#item0").val("")
		$("#qty0").val("")
		$("#ton0").val("")
		$("#kebutuhan0").val("")
		$("#history0").val("")
		$("#sisa0").val("")
		$("#datang0").val("")
		$("#no_po0").val("") 

	}

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

	function hitung_total()
	{
		var tonase_ppi          = $("#tonase_ppi").val().split('.').join('')
		var total_timb          = $("#jum_timb").val().split('.').join('')
		var history_timb        = $("#history_timb").val().split('.').join('')
		var total_kedatangan    = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var kedatangan   = parseInt($("#datang"+loop).val().split('.').join(''))
			total_kedatangan += kedatangan
		}		
		total_datang_ok = (total_kedatangan=='' || isNaN(total_kedatangan) || total_kedatangan == null) ? 0 : total_kedatangan
		sisa = total_timb - total_datang_ok - tonase_ppi - history_timb
		
		$("#total_bb").val(format_angka(total_kedatangan))
		$("#total_bb_item").val(format_angka(total_kedatangan))
		$("#sisa_timb").val(format_angka(sisa))
		
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
	function search_timbangan()
	{
		$('.list_timbangan').modal('show');
		
		var table   = $('#tbl_timbangan').DataTable();
		table.destroy();
		tabel = $('#tbl_timbangan').DataTable({
			"processing"   : true,
			"pageLength"   : true,
			"paging"       : true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_data/load_timbangan')?>',
				"type"  : "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function add_timb(id_timb,no_timb,bb,history)
	{		
		$('.list_timbangan').modal('hide');
		$('#id_timb').val(id_timb);
		$('#no_timb').val(no_timb);
		$('#history_timb').val(format_angka(history)); 
		$('#jum_timb').val(format_angka(bb)); 
		hitung_total();
		swal.close();
	}
	
	function load_item(id)
	{
		var id1   = id.substr(0,4);
		var id2   = id.substr(4,1);
		var no_timb   = $('#no_timb').val()
		

		// if (no_timb == '' || no_timb == null) 
		// {			
		// 	swal.close();
		// 	swal({
		// 		title               : "Cek Kembali",
		// 		html                : "Pilih No Timbangan Dahulu",
		// 		type                : "info",
		// 		confirmButtonText   : "OK"
		// 	});
		// 	return;
		// }else{			
			$('.list_item').modal('show');
		// }
		
		var table   = $('#tbl_po').DataTable();
		table.destroy();
		tabel = $('#tbl_po').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_data_bb')?>',
				"type"  : "POST",
				"data"  : { id:id2, jenis:'load_po_bahan' },
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function spilldata(id,no_po,id_name)
	{		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			dataType   : "JSON",
			data       : { id, no:no_po, jenis:'spill_po' },
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

					$('#id_po_bhn'+id_name).val(data.header.id_po_bhn);
					$('#id_hub'+id_name).val(data.header.id_hub);
					$('#id_hub'+id_name).val(data.header.id_hub);
					$('#nm_hub'+id_name).val(data.header.nm_hub);
					$('#no_po'+id_name).val(data.header.no_po_bhn);
					$('#ton'+id_name).val(format_angka(data.header.ton_bhn));
					$('#history'+id_name).val(format_angka(data.header.history_po));
					$('#sisa'+id_name).val(format_angka(data.header.ton_bhn-data.header.history_po));
					$('#datang'+id_name).val(format_angka(0));

					swal.close();
					$('.list_item').modal('hide');


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

	function reloadTable() 
	{
		load_data()
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/stok_bb')?>',
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
	
	function edit_data(id,no_po)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, tbl:'trs_h_stok_bb', jenis :'edit_stok_bb',field :'id_stok' },
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

					var history = data.header.history - data.header.total_item - data.header.tonase_ppi

					$("#id_stok_h").val(data.header.id_stok);
					$("#no_stok").val(data.header.no_stok);
					$("#muat_ppi").val(data.header.muatan_ppi).trigger('change');
					$("#tgl_stok").val(data.header.tgl_stok);
					$("#id_timb").val(data.header.id_timbangan);
					$("#no_timb").val(data.header.no_timbangan);
					$("#history_timb").val(format_angka(history));
					$("#jum_timb").val(format_angka(data.header.total_timb));
					$("#tonase_ppi").val(format_angka(data.header.tonase_ppi));
					$("#total_bb_item").val(format_angka(data.header.total_item));
					$("#sisa_timb").val(format_angka(data.header.sisa_stok)); 
					swal.close();

					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
						<thead class="color-tabel">
							<tr>
								<th id="header_del">Delete</th>
								<th style="padding : 12px 20px" >LIST </th>
								<th style="padding : 12px 150px">PO</th>
								<th style="padding : 12px 50px">Tonase PO</th>
								<th style="padding : 12px 70px" >History PO</th>
								<th style="padding : 12px 70px" >Sisa</th>
								<th style="padding : 12px 50px" >Kedatangan</th>
							</tr>
						</thead>`;
						
					var no   = 0;
					
					// <button type="button" title="PILIH"  onclick="cetak_inv_bb(this.id)" class="btn btn-danger btn-sm" name="print_inv[${ no }]" id="print_inv${ no }">
					// 	<i class="fas fa-print"></i>
					// </button> 

					$.each(data.detail, function(index, val) {
						var history_detail = val.history - val.datang_bhn_bk
						var sisa_po = val.tonase_po-val.history
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td>
									<div class="text-center">
										<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ no }]" id="list${ no }">
											<i class="fas fa-search"></i>
										</button> 
										
									</div>
								</td>
								<td style="padding : 12px 20px" >
									<input type="hidden" name="id_po_bhn[${ no }]" id="id_po_bhn${ no }" value="${val.id_po_bhn}">
									
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
											</span>
										</div>								
										<input type="hidden" name="id_hub[${ no }]" id="id_hub${ no }" class="angka form-control" value="${val.id_hub}" readonly>
										
										<input type="text" name="nm_hub[${ no }]" id="nm_hub${ no }" class="angka form-control" value="${val.nm_hub}" readonly>
									</div>
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>NO PO</b>
											</span>
										</div>
										
										<input type="text" name="no_po[${ no }]" id="no_po${ no }" class="angka form-control" value="${val.no_po_bhn}"  readonly>
									</div>
								</td>	

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="ton[${ no }]" id="ton${ no }" class="angka form-control" value="${format_angka(val.tonase_po)}"  readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="history[${ no }]" id="history${ no }" class="angka form-control" value="${format_angka(history_detail)}"  readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="sisa[${ no }]" id="sisa${ no }" class="angka form-control" value="${format_angka(sisa_po)}"  readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="datang[${ no }]" id="datang${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.datang_bhn_bk)}" >
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		
							</tr>
						`;

						no ++;
					})
					rowNum = no-1 
					$('#bucket').val(rowNum);					
					$("#table_list_item").html(list);					
					hitung_total()
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
		$tgl = '<?= date('Y-m-d') ?>'
		$("#id_stok_h").val("") 
		$("#no_stok").val("AUTO") 
		$("#jum_timb").val("") 
		$("#id_timb").val("") 
		$("#no_timb").val("") 
		$("#history_timb").val("") 
		$("#total_bb_item").val("") 		
		$("#muat_ppi").val('TIDAK').trigger('change');
		$("#tonase_ppi").val("") 
		$("#tgl_stok").val($tgl) 
		$("#sisa_timb").val("") 

		clear_data()
		
		swal.close()
	}

	function simpan() 
	{
		var tgl_stok    = $("#tgl_stok").val();
		var no_timb     = $("#no_timb").val();
		var muat_ppi    = $("#muat_ppi").val();
		var tonase_ppi  = $("#tonase_ppi").val().split('.').join('');
		var sisa_timb   = $("#sisa_timb").val().split('.').join('');
		
		if( sisa_timb < 0 ){
			swal({
				title               : "Cek Kembali",
				html                : "Inputan Stok Melebihi Timbangan !!",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
		
		if(muat_ppi == 'ADA' && tonase_ppi <= 0){
			swal({
				title               : "Cek Kembali",
				html                : "Isi Tonase PPI Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
		
		if ( tgl_stok=='' || no_timb== '' ) 
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
			url        : '<?= base_url(); ?>Logistik/Insert_stok_bb',
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
					// location.href = "<?= base_url()?>Logistik/stok_bb";
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});					
					kembaliList()
					
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
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(id,no_stok,id_hub) 
	{
		id_hub2 = id_hub.split('/').join(',')
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
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
					id         : id,
					no_stok    : no_stok,
					id_hub     : id_hub2,
					jenis      : 'trs_h_stok_bb',
					field      : 'id_stok'
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
