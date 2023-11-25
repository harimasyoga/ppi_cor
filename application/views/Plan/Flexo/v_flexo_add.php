<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<!-- <h1><b>Data Plan</b></h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<!-- <li class="breadcrumb-item active" ><a href="#">Flexo</a></li> -->
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body p-0">
							<div id="accordion-customer">
								<div class="card m-0" style="border-radius:0">
									<div class="card-header bg-gradient-secondary" style="padding:0;border-radius:0">
										<a class="d-block w-100 link-h-wo" style="font-weight:bold;padding:6px" data-toggle="collapse" href="#collapseCustomer" onclick="loadDataAllPlanCor()">
											LIST SEMUA PLAN COR
										</a>
									</div>
									<div id="collapseCustomer" class="collapse" data-parent="#accordion-customer">
										<div id="tampil-all-plan-header"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN CORR</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-12" style="padding:0">
								<a href="<?php echo base_url('Plan/Flexo')?>" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> <b>Kembali</b></a>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1"></div>
							<div class="col-md-11" style="font-size:small;font-style:italic;color:#f00">
								* [ TYPE ] NO. WO | TGL PLAN | ITEM | CUSTOMER
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-1">PLAN COR</div>
							<div class="col-md-11">
								<select id="plan_cor" class="form-control select2" onchange="plhPlanCor()"></select>
							</div>
						</div>
					</div>
				</div>

				<div id="riwayat-plan-cor"></div>

				<div id="riwayat-plan-flexo"></div>

				<div class="col-md-7">
					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">ITEM</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">KODE MC</div>
							<div class="col-md-10">
								<input type="text" id="kode_mc" class="form-control" autocomplete="off" placeholder="KODE MC" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">ITEM</div>
							<div class="col-md-10">
								<input type="text" id="item" class="form-control" autocomplete="off" placeholder="NAMA ITEM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">UK. BOX</div>
							<div class="col-md-10">
								<input type="text" id="uk_box" class="form-control" autocomplete="off" placeholder="UKURAN BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">UK. SHEET</div>
							<div class="col-md-10">
								<input type="text" id="uk_sheet" class="form-control" autocomplete="off" placeholder="UKURAN SHEET" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
							<div class="col-md-2">CREASING</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_3" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-1" style="padding:0"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KUALITAS</div>
							<div class="col-md-10">
								<input type="text" id="kualitas" class="form-control" autocomplete="off" placeholder="KUALITAS" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">FLUTE</div>
							<div class="col-md-10">
								<input type="text" id="flute" class="form-control" autocomplete="off" placeholder="FLUTE" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TIPE BOX</div>
							<div class="col-md-10">
								<input type="text" id="tipe_box" class="form-control" autocomplete="off" placeholder="TIPE BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">SAMBUNGAN</div>
							<div class="col-md-10">
								<input type="text" id="sambungan" class="form-control" autocomplete="off" placeholder="SAMBUNGAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">BB</div>
							<div class="col-md-10">
								<input type="text" id="bb_box" class="form-control" autocomplete="off" placeholder="BERAT BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">LB</div>
							<div class="col-md-10">
								<input type="text" id="lb_box" class="form-control" autocomplete="off" placeholder="LUAS BOX" disabled>
							</div>
						</div>
					</div>

					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2" style="padding-right: 0;">CUSTOMER</div>
							<div class="col-md-10">
								<input type="text" id="customer" class="form-control" autocomplete="off" placeholder="CUSTOMER" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right: 0;">SALES</div>
							<div class="col-md-10">
								<input type="text" id="sales" class="form-control" autocomplete="off" placeholder="SALES" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2" style="padding-right: 0;">ALAMAT</div>
							<div class="col-md-10">
								<textarea id="alamat" class="form-control" rows="2" style="resize:none" placeholder="ALAMAT" disabled></textarea>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TGL. PO</div>
							<div class="col-md-10">
								<input type="text" id="tgl_po" class="form-control" autocomplete="off" placeholder="TANGGAL PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NO. PO</div>
							<div class="col-md-10">
								<input type="text" id="no_po" class="form-control" autocomplete="off" placeholder="NO. PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KODE PO</div>
							<div class="col-md-10">
								<input type="text" id="kode_po" class="form-control" autocomplete="off" placeholder="KODE PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">QTY PO</div>
							<div class="col-md-10">
								<input type="text" id="qty_po" class="form-control" autocomplete="off" placeholder="QTY PO" disabled>
							</div>
						</div>
					</div>

					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">SO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">ETA. SO</div>
							<div class="col-md-10">
								<input type="text" id="eta_so" class="form-control" autocomplete="off" placeholder="ETA. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NO. SO</div>
							<div class="col-md-10">
								<input type="text" id="no_so" class="form-control" autocomplete="off" placeholder="NO. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">QTY SO</div>
							<div class="col-md-10">
								<input type="number" id="qty_so" class="form-control" autocomplete="off" placeholder="QTY SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">RM</div>
							<div class="col-md-10">
								<input type="number" id="rm_so" class="form-control" autocomplete="off" placeholder="RM SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TONASE</div>
							<div class="col-md-10">
								<input type="number" id="ton_so" class="form-control" autocomplete="off" placeholder="TONASE SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KET</div>
							<div class="col-md-10">
								<textarea class="form-control" id="ket_so" rows="2" style="resize:none" placeholder="KETERANGAN SO" disabled></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">FLEXO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-10">
								<input type="date" id="tgl" class="form-control" onchange="plhShiftMesin()">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">SHIFT</div>
							<div class="col-md-10">
								<select id="shift" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">MESIN</div>
							<div class="col-md-10">
								<select id="mesin" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="FLEXO1">FLEXO 1</option>
									<option value="FLEXO2">FLEXO 2</option>
									<option value="FLEXO2">FLEXO 3</option>
									<option value="FLEXO2">FLEXO 4</option>
								</select>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function ()
	{
		$("#plan_cor").html('<option value="">PILIH</option>').prop("disabled", true)
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function loadDataAllPlanCor()
	{
		$.ajax({
			url: '<?php echo base_url('Plan/loadDataAllPlanCor')?>',
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
			success: function(res){
				$("#tampil-all-plan-header").html(res)
				swal.close()
			}
		})
	}

	function onClickHeaderPlanCor(next_flexo)
	{
		$.ajax({
			url: '<?php echo base_url('Plan/onClickHeaderPlanCor')?>',
			type: "POST",
			data: ({
				next_flexo
			}),
			success: function(res){
				$("#tampil-all-flexo-isi-"+next_flexo).html(res)
			}
		})
	}

	function plhShiftMesin()
	{
		let tgl = $("#tgl").val()
		let shift = $("#shift").val()
		let mesin = $("#mesin").val()
		if(tgl == "" || shift == "" || mesin == ""){
			$("#plan_cor").html('<option value="">PILIH</option>').prop("disabled", true)
		}else{
			$("#tgl").html(`<option value="${tgl}">${tgl}</option>`).prop('disabled', true)
			$("#shift").html(`<option value="${shift}">${shift}</option>`).prop('disabled', true)
			$("#mesin").html(`<option value="${mesin}">${mesin}</option>`).prop('disabled', true)
			loadPlanCor('')
		}
	}

	function loadPlanCor(opsi)
	{
		let mesin = $("#mesin").val()
		$.ajax({
			url: '<?php echo base_url('Plan/loadPlanCor')?>',
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
				mesin
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				let htmlPlanCor = ''
				let kategori = ''
					htmlPlanCor += `<option value="">PILIH</option>`
				data.plan_cor.forEach(laodPlanCor);
				function laodPlanCor(r, index) {
					(r.kategori == 'K_BOX') ? kategori = '[ BOX ]' : kategori = '[ SHEET ]';
					htmlPlanCor += `<option value=""
						nm_produk
						eta_so
						nm_pelanggan
						id_plan
						no_urut_plan
						id_so_detail
						id_wo
						id_produk
						id_pelanggan
						no_plan
						tgl_plan
						tgl_kirim_plan
						shift_plan
						machine_plan
						no_wo
						no_so
						panjang_plan
						lebar_plan
						out_plan
						lebar_roll_p
						material_plan
						kualitas_plan
						kualitas_isi_plan
						pcs_plan
						good_cor_p
						bad_cor_p
						total_cor_p
						trim_plan
						c_off_p
						rm_plan
						tonase_plan
						next_plan
						ket_plan
						status_plan
						start_time_p
						end_time_p
					>
						${kategori} ${r.no_wo} | ${r.tgl_plan} | ${r.nm_produk} | ${r.nm_pelanggan}
					</option>`
				}
				$("#plan_cor").html(htmlPlanCor).prop('disabled', false)
				swal.close()
			}
		})
	}

	function plhPlanCor()
	{
		//
	}

</script>
