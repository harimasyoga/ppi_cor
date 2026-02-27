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

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		.day-of-week, .date-grid {
			display: grid;
			grid-template-columns: repeat(7, 1fr);
		}

		.btn2:focus, .btn2:active {
			background-color: transparent;
			outline: none;
			box-shadow: none;
		}

		.ds-link {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0
		}
	</style>
	
	<section class="content">
		<div class="container-fluid">
			<?php if(in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User'])) { ?>
				<div class="card">
					<div class="card-header" style="font-family:Cambria;">
						<h3 class="card-title" style="color:#4e73df;"><b>DELIVERY SYSTEM</b></h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body">
						<div class="card-body row" style="padding:12px 0 6px">
							<div class="col-md-12">
								<div class="tab_dev"></div>
								<div style="display:none" id="tampil-data"></div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-md-6">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">JADWAL PENGIRIMAN</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<div class="card-body row" style="padding:0 0 12px;font-weight:bold">
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="tahun" class="form-control select2" onchange="loadCalender('')">
										<?php 
											$thang = date("Y");
											$thang_maks = $thang + 1;
											$thang_min = $thang - 3;
											for ($th = $thang_min; $th <= $thang_maks; $th++)
											{ ?>
												<?php if ($th==$thang) { ?>
													<option selected value="<?= $th ?>"> <?= $thang ?> </option>
												<?php }else{ ?>
													<option value="<?= $th ?>"> <?= $th ?> </option>
												<?php }
											}
										?>
									</select>
								</div>
								<div class="col-md-3" style="padding-bottom:3px">
									<select id="bulan" class="form-control select2" onchange="loadCalender('')">
										<?php
											$month = strtoupper(date("F"));
											$bulan = [ '01' => "JANUARY", '02' => "FEBRUARY", '03' => "MARCH", '04' => "APRIL", '05' => "MAY", '06' => "JUNE", '07' => "JULY", '08' => "AUGUST", '09' => "SEPTEMBER", '10' => "OCTOBER", '11' => "NOVEMBER", '12' => "DECEMBER" ];
											foreach ($bulan as $no => $namaBulan) {
												($month == $namaBulan) ? $slt = 'selected' : $slt = '';
											?>
												<option value="<?= $no ?>" <?= $slt ?>><?= $namaBulan ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-7" style="padding-bottom:3px"></div>
							</div>
							<input type="hidden" id="h_tgl" value="">
							<div class="kalender"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6"></div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">RINCIAN PENGIRIMAN<span class="rinc-tgl" style="font-style:italic"></span></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<input type="hidden" id="r_tgl" value="">
							<div style="overflow:auto;white-space:nowrap">
								<div class="ds-kiriman">-</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("#tampil-rincian").html(``)
		$("#tampil-data").html(``)
		$('.select2').select2();
		list_dev()
	});

	function loadCalender(opsi) {
		let tgl = $("#h_tgl").val()
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		if(opsi == ''){
			$(".ds-kiriman").html('-')
			$(".rinc-tgl").html('')
		}
		$.ajax({
			url: '<?php echo base_url('Transaksi/loadCalender') ?>',
			data: ({ tgl, tahun, bulan }),
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
				data = JSON.parse(res)
				$(".kalender").html(data.html)
				$("#h_tgl").val('')
				swal.close()
			}
		})
	}

	function ccDevSys(tgl) {
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		$(".rinc-tgl").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/ccDevSys') ?>',
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
			data: ({ tgl, tahun, bulan }),
			success: function(res) {
				data = JSON.parse(res)
				$(".ds-kiriman").html(data.html)
				$(".rinc-tgl").html(data.tglRincian)
				$('.select2').select2()
				$("#h_tgl").val(tgl)
				$("#r_tgl").val(tgl)
				loadCalender('edit')
			}
		})
	}

	function dsUrut(id_dev) {
		let tgl = $("#r_tgl").val()
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		let urut = $("#ds-urut"+id_dev).val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/dsUrut') ?>',
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
			data: ({ id_dev, tgl, tahun, bulan, urut }),
			success: function(res) {
				data = JSON.parse(res)
				if(data.data){
					ccDevSys(tgl)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function plhEksDS(urut) {
		let tgl = $("#r_tgl").val()
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		let eks_ds = $("#eks_ds"+urut).val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/plhEksDS') ?>',
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
			data: ({ tgl, tahun, bulan, urut, eks_ds }),
			success: function(res) {
				data = JSON.parse(res)
				if(data.data){
					ccDevSys(tgl)
				}
			}
		})
	}

	function batalEksDS(urut) {
		let tgl = $("#r_tgl").val()
		let tahun = $("#tahun").val()
		let bulan = $("#bulan").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/batalEksDS') ?>',
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
			data: ({ tgl, tahun, bulan, urut }),
			success: function(res) {
				data = JSON.parse(res)
				if(data.data){
					ccDevSys(tgl)
				}
			}
		})
	}

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
				loadCalender('')
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
				loadCalender('')
			}
		})
	}
	
	function kembali_po()
	{
		$('.tab_dev').show("1000");
		$('#tampil-data').hide("1000");
		
	}

	function btnPiuPO(i, id_produk, id_pelanggan, sisa, sumkirim) {
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
		}
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
		$('#os_terplanning'+id).val(format_angka(os_plan));
	}

	// INVOICE ADD //
	function simpan(po_ok_id,id_produk,id_pelanggan,sts_input) 
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
		var eta                     = $("#eta_tiba"+po_ok_id).val()

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
			data: ({
				sts_input,po_ok_id,id_produk,id_pelanggan,qty_po,delivery,os,os_terplanning,os_belum_terplanning,qty_plan,eta
			}),
			dataType: "JSON",
			success: function(data) {
				if (data.status == '1') {
					swal.close();
					swal({
						title: "Data",
						html: "Berhasil Disimpan",
						type: "success"
					});
					Tampil_po(id_produk, id_pelanggan, data.produk.nm_produk)
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
					swal.close();
					swal({
						title: "Cek Kembali",
						html: data.msg,
						type: "error",
						confirmButtonText: "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
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

	function del_history(id) 
	{
		swal({
			title: "PO",
			html: "<p> Apakah Anda yakin ingin menghapus ini ?</p><br>",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?= base_url(); ?>Transaksi/hapusDelSys',
				data: ({ id }),
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
					Tampil_po(data.dev.id_produk, data.dev.id_pelanggan, data.nm_produk)
				}
			});
		});
	}

	function tglMuatEtaDSys(id_pelanggan, id){
		let eta_tiba = $('#eta_tiba'+id).val()
		$('.txt-eta-tiba'+id).html('-')
		$.ajax({
			url: '<?php echo base_url('Transaksi/tglMuatEtaDSys')?>',
			type: "POST",
			data: ({ id_pelanggan, eta_tiba }),
			success: function(res){
				data = JSON.parse(res)
				$('.txt-eta-tiba'+id).html(data.eta)
			}
		})
	}

</script>
