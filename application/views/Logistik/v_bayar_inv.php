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

	<div class="container-fluid row-input" style="display: none;">
		<form role="form" method="post" id="myForm">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">Input Pembayaran</h3>
						</div>

						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
							<div class="col-md-2">PILIH INVOICE</div>
							<div class="col-md-1">
								<button class="btn btn-success btn-sm" style="width:100%;margin:auto" data-toggle="modal" data-target=".list_inv" type="button" onclick="load_invoice()">
									<i class="fa fa-search"></i>
								</button>
								<input type="hidden" name="sts_input" id="sts_input">
								<input type="hidden" name="id_byr_inv" id="id_byr_inv">
							</div>
							<div class="col-md-8"></div>

						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
							<div class="col-md-2">Nama Perusahaan</div>
							<div class="col-md-9">
								<input type="hidden" name="idpl" id="idpl">
								<input type="hidden" name="id_invoice_h" id="id_invoice_h">
								<input type="hidden" name="id_perusahaan" id="id_perusahaan">
								<input type="text" name="nm_perusahaan" id="nm_perusahaan" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
							<div class="col-md-2">Tgl Sj</div>
							<div class="col-md-3">
								<input type="date" name="tgl_sj" id="tgl_sj" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">No Inv</div>
							<div class="col-md-3">
								<input type="text" name="no_inv" id="no_inv" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">						
							<div class="col-md-2">Tgl J Tempo</div>
							<div class="col-md-3">
								<input type="date" name="tgl_jt" id="tgl_jt" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
							</div>

							<div class="col-md-1"></div>
							<div class="col-md-2">Tgl Inv</div>
							<div class="col-md-3">
								<input type="date" name="tgl_inv" id="tgl_inv" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
							</div>
						</div>
											
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">Tipe</div>
							<div class="col-md-3">								
								<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" disabled>
									<option value="">-- PILIH --</option>
									<option value="ppn">PPN 11%</option>
									<option value="ppn_pph">PPN 11% + PPH22</option>
									<option value="nonppn">NON PPN</option>
								</select>
							</div>

							<div class="col-md-1"></div>
							<div class="col-md-2">Status Lunas</div>
							<div class="col-md-3">
								<select name="sts_lunas" id="sts_lunas" class="form-control select2" >
									<option value="OPEN">OPEN</option>
									<option value="TEMPO">TEMPO</option>
									<option value="LUNAS">LUNAS</option>
								</select>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
							<div class="col-md-2">Total Inv</div>
							<div class="col-md-3">
								
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text">Rp</span>
									</div>
									<input style="text-align: right;font-weight: bold;"  type="text" name="total_inv" id="total_inv" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" readonly>
								</div>
							</div>
							<div class="col-md-1"></div>
							
							<div class="col-md-2">Status J Tempo</div>
							<div class="col-md-3">
								<select name="status_jt" id="status_jt" class="form-control select2" readonly>
									<option value="jt">JATUH TEMPO</option>
									<option value="blm">BELUM</option>
								</select>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
							<div class="col-md-2">History bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text">Rp</span>
									</div>
									<input style="text-align: right;font-weight: bold;"  type="text" name="history_byr" id="history_byr" class="form-control" value="" onkeyup="ubah_angka(this.value,this.id)" readonly> 
								</div>
							</div>		
							
							<div class="col-md-1"></div>

							
							<div class="col-md-2">Include / Exclude</div>
							<div class="col-md-3">
								<select id="inc_exc" name="inc_exc" class="form-control select2" style="width: 100%" disabled>
										<option value="Include">Include</option>
										<option value="Exclude">Exclude</option>
										<option value="nonppn_inc">Non PPN</option>
									</select>
							</div>
							
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">			
							<div class="col-md-2">Kurang bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text">Rp</span>
									</div>
									<input style="text-align: right;font-weight: bold;"  type="text" name="krg_byr" id="krg_byr" class="form-control" value="" onkeyup="ubah_angka(this.value,this.id)" readonly> 
								</div>
							</div>		
							
							<div class="col-md-1"></div>

							
							<div class="col-md-2">Alasan Retur</div>
							<div class="col-md-3">
								<input type="text" name="alasan" id="alasan" class="form-control" value="-">
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">				
							<div class="col-md-2">Jumlah Bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text">Rp</span>
									</div>
									<input style="text-align: right;font-weight: bold; color:#ff5733;"   type="text" name="jml_byr" id="jml_byr" class="form-control" value="" onkeyup="ubah_angka(this.value,this.id),hitung_kurang(this.value)" > 
								</div>
								
							</div>							
							<div class="col-md-1"></div>
							<div class="col-md-2">Sales</div>
							<div class="col-md-3">
								<input type="text" name="sales" id="sales" class="form-control" value="" oninput="this.value = this.value.toUpperCase()" >
							</div>
							
						</div>
						
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
							<div class="col-md-2">Tgl Bayar</div>
							<div class="col-md-3">
								<input type="hidden" name="tgl_hari_ini" id="tgl_hari_ini" class="form-control" value="<?= date('Y-m-d') ?>" >
								<input type="date" name="tgl_byr" id="tgl_byr" class="form-control" value="<?= date('Y-m-d') ?>" >
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">TOP</div>
							<div class="col-md-3">
								<input type="text" name="top" id="top" class="form-control" value="" onkeyup="ubah_angka(this.value,this.id)" >
							</div>
							
						</div>
						<br>
						<hr>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">List Item</div>
								<div class="col-md-10">&nbsp;
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
							<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
									<table id="data_list" class="table table-hover table- table-bordered table-condensed table-scrollable">
										
									</table>
								</div>
							</div>
						
						<div class="card-body row"style="font-weight:bold">
							<div class="col-md-4">
								<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
									<i class="fa fa-chevron-left" ></i> Kembali</b>
								</button>
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
					<?php if(in_array($this->session->userdata('level'), ['Admin','Laminasi','Keuangan1','Pembayaran'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;white-space:nowrap;" >
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%"> 
							<thead class="color-tabel">
								<tr>
									<th class="text-center title-white">NO</th>
									<th class="text-center title-white">CUSTOMER</th>
									<th class="text-center title-white">TGL BAYAR</th>
									<th class="text-center title-white">NO INVOICE</th>
									<th class="text-center title-white">NO SJ</th>
									<th class="text-center title-white">TOTAL INVOICE</th>
									<th class="text-center title-white">TOTAL BAYAR</th>
									<th class="text-center title-white">ACC OWNER</th>
									<th class="text-center title-white">AKSI</th>
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

<!-- Modal Regist -->
<div class="modal fade list_inv" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" >

        <div class="modal-content">

			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>Pilih Invoice</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">
					
				<div class="" style="position: absolute;right: 20px; font-weight:bold">
					<?php 
						$qbulan    = $this->db->query("SELECT*FROM m_bulan");
						$bln_now   = date("m");
					?>
						<select id="rentang_bulan" class="form-control select2" onchange="load_invoice()"> 
							<option value="all">-- SEMUA --</option>
					<?php 									
						foreach ($qbulan->result() as $bln_row)
						{
							if ($bln_row->id==$bln_now) {
								echo "<option selected value=$bln_row->id><b>$bln_row->bulan</b></option>";
								}
							else {	
							echo "<option value=$bln_row->id><b>$bln_row->bulan</b></option>";
							}
						}		
					?>  
					</select>
				</div>
				<br>
				<br>

                <table class="table table-bordered table-striped" id="tbl_inv" style="margin:auto !important">
                    <thead>
                        <tr class="color-tabel">
                            <th class="text-center title-white">NO </th>
                            <th class="text-center title-white">Invoice</th>
                            <th class="text-center title-white">NO SJ</th>
                            <th class="text-center title-white">TGL INV</th>
                            <th class="text-center title-white">TGL SJ</th>
                            <th class="text-center title-white">EXCLUDE</th>
                            <th class="text-center title-white">INCLUDE</th>
                            <th class="text-center title-white">HISTORY BAYAR</th>
                            <th class="text-center title-white">KURANG BAYAR</th>
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
<!-- Modal Regist -->

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
	});

	function reloadTable() 
	{
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
				"url": '<?php echo base_url('Logistik/load_data/byr_inv')?>',
				"type": "POST",
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
	
	function load_invoice()
	{
		var blnn    = $('#rentang_bulan').val();
		var table   = $('#tbl_inv').DataTable();
		table.destroy();
		tabel = $('#tbl_inv').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_invoice/byr_inv')?>',
				"type"  : "POST",
				"data"  : ({blnn:blnn}),
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
	
	function edit_data(id,no_inv)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, no:no_inv, jenis:'byr_invoice' },
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
					var jth_tempo = data.header.tgl_jatuh_tempo;
					var tgl_hari_ini = $("#tgl_hari_ini").val();
					$('.list_inv').modal('hide');
					// header
					// $("#sts_lunas").val(data.header.type).trigger('change');
					if(tgl_hari_ini>=jth_tempo)
					{
						$("#status_jt").val('jt').trigger('change');
					}else{
						$("#status_jt").val('blm').trigger('change');

					}
					$("#pajak").val(data.header.pajak).trigger('change');
					$("#inc_exc").val(data.header.inc_exc).trigger('change');
					$("#id_invoice_h").val(data.header.id);
					$("#tgl_sj").val(data.header.tgl_sj);
					$("#tgl_inv").val(data.header.tgl_invoice);
					$("#tgl_jt").val(data.header.tgl_jatuh_tempo);
					$("#tgl_byr").val(data.header.tgl_jatuh_tempo);
					$("#jml_byr").val(format_angka(data.header.jumlah_bayar));
					$("#top").val(data.header.TOP);
					$("#alasan").val(data.header.alasan_retur);
					$("#id_byr_inv").val(data.header.id_bayar_inv);

					$("#id_perusahaan").val(data.header.id_perusahaan);
					$("#nm_perusahaan").val(data.header.nm_perusahaan);
					$("#no_inv").val(data.header.no_invoice);
					$("#sales").val(data.header.sales);
					
					$("#type_po").prop("disabled", true);

					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >List</th>
							<th style="text-align: center; padding-right: 30px" >Exclude</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding-right: 10px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding-right: 25px" >SESET</th>
							<th style="text-align: center; padding-right: 30px" >QTY FIX</th>
							<th style="text-align: center; padding-right: 50px" >TOTAL INV</th>
						</thead>`;

						var no            = 1;
						var berat_total   = 0;
						var exclude       = 0;
						var include       = 0;
						var qty           = 0;
						var r_qty         = 0;
						var qty_fix       = 0;
						var total_inv     = 0;
						var pph22         = 0;
						$.each(data.detail, function(index, val) {

							// var total_invo = val.harga*val.weight 
							var total_invo = val.harga*val.hasil 
							
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
									</td>

								<td>
									<table>									
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No SJ </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_surat}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No PO </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_po}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>GSM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.g_label}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>ITEM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.width}<br></td>
									</tr>
									</table>
								</td>
								<td style="text-align: center" >${format_angka(val.harga)}
								</td>
					
								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >${format_angka(val.retur_qty)}
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									
								</td>

								<td style="text-align: center" >${format_angka(val.seset)}
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
								</td>
								
								<td style="text-align: center" >
									<input style="text-align: right" type="text" id="total_invo${no}" name="total_invo[${no}]"  class="form-control" value="${format_angka(total_invo)}" readonly>
								</td>

							</tbody>`;
							berat_total    += parseInt(val.qty);
							total_inv      += parseInt(total_invo);
							no ++;
						})
						var ppn11 = Math.round(0.11 * total_inv);
						var pph22 = Math.round(0.001 * total_inv);
						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = 0;
								var total          = total_inv;
								

							}else{
								var ppn            = ppn11;
								var pph            = 0;
								var total          = total_inv + ppn11;
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = pph22;
								var total          = total_inv + pph22;
							}else{
								var ppn            = ppn11;
								var pph            = pph22;
								var total          = total_inv + ppn11 +pph22;
							}
						}else{
							var ppn           = 0;
							var pph           = 0;
							var total         = total_inv;

						}
						
						html_ppn =`
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">PPN
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn)}
						</td>
						</tr>`;
						
						html_pph =`						
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">PPH
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph)}
						</td>
						</tr>`;

						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
								

							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}
						}else{
							var html_ppn_ok   = ''
							var html_ppn_ok   = ''

						}

						list += `
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">SUB TOTAL
								</td>
								<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_inv)}
								</td>
						</tr>`;

						list += html_ppn_ok;
						
						list += html_pph_ok;
						
						list += `
						<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">TOTAL
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total)}
						</td>
						</tr>`;

						list += `</table>`;
					}else{

						var list = `
						<table id="datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >List</th>
								<th style="text-align: center; padding-right: 35px" >Exclude</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding-right: 35px">Retur</th>
								<th style="text-align: center; padding-right: 35px" >QTY FIX</th>
								<th style="text-align: center; padding-right: 50px" >TOTAL INV</th>

							</thead>`;
						var no            = 1;
						var berat_total   = 0;
						var exclude       = 0;
						var include       = 0;
						var qty           = 0;
						var r_qty         = 0;
						var qty_fix       = 0;
						var total_inv     = 0;
						$.each(data.detail, function(index, val) {
							if(val.no_po_sj == null || val.no_po_sj == '')
							{
								no_po = val.no_po
							}else{
								no_po = val.no_po_sj
							}

							
							// total invoice
							var total_invo = val.harga*val.hasil; 

							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
								</td>
								<td>
									<table>									
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No SJ </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_surat}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No PO </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${no_po}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>ITEM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.nm_ker}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>UKURAN </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.g_label}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>KUALITAS </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.kualitas}<br></td>
									</tr>
									</table>
								</td>

								<td style="text-align: center" >${format_angka(val.harga)}
								</td>

								<td style="text-align: right" >${format_angka(val.qty)}
								</td>
								
								<td style="text-align: center" >${format_angka(val.retur_qty)}
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
								</td>

								<td style="text-align: center" >
									<input style="text-align: right;font-weight: bold;" type="text" id="total_invo${no}" name="total_invo[${no}]"  class="form-control" value="${format_angka(total_invo)}" readonly>
								</td>

							</tbody>`;
							exclude    += parseInt(val.harga);
							include    += parseInt(val.include);
							qty        += parseInt(val.qty);
							r_qty      += parseInt(val.retur_qty);
							qty_fix    += parseInt(val.hasil);
							total_inv  += parseInt(total_invo);
							no ++;
						})
						var ppn11 = Math.round(0.11 * total_inv);
						var pph22 = Math.round(0.001 * total_inv);
						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = 0;
								var total          = total_inv;
								

							}else{
								var ppn            = ppn11;
								var pph            = 0;
								var total          = total_inv + ppn11;
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = pph22;
								var total          = total_inv + pph22;
							}else{
								var ppn            = ppn11;
								var pph            = pph22;
								var total          = total_inv + ppn11 +pph22;
							}
						}else{
							var ppn           = 0;
							var pph           = 0;
							var total         = total_inv;

						}

						
						html_ppn =`
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">PPN
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn)}
						</td>
						</tr>`;
						
						html_pph =`						
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">PPH
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph)}
						</td>
						</tr>`;

						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
								

							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}
						}else{
							var html_ppn_ok   = ''
							var html_ppn_ok   = ''

						}

						list += `
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">SUB TOTAL
								</td>
								<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_inv)}
								</td>
						</tr>`;

						list += html_ppn_ok;
						
						list += html_pph_ok;
						
						list += `
						<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">TOTAL
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total)}
						</td>
						</tr>`;
						list += `</table>`;
						swal.close();
					} 
					$("#total_inv").val(format_angka(total));
					$("#history_byr").val(format_angka(data.header.jum_bayar-data.header.jumlah_bayar));
					$("#data_list").html(list);
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

	function spilldata(id,no_inv)
	{
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, no:no_inv, jenis:'spill' },
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
					var jth_tempo = data.header.tgl_jatuh_tempo;
					var tgl_hari_ini = $("#tgl_hari_ini").val();
					$('.list_inv').modal('hide');
					// header
					// $("#sts_lunas").val(data.header.type).trigger('change');
					if(tgl_hari_ini>=jth_tempo)
					{
						$("#status_jt").val('jt').trigger('change');
					}else{
						$("#status_jt").val('blm').trigger('change');

					}
					$("#pajak").val(data.header.pajak).trigger('change');
					$("#inc_exc").val(data.header.inc_exc).trigger('change');
					$("#id_invoice_h").val(data.header.id);
					$("#tgl_sj").val(data.header.tgl_sj);
					$("#tgl_inv").val(data.header.tgl_invoice);
					$("#tgl_jt").val(data.header.tgl_jatuh_tempo);
					$("#tgl_byr").val(data.header.tgl_jatuh_tempo);

					$("#id_perusahaan").val(data.header.id_perusahaan);
					$("#nm_perusahaan").val(data.header.nm_perusahaan);
					$("#no_inv").val(data.header.no_invoice);
					$("#sales").val(data.header.sales);
					
					$("#type_po").prop("disabled", true);
					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >List</th>
							<th style="text-align: center; padding-right: 30px" >Exclude</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding-right: 10px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding-right: 25px" >SESET</th>
							<th style="text-align: center; padding-right: 30px" >QTY FIX</th>
							<th style="text-align: center; padding-right: 50px" >TOTAL INV</th>
						</thead>`;

						var no            = 1;
						var berat_total   = 0;
						var exclude       = 0;
						var include       = 0;
						var qty           = 0;
						var r_qty         = 0;
						var qty_fix       = 0;
						var total_inv     = 0;
						var pph22         = 0;
						$.each(data.detail, function(index, val) {

							// var total_invo = val.harga*val.weight 
							var total_invo = val.harga*val.hasil 
							
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
									</td>
								<td>
									<table>									
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No SJ </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_surat}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No PO </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_po}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>GSM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.g_label}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>ITEM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.width}<br></td>
									</tr>
									</table>
								</td>

								<td style="text-align: center" >${format_angka(val.harga)}
								</td>

								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >${format_angka(val.retur_qty)}
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									<input type="hidden" id="weight${no}" name="weight[${no}]"  value="${val.weight}">
								</td>

								<td style="text-align: center" >${format_angka(val.seset)}
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
								</td>
								
								<td style="text-align: center" >
									<input style="text-align: right" type="text" id="total_invo${no}" name="total_invo[${no}]"  class="form-control" value="${format_angka(total_invo)}" readonly>
								</td>

							</tbody>`;
							berat_total += parseInt(val.qty);
							total_inv  += parseInt(total_invo);
							no ++;
						})


						var ppn11 = Math.round(0.11 * total_inv);
						var pph22 = Math.round(0.001 * total_inv);
						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = 0;
								var total          = total_inv;
								

							}else{
								var ppn            = ppn11;
								var pph            = 0;
								var total          = total_inv + ppn11;
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = pph22;
								var total          = total_inv + pph22;
							}else{
								var ppn            = ppn11;
								var pph            = pph22;
								var total          = total_inv + ppn11 +pph22;
							}
						}else{
							var ppn           = 0;
							var pph           = 0;
							var total         = total_inv;

						}
						
						html_ppn =`
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">PPN
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn)}
						</td>
						</tr>`;
						
						html_pph =`						
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">PPH
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph)}
						</td>
						</tr>`;

						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
								

							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}
						}else{
							var html_ppn_ok   = ''
							var html_ppn_ok   = ''

						}

						list += `
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">SUB TOTAL
								</td>
								<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_inv)}
								</td>
						</tr>`;

						list += html_ppn_ok;
						
						list += html_pph_ok;
						
						list += `
						<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="8">TOTAL
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total)}
						</td>
						</tr>`;

						list += `</table>`;
					}else{

						var list = `
						<table id="datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >List</th>
								<th style="text-align: center; padding-right: 35px" >Exclude</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding-right: 35px">RETUR</th>
								<th style="text-align: center; padding-right: 35px" >QTY FIX</th>
								<th style="text-align: center; padding-right: 50px" >TOTAL INV</th>

							</thead>`;
						var no            = 1;
						var berat_total   = 0;
						var exclude       = 0;
						var include       = 0;
						var qty           = 0;
						var r_qty         = 0;
						var qty_fix       = 0;
						var total_inv     = 0;
						$.each(data.detail, function(index, val) {
							if(val.no_po_sj == null || val.no_po_sj == '')
							{
								no_po = val.no_po
							}else{
								no_po = val.no_po_sj
							}

							// total invoice
							var total_invo = val.harga*val.hasil; 

							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
								</td>
								<td>
									<table>									
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No SJ </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.no_surat}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>No PO </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${no_po}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>ITEM </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.nm_ker}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>UKURAN </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.g_label}<br></td>
									</tr>
									<tr style="background-color: transparent !important">
										<td style="padding : 2px;border:none;"><b>KUALITAS </td>
										<td style="padding : 2px;border:none;">:</td></b> 
										<td style="padding : 2px;border:none;">${val.kualitas}<br></td>
									</tr>
									</table>
								</td>
								<td style="text-align: center" >${format_angka(val.harga)}
								</td>

								<td style="text-align: right" >${format_angka(val.qty)}
									<input type="hidden" id="qty${no}" name="qty[${no}]" onkeyup="ubah_angka(this.value,this.id)" value="${val.qty}" readonly>
								</td>
								
								<td style="text-align: center" >${format_angka(val.retur_qty)}
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
								</td>

								<td style="text-align: center" >
									<input style="text-align: right;font-weight: bold;" type="text" id="total_invo${no}" name="total_invo[${no}]"  class="form-control" value="${format_angka(total_invo)}" readonly>
								</td>

							</tbody>`;
							exclude    += parseInt(val.harga);
							include    += parseInt(val.include);
							qty        += parseInt(val.qty);
							r_qty      += parseInt(val.retur_qty);
							qty_fix    += parseInt(val.hasil);
							total_inv  += parseInt(total_invo);
							no ++;
						})


						var ppn11 = Math.round(0.11 * total_inv);
						var pph22 = Math.round(0.001 * total_inv);
						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = 0;
								var total          = total_inv;
								

							}else{
								var ppn            = ppn11;
								var pph            = 0;
								var total          = total_inv + ppn11;
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var ppn            = 'KB';
								var pph            = pph22;
								var total          = total_inv + pph22;
							}else{
								var ppn            = ppn11;
								var pph            = pph22;
								var total          = total_inv + ppn11 +pph22;
							}
						}else{
							var ppn           = 0;
							var pph           = 0;
							var total         = total_inv;

						}

						
						html_ppn =`
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">PPN
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn)}
						</td>
						</tr>`;
						
						html_pph =`						
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">PPH
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph)}
						</td>
						</tr>`;

						if(data.header.pajak=='ppn')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
								

							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = ''
							}
						}else if(data.header.pajak=='ppn_pph')
						{
							if(data.header.inc_exc=='Include')
							{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}else{
								var html_ppn_ok    = html_ppn
								var html_pph_ok    = html_pph;
							}
						}else{
							var html_ppn_ok   = ''
							var html_ppn_ok   = ''

						}

						list += `
						<tr>
						<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">SUB TOTAL
								</td>
								<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_inv)}
								</td>
						</tr>`;

						list += html_ppn_ok;
						
						list += html_pph_ok;
						
						list += `
						<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="6">TOTAL
						</td>
						<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total)}
						</td>
						</tr>`;
						list += `</table>`;
						swal.close();
					} 
					$("#total_inv").val(format_angka(total));
					$("#history_byr").val(format_angka(data.header.jum_bayar));
					$("#data_list").html(list);
					hitung_kurang()
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
		statusInput = 'insert'
		$("#id_invoice_h").val("")
		$("#id_perusahaan").val("")
		$("#nm_perusahaan").val("")
		$("#tgl_sj").val("")
		$("#tgl_inv").val("")
		$("#no_inv").val("")
		$("#tgl_inv").val("")
		$("#alasan").val("")
		$("#total_inv").val("")
		$("#tgl_jt").val("")
		$("#tgl_byr").val("")
		$("#jml_byr").val("")
		$("#sales").val("")
		$("#top").val("")

		$("#status_jt").val("jt").trigger('change')
		$("#sts_lunas").val("OPEN").trigger('change')

		$("#data_list").html('')		

		swal.close()
	}

	function hitung_kurang()
	{
		var total_inv       = $("#total_inv").val().split('.').join('')
		var history_byr     = $("#history_byr").val().split('.').join('')
		var jml_byr         = $("#jml_byr").val().split('.').join('')
		var kurang_bayar    = total_inv - history_byr - jml_byr
		if(kurang_bayar==0)
		{
			krg_byr = 0
		}else{
			krg_byr = kurang_bayar
		}		
		$("#krg_byr").val(format_angka(krg_byr))
		
	}

	function simpan() 
	{
		var nm_perusahaan   = $("#nm_perusahaan").val();
		var alasan          = $("#alasan").val();
		var tgl_byr         = $("#tgl_byr").val();
		var jml_byr         = $("#jml_byr").val();
		var sales           = $("#sales").val();
		var top             = $("#top").val();

		if (nm_perusahaan=='' || alasan== '' || tgl_byr == '' || jml_byr=='' || sales=='' || top=='' ) 
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
			url        : '<?= base_url(); ?>Logistik/Insert_byr_inv',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					// swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";					
					kosong();
					location.href = "<?= base_url()?>Logistik/bayar_inv";
					
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

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no+ " </strong> ",
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
					id: id,
					jenis: 'byr_inv',
					field: 'id_bayar_inv'
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

	function acc_inv(id,status_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var acc_owner   = status_owner
		// var acc_admin   = $('#modal_status_inv_admin').val()
		var id      = id
		
		if(user=='bumagda' || user=='developer')
		{
			acc = acc_owner
		}else{
			acc = acc_owner
		}

		// console.log(user)
		// console.log(acc)
		if (acc=='N')
		{
			var html = 'VERIFIKASI'
			var icon = '<i class="fas fa-check"></i>'
		}else{
			var html = 'BATAL VERIFIKASI'
			var icon = '<i class="fas fa-lock"></i>'
		}
		
		swal({
			title              : html,
			html               : "<p> Apakah Anda yakin ?</p><br>",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>'+icon+' '+html+'</b>',
			cancelButtonText   : '<b><i class="fas fa-undo"></i> Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			confirmButtonColor : '#28a745',
			cancelButtonColor  : '#d33'
		}).then(() => {

				$.ajax({
					url: '<?= base_url(); ?>Logistik/prosesData',
					data: ({
						id    : id,
						acc       : acc,
						jenis     : 'verif_byr_inv'
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
						toastr.success('Data Berhasil Diproses');
						// swal({
						// 	title               : "Data",
						// 	html                : "Data Berhasil Diproses",
						// 	type                : "success",
						// 	confirmButtonText   : "OK"
						// });
						
						// setTimeout(function(){ location.reload(); }, 1000);
						// location.href = "<?= base_url()?>Logistik/Invoice";
						// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+id+"&statuss=Y&no_inv="+no_inv+"&acc=1";
						reloadTable()
						close_modal()
						swal.close();
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
		
		});


	}

	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}
</script>
