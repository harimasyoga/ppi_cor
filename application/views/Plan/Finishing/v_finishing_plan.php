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

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<?php if($this->session->userdata('level') == 'Admin' || $this->session->userdata('level') == 'PPIC') { ?>
				<!-- <div class="col-md-12">
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
				</div> -->
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN FLEXO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-12" style="padding:0">
								<a href="<?php echo base_url('Plan/Finishing')?>" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> <b>Kembali</b></a>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1"></div>
							<div class="col-md-11" style="font-size:small;font-style:italic;color:#f00">
								* [ TYPE ] NO. WO | TGL FLEXO | ITEM | CUSTOMER
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1 p-0">PLAN FLEXO</div>
							<div class="col-md-11">
								<select id="plan_flexo" class="form-control select2" onchange="plhPlanFlexo('')"></select>
							</div>
						</div>

						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">NO. WO</div>
							<div class="col-md-11">
								<input type="text" id="no_wo" class="form-control" placeholder="NO. WO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">NO. PO</div>
							<div class="col-md-11">
								<input type="text" id="no_po" class="form-control" placeholder="NO .PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-1 pr-0">CUSTOMER</div>
							<div class="col-md-11">
								<input type="text" id="customer" class="form-control" placeholder="CUSTOMER" disabled>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

				<!-- <div class="col-md-12">
					<div class="card">
						<div class="card-body p-0">
							<div id="accordion-flexo">
								<div class="card m-0" style="border-radius:0">
									<div class="card-header bg-gradient-secondary" style="padding:0;border-radius:0">
										<a class="d-block w-100 link-h-wo" style="font-weight:bold;padding:6px" data-toggle="collapse" href="#collapseflexo" onclick="loadDataAllPlanFlexo()">
											LIST SEMUA PLAN FLEXO
										</a>
									</div>
									<div id="collapseflexo" class="collapse" data-parent="#accordion-flexo">
										<div id="tampil-all-plan-flexo-header"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->

				<!-- <div class="col-md-12">
					<div id="list-plan-flexo"></div>
					<div id="riwayat-flexo"></div>
				</div> -->
				
				<div class="col-md-12">
					<div id="list-input-finishing"></div>
				</div>

				<div class="col-md-7">
					<!-- <div id="card-produksi">
						<div class="card card-danger card-outline" style="padding-bottom:20px">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">DOWNTIME</h3>
							</div>
							<div id="dt-pilih"></div>
							<div id="dt-select"></div>
							<div style="overflow:auto;white-space:nowrap">
								<div id="dt-load-data"></div>
							</div>
						</div>

						<div class="card card-success card-outline" style="padding-bottom:20px">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">HASIL PRODUKSI FLEXO</h3>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">GOOD COR.</div>
								<div class="col-md-10">
									<input type="number" id="good_cor" style="font-weight:bold" class="form-control" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">GOOD</div>
								<div class="col-md-10">
									<input type="number" id="good_flexo" class="form-control" onkeyup="hitungProduksiFlexo()">
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">R. FLEXO</div>
								<div class="col-md-10">
									<input type="number" id="bad_flexo" class="form-control" onkeyup="hitungProduksiFlexo()">
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">R. BAHAN</div>
								<div class="col-md-10">
									<input type="number" id="bad_b_flexo" class="form-control" onkeyup="hitungProduksiFlexo()">
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">TOTAL</div>
								<div class="col-md-10">
									<input type="number" id="total_flexo" class="form-control" onkeyup="hitungProduksiFlexo()" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">KET</div>
								<div class="col-md-10">
									<textarea id="ket_flexo" class="form-control" style="resize:none" rows="2"></textarea>
								</div>
							</div>
							<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
								<div class="col-md-2">TGL PROD.</div>
								<div class="col-md-10">
									<input type="date" id="tgl_flexo" class="form-control">
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">START</div>
								<div class="col-md-10">
									<input type="time" id="start_flexo" class="form-control">
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
								<div class="col-md-2">END</div>
								<div class="col-md-10">
									<input type="time" id="end_flexo" class="form-control">
								</div>
							</div>

							<?php if($this->session->userdata('level') == 'Admin' || $this->session->userdata('level') == 'PPIC' || $this->session->userdata('level') == 'Flexo') { ?>
								<div id="btn-aksi-produksi"></div>
							<?php } ?>
						</div>
					</div> -->

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
								<input type="text" id="creasing_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="text" id="creasing_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="text" id="creasing_3" class="form-control" autocomplete="off" placeholder="0" disabled>
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
				</div>

				<div class="col-md-5">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">FINISHING</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-10">
								<input type="date" id="tgl" class="form-control">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">SHIFT</div>
							<div class="col-md-10">
								<select id="shift" class="form-control select2"></select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">JOINT</div>
							<div class="col-md-10">
								<select id="joint" class="form-control select2"></select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2 p-0">PANJANG</div>
							<div class="col-md-4">
								<input type="text" id="panjang_plan" class="form-control" style="font-weight:bold;color:#f00" placeholder="PANJANG" disabled>
							</div>
							<div class="col-md-2 pr-0">LEBAR</div>
							<div class="col-md-4">
								<input type="text" id="lebar_plan" class="form-control" style="font-weight:bold;color:#f00" placeholder="LEBAR" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">ORDER</div>
							<div class="col-md-4">
								<input type="text" id="order_so" class="form-control" style="font-weight:bold" placeholder="ORDER" disabled>
							</div>
							<div class="col-md-2">KIRIM</div>
							<div class="col-md-4">
								<input type="text" id="kirim" class="form-control pr-0" placeholder="KIRIM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-12">KELUAR COR</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-4">
								<input type="text" id="tgl_cor" class="form-control pr-0" placeholder="TANGGAL" disabled>
							</div>
							<div class="col-md-2">QTY</div>
							<div class="col-md-4">
								<input type="text" id="qty_cor" class="form-control" placeholder="QTY COR" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-12">KELUAR FLEXO</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-4">
								<input type="text" id="tgl_flexo" class="form-control pr-0" placeholder="TANGGAL" disabled>
							</div>
							<div class="col-md-2">QTY</div>
							<div class="col-md-4">
								<input type="text" id="qty_flexo" class="form-control" placeholder="QTY FLEXO" disabled>
							</div>
						</div>

						<!-- <div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-12">
								<button type="button" class="btn btn-success btn-block" onclick="addRencanaFinishing()"><i class="fa fa-plus"></i> <b>ADD FINISHING</b></button>
							</div>
						</div> -->
					</div>
				</div>

				<input type="hidden" id="ehid_flexo" value="">

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
			<div class="modal-body" style="overflow:auto;white-space:nowrap"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const urlAuth = '<?= $this->session->userdata('level')?>'
	const urlTglFs = '<?= $tgl?>'
	const urlShiftFs = '<?= $shift?>'
	const urlJointFs = '<?= $joint?>'
	let inputDtProd = ''

	$(document).ready(function ()
	{
		$("#tgl").val(urlTglFs).prop('disabled', true)
		$("#shift").html(`<option value="${urlShiftFs}">${urlShiftFs}</option>`).prop('disabled', true)
		$("#joint").html(`<option value="${urlJointFs}">${urlJointFs}</option>`).prop('disabled', true)

		$("#plan_flexo").html('<option value="">PILIH</option>').prop("disabled", true)
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

</script>
