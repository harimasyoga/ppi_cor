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

	<style>
		.bg-expired {
			position: relative;
		}

		.bg-expired::before {
			content: "";
			position: absolute;
			top: -12px;
			right: -12px;
			bottom: -12px;
			left: -12px;
			background: #f00;
			opacity: 0.2;
		}
	</style>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT INVOICE</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
		
			<form role="form" method="post" id="myForm">
				<div class="card-body">
					<div class="col-md-12">
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">Status Invoice</div>
							<div class="col-md-3">
								<select id="cek_inv" name="cek_inv" class="form-control select2" style="width: 100%" onchange="cek_invoice()">
									<option value="baru">BARU</option>
									<option value="revisi">REVISI</option>
								</select>
								<input type="hidden" name="cek_inv2" id="cek_inv2">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Type</div>
							<div class="col-md-3">
								
								<input type="hidden" name="sts_input" id="sts_input">
								<input type="hidden" name="jenis" id="jenis" value="invoice">
								<input type="hidden" class="form-control" value="Add" name="status" id="status">
								<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="roll">Roll</option>
									<option value="sheet">Sheet</option>
									<option value="box">Box</option>
								</select>
								<input type="hidden" name="type_po2" id="type_po2">
							</div>

						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">Tanggal Invoice</div>
							<div class="col-md-3">
								<input type="date" id="tgl_inv" name="tgl_inv" class="form-control" autocomplete="off" placeholder="Tanggal Invoice" onchange="noinv(),no_inv2()">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Pajak</div>
							<div class="col-md-3">
								<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="ppn">PPN 11%</option>
									<option value="ppn_pph">PPN 11% + PPH22</option>
									<option value="nonppn">NON PPN</option>
								</select>
								<input type="hidden" name="pajak2" id="pajak2">
							</div>

						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="ppn_pilihan">						
							<div class="col-md-2">Incl / Excl</div>
							<div class="col-md-9">
								<select id="inc_exc" name="inc_exc" class="form-control select2" style="width: 100%" >
									<option value="Include">Include</option>
									<option value="Exclude">Exclude</option>
									<option value="nonppn_inc">Non PPN</option>
								</select>
							</div>
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">Tanggal SJ</div>
							<div class="col-md-3">
								<input type="date" id="tgl_sj" name="tgl_sj" class="form-control" autocomplete="off" placeholder="Tanggal Surat Jalan" >
								<input type="hidden" name="id_pl_sementara" id="id_pl_sementara" value="">
							</div>
							<div class="col-md-1"></div>

							<div class="col-md-2">Tanggal Jatuh Tempo</div>
							<div class="col-md-3">
								<input type="date" id="tgl_tempo" name="tgl_tempo" class="form-control" autocomplete="off" placeholder="Jatuh Tempo" >
							</div>

						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">Customer</div>
							<div class="col-md-8">
								<select class="form-control select2" id="id_pl" name="id_pl" style="width: 100%" autocomplete="off" onchange="load_cs()" disabled>
								</select>
							</div>
							
							<div class="col-md-1">
								<button type="button" class="btn btn-primary" id="btn-search" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
							</div>
							
							
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">No Invoice</div>
							<div class="col-md-1">
								<input type="hidden" id="id_inv" name="id_inv" class="input-border-none" autocomplete="off"  readonly>
								<input type="hidden" id="no_inv_old" name="no_inv_old" class="input-border-none" autocomplete="off"  readonly>
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;" type="text" id="no_inv_kd" name="no_inv_kd" class="input-border-none" autocomplete="off"  readonly>
							</div>
							<div class="col-md-1">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv" name="no_inv" class="input-border-none" autocomplete="off" oninput="this.value = this.value.toUpperCase(), this.value = this.value.trim(); " readonly>
							</div>
							<div class="col-md-3">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv_tgl" name="no_inv_tgl" class="input-border-none" autocomplete="off" readonly>
							</div>
							
							<div class="col-md-4"></div>
							
						</div>


							<hr>
							<div class="card-body row" style="padding:0 20px;font-weight:bold">
								<div class="col-md-12" style="font-family:Cambria;color:#4e73df;font-size:25px"><b>DIKIRIM KE</b></div>
							</div>
							<hr>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Kepada</div>
								<div class="col-md-10">
									<input type="hidden" id="id_perusahaan" name="id_perusahaan" >

									<input type="text" id="kpd" name="kpd" class="form-control" autocomplete="off" placeholder="Kepada" >
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Nama Perusahaan</div>
								<div class="col-md-10">
									<input type="text" id="nm_perusahaan" name="nm_perusahaan" class="form-control" autocomplete="off" placeholder="Nama Perusahaan" >
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">Alamat Perusahaan</div>
								<div class="col-md-10">
									<textarea class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" cols="30" rows="5" placeholder="Alamat Perusahaan" ></textarea>
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Pilihan Bank</div>
								<div class="col-md-10">
									<select class="form-control select2" id="bank" name="bank" style="width: 100%" autocomplete="off">
										<!-- <option value="BCA_AKB">BCA AKB</option>
										<option value="BCA_SSB">BCA SSB</option>
										<option value="BCA_KSM">BCA KSM</option>
										<option value="BCA_GMB">BCA GMB</option>
										<option value="BCA">BCA</option>
										<option value="BNI">BNI</option> -->
									</select>
								</div>
							</div>
							<hr>
							<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">List Item</div>
								<div class="col-md-10">&nbsp;
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">		
								<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
									<table id="datatable_input" class="table table-hover table- table-bordered table-condensed table-scrollable">
										
									</table>
								</div>
							</div>						
						
					</div>
				</div>
				<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
					<div class="col-md-12">
						<!-- <a href="<?= base_url('Logistik/Invoice')?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i> <b>Kembali</b></a> -->

						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-arrow-left" ></i> Kembali</b>
						</button>
						
						<button type="button" class="btn btn-sm btn-primary" id="btn-simpan" ><i class="fas fa-save"></i><b> Simpan</b></button>
					</div>
				</div>
				<br>
				<br>
			</form>	
		</div>
		<!-- /.card -->
	</section>
	
	<section class="content">

		<!-- Default box -->
		<div class="card shadow list_lap" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>LAPORAN INVOICE</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>

			<div class="card shadow mb-3">
				<div class="card-body">
					<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'Keuangan1'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-arrow-left" ></i> Kembali</b>
							</button>
						</div>
					<?php } ?>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">TYPE</div>
						<div class="col-md-3">
							<select id="pilih_type" class="form-control select2" style="font-weight:bold" onchange="cek_type()" >
								<option value="box">BOX / SHEET</option>
								<option value="roll">ROLL</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold" id="list_attn" >						
						<div class="col-md-2">ATTN</div>
						<div class="col-md-3">
							<select id="byr_attn" class="form-control select2">
								<?php
									$html ='';
									$query = $this->db->query("SELECT*FROM m_hub where jns='BOX' ORDER BY id_hub");
									$html .='<option value="">SEMUA</option>';
									foreach($query->result() as $r){
										$html .='<option value="'.$r->id_hub.'">'.$r->nm_hub.'</option>';
									}
									echo $html;
								?>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold" id="list_cust">						
						
						<div class="col-md-2">CUSTOMER</div>
						<div class="col-md-3">
							<select id="plh_cust" class="form-control select2">
								<?php
									$query = $this->db->query("SELECT c.id_pelanggan,d.nm_pelanggan,d.attn
									from invoice_header a 
									join invoice_detail b on a.no_invoice=b.no_invoice
									join trs_po c on b.no_po=c.kode_po
									join m_pelanggan d on c.id_pelanggan=d.id_pelanggan
									group by c.id_pelanggan,d.nm_pelanggan
									order by d.nm_pelanggan");

									$html4 ='';
									$html4 .='<option value="" attn="">SEMUA</option>';
									foreach($query->result() as $r)
									{
										if($r->attn=='-')
										{
											$html4 .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.'</option>';
										}else{
											$html4 .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.' - '.$r->attn.'</option>';
										}
										
									}
									echo $html4;
								?>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">PEMBAYARAN</div>
						<div class="col-md-3">
							<select id="plh_bayar" class="form-control select2">
								<option value="">SEMUA</option>
								<option value="BELUM BAYAR">BELUM BAYAR</option>
								<option value="NYICIL">NYICIL</option>
								<option value="LUNAS">LUNAS</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">PERIODE</div>
						<div class="col-md-3">
							<select class="form-control select2" name="priode" id="priode" style="width: 100%;" onchange="cek_periode()">
								<option value="bln_ini">BULAN INI</option>
								<option value="custom">Custom</option>
								<option value="all">ALL</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="list_tgl">						
						<div class="col-md-2">TGL INV</div>
						<div class="col-md-3">
							<input type="date" id="tgl1_inv" class="form-control" value="<?= date("Y-m-d")?>">
						</div>
						<div class="col-md-1">S/D</div>
						<div class="col-md-3">
							<input type="date" id="tgl2_inv" class="form-control" value="<?= date("Y-m-d")?>">
						</div>
						<div class="col-md-2"></div>
					</div>
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold;" >
						<div class="col-md-2">
							<button type="button" class="btn btn-primary" onclick="tampil_data_inv('laporan')"><i class="fas fa-search"></i></button>
						</div>
						
						<div class="col-md-9"></div>
					</div>

					<div style="overflow:auto;white-space:nowrap">
						<div id="tampil_lap_inv"></div>
					</div>
				</div>
			</div>
		
		</div>
		<!-- /.card -->
	</section>

	<section class="content">
		<div class="card shadow list_sj" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>LIST SURAT JALAN</b></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card shadow mb-3">
				<div class="card-body">
					<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'Keuangan1','Owner'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-arrow-left" ></i> Kembali</b>
							</button>
						</div>
					<?php } ?>
					<div class="card-body row" style="font-weight:bold;padding:12px 6px 6px">
						<div class="col-md-2">TAHUN</div>
						<div class="col-md-2">
							<select class="form-control select2" id="ll_tahun" onchange="listNomerSJ()">
								<?php 
								$thang = date("Y");
								$thang_maks = $thang + 2;
								$thang_min = $thang - 2;
								for ($th = $thang_min; $th <= $thang_maks; $th++)
								{ ?>
									<?php if ($th==$thang) { ?>
										<option selected value="<?= $th ?>"> <?= $thang ?> </option>
									<?php }else{ ?>
										<option value="<?= $th ?>"> <?= $th ?> </option>
									<?php }
								} ?>
							</select>
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
						<div class="col-md-2">PILIH</div>
						<div class="col-md-2">
							<select class="form-control select2" id="ll_pilih" onchange="listNomerSJ()">
								<option selected value="BOX">BOX</option>
								<option value="ROLL">ROLL</option>
							</select>
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
						<div class="col-md-2">PAJAK</div>
						<div class="col-md-2">
							<select class="form-control select2" id="ll_pajak" onchange="listNomerSJ()">
								<option selected value="ppn">PPN</option>
								<option value="non">NON PPN</option>
							</select>
						</div>
						<div class="col-md-8"></div>
					</div>
					<div class="card-body row" style="padding:0 6px 6px">
						<div class="col-md-12">
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="width:5%;padding:12px;text-align:center">NO.</th>
											<th style="width:8%;padding:12px;text-align:center">HARI, TGL</th>
											<th style="width:16%;padding:12px;text-align:center">NO. SJ</th>
											<th style="width:16%;padding:12px;text-align:center">NO. PO</th>
											<th style="width:31%;padding:12px;text-align:center">CUSTOMER</th>
											<th style="width:8%;padding:12px;text-align:center">PLAT</th>
											<th style="width:8%;padding:12px;text-align:center">EKSPEDISI</th>
											<th style="width:8%;padding:12px;text-align:center">SJ BALIK</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card shadow list_exp" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>LAPORAN EXPIRED</b></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card shadow mb-3">
				<div class="card-body">
					<div style="margin-bottom:12px">
						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-arrow-left" ></i> Kembali</b>
						</button>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:12px 0 6px">
						<div class="col-md-2">PILIH</div>
						<div class="col-md-3">
							<select id="ex_pilih" class="form-control select2" onchange="exPilih()">
								<option value="">PILIH</option>
								<option value="TANGGAL">TANGGAL</option>
								<option value="BULAN">BULAN</option>
								<option value="SEMUA">SEMUA</option>
							</select>
						</div>
						<div class="col-md-7"></div>
					</div>
					<div class="ex-tmpl"></div>
					<div class="card-body row" style="font-weight:bold;padding:12px 0 6px">
						<div class="col-md-12">
							<div style="overflow:auto;white-space:nowrap">
								<div class="tab_expired"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</div>
	</section>

	<!-- Main content -->
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

					<div class="card-body" style="padding:12px 6px">
						<?php if(in_array($this->session->userdata('username'), ['karina', 'tegar', 'developer'])){ ?>
							<div style="margin-bottom:12px">
								<button type="button" class="btn btn-dark btn-sm" onclick="updateExpired()" title="UPDATE EXPIRED"><i class="fas fa-sync-alt"></i></button>
								<button type="button" class="btn btn-info btn-sm" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								<button type="button" class="btn btn-danger btn-sm" onclick="open_laporan()"><i class="fa fa-print"></i> <b>Laporan</b></button>
								<button type="button" class="btn btn-secondary btn-sm" onclick="open_sj()"><i class="fas fa-list"></i> <b>List SJ</b></button>
								<?php if (in_array($this->session->userdata('level'), ['Admin'])) { ?>
									<button type="button" class="btn btn-danger btn-sm" onclick="open_lapExp()"><i class="fa fa-print"></i> <b>Lap Expired</b></button>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if (in_array($this->session->userdata('username'), ['owner'])) { ?>
							<button type="button" class="btn btn-secondary btn-sm" onclick="open_sj()"><i class="fas fa-list"></i> <b>List SJ</b></button>
						<?php } ?>

						<div class="card-body row" style="padding:0 0 8px;font-weight:bold">
							<div class="col-md-2" style="padding-bottom:3px">
								<select class="form-control select2" id="rentang_thn" name="rentang_thn" onchange="load_data()">
									<?php 
										$thang        = date("Y");
										$thang_maks   = $thang + 3 ;
										$thang_min    = $thang - 3 ;
										for ($th=$thang_min ; $th<=$thang_maks ; $th++) { ?>
											<?php if($th == $thang) { ?>
												<option selected value="<?= $th ?>"> <?= $thang ?> </option>
											<?php }else{ ?>
												<option value="<?= $th ?>"> <?= $th ?> </option>
											<?php } ?>
									<?php } ?>
							</select>
							</div>
							<div class="col-md-2" style="padding-bottom:3px">
								<?php 
									$qbulan    = $this->db->query("SELECT*FROM m_bulan");
									$bln_now   = date("m");
								?>
									<select id="rentang_bulan" class="form-control select2" onchange="load_data()"> 
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
							<div class="col-md-2" style="padding-bottom:3px">
								<select id="type_inv" class="form-control select2" onchange="load_data()"> 
									<option value="all">-- SEMUA --</option>
									<option value="box">BOX</option>
									<option value="roll">ROLL</option>
								</select>
							</div>
							<div class="col-md-2" style="padding-bottom:3px">
								<select id="exp_pilih" class="form-control select2" onchange="load_data()"> 
									<option value="all">-- CEK --</option>
									<option value="exp_bc">EXPIRED BC</option>
									<option value="exp_faktur">EXPIRED FAKTUR</option>
									<option value="exp_resi">EXPIRED RESI</option>
									<option value="exp_inv_terima">EXPIRED INV TERIMA</option>
									<option value="exp_sj_balik">EXPIRED SJ BALIK</option>
									<option value="exp_mutasi">EXPIRED MUTASI</option>
									<option value="exp_not">EXPIRED TIDAK ADA</option>
								</select>
							</div>
							<div class="col-md-4" style="padding-bottom:3px">
							</div>
						</div>
						<div style="overflow:auto;white-space:nowrap">
							<table id="datatable" class="table table-bordered table-striped">
								<thead class="color-tabel">
									<tr>
										<th style="padding:12px;text-align:center">#</th>
										<th style="padding:12px;text-align:center">NO. PO</th>
										<th style="padding:12px;text-align:center">TGL</th>
										<th style="padding:12px;text-align:center">JT. TEMPO</th>
										<th style="padding:12px;text-align:center">TOTAL</th>
										<th style="padding:12px;text-align:center">PEMBAYARAN</th>
										<th style="padding:12px;text-align:center">MKT</th>
										<th style="padding:12px;text-align:center">OWNER</th>
										<th style="padding:12px;text-align:center">AKSI</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL box -->
	<div class="modal fade" id="modalForm">
		<div class="modal-dialog modal-full">
			<div class="modal-content">

				<div class="card-header" style="font-family:Cambria;" >
					<h4 class="card-title" style="color:#4e73df;" id="judul"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						<div class="card-body">
							<div class="col-md-12">
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									<div class="col-md-2">Status Invoice</div>
									<div class="col-md-3">
										<select id="modal_cek_inv" name="modal_cek_inv" class="form-control select2" style="width: 100%">
											<option value="baru">BARU</option>
											<option value="revisi">REVISI</option>
										</select>
										<input type="hidden" name="modal_cek_inv2" id="modal_cek_inv2">
									</div>
									<div class="col-md-1"></div>
									<div class="col-md-2">Type</div>
									<div class="col-md-3">
										<input type="hidden" name="modal_jenis" id="modal_jenis" value="invoice">

										<input type="hidden" class="form-control" value="Add" name="modal_status" id="modal_status">

										<input type="hidden" class="form-control" name="modal_id_header" id="modal_id_header">

										<select name="modal_type_po" id="modal_type_po" class="form-control select2" style="width: 100%" >
																	
											<option value="">-- PILIH --</option>
											<option value="roll">Roll</option>
											<option value="sheet">Sheet</option>
											<option value="box">Box</option>
										</select>
										<input type="hidden" name="modal_type_po2" id="modal_type_po2">

									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">Tanggal Invoice</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_inv" name="modal_tgl_inv" class="form-control" autocomplete="off" placeholder="Tanggal Invoice" onchange="noinv_modal()" readonly >
									</div>
									<div class="col-md-1"></div>
									<div class="col-md-2">Pajak</div>
									<div class="col-md-3">
										<select id="modal_pajak" name="modal_pajak" class="form-control select2" style="width: 100%" onchange="noinv_modal()">
											<option value="">-- PILIH --</option>
											<option value="ppn">PPN 11%</option>
											<option value="ppn_pph">PPN 11% + PPH22</option>
											<option value="nonppn">NON PPN</option>
										</select>
										<input type="hidden" name="modal_pajak2" id="modal_pajak2">
									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="modal_ppn_pilihan">						
									<div class="col-md-2">Incl / Excl</div>
									<div class="col-md-9">
										<select id="modal_inc_exc" name="modal_inc_exc" class="form-control select2" style="width: 100%" readonly>
											<option value="Include">Include</option>
											<option value="Exclude">Exclude</option>
											<option value="nonppn_inc">Non PPN</option>
										</select>
									</div>
								</div>
								
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									<div class="col-md-2">Tanggal SJ</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_sj" name="modal_tgl_sj" class="form-control" autocomplete="off" placeholder="Tanggal Surat Jalan" onchange="load_sj_modal()" >
										<input type="hidden" name="modal_id_pl_sementara" id="modal_id_pl_sementara" value="">
									</div>
									<div class="col-md-1"></div>

									<div class="col-md-2">Tanggal Jatuh Tempo</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_tempo" name="modal_tgl_tempo" class="form-control" autocomplete="off" placeholder="Jatuh Tempo" readonly>
									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">Customer</div>
									<div class="col-md-9">
										<select class="form-control select2" id="modal_id_pl" name="modal_id_pl" style="width: 100%" autocomplete="off" >
										</select>
										<!-- onchange="load_cs()" -->
									</div>
									
									<!-- <div class="col-md-1">
										<button type="button" class="btn btn-primary" id="modal_btn_verif" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
									</div> -->
									
								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">No Invoice</div>
									<div class="col-md-3">
										
										<input type="text" class="form-control" name="modal_no_invoice" id="modal_no_invoice" readonly>
									</div>
									<div class="col-md-6"></div>
									
								</div>

									<hr>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-12" style="font-family:Cambria;color:#4e73df;font-size:25px"><b>DIKIRIM KE</b></div>
									</div>
									<hr>

									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Kepada</div>
										<div class="col-md-10">
											<input type="hidden" id="modal_id_perusahaan" name="modal_id_perusahaan" >

											<input type="text" id="modal_kpd" name="modal_kpd" class="form-control" autocomplete="off" placeholder="Kepada" >
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Nama Perusahaan</div>
										<div class="col-md-10">
											<input type="text" id="modal_nm_perusahaan" name="modal_nm_perusahaan" class="form-control" autocomplete="off" placeholder="Nama Perusahaan" >
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2" style="padding-right:0">Alamat Perusahaan</div>
										<div class="col-md-10">
											<textarea class="form-control" name="modal_alamat_perusahaan" id="modal_alamat_perusahaan" cols="30" rows="5" placeholder="Alamat Perusahaan" ></textarea>
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Pilihan Bank</div>
										<div class="col-md-10">
											<select class="form-control select2" id="modal_bank" name="modal_bank" style="width: 100%" autocomplete="off">
												<option value="BCA_AKB">BCA AKB</option>
												<option value="BCA_SSB">BCA SSB</option>
												<option value="BCA_KSM">BCA KSM</option>
												<option value="BCA_GMB">BCA GMB</option>
												<option value="BCA">BCA</option>
												<option value="BNI">BNI</option>
											</select>
										</div>
									</div>
									<hr>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2" style="padding-right:0">List Item</div>
										<div class="col-md-10">&nbsp;
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;">		
										<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
												<table id="modal_datatable_input" class="table table-hover table- table-bordered table-condensed table-scrollable">
												</table>
											</div>
										</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-12">
											<input type="hidden" name="modal_status_inv_owner" id="modal_status_inv_owner">
											<input type="hidden" name="modal_status_inv_admin" id="modal_status_inv_admin">
											
											<!-- <button type="button" class="btn btn-success" id="btn_verif" onclick="acc_inv()"><i class="fas fa-check"></i><b> VERIFIKASI</b></button> -->

											<span id="modal_btn_verif"></span>

											<button type="button" class="btn btn-danger" id="modal_btn-print" onclick="Cetak()" ><i class="fas fa-print"></i> <b>Print</b></button>
											
											<button type="button" class="btn btn-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-times"></i> <b> Batal</b></button>
											
											
											
										</div>
									</div>
									<br>
									<br>
									
								
							</div>
						</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- /.MODAL -->

	
<div class="modal fade" id="modal_foto">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="card-header" style="font-family:Arial;" >
				<h4 class="card-title" style="color:#4e73df;" id="judul_file"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>

			<br><br>
			
			<form role="form" method="post" id="form_foto" enctype="multipart/form-data">
				<div>
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
						<div class="col-md-2">No Inv</div>
						<div class="col-md-3">
						<input type="hidden" name="status_modal" id="status_modal" class="form-control" readonly>

						<input type="text" name="no_inv_foto" id="no_inv_foto" class="form-control" readonly>
															
						</div>
						
						<div class="col-md-6"></div>
					</div>
					<div id="upload_invd" class="card-body row" style="padding:5px;font-weight:bold">
						<div class="col-md-1"></div>
						<div class="col-md-2">Tgl Inv Diterima</div>
						<div class="col-md-3">
							<input type="date" name="tgl_invd" id="tgl_invd" class="form-control">
						</div>
						<div class="col-md-6"></div>
					</div>
					<div id="upload_blk" class="card-body row" style="padding:5px;font-weight:bold">
						<div class="col-md-1"></div>
						<div class="col-md-2">Tgl Balik</div>
						<div class="col-md-3">
							<input type="date" name="tgl_blk" id="tgl_blk" class="form-control">
						</div>
						<div class="col-md-6"></div>
					</div>
					<div id="upload_file" class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
						<div class="col-md-2">Upload File</div>
						<div class="col-md-3">
							<div class="col-9">
								<input type="file" name="filefoto" id="filefoto" accept=".jpg,.jpeg,.png,.pdf" onchange="diPilih()">
							</div>
						</div>
						<div class="col-md-1">
							<div>
								<input style="color:#f00;font-style:italic;height: calc(2.25rem + 2px);font-size: 1rem;" type="text" value="* Max 1.5MB" class="input-border-none" autocomplete="off"  readonly>
							</div>
						</div>
						<div class="col-md-5"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-3"></div>
						<div class="col-md-9" style="color:#f00;font-size:12px;font-style:italic">
							* .jpg, .jpeg, .png, .pdf
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 5px 6px">
						<div class="col-md-1"></div>
						<div class="col-md-2">Keterangan</div>
						<div class="col-md-9">
							<textarea id="ket_file" class="form-control" style="resize:none" onchange="changeKetFile()" oninput="this.value=this.value.toUpperCase()"></textarea>
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 0 6px">
						<div class="col-md-3"></div>
						<div class="col-md-9">
							<div class="simpan-save"></div>
						</div>
					</div>
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
						<div class="col-md-10">
								<div class="detail-inv"></div>
								<span class="help-block"></span>	
						</div>
						<div class="col-md-1"></div>
					</div>
					<div class="cekcekcek"></div>
					<br><br>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Image Zoom HTML -->
<div id="mymodal-img" class="modal-img">
  <img class="modal-img-content" id="img01">
</div>
<!-- End Image Zoom HTML -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		load_data()
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
		load_bank()
	});

	status = "insert";

	$("#filefoto").change(function() {
		
		$(".detail-inv").html('')
        // readURL(this);
        // cek_size(this);
    });	
	
	function cek_size(input) {
		console.log(input.files[0].size)
	}
	function readURL(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#div_preview_foto').css("display","block");
			$('#preview_img').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
		} else {
			$('#div_preview_foto').css("display","none");
			$('#preview_img').attr('src', '');
		}
	}

	function open_foto(no_inv, tipe, ket, username)
	{
		$(".cekcekcek").html('')
		$(".simpan-save").html('')
		$(".detail-inv").html('')
		$("#filefoto").html('')
		$("#tgl_invd").val('')
		$("#tgl_blk").val('')
		$("#ket_file").val('')
		$('#modal_foto').modal('show');
		$("#no_inv_foto").val(no_inv);
		$('#upload_invd').hide();
		$('#upload_blk').hide();
		$('#filefoto').css("display","block");
		if(ket=='bc' && (username=='karina' || username=='siska' || username=='tegar')){
			$('#upload_file').show();
		}else if(ket=='faktur' && username=='siska'){
			$('#upload_file').show();
		}else if(ket=='resi' && (username=='karina' || username=='tegar')){
			$('#upload_file').show();
		}else if(ket=='inv_terima' && (username=='karina' || username=='tegar')){
			$('#upload_invd').show();
			$('#upload_file').show();
		}else if(ket=='mutasi' && (username=='karina' || username=='tegar')){
			$('#upload_file').show();
		}else if(ket=='sj_balik' && (username=='karina' || username=='tegar')){
			$('#upload_blk').show();
			$('#upload_file').show();
		}else if(ket=='upload_inv' && (username=='karina' || username=='tegar')){
			$('#upload_file').show();
		}else if(username=='developer'){
			if(ket=='inv_terima'){
				$('#upload_invd').show();
			}
			if(ket=='sj_balik'){
				$('#upload_blk').show();
			}
			$('#upload_file').show();
		}else{
			$('#upload_invd').css("display","none");
			$('#upload_blk').css("display","none");
			$('#upload_file').css("display","none");
		}

		document.getElementById("judul_file").innerHTML = "FILE "+ket.toUpperCase();
		$("#status_modal").val(ket);		

		
		$.ajax({
				url: '<?= base_url('Logistik/get_foto_'); ?>'+ket,
				type: 'POST',
				data: {
					no       : no_inv,
					jenis    : "invoice_header",
					field    : 'no_invoice'
				},
				dataType: "JSON",
			})
			.done(function(data) {

				$('#div_preview_foto').css("display","block");
				let btnHapHap = ''
				if(username == 'developer' && data.url_foto != 'foto'){
					btnHapHap = `<div style="display:flex">
						<div style="margin-right:4px">
							<select id="hps_file_inv" onchange="sHpsFile('${data.header.id}', '${ket}')">
								<option value=""></option>
								<option value="HAPUS">HAPUS</option>
								<option value="DDDDD">UPDATE</option>
							</select>
						</div>
						${data.htmlDtl}
					</div>`;
				}else{
					btnHapHap = data.htmlDtl
				}
				$(".detail-inv").html(btnHapHap)
				if(ket=='inv_terima'){
					$("#tgl_invd").val(data.header.inp_inv_terima.substr(0, 10))
				}
				if(ket=='sj_balik'){
					if(data.header.inp_sj_balik != null && data.header.tgl_sj_blk == null){
						$("#tgl_blk").val(data.header.inp_sj_balik.substr(0, 10))
					}else if(data.header.inp_sj_balik != null && data.header.tgl_sj_blk != null){
						$("#tgl_blk").val(data.header.tgl_sj_blk)
					}
				}
				$("#ket_file").val(data.ket)
				if(data.ext=='pdf')
				{
					
				}else{
					var modal = document.getElementById('mymodal-img');
					var img            = document.getElementById('preview_img');
					var modalImg       = document.getElementById("img01");
					img.onclick = function(){
						modal.style.display   = "block";
						modalImg.src          = this.src;
						modalImg.alt          = this.alt;
					}
					modal.onclick = function() {
						img01.className       += " out";
						setTimeout(function() {
							modal.style.display   = "none";
							img01.className       = "modal-img-content";
						}, 400);
					}
				}

				// cek
				if(data.header.cekinv == null && data.header.inpinv != null && (username=='bumagda' || username=='developer')){
					$(".cekcekcek").html(`<div class="card-body row" style="font-weight:bold;padding:20px 0 6px">
						<div class="col-md-3"></div>
						<div class="col-md-2">
							<select class="form-control select2" id="invinvinv" onchange="cekInv('lama', '')">
								<option value="">CEK</option>
								<option value="${ket}">OK</option>
							</select>
						</div>
						<div class="col-md-7"></div>
					</div>`)
				}else if(data.header.cekinv != null && (username=='bumagda' || username=='developer')){
					$(".cekcekcek").html(`<div class="card-body row" style="font-weight:bold;padding:20px 5px 6px">
						<div class="col-md-3"></div>
						<div class="col-md-9">
							<span style="font-weight:bold">CEK : ${data.header.cekinv}</span>
						</div>
					</div>`)
				}else{
					$(".cekcekcek").html(``)
				}
				$('.select2').select2()
			})
	}

	function sHpsFile(id_inv, ket){
		let hps_file_inv = $('#hps_file_inv').val()
		let tgl_blk = $("#tgl_blk").val()
		let tgl_invd = $("#tgl_invd").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/sHpsFile')?>',
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
			data: ({ hps_file_inv, tgl_blk, tgl_invd, id_inv, ket }),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					reloadTable()
					toastr.success(`<b>${data.msg}</b>`)
					$('#modal_foto').modal('hide')
					load_bank()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
			}
		})
	}

	function cekInv(opsi, oNoInv){
		let no_inv = $('#no_inv_foto').val()
		let status_modal = $("#status_modal").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cekInv')?>',
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
			data: ({ opsi, oNoInv, no_inv, status_modal }),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					reloadTable()
					toastr.success(`<b>${data.msg}</b>`)
					$('#modal_foto').modal('hide')
					load_bank()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
			}
		})
	}

	function diPilih()
	{
		$(".simpan-save").html('<button class="btn btn-primary btn-sm" onclick="simpan_file()" ><i class="fas fa-save"></i> <b>SIMPAN</b></button>')
	}

	
	function simpan_file() 
	{
		
		var status_modal    = $('#status_modal').val();
		var file_data       = $('#filefoto').prop('files')[0];
		var form_data       = new FormData();
		form_data.append('filefoto', file_data);
		// alert(status_modal)
		var url_            = '<?= base_url(); ?>Logistik/save_'+status_modal;
		
		var form            = $('#form_foto')[0];
		var data            = new FormData(form);
		var noinv           = $('#no_inv_foto').val();

		$(".simpan-save").html('')

		swal({
			title: 'loading ...',
			allowEscapeKey    : false,
			allowOutsideClick : false,
			onOpen: () => {
				swal.showLoading();
			} 
		})

		$.ajax({
			url            : url_,
			type           : "POST",
			enctype        : 'multipart/form-data',
			data           : data,
			dataType       : "JSON",
			contentType    : false,
			cache          : false,
			timeout        : 600000,
			processData    : false,
			success: function(data) {
				if (data) 
				{
					reloadTable()	
					swal.close();
					toastr.success(`<b>Berhasil Disimpan</b>`)
					$('#modal_foto').modal('hide');	
					load_bank()
				} else {
					// console.log('GAGAL SIMPAN');
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
			error: function(jqXHR, textStatus, errorThrown) 
			{
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

	function changeKetFile(){
		let no_inv = $('#no_inv_foto').val()
		let status_modal = $("#status_modal").val()
		let ket_file = $("#ket_file").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/changeKetFile')?>',
			type: "POST",
			data: ({ no_inv, status_modal, ket_file }),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					reloadTable()
					toastr.success(`<b>${data.msg}</b>`)
					$('#modal_foto').modal('hide')
					load_bank()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
			}
		})
	}

	function cetak_jurnal(ctk)
	{		
		var url    = "<?php echo base_url('Logistik/cetak_jurnal'); ?>";
		window.open(url, '_blank');   
	}

	function Cetak() 
	{
		no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Logistik/Cetak_Invoice'); ?>";
		window.open(url + '?no_invoice=' + no_invoice, '_blank');
	}

	function load_data() 
	{
		
		var blnn        = $('#rentang_bulan').val();
		var thnn        = $('#rentang_thn').val();
		var type_inv    = $('#type_inv').val();
		var exp_pilih   = $('#exp_pilih').val();
		var table       = $('#datatable').DataTable();
		
		table.destroy();

		tabel = $('#datatable').DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?= base_url(); ?>Logistik/load_data/Invoice',
				"type": "POST",
				data  : ({blnn, thnn, type_inv, exp_pilih}), 
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
				// success: function(){
				// 	swal.close()
				// }
			},
			"aLengthMenu": [
				[10, 15, 20, 25, -1],
				[10, 15, 20, 25, "Semua"] // change per page values here
			],		

			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	function load_bank()
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_bank",
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
					option += "<option value='"+val.nm_bank+"'>"+val.nm_bank+"</option>";
					});

					$('#bank').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#bank').html(option);					
					swal.close();
				}
			}
		});
		
	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	var no_po = ''

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "INVOICE",
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
				url   : '<?= base_url(); ?>Logistik/hapus',
				type  : "POST",
				data: ({
					id       : id,
					no_inv   : no,
					field    : 'id',
					jenis    : 'invoice'
				}),
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
					// toastr.success('Data Berhasil Di Hapus');
					swal({
						title               : "Data",
						html                : "Data Berhasil Di Hapus",
						type                : "success",
						confirmButtonText   : "OK"
					});
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

	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$(".list_lap").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}
	
	function open_laporan()
	{
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', 'display:none')
		$(".list_lap").attr('style', '')
	}

	function open_sj()
	{
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', 'display:none')
		$(".list_sj").attr('style', '')
		listNomerSJ()
	}

	function open_lapExp() {
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', 'display:none')
		$(".list_exp").attr('style', '')
	}

	function exPilih(){
		$('.ex-tmpl').html(``)
		$(".tab_expired").html('')
		let ex_pilih = $('#ex_pilih').val()
		if(ex_pilih == 'TANGGAL'){
			$('.ex-tmpl').html(`
				<div class="card-body row" style="font-weight:bold;padding:6px 0">
					<div class="col-md-2"></div>
					<div class="col-md-3">
						<input type="date" id="tgl_expired" class="form-control" onchange="cariLapExpired()">
					</div>
					<div class="col-md-7"></div>
				</div>
			`)
		}else if(ex_pilih == 'BULAN'){
			$('.ex-tmpl').html(`
				<div class="card-body row" style="font-weight:bold;padding:6px 0">
					<div class="col-md-2"></div>
					<div class="col-md-3">
						<input type="month" id="tgl_expired" class="form-control" onchange="cariLapExpired()">
					</div>
					<div class="col-md-7"></div>
				</div>
			`)
		}else{
			$('.ex-tmpl').html(`<input type="hidden" id="tgl_expired" value="">`)
			cariLapExpired()
		}
	}

	function cariLapExpired() {
		$(".tab_expired").html('')
		let ex_pilih = $('#ex_pilih').val()
		let tgl_expired = $("#tgl_expired").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariLapExpired')?>',
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
			data: ({ ex_pilih, tgl_expired }),
			success: function(res){
				data = JSON.parse(res)
				$(".tab_expired").html(data.html)
				swal.close()
			}
		})
	}

	function listNomerSJ(){
		let tahun = $("#ll_tahun").val()
		let pilih = $("#ll_pilih").val()
		let pajak = $("#ll_pajak").val()
		let table = $('#datatable1').DataTable();
		table.destroy();
		tabel = $('#datatable1').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/listNomerSJ')?>',
				"type": "POST",
				"data": ({
					tahun, pilih, pajak, jenis: "invoice"
				}),
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 25,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			},
			// "order": [
			// 	[4, "desc"]
			// ]
		})
		swal.close()
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".list_lap").attr('style', 'display:none')
		$(".list_sj").attr('style', 'display:none')
		$(".list_exp").attr('style', 'display:none')
		$("#tgl_expired").val('')
		$('#ex_pilih').val('').trigger('change')
		$('.ex-tmpl').html(``)
		$(".row-list").attr('style', '')
	}

	// MODAL //
	function open_modal(id,no_invoice) 
	{		
		$("#modalForm").modal("show");

		$("#judul").html('<h3> VERIFIKASI OWNER </h3>');
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
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
					$("#modal_type_po").val(data.header.type).trigger('change');
					$("#modal_cek_inv").val(data.header.cek_inv).trigger('change');
					$("#modal_tgl_inv").val(data.header.tgl_invoice);
					$("#modal_tgl_sj").val(data.header.tgl_sj);
					$("#modal_id_inv").val(data.header.id);
					$("#modal_no_inv_old").val(data.header.no_invoice);
					$("#modal_no_invoice").val(data.header.no_invoice);
					$("#modal_id_pl_sementara").val(data.header.id_perusahaan);
					load_sj_modal()

					$("#modal_pajak").val(data.header.pajak).trigger('change');
					$("#modal_bank").val(data.header.bank).trigger('change');
					$("#modal_tgl_tempo").val(data.header.tgl_jatuh_tempo);
					$("#modal_id_perusahaan").val(data.header.id_perusahaan);
					$("#modal_kpd").val(data.header.kepada);
					$("#modal_nm_perusahaan").val(data.header.nm_perusahaan);
					$("#modal_alamat_perusahaan").val(data.header.alamat_perusahaan);
					$("#modal_status_inv_owner").val(data.header.acc_owner);
					$("#modal_status_inv_admin").val(data.header.acc_admin);

					if(data.header.acc_owner == 'Y')
					{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv()"><i class="fas fa-lock"></i><b> BATAL VERIFIKASI </b></button>`)
					}else{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv()"><i class="fas fa-check"></i><b> VERIFIKASI </b></button>`)

					}

					if(data.header.pajak == 'ppn' || data.header.pajak == 'ppn_pph' )
					{
						$('#modal_ppn_pilihan').show("1000");
						$("#modal_inc_exc").val(data.header.inc_exc).trigger('change');
					}else{
						$('#modal_ppn_pilihan').hide("1000");
					}
					
					$("#modal_type_po").prop("disabled", true);
					$("#modal_pajak").prop("disabled", true);
					$("#modal_inc_exc").prop("disabled", true);
					$("#modal_id_pl").prop("disabled", true);
					$("#modal_cek_inv").prop("disabled", true);
					$("#modal_tgl_sj").prop("readonly", true);

					
					$("#modal_type_po2").val(data.header.type);
					$("#modal_cek_inv2").val(data.header.cek_inv);
					$("#modal_pajak2").val(data.header.pajak);

					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >KET</th>
							<th style="text-align: center; padding: 12px 50px" >HARGA</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding: 12px 30px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding: 12px 30px" >SESET</th>
							<th style="text-align: center; padding: 12px 30px" >HASIL</th>
						</thead>`;

						var no = 1;
						$.each(data.detail, function(index, val) {
							list += `
							<tbody>
								<td id="modal_no_urut${no}" name="modal_no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="modal_nm_ker[${no}]" id="modal_nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="modal_id_inv_detail[${no}]" id="modal_id_inv_detail${no}" value="${val.id}">
									</td>

								<td style="text-align: left" >
									NO SJ : <b> ${val.no_surat} </b> <br>
									NO PO : <b> ${val.no_po} </b> <br>
									GSM : <b> ${val.g_label} </b> <br> 
									ITEM : <b> ${val.width} </b>
									
									<input type="hidden" name="modal_no_surat[${no}]" id="modal_no_surat${no}" value="${val.no_surat}">
									<input type="hidden" id="modal_no_po${no}" name="modal_no_po[${no}]" value="${val.no_po}">
									<input type="hidden" id="modal_g_label${no}" name="modal_g_label[${no}]" value="${val.g_label}">
									<input type="hidden" id="modal_width${no}" name="modal_width[${no}]" value="${val.width}">
								</td>

								<td style="text-align: center" >
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>		
										<input type="text" name="modal_hrg[${no}]" id="modal_hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}" readonly >
									</div>
								</td>

								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="modal_qty${no}" name="modal_qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >${format_angka(val.retur_qty)}
									<input type="hidden" name="modal_retur_qty[${no}]" id="modal_retur_qty${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									<input type="hidden" id="modal_weight${no}" name="modal_weight[${no}]"  value="${val.weight}">
								</td>

								<td style="text-align: center" >${format_angka(val.seset)}
									<input type="hidden" name="modal_seset[${no}]" id="modal_seset${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.seset)}" >
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
									<input type="hidden" id="modal_hasil${no}" name="modal_hasil[${no}]"  class="form-control" value="${format_angka(val.hasil)}" readonly>
								</td>
							</tbody>`;
							no ++;
						})
						list += `</table>`;
					}else{
						var list = `
						<table id="modal_datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >Ukuran</th>
								<th style="text-align: center" >Kualitas</th>
								<th style="text-align: center; padding: 12px 50px" >HARGA</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding: 12px 30px">R. QTY</th>
								<th style="text-align: center; padding: 12px 30px" >HASIL</th>
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
								<td id="modal_no_urut${no}" name="modal_no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="modal_id_pl_roll[${no}]" id="modal_id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="modal_id_inv_detail[${no}]" id="modal_id_inv_detail${no}" value="${val.id}">
								</td>

								<td style="text-align: left" >
									NO SJ : <b> ${val.no_surat} </b> <br>
									NO PO : <b> ${val.no_po} </b><br>
									ITEM : <b> ${val.id_produk_simcorr} - ${val.nm_ker} </b><br>
									UKURAN : <b> ${val.g_label} </b>

									<input type="hidden" name="modal_no_surat[${no}]" id="modal_no_surat${no}" value="${val.no_surat}">
									<input type="hidden" id="modal_no_po${no}" name="modal_no_po[${no}]" value="${no_po}">
									<input type="hidden" name="modal_item[${no}]" id="modal_item${no}" value="${val.nm_ker}">
									<input type="hidden" id="modal_id_produk_simcorr${no}" name="modal_id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
									<input type="hidden" id="modal_ukuran${no}" name="modal_ukuran[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.kualitas}
									<input type="hidden" id="modal_kualitas${no}" name="modal_kualitas[${no}]" value="${val.kualitas}">
								</td>

								<td style="text-align: center" >
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>		
										<input type="text" name="modal_hrg[${no}]" id="modal_hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}" readonly>
									</div>
									
								</td>

								<td style="text-align: center" >${format_angka(val.qty)} pcs
									<input type="hidden" id="modal_qty${no}" name="modal_qty[${no}]" onkeyup="ubah_angka(this.value,this.id)" value="${val.qty}">
								</td>
								
								<td style="text-align: center" >${format_angka(val.retur_qty)} pcs
									<input type="hidden" id="modal_retur_qty${no}" name="modal_retur_qty[${no}]" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)} pcs
									<input type="hidden" id="modal_hasil${no}" name="modal_hasil[${no}]"  class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.hasil)}" readonly>
								</td>

							</tbody>`;
							berat_total += parseInt(val.qty);
							no ++;
						})
						list += `<td style="text-align: center" colspan="6">TOTAL
								</td>
								<td style="text-align: center" >${format_angka(berat_total)}
								</td>`;
						list += `</table>`;
						$("#modal_datatable_input").html(list);
						// swal.close();
					}
					
					$("#modal_datatable_input").html(list);
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

	function noinv_modal()
	{
		var type    = $('#modal_type_po').val()
		var tgl_inv = $('#modal_tgl_inv').val()
		var pajak   = $('#modal_pajak').val()

		const myArray   = tgl_inv.split("-");
		let year        = myArray[0];
		let month       = myArray[1];
		let day         = myArray[2];

		if(type=='roll')
		{
			if(pajak=='nonppn')
			{
				$('#modal_no_inv_kd').val('B/');
			}else{
				$('#modal_no_inv_kd').val('A/');
			}
		}else{

			if(pajak=='nonppn')
			{
				$('#modal_no_inv_kd').val('BB/');
			}else{
				$('#modal_no_inv_kd').val('AA/');
			}

		}
		
		if(tgl_inv)
		{
			$('#modal_no_inv_tgl').val('/'+month+'/'+year);
		}
		
	}
	
	function load_sj_modal() 
	{
		var tgl_sj            = $("#modal_tgl_sj").val()
		var type_po           = $("#modal_type_po").val()
		var id_pl_sementara   = $("#modal_id_pl_sementara").val()
		var stat              = 'edit'
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_sj",
			dataType   : 'json',
			data       : {tgl_sj,type_po,stat},
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
					option = "<option>--- Pilih ---</option>";
					$.each(data.data, function(index, val) {
					option += `<option value="${val.id_perusahaan}" data-nm="${val.pimpinan}" data-nm_perusahaan="${val.nm_perusahaan}" data-id_perusahaan="${val.id_perusahaan}" data-alamat_perusahaan="${val.alamat_perusahaan}">[ "${val.tgll}" ] - [ "${val.pimpinan}" ] - [ "${val.nm_perusahaan}" ]</option>`;
					});

					$('#modal_id_pl').html(option);
					if(id_pl_sementara !='')
					{
						$("#modal_id_pl").val(id_pl_sementara).trigger('change');
					}
					swal.close();
				}else{	
					option += "<option value=''>Data Kosong</option>";
					$('#modal_id_pl').html(option);		
					swal.close();
				}
			}
		});
	}

	
	function acc_inv(no_invoice,status_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var acc_owner   = status_owner
		// var acc_admin   = $('#modal_status_inv_admin').val()
		var no_inv      = no_invoice
		
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
					url: '<?= base_url(); ?>Logistik/prosesData2',
					data: ({
						no_inv    : no_inv,
						acc       : acc,
						jenis     : 'verif_inv'
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
					success: function(res) {
						data = JSON.parse(res)
						if(data.data){
							reloadTable()
							toastr.success('Data Berhasil Diproses');
							close_modal()
							load_bank()
						}else{
							toastr.error('<b>MUTASI BELUM DI UPLOAD!</b>');
							swal.close()
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
		});
	}

	// INVOICE ADD //
	function simpan() 
	{
		var cek_inv   = $('#cek_inv').val();
		var no_inv_kd   = $('#no_inv_kd').val();
		var no_inv      = $('#no_inv').val();
		var no_inv_tgl  = $('#no_inv_tgl').val();
		var no_inv_ok   = no_inv_kd+''+no_inv+''+no_inv_tgl;

		swal({
			title: 'loading ...',
			allowEscapeKey    : false,
			allowOutsideClick : false,
			onOpen: () => {
				swal.showLoading();
			} 
		})		
		
		var tgl_inv   = $("#tgl_inv").val();
		var tgl_sj    = $("#tgl_sj").val();
		var id_pl     = $("#id_pl").val();
		var pajak     = $("#pajak").val();
		var tgl_tempo = $("#tgl_tempo").val();

		if (tgl_inv == '' || tgl_sj == '' || id_pl=='' || pajak=='' || tgl_tempo=='' ) 
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

		var bucket = $('#bucket').val();

		for (var i = 1; i <= bucket-1; i++) {
			id_produk_simcorr   = $("#id_produk_simcorr" + i).val();

			if (id_produk_simcorr == '' ) {
				swal({
					title               : "Cek Kembali",
					html                : "Kode ITEM Kosong !, Hubungi IT",
					type                : "info",
					confirmButtonText   : "OK"
				});
				return;
				// swal.close();
			}
		}
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/Insert_inv',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success"
						// confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";
					// location.href = "<?= base_url()?>Logistik/Invoice";
					kembaliList();
					kosong();
					
				} else if(data.status=='3'){
					swal.close();
					swal({
						title               : "CEK KEMBALI",
						html                : "<p><strong>Nomor Invoice</strong></p>"
											+"Sudah di Gunakan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
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

	function kosong(c = '') 
	{
		// $("#cek_inv").val("");
		$("#jenis").val("");
		$("#status").val("");
		$("#type_po").val("");
		$("#type_po").html(`<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="roll">Roll</option>
									<option value="sheet">Sheet</option>
									<option value="box">Box</option>
								</select>`);
		$("#tgl_inv").val("");
		$("#tgl_sj").val("");
		$("#tgl_tempo").val("");
		$("#pajak").val("");
		$("#pajak").html(`<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="ppn">PPN 11%</option>
									<option value="ppn_pph">PPN 11% + PPH22</option>
									<option value="nonppn">NON PPN</option>
								</select>`);
		$("#inc_exc").val("");
		$('#ppn_pilihan').hide("1000");
		$("#id_pl_sementara").val("");
		$("#id_pl").val("");
		$("#id_pl").html(`<select class="form-control select2" id="id_pl" name="id_pl" style="width: 100%" autocomplete="off" onchange="load_cs()" disabled></select>`);
		$("#no_inv_kd").val("");
		$("#no_inv").val("");
		$("#no_inv_tgl").val("");
		$("#id_perusahaan").val("");
		$("#kpd").val("");
		$("#nm_perusahaan").val("");
		$("#alamat_perusahaan").val("");
		// $("#bank").val("");

		$("#id_pelanggan").select2("val", "");
		$('#id_pelanggan').val("").trigger('change');		
		$("#id_pelanggan").prop("", false);

		clearRow();		
		$("#type_po").prop("disabled", false);
		$("#pajak").prop("disabled", false);
		$("#id_pl").prop("disabled", false);
		$("#btn-search").prop("disabled", false);
		$("#cek_inv").prop("disabled", false);
		$("#tgl_sj").prop("readonly", false);
		$("#btn-simpan").show();

		$(".btn-tambah-produk").show();
	}

	var no_po = ''

	function load_sj() 
	{
		var tgl_sj            = $("#tgl_sj").val()
		var type_po           = $("#type_po").val()
		var id_pl_sementara   = $("#id_pl_sementara").val()
		var stat              = $("#sts_input").val();
		$("#id_pl").prop('disabled', false);

		if(type_po == '' || type_po == null)
		{
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Pilih <b> Type  </b> Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_sj",
			dataType   : 'json',
			data       : {tgl_sj,type_po,stat},
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
					option = "<option>--- Pilih ---</option>";
					$.each(data.data, function(index, val) {
					option += `<option value="${val.id_perusahaan}" data-nm="${val.pimpinan}" data-nm_perusahaan="${val.nm_perusahaan}" data-id_perusahaan="${val.id_perusahaan}" data-alamat_perusahaan="${val.alamat_perusahaan}">[ "${val.tgll}" ] - [ "${val.pimpinan}" ] - [ "${val.nm_perusahaan}" ]</option>`;
					});

					$('#id_pl').html(option);
					if(id_pl_sementara !='')
					{
						$("#id_pl").val(id_pl_sementara).trigger('change');
					}
					swal.close();
				}else{	
					option += "<option value=''>Data Kosong</option>";
					$('#id_pl').html(option);		
					swal.close();
				}
			}
		});
	}

	function load_cs()
	{
		var status    = $("#sts_input").val();
		if(status=='add')
		{
			var kpd                 = $('#id_pl option:selected').attr('data-nm');
			var id_perusahaan       = $('#id_pl option:selected').attr('data-id_perusahaan');
			var nm_perusahaan       = $('#id_pl option:selected').attr('data-nm_perusahaan');
			var alamat_perusahaan   = $('#id_pl option:selected').attr('data-alamat_perusahaan');
			$("#id_perusahaan").val(id_perusahaan)
			$("#kpd").val(kpd)
			$("#nm_perusahaan").val(nm_perusahaan)
			$("#alamat_perusahaan").val(alamat_perusahaan)
		}else{

		}
			show_list_pl()

	}

	function show_list_pl()
	{
		var id_perusahaan   = $('#id_pl option:selected').attr('data-id_perusahaan');
		var tgl_sj          = $("#tgl_sj").val()
		var type_po         = $("#type_po").val()

		$.ajax({
			url: '<?= base_url('Logistik/list_item'); ?>',
			type: 'POST',
			data: {id_perusahaan, tgl_sj, type_po},
			dataType: "JSON",
			beforeSend: function() {
						swal({
							title: 'Ambil Data Surat Jalan...',
							allowEscapeKey    : false,
							allowOutsideClick : false,
							onOpen: () => {
								swal.showLoading();
							}
						})
					},
			success: function(data)
			{  
				if(data.message == "Success"){
					if(type_po=='roll')
					{
						var list = `
							<table id="datatable_input" class="table">
								<thead class="color-tabel">
									<th style="text-align: center" >No</th>
									<th style="text-align: center" >NO SJ</th>
									<th style="text-align: center" >NO PO</th>
									<th style="text-align: center" >GSM</th>
									<th style="text-align: center" >ITEM</th>
									<th style="text-align: center; padding-right: 35px" >EXCLUDE</th>
									<th style="text-align: center; padding-right: 35px" >INCLUDE</th>
									<th style="text-align: center" >QTY</th>
									<th style="text-align: center; padding-right: 10px">R. QTY</th>
									<th style="text-align: center" >BERAT</th>
									<th style="text-align: center; padding-right: 25px" >SESET</th>
									<th style="text-align: center; padding-right: 30px" >HASIL</th>
									<th style="text-align: center" >AKSI</th>
								</thead>`;
							var no             = 1;
							var berat_total    = 0;
							var no_po          = '';
							$.each(data.data, function(index, val) {
								if(val.no_po_sj == null || val.no_po_sj == '')
								{
									no_po = val.no_po
								}else{
									no_po = val.no_po_sj
								}
								list += `
								<tbody>
									<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
										<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
										
										<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									</td>

									<td style="text-align: center" >${val.no_surat}
										<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
									</td>

									<td style="text-align: center" >${no_po}
										<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
									</td>

									<td style="text-align: center" >${val.g_label}
										<input type="hidden" id="g_label${no}" name="g_label[${no}]" value="${val.g_label}">
									</td>

									<td style="text-align: center" >${val.width}
										<input type="hidden" id="width${no}" name="width[${no}]" value="${val.width}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>
									<td style="text-align: center" >
										<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>

									<td style="text-align: center" >${val.qty}
										<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id)">
									</td>

									<td style="text-align: center" >${format_angka(val.weight)}
										<input type="hidden" id="weight${no}" name="weight[${no}]"  value="${val.weight}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="seset[${no}]" id="seset${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})">
									</td>

									<td style="text-align: center" >
										<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.weight)}" readonly>
									</td>

									<td style="text-align: center" >
										<input type="checkbox" name="aksi[${no}]" id="aksi${no}" class="form-control" value="0" onchange="cek(this.value,this.id)">
									</td>
								</tbody>`;
								berat_total += parseInt(val.weight);
								no ++;
							})
							list += `<td style="text-align: center" colspan="9">TOTAL
									</td>
									<td style="text-align: center" >${format_angka(berat_total)}
									</td>
									<td style="text-align: center" colspan="3">&nbsp;
									</td>`;
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
									<th style="text-align: center; padding-right: 35px" >EXCLUDE</th>
									<th style="text-align: center; padding-right: 35px" >INCLUDE</th>
									<th style="text-align: center" >QTY</th>
									<th style="text-align: center; padding-right: 35px">R. QTY</th>
									<th style="text-align: center; padding-right: 35px" >HASIL</th>
									<th style="text-align: center" >AKSI</th>
								</thead>`;
							var no             = 1;
							var berat_total    = 0;
							var no_po          = '';
							$.each(data.data, function(index, val) {
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
									</td>

									<td style="text-align: center" >${val.no_surat}
										<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
									</td>

									<td style="text-align: center" >${no_po}
										<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
									</td>

									<td style="text-align: center" >${val.id_produk_simcorr} - ${val.item}
										<input type="hidden" id="item${no}" name="item[${no}]" value="${val.item}">
										<input type="hidden" id="id_produk_simcorr${no}" name="id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
									</td>

									<td style="text-align: center" >${val.ukuran2}
										<input type="hidden" id="ukuran${no}" name="ukuran[${no}]" value="${val.ukuran2}">
									</td>

									<td style="text-align: center" >${val.kualitas}
										<input type="hidden" id="kualitas${no}" name="kualitas[${no}]" value="${val.kualitas}">
									</td>
									
									<td style="text-align: center" >
										<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.exc)}" readonly>

									</td>

									<td style="text-align: center" >
										<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.inc)}" readonly>
									</td>

									<td style="text-align: center" >${format_angka(val.qty)}
										<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})">
									</td>

									<td style="text-align: center" >
										<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.qty)}" readonly>
									</td>

									<td style="text-align: center" >
										<input type="checkbox" name="aksi[${no}]" id="aksi${no}" class="form-control" value="0" onchange="cek(this.value,this.id)">
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
										<input type="hidden" id="bucket" value="${no}"></input>
									</td>`;
							list += `</table>`;
					}				
					
					$("#datatable_input").html(list);
					swal.close();
				}else{	
						
					swal.close();
				}
				
			}
		})

	}

	function noinv()
	{
		var type    = $('#type_po').val()
		var tgl_inv = $('#tgl_inv').val()
		var pajak   = $('#pajak').val()
		$("#id_pl").prop('disabled', true);
		
		if(pajak == 'ppn' || pajak == 'ppn_pph' )
		{
			$('#ppn_pilihan').show("1000");
			$("#inc_exc").val('Exclude').trigger('change');
		}else{
			$('#ppn_pilihan').hide("1000");
			$("#inc_exc").val('nonppn_inc').trigger('change');
		}

		const myArray   = tgl_inv.split("-");
		let year        = myArray[0];
		let month       = myArray[1];
		let day         = myArray[2];

		if(year=='2023'){

			if(type=='roll')
			{
				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('B/');
				}else{
					$('#no_inv_kd').val('A/');
				}
			}else{

				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('BB/');
				}else{
					$('#no_inv_kd').val('AA/');
				}

			}
			
		}else{
			if(type=='roll')
			{
				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('FD/');
				}else{
					$('#no_inv_kd').val('FC/');
				}
			}else{

				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('FB/');
				}else{
					$('#no_inv_kd').val('FA/');
				}

			}

		}
		
		
		if(tgl_inv)
		{
			$('#no_inv_tgl').val('/'+month+'/'+year);
		}
		
	}
	
	function no_inv2()
	{
		var status    = $("#sts_input").val();
		if(status=='add')
		{

			var type      = $('#type_po').val()
			var pajak     = $('#pajak').val()
			var cek_inv   = $('#cek_inv').val()
			var tgl_inv   = $('#tgl_inv').val()

			if(tgl_inv=='' || tgl_inv == null)
			{
				th_invoice = <?= date('Y') ?>
			}else{

				const myArray    = tgl_inv.split("-")
				var year         = myArray[0]
				th_invoice      = year

			}
			$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Logistik/load_no_inv",
				data        : { type,pajak,th_invoice },
				dataType    : 'json',
				success:function(val){			
						
						$("#no_inv").val(val)
						if(cek_inv=='baru')
						{
							$("#no_inv").prop('readonly', true);
						}else{
							$("#no_inv").prop('readonly', false);

						}
					
				}
			});
		
		}else{

		}
	}

	function cek_invoice()
	{
		var cek_inv = $('#cek_inv').val()

		if(cek_inv=='baru')
		{
			$("#no_inv").prop('readonly', true);
		}else{
			$("#no_inv").prop('readonly', false);
		}
	}

	function cek(vall,id)
	{
		if (vall == 0) {
			$('#'+id).val(1);
		} else {
			$('#'+id).val(0);
		}
	}


	function clearRow() 
	{
		// jQuery('#datatable_input').remove();
		$("#datatable_input").html('');
	}

	function Hitung_price(val,id) 
	{
		var cek = id.substr(0,3);
		var id2 = id.substr(3,1);
		var isi = val.split('.').join('');
		
		if(cek=='hrg')
		{
			inc = (isi *1.11).toFixed(2);
			$('#inc'+id2).val(format_angka_koma(inc));

		}else {
			exc = Math.ceil(isi /1.11);
			$('#hrg'+id2).val(format_angka(exc));

		}
	}

	function hitung_hasil(val,id)
	{
		var type    = $('#type_po').val()
		if(type=='roll')
		{
			var berat    = $('#weight'+id).val()
			var seset    = val.split('.').join('')
			var hasil    = berat - seset
		}else{
			var qty    = $('#qty'+id).val()
			var retur  = val.split('.').join('')
			var hasil  = qty - retur
		}

		$('#hasil'+id).val(format_angka(hasil));

	}

	// INVOICE ADD END //


	// INVOICE EDIT //

	// function edit_data(id,no_po)
	// {
	// 	$(".row-input").attr('style', '');
	// 	$(".row-list").attr('style', 'display:none');
	// 	$("#sts_input").val('edit');

	// 	$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

	// 	$.ajax({
	// 		url        : '<?= base_url(); ?>Logistik/load_data_1',
	// 		type       : "POST",
	// 		data       : { id, tbl:'trs_h_stok_bb', jenis :'edit_stok_bb',field :'id_stok' },
	// 		dataType   : "JSON",
	// 		beforeSend: function() {
	// 			swal({
	// 			title: 'loading data...',
	// 			allowEscapeKey    : false,
	// 			allowOutsideClick : false,
	// 			onOpen: () => {
	// 				swal.showLoading();
	// 			}
	// 			})
	// 		},
	// 		success: function(data) {
	// 			if(data){
	// 				// header

	// 				var history = data.header.history - data.header.total_item - data.header.tonase_ppi

	// 				$("#id_stok_h").val(data.header.id_stok);
	// 				$("#no_stok").val(data.header.no_stok);
	// 				$("#muat_ppi").val(data.header.muatan_ppi).trigger('change');
	// 				$("#tgl_stok").val(data.header.tgl_stok);
	// 				$("#id_timb").val(data.header.id_timbangan);
	// 				$("#no_timb").val(data.header.no_timbangan);
	// 				$("#history_timb").val(format_angka(history));
	// 				$("#jum_timb").val(format_angka(data.header.total_timb));
	// 				$("#tonase_ppi").val(format_angka(data.header.tonase_ppi));
	// 				$("#total_bb_item").val(format_angka(data.header.total_item));
	// 				$("#sisa_timb").val(format_angka(data.header.sisa_stok)); 
	// 				swal.close();

	// 				// detail

	// 				var list = `
	// 					<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
	// 					<thead class="color-tabel">
	// 						<tr>
	// 							<th id="header_del">Delete</th>
	// 							<th style="padding : 12px 20px" >LIST </th>
	// 							<th style="padding : 12px 150px">PO</th>
	// 							<th style="padding : 12px 50px">Tonase PO</th>
	// 							<th style="padding : 12px 70px" >History PO</th>
	// 							<th style="padding : 12px 50px" >Kedatangan</th>
	// 						</tr>
	// 					</thead>`;
						
	// 				var no   = 0;
	// 				$.each(data.detail, function(index, val) {
	// 					var history_detail = val.history - val.datang_bhn_bk
	// 					list += `
	// 						<tr id="itemRow${ no }">
	// 							<td id="detail-hapus-${ no }">
	// 								<div class="text-center">
	// 									<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
	// 										<i class="far fa-trash-alt" style="color:#fff"></i> 
	// 									</a>
	// 								</div>
	// 							</td>
	// 							<td>
	// 								<div class="text-center">
	// 									<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ no }]" id="list${ no }">
	// 										<i class="fas fa-search"></i>
	// 									</button> 

	// 									<button type="button" title="PILIH"  onclick="cetak_inv_bb(this.id)" class="btn btn-danger btn-sm" name="print_inv[${ no }]" id="print_inv${ no }">
	// 										<i class="fas fa-print"></i>
	// 									</button> 
										
	// 								</div>
	// 							</td>
	// 							<td style="padding : 12px 20px" >
	// 								<input type="hidden" name="id_po_bhn[${ no }]" id="id_po_bhn${ no }" value="${val.id_po_bhn}">
									
	// 								<div class="input-group mb-1">
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
	// 										</span>
	// 									</div>								
	// 									<input type="hidden" name="id_hub[${ no }]" id="id_hub${ no }" class="angka form-control" value="${val.id_hub}" readonly>
										
	// 									<input type="text" name="nm_hub[${ no }]" id="nm_hub${ no }" class="angka form-control" value="${val.nm_hub}" readonly>
	// 								</div>
	// 								<div class="input-group mb-1">
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>NO PO</b>
	// 										</span>
	// 									</div>
										
	// 									<input type="text" name="no_po[${ no }]" id="no_po${ no }" class="angka form-control" value="${val.no_po_bhn}"  readonly>
	// 								</div>
	// 							</td>	

	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="ton[${ no }]" id="ton${ no }" class="angka form-control" value="${format_angka(val.tonase_po)}"  readonly>
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		

	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="history[${ no }]" id="history${ no }" class="angka form-control" value="${format_angka(history_detail)}"  readonly>
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		
	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="datang[${ no }]" id="datang${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.datang_bhn_bk)}" >
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		
	// 						</tr>
	// 					`;

	// 					no ++;
	// 				})
	// 				rowNum = no-1 
	// 				$('#bucket').val(rowNum);					
	// 				$("#table_list_item").html(list);					
	// 				hitung_total()
	// 				swal.close();

	// 			} else {

	// 				swal.close();
	// 				swal({
	// 					title               : "Cek Kembali",
	// 					html                : "Gagal Simpan",
	// 					type                : "error",
	// 					confirmButtonText   : "OK"
	// 				});
	// 				return;
	// 			}
	// 		},
	// 		error: function(jqXHR, textStatus, errorThrown) {
	// 			// toastr.error('Terjadi Kesalahan');
				
	// 			swal.close();
	// 			swal({
	// 				title               : "Cek Kembali",
	// 				html                : "Terjadi Kesalahan",
	// 				type                : "error",
	// 				confirmButtonText   : "OK"
	// 			});
				
	// 			return;
	// 		}
	// 	});
	// }

	function edit_data(id,no_invoice) 
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		// var type_po       = $('#type_po').val()

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
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
						// discount
						let cci = '';
						(data.header.disc != 0) ? cci = data.header.disc : cci = '';
						list += `<td style="text-align: center" colspan="10"></td>
						<td style="text-align:center">DISCOUNT (%)</td>
						<td style="text-align:center">
							<input type="text" id="disc_input" name="disc_input" onkeyup="ubah_angka(this.value,this.id)" class="form-control" value="${cci}" autocomplete="off">
						</td>
						<td style="text-align:center"></td>`;
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
								
									<input type="hidden" name="disc_input" id="disc_input" value="0">
									<input type="hidden" name="disc_cek" id="disc_cek" value="0">
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

	function cek_periode()
    {
      $cek = $('#priode').val();

      if($cek=='custom' )
        {
          $('#list_tgl').show("1000");
        }else{
          $('#list_tgl').hide("1000");
        }
    }

	function cek_type()
    {
      $cek = $('#pilih_type').val();

      if($cek=='box' )
        {
          $('#list_attn').show("1000");
          $('#list_cust').show("1000");
        }else{
          $('#list_attn').hide("1000");
          $('#list_cust').hide("1000");
          $('#byr_attn').val("").trigger('change');;
          $('#plh_cust').val("").trigger('change');;
        }
    }

	function tampil_data_inv()
	{
		var pilih_type    = $("#pilih_type").val()
		var list_attn     = $("#list_attn").val()
		var list_cust     = $("#list_cust").val()
		var plh_bayar     = $("#plh_bayar").val()
		var priode        = $("#priode").val()
		var tgl1_inv      = $("#tgl1_inv").val()
		var tgl2_inv      = $("#tgl2_inv").val()
		
		$.ajax({
			url    : '<?php echo base_url('Logistik/tampil_data_inv')?>',
			type   : "POST",
			data   : {pilih_type ,list_attn ,list_cust ,plh_bayar ,priode ,tgl1_inv ,tgl2_inv},
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
			success: function(res)
			{
				// data = JSON.parse(res)
				$("#tampil_lap_inv").html(res)
				swal.close()
			}

		})
	}

	function updateExpired(){
		let tahun = $("#rentang_thn").val()
		let bulan = $("#rentang_bulan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/updateExpired')?>',
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
			data: ({ tahun, bulan }),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					reloadTable()
					toastr.success(`<b>UPDATE EXPIRED BERHASIL!</b>`)
					load_bank()
				}else{
					toastr.error(`<b>BELUM BERUNTUNG</b>`)
					swal.close()
				}
			}
		})
	}

	function btnSakti(id_inv, jenis, izin = '', jenisIzin = '') {
		$.ajax({
			url: '<?php echo base_url('Logistik/btnSakti')?>',
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
			data: ({ id_inv, jenis, izin, jenisIzin }),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					reloadTable()
					toastr.success(`<b>BERHASIL!</b>`)
					load_bank()
				}
			}
		})
	}

</script>
