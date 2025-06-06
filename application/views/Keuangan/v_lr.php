<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
					<!-- <h1><b>Data Logistik</b> </h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow mb-3">
			
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;" >
					<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					<!--  AA -->
					<div class="col-md-12">			
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">TAHUN</div>
								<div class="col-md-3">
								<?php 
									$thang =  date("Y"); 
									$thang_min = $thang - 2 ;
								?>
									<select class="form-control select2" name ="thun" id="thun" onchange="load_data()" > 
								<?php 									
									for ($th=$thang_min ; $th<=$thang ; $th++)
									{
										if ($th==$thang) {
											echo "<option selected value=$th>$thang</option>";
											}
										else {	
										echo "<option value=$th>$th</option>";
										}
									}		
								?>  
									</select>
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">ATTN</div>
							<div class="col-md-3">
								<select class="form-control select2" name="id_hub2" id="id_hub2" style="width: 100%;" onchange="load_data()">
								</select>
							</div>
						</div>
									
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold;" id="blnn" >						
							<div class="col-md-2">BULAN</div>
							<div class="col-md-3">
								<?php 
									$qbulan    = $this->db->query("SELECT*FROM m_bulan");
									$bln_now   = date("m");
								?>
									<select id="rentang_bulan" class="form-control select2" onchange="load_data()" > 
										<option value="all">-- SEMUA --</option>
								<?php 									
									foreach ($qbulan->result() as $bln_row)
									{
										if ($bln_row->id==$bln_now) 
										{
											echo "<option selected value=$bln_row->id>$bln_row->bulan</option>";
										} else {	
											echo "<option value=$bln_row->id>$bln_row->bulan</option>";
										}
									}		
								?>  
									</select>
							</div>
							<div class="col-md-6"></div>
							
						</div>
						
						<br>
					</div>
					<!-- AA -->

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
						<div class="col-md-6">
							
							<button onclick="cetak_lr(0)"  class="btn btn-primary">
							<i class="fa fa-print"></i> <b>LAYAR</b></button>
							
							<button onclick="cetak_lr(1)"  class="btn btn-danger">
							<i class="fa fa-print"></i> <b>PDF</b></button>

							<button onclick="cetak_lr(2)"  class="btn btn-success">
							<i class="fa fa-download"></i> <b>EXCEL</b></button>
									<br>
									<br>
								
						</div>
						<div class="col-md-5"></div>
					</div>

					<div id="data_lr" style="overflow:auto;white-space:nowrap;" >
					</div>
				</div>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		load_data();
		load_hub();
		// getMax();
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";

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

            $('#id_hub2').html(option);
            swal.close();
          }else{	
            option += "<option value=''></option>";
            $('#id_hub2').html(option);					
            swal.close();
          }
        }
      });
      
    }
	
	function cetak_lr(ctk)
	{		
		var id_hub    = $('#id_hub2').val()
		var priode    = $('#priode').val()
		var tgl_awal  = $('#tgl_awal').val()
		var tgl_akhir = $('#tgl_akhir').val()

		var url    = "<?php echo base_url('Keuangan/cetak_lr'); ?>";
		window.open(url+'?id_hub='+id_hub+'&priode='+priode+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir, '_blank');   

		// var url    = "<?php echo base_url('Keuangan/cetak_lr'); ?>";
		// window.open(url, '_blank');   
	}

	function load_data() 
	{
		var id_hub    = $('#id_hub2').val()
		var priode    = $('#priode').val()
		var blnn      = $('#rentang_bulan').val()
		var thun      = $('#thun').val()
		$.ajax({
			url: '<?php echo base_url('Keuangan/load_lr')?>',
			type: "POST",
			// data: ({ id, id_dtl, opsi }),
			"data" : ({
					priode       : priode,
					id_hub       : id_hub,
					blnn         : blnn,
					thun         : thun
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
				data = JSON.parse(res)
				$("#data_lr").html(data.html_dtl)
				swal.close()
			}
		})

	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	var no_po = ''

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function edit_data(id,no_invoice) 
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		// var type_po       = $('#type_po').val()

		$.ajax({
			url        : '<?= base_url(); ?>Keuangan/load_data_1',
			type       : "POST",
			data       : { id: id, no: no_invoice, jenis:'invoice' },
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
					$("#type_po").val(data.header.type).trigger('change');
					$("#cek_inv").val(data.header.cek_inv).trigger('change');
					$("#tgl_inv").val(data.header.tgl_invoice);
					$("#tgl_sj").val(data.header.tgl_sj);
					$("#id_inv").val(data.header.id);
					$("#no_inv_old").val(data.header.no_invoice);
					$("#id_pl_sementara").val(data.header.id_perusahaan);
					load_sj() 
					
					$("#pajak").val(data.header.pajak).trigger('change');
					$("#bank").val(data.header.bank).trigger('change');
					$("#tgl_tempo").val(data.header.tgl_jatuh_tempo);
					$("#id_perusahaan").val(data.header.id_perusahaan);
					$("#kpd").val(data.header.kepada);
					$("#nm_perusahaan").val(data.header.nm_perusahaan);
					$("#alamat_perusahaan").val(data.header.alamat_perusahaan);

					if(data.header.pajak == 'ppn' || data.header.pajak == 'ppn_pph' )
					{
						$('#ppn_pilihan').show("1000");
						$("#inc_exc").val(data.header.inc_exc).trigger('change');
					}else{
						$('#ppn_pilihan').hide("1000");
					}
					
					const myArray    = data.header.no_invoice.split("/");
					var no_inv_kd    = myArray[0]+'/';
					var no_inv       = myArray[1];
					var no_inv_tgl   = '/'+myArray[2]+'/'+myArray[3];

					$("#no_inv_kd").val(no_inv_kd);
					$("#no_inv").val(no_inv);
					$("#no_inv_tgl").val(no_inv_tgl);
					
					$("#type_po").prop("disabled", true);
					$("#pajak").prop("disabled", true);
					// $("#inc_exc").prop("disabled", true);
					$("#id_pl").prop("disabled", true);
					$("#btn-search").prop("disabled", true);
					$("#cek_inv").prop("disabled", true);
					$("#tgl_sj").prop("readonly", true);

					
					$("#type_po2").val(data.header.type);
					$("#cek_inv2").val(data.header.cek_inv);
					$("#pajak2").val(data.header.pajak);

					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >NO SJ</th>
							<th style="text-align: center" >NO PO</th>
							<th style="text-align: center" >GSM</th>
							<th style="text-align: center" >ITEM</th>
							<th style="text-align: center; padding-right: 30px" >Exclude</th>
							<th style="text-align: center; padding-right: 30px" >Include</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding-right: 10px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding-right: 25px" >SESET</th>
							<th style="text-align: center; padding-right: 30px" >HASIL</th>
							<th style="text-align: center" >AKSI</th>
						</thead>`;

						var no = 1;
						$.each(data.detail, function(index, val) {
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
									</td>

								<td style="text-align: center" >${val.no_surat}
									<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
								</td>

								<td style="text-align: center" >${val.no_po}
									<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${val.no_po}">
								</td>

								<td style="text-align: center" >${val.g_label}
									<input type="hidden" id="g_label${no}" name="g_label[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.width}
									<input type="hidden" id="width${no}" name="width[${no}]" value="${val.width}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}">
								</td>
								
								<td style="text-align: center" >
									<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka_koma(val.include)}">
								</td>

								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									<input type="hidden" id="weight${no}" name="weight[${no}]"  value="${val.weight}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="seset[${no}]" id="seset${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.seset)}" >
								</td>

								<td style="text-align: center" >
									<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.hasil)}" readonly>
								</td>

								<td style="text-align: center" >
									<input type="checkbox" checked name="aksi[${no}]" id="aksi${no}" class="form-control" value="1" onchange="cek(this.value,this.id)" disabled>
								</td>
							</tbody>`;
							no ++;
						})
						list += `</table>`;
					}else{
						var list = `
						<table id="datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >NO SJ</th>
								<th style="text-align: center" >NO PO</th>
								<th style="text-align: center" >ITEM</th>
								<th style="text-align: center" >Ukuran</th>
								<th style="text-align: center" >Kualitas</th>
								<th style="text-align: center; padding-right: 35px" >Exclude</th>
								<th style="text-align: center; padding-right: 40px" >Include</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding-right: 35px">R. QTY</th>
								<th style="text-align: center; padding-right: 40px" >HASIL</th>
								<th style="text-align: center" >AKSI</th>
							</thead>`;
						var no             = 1;
						var berat_total    = 0;
						$.each(data.detail, function(index, val) {
							if(val.no_po_sj == null || val.no_po_sj == '')
							{
								no_po = val.no_po
							}else{
								no_po = val.no_po_sj
							}
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
								</td>

								<td style="text-align: center" >${val.no_surat}
									<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
								</td>

								<td style="text-align: center" >${no_po}
									<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
								</td>

								<td style="text-align: center" >${val.id_produk_simcorr} - ${val.nm_ker}
									<input type="hidden" name="item[${no}]" id="item${no}" value="${val.nm_ker}">
									<input type="hidden" id="id_produk_simcorr${no}" name="id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
								</td>

								<td style="text-align: center" >${val.g_label}
									<input type="hidden" id="ukuran${no}" name="ukuran[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.kualitas}
									<input type="hidden" id="kualitas${no}" name="kualitas[${no}]" value="${val.kualitas}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka_koma(val.include)}">
								</td>

								<td style="text-align: center" >${format_angka(val.qty)}
									<input type="hidden" id="qty${no}" name="qty[${no}]" onkeyup="ubah_angka(this.value,this.id)" value="${val.qty}">
								</td>
								
								<td style="text-align: center" >
									<input type="text" id="retur_qty${no}" name="retur_qty[${no}]" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >
									<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.hasil)}" readonly>
								</td>

								<td style="text-align: center" >
									<input type="checkbox" checked name="aksi[${no}]" id="aksi${no}" class="form-control" value="1" onchange="cek(this.value,this.id)" disabled>
								</td>
							</tbody>`;
							berat_total += parseInt(val.qty);
							no ++;
						})
						list += `<td style="text-align: center" colspan="8">TOTAL
								</td>
								<td style="text-align: center" >${format_angka(berat_total)}
								</td>
								<td style="text-align: center" colspan="3">&nbsp;
								</td>`;
						list += `</table>`;
						// $("#datatable_input").html(list);
					}
					
					$("#datatable_input").html(list);
					// swal.close();

				} else {

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

	// INVOICE EDIT END //

</script>
