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

	function btnPiuPO(i) {
		// $(".tr1").hide()
		$(".tr_i").hide()
		$(".i" + i).hide()
		$(".ab4").removeClass("btn-warning").addClass("btn-danger")
		$(".af4").removeClass("fa-minus").addClass("fa-plus")
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

</script>
