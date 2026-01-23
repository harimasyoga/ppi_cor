<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
			</div>
		</div>
	</section>
	
	<section class="content" style="padding-bottom:30px">
		
		<div class="card shadow list_piutang" >
			<div class="card-header" style="font-family:Cambria;">
				<h3 class="card-title" style="color:#4e73df;"><b>DELIVERY SYSTEM</b></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<!-- <div style="margin-bottom:12px">
					<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-arrow-left"></i> Kembali</b>
					</button>
				</div> -->
				<div class="card-body row" style="padding:12px 0 6px">
					<div class="col-md-12">
						<!-- <div style="overflow:auto;white-space:nowrap"> -->
							<div style="" class="tab_dev"></div>
							<div style="display:none" id="tampil-data"></div>
						<!-- </div> -->
					</div>
					<!-- <div class="col-md-6">
					</div> -->
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

<script type="text/javascript">
	$(document).ready(function () {
		$("#tampil-rincian").html(``)
		$("#tampil-data").html(``)
		$('.select2').select2();
		list_dev()
	});

	function list_dev() {
		$(".tab_dev").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/list_dev') ?>',
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
			success: function(res) {
				$(".tab_dev").html(res)
				swal.close()
			}
		})
	}

	function btnPiuSales(i) {
		$(".tr1").hide()
		$(".tr_l").hide()
		$(".tr_p").hide()
		$("#ts2").val("")
		$(".ab1").removeClass("btn-warning").addClass("btn-success")
		$(".af1").removeClass("fa-minus").addClass("fa-plus")
		$(".ab2").removeClass("btn-secondary").addClass("btn-info")
		$(".af2").removeClass("fa-minus").addClass("fa-plus")
		$(".ab3").removeClass("btn-secondary").addClass("btn-info")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		$(".ab4").removeClass("btn-secondary").addClass("btn-info")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
		$(".ab5").removeClass("btn-secondary").addClass("btn-info")
		$(".af5").removeClass("fa-minus").addClass("fa-plus")
		let ts1 = $("#ts1").val()
		if (parseInt(ts1) == parseInt(i)) {
			$("#ts1").val("")
		} else {
			$(".b1-" + i).removeClass("btn-success").addClass("btn-warning")
			$(".f1-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts1").val(i)
			$(".t" + i).show()
		}
	}

	function btnPiuCustomer(i) {
		// $(".tr1").hide()
		$(".tr_l").hide()
		$(".tr_p").hide()
		$("#ts5").val("")
		$("#ts3").val("")
		$(".ab2").removeClass("btn-warning").addClass("btn-info")
		$(".af2").removeClass("fa-minus").addClass("fa-plus")
		$(".ab3").removeClass("btn-secondary").addClass("btn-info")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		$(".ab4").removeClass("btn-secondary").addClass("btn-info")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
		$(".ab5").removeClass("btn-secondary").addClass("btn-info")
		$(".af5").removeClass("fa-minus").addClass("fa-plus")
		let ts2 = $("#ts2").val()
		if (parseInt(ts2) == parseInt(i)) {
			$("#ts2").val("")
		} else {
			$(".b2-" + i).removeClass("btn-info").addClass("btn-warning")
			$(".f2-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts2").val(i)
			$(".l" + i).show()
		}
	}

	function btnPiuLok(i) {
		// $(".tr1").hide()
		$(".tr_p").hide()
		$("#ts5").val("")
		$("#ts4").val("")
		$(".ab3").removeClass("btn-warning").addClass("btn-danger")
		$(".af3").removeClass("fa-minus").addClass("fa-plus")
		$(".ab4").removeClass("btn-secondary").addClass("btn-info")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
		$(".ab5").removeClass("btn-secondary").addClass("btn-info")
		$(".af5").removeClass("fa-minus").addClass("fa-plus")
		let ts3 = $("#ts3").val()
		if (parseInt(ts3) == parseInt(i)) {
			$("#ts3").val("")
		} else {
			$(".b3-" + i).removeClass("btn-danger").addClass("btn-warning")
			$(".f3-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts3").val(i)
			$(".p" + i).show()
		}
	}

	function btnPiuITEM(i) {
		// $(".tr1").hide()
		$("#ts5").val("")
		$(".ab4").removeClass("btn-warning").addClass("btn-danger")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
		$(".ab5").removeClass("btn-secondary").addClass("btn-info")
		$(".af5").removeClass("fa-minus").addClass("fa-plus")
		let ts4 = $("#ts4").val()
		if (parseInt(ts4) == parseInt(i)) {
			$("#ts4").val("")
		} else {
			$(".b4-" + i).removeClass("btn-danger").addClass("btn-warning")
			$(".f4-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts4").val(i)
			$(".i" + i).show()
		}
	}

	function Tampil_po(id_produk, id_pelanggan, nm_produk)
	{
		$('.tab_dev').hide("1000");
		$('#tampil-data').show("1000");
		$.ajax({
			url: '<?php echo base_url('Transaksi/TampilPO_dev')?>',
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
				id_pelanggan, id_produk, nm_produk
			}),
			success: function(res){
				$("#tampil-data").html(res)
				swal.close()
			}
		})
	}
	
	function close_po()
	{
		$('.tab_dev').show("1000");
		$('#tampil-data').hide("1000");
		
	}

	function btnPiuPO(i,id_produk,id_pelanggan,sisa,sumkirim) {
		// $(".tr1").hide()
		$(".tr_i").hide()
		$(".i" + i).hide()
		$(".ab4").removeClass("btn-warning").addClass("btn-danger")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
		let ts4 = $("#ts4").val()
		if (parseInt(ts4) == parseInt(i)) {
			$("#ts4").val("")
			$("#i"+i).html(``)
		} else {
			$(".b4-" + i).removeClass("btn-danger").addClass("btn-warning")
			$(".f4-" + i).removeClass("fa-plus").addClass("fa-minus")
			$("#ts4").val(i)
			$(".i" + i).show()
			// tampil_data(i,id_produk,id_pelanggan,sisa,sumkirim)
		}
	}

	function tampil_data(i,id_produk,id_pelanggan,sisa,sumkirim)
	{
		$.ajax({
			url: '<?= base_url(); ?>Transaksi/load_det_dat',
			type: "POST",
			data: {
				id: i,
				id_produk: id_produk,
				id_pelanggan: id_pelanggan
			},
			dataType: "JSON",
			// beforeSend: function() {
			// 	swal({
			// 		title: 'loading data...',
			// 		allowEscapeKey: false,
			// 		allowOutsideClick: false,
			// 		onOpen: () => {
			// 			swal.showLoading();
			// 		}
			// 	})
			// },
			success: function(data) {
				if (data) {

					$("#plan_os"+i).html(`
						<tr>
							<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;">QTY PO</th>
							<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;">DELIVERY</th>
							<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;">OS</th>
							<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;" rowspan="2" >
							
								<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Simpan</b>
								</button>
							</th>
						</tr>

						<tr>
							<td style="padding:5px;border:1px solid #aaa">${data.header.qty}</td>
							<td style="padding:5px;border:1px solid #aaa">${format_angka(sumkirim)}</td>
							<td style="padding:5px;border:1px solid #aaa">${format_angka(sisa)}</td>
						</tr>
						<tr>
							<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#ff0000ff;">OS TERPLANNING</th>
							<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#ff0000ff;">OS BELUM TERPLANNING</th>
							<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#007bffff;">QTY PLAN DELIVERY</th>
							<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#007bffff;">ETA</th>
						</tr>
						
						<tr>
							<td id="os_terplanning" name="os_terplanning" style="padding:5px;text-align:center;border:1px solid #aaa"></td>
							<td style="padding:5px;text-align:center;border:1px solid #aaa;" value="${format_angka(sisa)}">${format_angka(sisa)}</td>
							<td style="padding:5px;text-align:center;border:1px solid #aaa;">
							<input type="number" id="qty_plan" autocomplete="off" onkeyup="hitung_os_plan(this.value,${sisa})">
							</td>
							<td style="padding:5px;text-align:center;border:1px solid #aaa;text-align:center">
								<input type="date" id="eta" autocomplete="off" >
							</td>
						</tr>
						
					`)
				} else {

					swal({
						title: "Cek Kembali",
						html: "Gagal Simpan",
						type: "error",
						confirmButtonText: "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');

				swal({
					title: "Cek Kembali",
					html: "Terjadi Kesalahan",
					type: "error",
					confirmButtonText: "OK"
				});

				return;
			}
		});
		
			
	}

	function hitung_os_plan(val,id,sisa,id) 
	{
		// pastikan string, hilangkan titik pemisah ribuan
		sisa = sisa.toString().replace(/\./g, '');
		val  = val.toString().replace(/\./g, '');

		// konversi ke number
		sisa = Number(sisa);
		val  = Number(val);

		if (isNaN(sisa) || isNaN(val)) {
			$('#os_terplanning'+id).val('');
			return;
		}

		let os_plan = sisa - val;

		if (os_plan < 0) os_plan = 0;
// alert(os_plan)
		$('#os_terplanning'+id).val(format_angka(os_plan));

	}

	// INVOICE ADD //
	function simpan(po_ok_id,sts_input) 
	{               
				
		swal({
			title: 'loading ...',
			allowEscapeKey: false,
			allowOutsideClick: false,
			onOpen: () => {
				swal.showLoading();
			}
		})

		var qty_po                  = $("#qty_po"+po_ok_id).val().split('.').join('')
		var delivery                = $("#delivery"+po_ok_id).val().split('.').join('')
		var os                      = $("#os"+po_ok_id).val().split('.').join('')
		var os_terplanning          = $("#os_terplanning"+po_ok_id).val().split('.').join('')
		var os_belum_terplanning    = $("#os_belum_terplanning"+po_ok_id).val().split('.').join('')
		var qty_plan                = $("#qty_plan"+po_ok_id).val().split('.').join('')
		var eta                     = $("#eta"+po_ok_id).val().split('.').join('')

		if (qty_po == ''|| delivery == ''|| os == ''|| os_terplanning == ''|| os_belum_terplanning == ''|| qty_plan == ''|| eta == '') {
			swal.close();
			swal({
				title: "Cek Kembali",
				html: "Harap Lengkapi Form Dahulu",
				type: "info",
				confirmButtonText: "OK"
			});
			return;
		}

		$.ajax({
			url: '<?= base_url(); ?>Transaksi/Insert_dev_sys',
			type: "POST",
			// data: $('#myForm').serialize(),
			data: ({
				sts_input,qty_po,delivery,os,os_terplanning,os_belum_terplanning,qty_plan,eta
			}),
			dataType: "JSON",
			success: function(data) {
				if (data.status == '1') {
					// toastr.success('Berhasil Disimpan');
					swal.close();
					swal({
						title: "Data",
						html: "Berhasil Disimpan",
						type: "success"
						// confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url() ?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";
					// location.href = "<?= base_url() ?>Logistik/Invoice";
					kembaliList();
					kosong();

				} else if (data.status == '3') {
					swal.close();
					swal({
						title: "CEK KEMBALI",
						html: "<p><strong>Nomor Invoice</strong></p>" +
							"Sudah di Gunakan",
						type: "error",
						confirmButtonText: "OK"
					});
					return;
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title: "Cek Kembali",
						// html: "Gagal Simpan",
						html: data.msg,
						type: "error",
						confirmButtonText: "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');

				swal.close();
				swal({
					title: "Cek Kembali",
					html: "Terjadi Kesalahan",
					type: "error",
					confirmButtonText: "OK"
				});

				return;
			}
		});

	}

</script>
