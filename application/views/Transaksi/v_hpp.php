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
		<div class="container-fluid">
			<div class="row row-input-hpp" style="display:none">
				<div class="col-md-9">
					<!-- PILIH HPP -->
					<div class="card card-success card-outline" style="padding-bottom:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT HPP</h3>
						</div>
						<div style="padding:12px 6px">
							<button type="button" class="btn btn-sm btn-info" onclick="kembaliHPP()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">HPP</div>
							<div class="col-md-9">
								<select id="pilih_hpp" class="form-control select2" onchange="pilihHPP()">
									<option value="">PILIH</option>
									<option value="PM2">PM2</option>
									<option value="LAMINASI">LAMINASI</option>
									<option value="SHEET">SHEET</option>
									<option value="BOX">BOX</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TANGGAL</div>
							<div class="col-md-9">
								<input type="date" id="tgl1_hpp" class="form-control" onchange="pilihHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">JENIS</div>
							<div class="col-md-9">
								<select id="jenis_hpp" class="form-control select2" onchange="pilihHPP()"></select>
							</div>
						</div>
					</div>
					<!-- PEMAKAIAN BAHAN PM -->
					<div class="cbx card-pemakaian-bahan-pm" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
							<!-- PEMAKAIAN BAHAN -->
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">KETERANGAN</div>
								<div class="col-md-9">
									<select id="ket_bahan_txt" class="form-control select2">
										<option value="">PILIH</option>
										<option value="LOCAL OCC">LOCAL OCC</option>
										<option value="MIX WASTE">MIX WASTE</option>
										<option value="PLUMPUNG">PLUMPUNG</option>
										<option value="LAMINATING">LAMINATING</option>
										<option value="SLUDGE">SLUDGE</option>
										<option value="BROKE LAMINASI">BROKE LAMINASI</option>
										<option value="BROKE CORR">BROKE CORR</option>
										<option value="BROKE PM">BROKE PM</option>
									</select>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3"></div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="ket_bahan_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetBahan()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="ket_bahan_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetBahan()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="ket_bahan_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-9"></div>
								<div class="col-md-3">
									<input type="hidden" id="id_cart_bahan" value="777">
									<div class="tambah-bahan"></div>
								</div>
							</div>
							<!-- LIST KETERANGAN LAIN LAIN -->
							<div class="llll update-keterangan-bahan"></div>
							<div class="llll list-keterangan-bahan"></div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-3">PEMAKAIAN BAHAN</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="bahan_baku_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3"></div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="bahan_baku_rp" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- BIAYA PRODUKSI PM -->
					<div class="cbx card-biaya-produksi-pm" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">BIAYA PRODUKSI</h3>
							</div>
							<!-- UPAH -->
							<div class="card card-secondary" style="margin:12px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">UPAH</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<select id="ket_upah_txt" class="form-control select2">
											<option value="">PILIH</option>
											<option value="HARIAN LEPAS">HARIAN LEPAS</option>
											<option value="BORONGAN">BORONGAN</option>
											<option value="INSENTIF">INSENTIF</option>
											<option value="PHK">PHK</option>
										</select>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="ket_upah_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="hidden" id="id_cart_upah" value="111">
										<div class="tambah-upah"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN UPAH -->
								<div class="llll update-keterangan-upah"></div>
								<div class="llll list-keterangan-upah"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">UPAH</div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="upah" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" onkeyup="hitungBiayaProduksi()">
										</div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TENAGA KERJA</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="tenaga_kerja" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">THR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="thr" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">LISTRIK</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="listrik" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BATU BARA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="batu_bara_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="batu_bara_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="batu_bara_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BAHAN KIMIA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="chemical_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="chemical_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="chemical_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">B. PEMBANTU</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="bahan_pembantu" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">SOLAR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="solar" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MAINTENANCE</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="biaya_pemeliharaan" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">EKSPEDISI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="ekspedisi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">DEPRESIASI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="depresiasi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<!-- LAIN LAIN -->
							<div class="card card-secondary" style="margin:6px 12px 18px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">LAIN LAIN</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<input type="text" id="ket_dll_txt" class="form-control" autocomplete="off" placeholder="KETERANGAN" oninput="this.value = this.value.toUpperCase()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="ket_dll_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetLainLain()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="ket_dll_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetLainLain()">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="ket_dll_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-9"></div>
									<div class="col-md-3">
										<input type="hidden" id="id_cart_dll" value="333">
										<div class="tambah-dll"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN LAIN LAIN -->
								<div class="llll update-keterangan-dll"></div>
								<div class="llll list-keterangan-dll"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3">LAIN LAIN</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="lain_lain_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="lain_lain_rp" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9" style="font-style:italic;font-size:12px">*opsional</div>
								</div>
							</div>
						</div>
					</div>

					<!-- LIST HPP PM -->
						<div class="cbx card-list-hpp-pm" style="display:none">
							<div class="card card-info card-outline" style="padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST HPP PM</h3>
								</div>
								<div class="tampil-list-hpp-pm"></div>
							</div>
						</div>
					<!-- LIST HPP PM -->

					<!-- PEMAKAIAN BAHAN SHEET -->
					<div class="cbx card-pemakaian-bahan-sheet" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
							<div class="pb-sheet-bk" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:18px 12px">
									<div class="col-md-3">BK</div>
									<div class="col-md-3">
										<div class="input-group">
											<input type="text" id="bk_kg" class="form-control" style="text-align:right" placeholder="0" autocomplete="off" onkeyup="HitungBB('BK','sheet')">
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="bk_rp" class="form-control" style="text-align:right" placeholder="0" autocomplete="off" onkeyup="HitungBB('BK','sheet')">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="bk_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="pb-sheet-mh" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:18px 12px">
									<div class="col-md-3">MH</div>
									<div class="col-md-3">
										<div class="input-group">
											<input type="text" id="mh_kg" class="form-control" style="text-align:right" placeholder="0"  autocomplete="off" onkeyup="HitungBB('MH','sheet')">
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="mh_rp" class="form-control" style="text-align:right" placeholder="0"  autocomplete="off" onkeyup="HitungBB('MH','sheet')">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="mh_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- BIAYA PRODUKSI SHEET -->
					<div class="cbx card-biaya-produksi-sheet" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">BIAYA PRODUKSI</h3>
							</div>
							<!-- UPAH -->
							<div class="card card-secondary" style="margin:12px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">UPAH</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<select id="s_ket_upah_txt" class="form-control select2">
											<option value="">PILIH</option>
											<option value="HARIAN LEPAS">HARIAN LEPAS</option>
											<option value="BORONGAN">BORONGAN</option>
											<option value="INSENTIF">INSENTIF</option>
											<option value="PHK">PHK</option>
										</select>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="text" id="s_ket_upah_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="hidden" id="id_cart_upah_sheet" value="111">
										<div class="tambah-upah-sheet"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN UPAH -->
								<div class="llll update-keterangan-upah-sheet"></div>
								<div class="llll list-keterangan-upah-sheet"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">UPAH</div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="s_upah" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" onkeyup="hitungBiayaProduksi()" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TENAGA KERJA</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_tenaga_kerja" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">THR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_thr" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">LISTRIK</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_listrik" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BATU BARA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="s_batu_bara_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_batu_bara_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_batu_bara_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BAHAN KIMIA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="s_chemical_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_chemical_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_chemical_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">B. PEMBANTU</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_bahan_pembantu" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">SOLAR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_solar" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MAINTENANCE</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_biaya_pemeliharaan" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">EKSPEDISI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_ekspedisi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">DEPRESIASI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_depresiasi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<!-- LAIN LAIN -->
							<div class="card card-secondary" style="margin:6px 12px 18px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">LAIN LAIN</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<input type="text" id="s_ket_dll_txt" class="form-control" autocomplete="off" placeholder="KETERANGAN" oninput="this.value = this.value.toUpperCase()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="s_ket_dll_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetLainLain()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="s_ket_dll_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetLainLain()">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="s_ket_dll_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-9"></div>
									<div class="col-md-3">
										<input type="hidden" id="id_cart_dll_sheet" value="333">
										<div class="tambah-dll-sheet"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN LAIN LAIN -->
								<div class="llll update-keterangan-dll-sheet"></div>
								<div class="llll list-keterangan-dll-sheet"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3">LAIN LAIN</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="s_lain_lain_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="s_lain_lain_rp" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9" style="font-style:italic;font-size:12px">*opsional</div>
								</div>
							</div>
						</div>
					</div>

					<!-- PEMAKAIAN BAHAN BOX -->
					<div class="cbx card-pemakaian-bahan-box" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
							<div class="pb-box-bk" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:18px 12px">
									<div class="col-md-3">BK</div>
									<div class="col-md-3">
										<div class="input-group">
											<input type="text" id="bk_kg_box" class="form-control" style="text-align:right" placeholder="0" autocomplete="off" onkeyup="HitungBB('BK','box')">
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="bk_rp_box" class="form-control" style="text-align:right" placeholder="0" autocomplete="off" onkeyup="HitungBB('BK','box')">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="bk_x_box" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="pb-box-mh" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:18px 12px">
									<div class="col-md-3">MH</div>
									<div class="col-md-3">
										<div class="input-group">
											<input type="text" id="mh_kg_box" class="form-control" style="text-align:right" placeholder="0"  autocomplete="off" onkeyup="HitungBB('MH','box')">
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="mh_rp_box" class="form-control" style="text-align:right" placeholder="0"  autocomplete="off" onkeyup="HitungBB('MH','box')">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="mh_x_box" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- BIAYA PRODUKSI BOX -->
					<div class="cbx card-biaya-produksi-box" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">BIAYA PRODUKSI</h3>
							</div>
							<!-- UPAH -->
							<div class="card card-secondary" style="margin:12px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">UPAH</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<select id="b_ket_upah_txt" class="form-control select2">
											<option value="">PILIH</option>
											<option value="HARIAN LEPAS">HARIAN LEPAS</option>
											<option value="BORONGAN">BORONGAN</option>
											<option value="INSENTIF">INSENTIF</option>
											<option value="PHK">PHK</option>
										</select>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="text" id="b_ket_upah_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="hidden" id="id_cart_upah_box" value="111">
										<div class="tambah-upah-box"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN UPAH -->
								<div class="llll update-keterangan-upah-box"></div>
								<div class="llll list-keterangan-upah-box"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">UPAH</div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="b_upah" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" onkeyup="hitungBiayaProduksi()" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TENAGA KERJA</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_tenaga_kerja" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">THR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_thr" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">LISTRIK</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_listrik" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BATU BARA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="b_batu_bara_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="b_batu_bara_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_batu_bara_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
								<div class="col-md-3">BAHAN KIMIA</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<input type="text" id="b_chemical_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="margin-bottom:3px">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="b_chemical_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_chemical_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">B. PEMBANTU</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_bahan_pembantu" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">SOLAR</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_solar" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">MAINTENANCE</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_biaya_pemeliharaan" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">EKSPEDISI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_ekspedisi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">DEPRESIASI</div>
								<div class="col-md-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="b_depresiasi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
									</div>
								</div>
							</div>
							<!-- LAIN LAIN -->
							<div class="card card-secondary" style="margin:6px 12px 18px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">LAIN LAIN</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">KETERANGAN</div>
									<div class="col-md-9">
										<input type="text" id="b_ket_dll_txt" class="form-control" autocomplete="off" placeholder="KETERANGAN" oninput="this.value = this.value.toUpperCase()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="b_ket_dll_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetLainLain()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="b_ket_dll_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetLainLain()">
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="b_ket_dll_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-9"></div>
									<div class="col-md-3">
										<input type="hidden" id="id_cart_dll_box" value="333">
										<div class="tambah-dll-box"></div>
									</div>
								</div>
								<!-- LIST KETERANGAN LAIN LAIN -->
								<div class="llll update-keterangan-dll-box"></div>
								<div class="llll list-keterangan-dll-box"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3">LAIN LAIN</div>
									<div class="col-md-3">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="b_lain_lain_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-3"></div>
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="b_lain_lain_rp" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9" style="font-style:italic;font-size:12px">*opsional</div>
								</div>
							</div>
						</div>
					</div>

					<!-- PEMAKAIAN BAHAN LAMINASI -->
					<div class="cbx card-pemakaian-bahan-laminasi" style="display:none">
						PEMAKAIAN BAHAN LAMINASI
					</div>
					<!-- BIAYA PRODUKSI LAMINASI -->
					<div class="cbx card-biaya-produksi-laminasi" style="display:none">
						BIAYA PRODUKSI LAMINASI
					</div>

				</div>

				<div class="col-md-3">
					<div class="col-hitung-hpp" style="display:none">
						<div class="card card-primary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">HPP AKTUAL</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
								<div class="col-md-12">TOTAL</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="hasil_hpp" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">TONASE ORDER</div>
							</div>
							<div class="tonase-order-pm" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-12">
										<div class="input-group">
											<input type="text" id="tonase_order" class="form-control" style="color:#000;font-weight:bold;text-align:right" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungBiayaProduksi()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">KG</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tonase-order-sheet" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-12">
										<div class="input-group">
											<input type="text" id="s_tonase_order" class="form-control" style="color:#000;font-weight:bold;text-align:right" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungBiayaProduksi()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">KG</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tonase-order-box" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-12">
										<div class="input-group">
											<input type="text" id="b_tonase_order" class="form-control" style="color:#000;font-weight:bold;text-align:right" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungBiayaProduksi()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">KG</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">HPP</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="hasil_x_tonase" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-3"></div>
								<div class="col-md-9" style="text-align:right">
									<div id="btn-simpan"></div>
								</div>
							</div>
						</div>
						<input type="hidden" id="id_hpp" value="">
						<input type="hidden" id="pilih_id_hpp" value="">
						<input type="hidden" id="load_edit" value="">
					</div>

					<div class="col-hitung-hpp-tanpa-bb" style="display:none">
						<div class="card card-primary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">HPP TANPA BAHAN BAKU</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
								<div class="col-md-12">TOTAL</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="hasil_hpp_tanpa_bb" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">HPP</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="hasil_x_tonase_tanpa_bb" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">PRESENTASE ( % )</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<input type="text" id="presentase" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" value="10" onkeyup="hitungBiayaProduksi()">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px 12px;font-weight:bold;color:#000">%</span>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">HPP x PRESENTASE</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="hxt_x_persen" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">HPP + PRESENTASE</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="fix_hpp" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-hpp">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST HPP</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<div style="margin-bottom:12px">
								<button type="button" class="btn btn-sm btn-info" onclick="addHPP()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="text-align:center">#</th>
											<th style="text-align:center">HARI, TANGGAL</th>
											<th style="text-align:center">HPP</th>
											<th style="text-align:center">JENIS</th>
											<th style="text-align:center">TOTAL</th>
											<th style="text-align:center">TONASE ORDER</th>
											<th style="text-align:center">HASIL</th>
											<th style="text-align:center">AKSI</th>
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
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const periode = '<?= date('Y-m-d')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
		$(".llll").load("<?php echo base_url('Transaksi/destroyHPP') ?>")
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Transaksi/LoadDataHPP')?>',
				"type": "POST",
				// "data"  : { th_hub },
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function kosong()
	{
		$(".update-keterangan-bahan").html('')
		$(".update-keterangan-upah").html('')
		$(".update-keterangan-dll").html('')
		
		$(".update-keterangan-upah-sheet").html('')
		$(".update-keterangan-dll-sheet").html('')
		$(".update-keterangan-upah-box").html('')
		$(".update-keterangan-dll-box").html('')

		$("#pilih_hpp").val("").prop('disabled', false)
		$("#tgl1_hpp").val("").prop('disabled', true)
		$("#jenis_hpp").html('<option value="">PILIH</option>').prop('disabled', true)

		// PEMAKAIAN BAHAN
		$("#id_cart_bahan").val("777") // cart
		$("#ket_bahan_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_bahan_kg").val("").prop('disabled', false) // cart
		$("#ket_bahan_rp").val("").prop('disabled', false) // cart
		$("#ket_bahan_x").val("").prop('disabled', true) // cart
		$("#bahan_baku_kg").val("").prop('disabled', true)
		$("#bahan_baku_rp").val("").prop('disabled', true)

		// SHEET
		$("#bk_kg").val("")
		$("#bk_rp").val("")
		$("#bk_x").val("")
		$("#mh_kg").val("")
		$("#mh_rp").val("")
		$("#mh_x").val("")

		// BOX
		$("#bk_kg_box").val("")
		$("#bk_rp_box").val("")
		$("#bk_x_box").val("")
		$("#mh_kg_box").val("")
		$("#mh_rp_box").val("")
		$("#mh_x_box").val("")

		// BIAYA PRODUKSI
		$("#tenaga_kerja").val("").prop('disabled', false)
		$("#s_tenaga_kerja").val("").prop('disabled', false)
		$("#b_tenaga_kerja").val("").prop('disabled', false)

		// PM
		$("#id_cart_upah").val("111") // cart
		$("#ket_upah_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_upah_rp").val("").prop('disabled', false) // cart
		$("#upah").val("").prop('disabled', true)

		// SHEET
		$("#id_cart_upah_sheet").val("111") // cart
		$("#s_ket_upah_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#s_ket_upah_rp").val("").prop('disabled', false) // cart
		$("#s_upah").val("").prop('disabled', true)

		// BOX
		$("#id_cart_upah_box").val("111") // cart
		$("#b_ket_upah_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#b_ket_upah_rp").val("").prop('disabled', false) // cart
		$("#b_upah").val("").prop('disabled', true)

		$("#thr").val("").prop('disabled', false)
		$("#s_thr").val("").prop('disabled', false)
		$("#b_thr").val("").prop('disabled', false)
		$("#listrik").val("").prop('disabled', false)
		$("#s_listrik").val("").prop('disabled', false)
		$("#b_listrik").val("").prop('disabled', false)
		$("#batu_bara_kg").val("").prop('disabled', false)
		$("#s_batu_bara_kg").val("").prop('disabled', false)
		$("#b_batu_bara_kg").val("").prop('disabled', false)
		$("#batu_bara_rp").val("").prop('disabled', false)
		$("#s_batu_bara_rp").val("").prop('disabled', false)
		$("#b_batu_bara_rp").val("").prop('disabled', false)
		$("#batu_bara_x").val("").prop('disabled', true)
		$("#s_batu_bara_x").val("").prop('disabled', true)
		$("#b_batu_bara_x").val("").prop('disabled', true)
		$("#chemical_kg").val("").prop('disabled', false)
		$("#s_chemical_kg").val("").prop('disabled', false)
		$("#b_chemical_kg").val("").prop('disabled', false)
		$("#chemical_rp").val("").prop('disabled', false)
		$("#s_chemical_rp").val("").prop('disabled', false)
		$("#b_chemical_rp").val("").prop('disabled', false)
		$("#chemical_x").val("").prop('disabled', true)
		$("#s_chemical_x").val("").prop('disabled', true)
		$("#b_chemical_x").val("").prop('disabled', true)
		$("#bahan_pembantu").val("").prop('disabled', false)
		$("#s_bahan_pembantu").val("").prop('disabled', false)
		$("#b_bahan_pembantu").val("").prop('disabled', false)
		$("#solar").val("").prop('disabled', false)
		$("#s_solar").val("").prop('disabled', false)
		$("#b_solar").val("").prop('disabled', false)
		$("#biaya_pemeliharaan").val("").prop('disabled', false)
		$("#s_biaya_pemeliharaan").val("").prop('disabled', false)
		$("#b_biaya_pemeliharaan").val("").prop('disabled', false)
		$("#ekspedisi").val("").prop('disabled', false)
		$("#s_ekspedisi").val("").prop('disabled', false)
		$("#b_ekspedisi").val("").prop('disabled', false)
		$("#depresiasi").val("").prop('disabled', false)
		$("#s_depresiasi").val("").prop('disabled', false)
		$("#b_depresiasi").val("").prop('disabled', false)

		// PM
		$("#id_cart_dll").val("333") // cart
		$("#ket_dll_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_dll_kg").val("").prop('disabled', false) // cart
		$("#ket_dll_rp").val("").prop('disabled', false) // cart
		$("#ket_dll_x").val("").prop('disabled', true) // cart
		$("#lain_lain_kg").val("").prop('disabled', true)
		$("#lain_lain_rp").val("").prop('disabled', true)

		// SHEET
		$("#id_cart_dll_sheet").val("333") // cart
		$("#s_ket_dll_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#s_ket_dll_kg").val("").prop('disabled', false) // cart
		$("#s_ket_dll_rp").val("").prop('disabled', false) // cart
		$("#s_ket_dll_x").val("").prop('disabled', true) // cart
		$("#s_lain_lain_kg").val("").prop('disabled', true)
		$("#s_lain_lain_rp").val("").prop('disabled', true)

		// BOX
		$("#id_cart_dll_box").val("333") // cart
		$("#b_ket_dll_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#b_ket_dll_kg").val("").prop('disabled', false) // cart
		$("#b_ket_dll_rp").val("").prop('disabled', false) // cart
		$("#b_ket_dll_x").val("").prop('disabled', true) // cart
		$("#b_lain_lain_kg").val("").prop('disabled', true)
		$("#b_lain_lain_rp").val("").prop('disabled', true)

		// PERHITUNGAN HPP
		$("#hasil_hpp").val("").prop('disabled', true)
		$("#tonase_order").val("").prop('disabled', true)
		$("#s_tonase_order").val("").prop('disabled', true)
		$("#b_tonase_order").val("").prop('disabled', true)
		$("#hasil_x_tonase").val("").prop('disabled', true)

		$("#presentase").val("10").prop('disabled', true)
		$("#hasil_hpp_tanpa_bb").val("").prop('disabled', true)
		$("#hasil_x_tonase_tanpa_bb").val("").prop('disabled', true)
		$("#fix_hpp").val("").prop('disabled', true)

		// HIDDEN
		$("#id_hpp").val("")
		$("#pilih_id_hpp").val("")

		$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP('')"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
		swal.close()
	}

	function kembaliHPP()
	{
		reloadTable()
		$(".llll").load("<?php echo base_url('Transaksi/destroyHPP') ?>")
		$("#pilih_hpp").val("").trigger('change').prop('disabled', false)
		$("#tgl1_hpp").val("").prop('disabled', false)
		$("#jenis_hpp").html('<option value="">PILIH</option>').prop('disabled', false)
		$(".row-input-hpp").hide()
		$(".row-list-hpp").show()
		hideAll('', 'none')
		$(".cbx").attr('style', 'display:none')
		kosong()
	}

	function addHPP()
	{
		statusInput = 'insert'
		$(".row-input-hpp").show()
		$(".row-list-hpp").hide()
		hideAll('', 'none')
		kosong()
	}

	function hideAll(cbx, opsi)
	{
		$(".card-pemakaian-bahan-"+cbx).attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".card-biaya-produksi-"+cbx).attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".col-hitung-hpp").attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".col-hitung-hpp-tanpa-bb").attr('style', (opsi == 'show') ? '' : 'display:none')

		$(".tambah-bahan").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-upah").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-dll").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)

		$(".tambah-upah-sheet").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','sheet','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-dll-sheet").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','sheet','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)

		$(".tambah-upah-box").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','box','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-dll-box").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','box','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)

		if(cbx == 'pm'){
			$(".tonase-order-pm").show()
			$(".tonase-order-sheet").hide()
			$(".tonase-order-box").hide()
		}
		if(cbx == 'sheet'){
			$(".tonase-order-pm").hide()
			$(".tonase-order-sheet").show()
			$(".tonase-order-box").hide()
		}
		if(cbx == 'box'){
			$(".tonase-order-pm").hide()
			$(".tonase-order-sheet").hide()
			$(".tonase-order-box").show()
		}
	}

	function pilihHPP()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()

		if(pilih_hpp == ''){
			$("#pilih_hpp").val("").prop('disabled', false)
			$("#tgl1_hpp").val("").prop('disabled', true)
			$("#jenis_hpp").html('<option value="">PILIH</option>').prop('disabled', true)
		}
		if(pilih_hpp != '' && tgl_hpp == '' && (jenis_hpp == '' || jenis_hpp != '')){
			$("#pilih_hpp").prop('disabled', true)
			$("#tgl1_hpp").val("").prop('disabled', false);
			if(pilih_hpp == 'LAMINASI'){
				$("#jenis_hpp").html('<option value="">PILIH</option><option value="WP">WP</option>').prop('disabled', true)
			}else{
				$("#jenis_hpp").html('<option value="">PILIH</option><option value="BK">BK</option><option value="MH">MH</option>').prop('disabled', true)
			}
		}
		if(pilih_hpp != '' && tgl_hpp != '' && jenis_hpp == ''){
			$("#pilih_hpp").prop('disabled', true)
			$("#tgl1_hpp").prop('disabled', true)
			if(pilih_hpp == 'LAMINASI'){
				$("#jenis_hpp").html('<option value="">PILIH</option><option value="WP">WP</option>').prop('disabled', false)
			}else{
				$("#jenis_hpp").html('<option value="">PILIH</option><option value="BK">BK</option><option value="MH">MH</option>').prop('disabled', false)
			}
		}
		if(pilih_hpp != '' && tgl_hpp != '' && jenis_hpp != ''){
			$("#pilih_hpp").prop('disabled', true)
			$("#tgl1_hpp").prop('disabled', true)
			$("#jenis_hpp").prop('disabled', true)
		}

		$(".cbx").attr('style', 'display:none')
		if(pilih_hpp == "PM2" && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('pm', 'show')
		}else if(pilih_hpp == "BOX" && tgl_hpp != '' && jenis_hpp != ''){
			tampilListHpp('box')
			hideAll('box', 'show')
		}else if(pilih_hpp == "SHEET" && tgl_hpp != '' && jenis_hpp != ''){
			tampilListHpp('sheet')
			hideAll('sheet', 'show')
		}else if(pilih_hpp == "LAMINASI" && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('laminasi', 'show')
		}else{
			hideAll('', 'none')
		}
	}

	function tampilListHpp(opsi)
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		$(".card-list-hpp-pm").show()
		$.ajax({
			url: '<?php echo base_url('Transaksi/tampilListHpp')?>',
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
				pilih_hpp, tgl1_hpp, jenis_hpp, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".tampil-list-hpp-pm").html(data.html)
				if(opsi == 'sheet' && jenis_hpp == "MH"){
					$(".pb-sheet-mh").show()
					$(".pb-sheet-bk").hide()
				}
				if(opsi == 'sheet' && jenis_hpp == "BK"){
					$(".pb-sheet-mh").hide()
					$(".pb-sheet-bk").show()
				}

				if(opsi == 'box' && jenis_hpp == "MH"){
					$(".pb-box-mh").show()
					$(".pb-box-bk").hide()
				}
				if(opsi == 'box' && jenis_hpp == "BK"){
					$(".pb-box-mh").hide()
					$(".pb-box-bk").show()
				}
				swal.close()
			}
		})
	}

	function pilihListHPP(id_hpp, opsi)
	{
		$("#pilih_id_hpp").val("")
		$.ajax({
			url: '<?php echo base_url('Transaksi/pilihListHPP')?>',
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
				id_hpp
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(opsi == 'sheet'){
					$("#bk_rp").val(data.pm.hasil_x_tonase)
					$("#mh_rp").val(data.pm.hasil_x_tonase)
					HitungBB(data.pm.jenis_hpp, opsi)
				}
				if(opsi == 'box'){
					$("#bk_rp_box").val(data.pm.hasil_x_tonase)
					$("#mh_rp_box").val(data.pm.hasil_x_tonase)
					HitungBB(data.pm.jenis_hpp, opsi)
				}
				$("#pilih_id_hpp").val(data.pm.id_hpp)
				swal.close()
			}
		})
	}

	function keteranganHPP(opsi, jenis, id_hpp)
	{
		let ket_txt = ''
		let ket_kg = 0
		let ket_rp = 0
		let ket_x = 0
		if(opsi == 'upah' && jenis == 'pm'){
			ket_txt = $("#ket_upah_txt").val()
			ket_kg = 0
			ket_rp = $("#ket_upah_rp").val().split('.').join('')
			ket_x = 0
			id_cart = parseInt($("#id_cart_upah").val()) + 1
			$("#id_cart_upah").val(id_cart)
		}else if(opsi == 'upah' && jenis == 'sheet'){
			ket_txt = $("#s_ket_upah_txt").val()
			ket_kg = 0
			ket_rp = $("#s_ket_upah_rp").val().split('.').join('')
			ket_x = 0
			id_cart = parseInt($("#id_cart_upah_sheet").val()) + 1
			$("#id_cart_upah_sheet").val(id_cart)
		}else if(opsi == 'upah' && jenis == 'box'){
			ket_txt = $("#b_ket_upah_txt").val()
			ket_kg = 0
			ket_rp = $("#b_ket_upah_rp").val().split('.').join('')
			ket_x = 0
			id_cart = parseInt($("#id_cart_upah_box").val()) + 1
			$("#id_cart_upah_box").val(id_cart)
		}else if(opsi == 'bb'){
			ket_txt = $("#ket_bahan_txt").val()
			ket_kg = $("#ket_bahan_kg").val().split('.').join('')
			ket_rp = $("#ket_bahan_rp").val().split('.').join('')
			ket_x = $("#ket_bahan_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_bahan").val()) + 1
			$("#id_cart_bahan").val(id_cart)
		}else if(opsi == 'lainlain' && jenis == 'pm'){
			ket_txt = $("#ket_dll_txt").val()
			ket_kg = $("#ket_dll_kg").val().split('.').join('')
			ket_rp = $("#ket_dll_rp").val().split('.').join('')
			ket_x = $("#ket_dll_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_dll").val()) + 1
			$("#id_cart_dll").val(id_cart)
		}else if(opsi == 'lainlain' && jenis == 'sheet'){
			ket_txt = $("#s_ket_dll_txt").val()
			ket_kg = $("#s_ket_dll_kg").val().split('.').join('')
			ket_rp = $("#s_ket_dll_rp").val().split('.').join('')
			ket_x = $("#s_ket_dll_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_dll_sheet").val()) + 1
			$("#id_cart_dll_sheet").val(id_cart)
		}else if(opsi == 'lainlain' && jenis == 'box'){
			ket_txt = $("#b_ket_dll_txt").val()
			ket_kg = $("#b_ket_dll_kg").val().split('.').join('')
			ket_rp = $("#b_ket_dll_rp").val().split('.').join('')
			ket_x = $("#b_ket_dll_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_dll_box").val()) + 1
			$("#id_cart_dll_box").val(id_cart)
		}

		$.ajax({
			url: '<?php echo base_url('Transaksi/keteranganHPP')?>',
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
				opsi, jenis, id_hpp, ket_txt, ket_kg, ket_rp, ket_x, id_cart
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.valid){
					listKeteranganHPP(opsi, jenis, id_hpp)
				}else{
					toastr.error(`<b>${data.data}</b>`)
					swal.close()
				}
			}
		})
	}

	function listKeteranganHPP(opsi, jenis, id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/listKeteranganHPP')?>',
			type: "POST",
			data: ({
				opsi, jenis, id_hpp
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(opsi == 'upah' && jenis == 'pm'){
					$("#ket_upah_txt").html('<option value="">PILIH</option><option value="HARIAN LEPAS">HARIAN LEPAS</option><option value="BORONGAN">BORONGAN</option><option value="INSENTIF">INSENTIF</option><option value="PHK">PHK</option>')
					$("#ket_upah_rp").val("")
					$(".list-keterangan-upah").html(data.htmlUpah)
					$("#upah").val(data.sumUpah)
				}else if(opsi == 'upah' && jenis == 'sheet'){
					$("#s_ket_upah_txt").html('<option value="">PILIH</option><option value="HARIAN LEPAS">HARIAN LEPAS</option><option value="BORONGAN">BORONGAN</option><option value="INSENTIF">INSENTIF</option><option value="PHK">PHK</option>')
					$("#s_ket_upah_rp").val("")
					$(".list-keterangan-upah-sheet").html(data.htmlUpah)
					$("#s_upah").val(data.sumUpah)
				}else if(opsi == 'upah' && jenis == 'box'){
					$("#b_ket_upah_txt").html('<option value="">PILIH</option><option value="HARIAN LEPAS">HARIAN LEPAS</option><option value="BORONGAN">BORONGAN</option><option value="INSENTIF">INSENTIF</option><option value="PHK">PHK</option>')
					$("#b_ket_upah_rp").val("")
					$(".list-keterangan-upah-box").html(data.htmlUpah)
					$("#b_upah").val(data.sumUpah)
				}else if(opsi == 'bb'){
					$("#ket_bahan_txt").html('<option value="">PILIH</option><option value="LOCAL OCC">LOCAL OCC</option><option value="MIX WASTE">MIX WASTE</option><option value="PLUMPUNG">PLUMPUNG</option><option value="LAMINATING">LAMINATING</option><option value="SLUDGE">SLUDGE</option><option value="BROKE LAMINASI">BROKE LAMINASI</option><option value="BROKE CORR">BROKE CORR</option><option value="BROKE PM">BROKE PM</option>')
					$("#ket_bahan_kg").val("")
					$("#ket_bahan_rp").val("")
					$("#ket_bahan_x").val("")
					$(".list-keterangan-bahan").html(data.htmlBB)
					$("#bahan_baku_kg").val(data.sumBBkg)
					$("#bahan_baku_rp").val(data.sumBBrp)
				}else if(opsi == 'lainlain' && jenis == 'pm'){
					$("#ket_dll_txt").val("")
					$("#ket_dll_kg").val("")
					$("#ket_dll_rp").val("")
					$("#ket_dll_x").val("")
					$(".list-keterangan-dll").html(data.htmlLainLain)
					$("#lain_lain_kg").val(data.sumLLkg)
					$("#lain_lain_rp").val(data.sumLLrp)
				}else if(opsi == 'lainlain' && jenis == 'sheet'){
					$("#s_ket_dll_txt").val("")
					$("#s_ket_dll_kg").val("")
					$("#s_ket_dll_rp").val("")
					$("#s_ket_dll_x").val("")
					$(".list-keterangan-dll-sheet").html(data.htmlLainLain)
					$("#s_lain_lain_kg").val(data.sumLLkg)
					$("#s_lain_lain_rp").val(data.sumLLrp)
				}else if(opsi == 'lainlain' && jenis == 'box'){
					$("#b_ket_dll_txt").val("")
					$("#b_ket_dll_kg").val("")
					$("#b_ket_dll_rp").val("")
					$("#b_ket_dll_x").val("")
					$(".list-keterangan-dll-box").html(data.htmlLainLain)
					$("#b_lain_lain_kg").val(data.sumLLkg)
					$("#b_lain_lain_rp").val(data.sumLLrp)
				}

				hitungBiayaProduksi()
				swal.close()
			}
		})
	}

	function hapusKeteranganHPP(rowid, opsi, jenis, id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusKeteranganHPP')?>',
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
			data: ({ rowid }),
			success: function(res){
				listKeteranganHPP(opsi, jenis, id_hpp)
				swal.close()
			}
		})
	}

	function formatRupiah(angka)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator+ribuan.join('.');
        }
        return rupiah = split[1] != undefined ? rupiah+','+split[1] : rupiah;
    }

	$("#ket_upah_rp").on("keyup", function() {
		let ket_upah_rp = $("#ket_upah_rp").val()
		$("#ket_upah_rp").val(formatRupiah(ket_upah_rp))
	});

	$("#s_ket_upah_rp").on("keyup", function() {
		let ket_upah_rp = $("#s_ket_upah_rp").val()
		$("#s_ket_upah_rp").val(formatRupiah(ket_upah_rp))
	});

	$("#b_ket_upah_rp").on("keyup", function() {
		let ket_upah_rp = $("#b_ket_upah_rp").val()
		$("#b_ket_upah_rp").val(formatRupiah(ket_upah_rp))
	});

	// HITUNG PEMAKAIAN BAHAN PM
	function hitungKetBahan()
	{
		let ket_bahan_kg = $("#ket_bahan_kg").val()
		let ket_bahan_rp = $("#ket_bahan_rp").val()
		$("#ket_bahan_kg").val(formatRupiah(ket_bahan_kg))
		$("#ket_bahan_rp").val(formatRupiah(ket_bahan_rp))
		let h_ket_bahan_kg = (ket_bahan_kg == '' || isNaN(ket_bahan_kg)) ? 0 : parseInt(ket_bahan_kg.split('.').join(''));
		let h_ket_bahan_rp = (ket_bahan_rp == '' || isNaN(ket_bahan_rp)) ? 0 : parseInt(ket_bahan_rp.split('.').join(''));
		let x_h_ket_dll = 0;
		((h_ket_bahan_kg == '' || h_ket_bahan_kg == 0 || isNaN(h_ket_bahan_kg)) && h_ket_bahan_rp != 0) ? x_h_ket_dll = h_ket_bahan_rp : x_h_ket_dll = h_ket_bahan_kg * h_ket_bahan_rp;
		(isNaN(x_h_ket_dll)) ? x_h_ket_dll = 0 : x_h_ket_dll = x_h_ket_dll
		$("#ket_bahan_x").val(format_angka(x_h_ket_dll))
	}

	// HITUNG PEMAKAIAN BAHAN SHEET, BOX, LAMINASI
	function HitungBB(jenis, opsi)
	{
		let o = ''
		if(opsi == 'sheet'){
			o = ''
		}else if(opsi == 'box'){
			o = '_box'
		}
		if(jenis == 'BK'){
			let bk_kg = $("#bk_kg"+o).val()
			let bk_rp = $("#bk_rp"+o).val()
			$("#bk_kg"+o).val(formatRupiah(bk_kg))
			$("#bk_rp"+o).val(formatRupiah(bk_rp))
			let h_bk_kg = (bk_kg == '' || isNaN(bk_kg)) ? 0 : parseInt(bk_kg.split('.').join(''));
			let h_bk_rp = (bk_rp == '' || isNaN(bk_rp)) ? 0 : parseInt(bk_rp.split('.').join(''));
			let x_bk = 0;
			((h_bk_kg == '' || h_bk_kg == 0 || isNaN(h_bk_kg)) && h_bk_rp != 0) ? x_bk = h_bk_rp : x_bk = h_bk_kg * h_bk_rp;
			$("#bk_x"+o).val(format_angka(x_bk))
		}
		if(jenis == 'MH'){
			let mh_kg = $("#mh_kg"+o).val()
			let mh_rp = $("#mh_rp"+o).val()
			$("#mh_kg"+o).val(formatRupiah(mh_kg))
			$("#mh_rp"+o).val(formatRupiah(mh_rp))
			let h_mh_kg = (mh_kg == '' || isNaN(mh_kg)) ? 0 : parseInt(mh_kg.split('.').join(''));
			let h_mh_rp = (mh_rp == '' || isNaN(mh_rp)) ? 0 : parseInt(mh_rp.split('.').join(''));
			let x_mh = 0;
			((h_mh_kg == '' || h_mh_kg == 0 || isNaN(h_mh_kg)) && h_mh_rp != 0) ? x_mh = h_mh_rp : x_mh = h_mh_kg * h_mh_rp;
			$("#mh_x"+o).val(format_angka(x_mh))
		}
		hitungBiayaProduksi()
	}

	function hitungKetLainLain()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let o = ''
		if(pilih_hpp == 'PM2'){
			o = ''
		}else if(pilih_hpp == 'SHEET'){
			o = 's_'
		}else if(pilih_hpp == 'BOX'){
			o = 'b_'
		}

		let ket_dll_kg = $("#"+o+"ket_dll_kg").val()
		let ket_dll_rp = $("#"+o+"ket_dll_rp").val()
		$("#"+o+"ket_dll_kg").val(formatRupiah(ket_dll_kg))
		$("#"+o+"ket_dll_rp").val(formatRupiah(ket_dll_rp))
		let h_ket_dll_kg = (ket_dll_kg == '' || isNaN(ket_dll_kg)) ? 0 : parseInt(ket_dll_kg.split('.').join(''));
		let h_ket_dll_rp = (ket_dll_rp == '' || isNaN(ket_dll_rp)) ? 0 : parseInt(ket_dll_rp.split('.').join(''));
		let x_h_ket_dll = 0;
		((h_ket_dll_kg == '' || h_ket_dll_kg == 0 || isNaN(h_ket_dll_kg)) && h_ket_dll_rp != 0) ? x_h_ket_dll = h_ket_dll_rp : x_h_ket_dll = h_ket_dll_kg * h_ket_dll_rp;
		(isNaN(x_h_ket_dll)) ? x_h_ket_dll = 0 : x_h_ket_dll = x_h_ket_dll
		$("#"+o+"ket_dll_x").val(format_angka(x_h_ket_dll))
	}

	function hitungBatuBara()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let o = ''
		if(pilih_hpp == 'PM2'){
			o = ''
		}else if(pilih_hpp == 'SHEET'){
			o = 's_'
		}else if(pilih_hpp == 'BOX'){
			o = 'b_'
		}

		let batu_bara_kg = $("#"+o+"batu_bara_kg").val()
		let batu_bara_rp = $("#"+o+"batu_bara_rp").val()
		$("#"+o+"batu_bara_kg").val(formatRupiah(batu_bara_kg))
		$("#"+o+"batu_bara_rp").val(formatRupiah(batu_bara_rp))
		let h_batu_bara_kg = (batu_bara_kg == '' || isNaN(batu_bara_kg)) ? 0 : parseInt(batu_bara_kg.split('.').join(''));
		let h_batu_bara_rp = (batu_bara_rp == '' || isNaN(batu_bara_rp)) ? 0 : parseInt(batu_bara_rp.split('.').join(''));
		let x_batu_bara_rp = 0;
		((h_batu_bara_kg == '' || h_batu_bara_kg == 0 || isNaN(h_batu_bara_kg)) && h_batu_bara_rp != 0) ? x_batu_bara_rp = h_batu_bara_rp : x_batu_bara_rp = h_batu_bara_kg * h_batu_bara_rp;
		(isNaN(x_batu_bara_rp)) ? x_batu_bara_rp = 0 : x_batu_bara_rp = x_batu_bara_rp
		$("#"+o+"batu_bara_x").val(format_angka(x_batu_bara_rp))
		hitungBiayaProduksi()
	}

	function hitungBahanKimia()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let o = ''
		if(pilih_hpp == 'PM2'){
			o = ''
		}else if(pilih_hpp == 'SHEET'){
			o = 's_'
		}else if(pilih_hpp == 'BOX'){
			o = 'b_'
		}

		let chemical_kg = $("#"+o+"chemical_kg").val()
		let chemical_rp = $("#"+o+"chemical_rp").val()
		$("#"+o+"chemical_kg").val(formatRupiah(chemical_kg))
		$("#"+o+"chemical_rp").val(formatRupiah(chemical_rp))
		let h_chemical_kg = (chemical_kg == '' || isNaN(chemical_kg)) ? 0 : parseInt(chemical_kg.split('.').join(''));
		let h_chemical_rp = (chemical_rp == '' || isNaN(chemical_rp)) ? 0 : parseInt(chemical_rp.split('.').join(''));
		let x_chemical_rp = 0;
		((h_chemical_kg == '' || h_chemical_kg == 0 || isNaN(h_chemical_kg)) && h_chemical_rp != 0) ? x_chemical_rp = h_chemical_rp : x_chemical_rp = h_chemical_kg * h_chemical_rp;
		(isNaN(x_chemical_rp)) ? x_chemical_rp = 0 : x_chemical_rp = x_chemical_rp
		$("#"+o+"chemical_x").val(format_angka(x_chemical_rp))
		hitungBiayaProduksi()
	}

	function hitungBiayaProduksi()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val();
		let o = ''
		if(pilih_hpp == 'PM2'){
			o = ''
		}else if(pilih_hpp == 'SHEET'){
			o = 's_'
		}else if(pilih_hpp == 'BOX'){
			o = 'b_'
		}

		let bahan_baku_rp = 0;
		if(pilih_hpp == 'PM2'){
			bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')
		}else if(pilih_hpp == 'SHEET'){
			(jenis_hpp == 'MH') ? bahan_baku_rp =  $("#mh_x").val().split('.').join('') : bahan_baku_rp =  $("#bk_x").val().split('.').join(''); // sheet
		}else if(pilih_hpp == 'BOX'){
			(jenis_hpp == 'MH') ? bahan_baku_rp =  $("#mh_x_box").val().split('.').join('') : bahan_baku_rp =  $("#bk_x_box").val().split('.').join(''); // box
		}

		// let bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')
		let tenaga_kerja = $("#"+o+"tenaga_kerja").val().split('.').join('')
		let upah = $("#"+o+"upah").val().split('.').join('')
		let thr = $("#"+o+"thr").val().split('.').join('')
		let listrik = $("#"+o+"listrik").val().split('.').join('')
		let batu_bara_x = $("#"+o+"batu_bara_x").val().split('.').join('')
		let chemical_x = $("#"+o+"chemical_x").val().split('.').join('')
		let bahan_pembantu = $("#"+o+"bahan_pembantu").val().split('.').join('')
		let solar = $("#"+o+"solar").val().split('.').join('')
		let biaya_pemeliharaan = $("#"+o+"biaya_pemeliharaan").val().split('.').join('')
		let ekspedisi = $("#"+o+"ekspedisi").val().split('.').join('')
		let depresiasi = $("#"+o+"depresiasi").val().split('.').join('')
		let lain_lain_rp = $("#"+o+"lain_lain_rp").val().split('.').join('')

		$("#"+o+"tenaga_kerja").val(formatRupiah(tenaga_kerja))
		$("#"+o+"upah").val(formatRupiah(upah))
		$("#"+o+"thr").val(formatRupiah(thr))
		$("#"+o+"listrik").val(formatRupiah(listrik))
		$("#"+o+"bahan_pembantu").val(formatRupiah(bahan_pembantu))
		$("#"+o+"solar").val(formatRupiah(solar))
		$("#"+o+"biaya_pemeliharaan").val(formatRupiah(biaya_pemeliharaan))
		$("#"+o+"ekspedisi").val(formatRupiah(ekspedisi))
		$("#"+o+"depresiasi").val(formatRupiah(depresiasi))
		$("#"+o+"lain_lain_rp").val(formatRupiah(lain_lain_rp))

		let h_bahan_baku_rp = (bahan_baku_rp == '' || isNaN(bahan_baku_rp)) ? 0 : parseInt(bahan_baku_rp);
		let h_tenaga_kerja = (tenaga_kerja == '' || isNaN(tenaga_kerja)) ? 0 : parseInt(tenaga_kerja.split('.').join(''));
		let h_upah = (upah == '' || isNaN(upah)) ? 0 : parseInt(upah.split('.').join(''));
		let h_thr = (thr == '' || isNaN(thr)) ? 0 : parseInt(thr.split('.').join(''));
		let h_listrik = (listrik == '' || isNaN(listrik)) ? 0 : parseInt(listrik.split('.').join(''));
		let h_batu_bara_x = (batu_bara_x == '' || isNaN(batu_bara_x)) ? 0 : parseInt(batu_bara_x);
		let h_chemical_x = (chemical_x == '' || isNaN(chemical_x)) ? 0 : parseInt(chemical_x);
		let h_bahan_pembantu = (bahan_pembantu == '' || isNaN(bahan_pembantu)) ? 0 : parseInt(bahan_pembantu.split('.').join(''));
		let h_solar = (solar == '' || isNaN(solar)) ? 0 : parseInt(solar.split('.').join(''));
		let h_biaya_pemeliharaan = (biaya_pemeliharaan == '' || isNaN(biaya_pemeliharaan)) ? 0 : parseInt(biaya_pemeliharaan.split('.').join(''));
		let h_ekspedisi = (ekspedisi == '' || isNaN(ekspedisi)) ? 0 : parseInt(ekspedisi.split('.').join(''));
		let h_depresiasi = (depresiasi == '' || isNaN(depresiasi)) ? 0 : parseInt(depresiasi.split('.').join(''));
		let h_lain_lain_rp = (lain_lain_rp == '' || isNaN(lain_lain_rp)) ? 0 : parseInt(lain_lain_rp.split('.').join(''));

		// HPP
		let hitung_hpp = h_bahan_baku_rp + h_tenaga_kerja + h_upah + h_thr + h_listrik + h_batu_bara_x + h_chemical_x + h_bahan_pembantu + h_solar + h_biaya_pemeliharaan + h_ekspedisi + h_depresiasi + h_lain_lain_rp;
		(isNaN(hitung_hpp) || hitung_hpp == '' || hitung_hpp == 0) ? hitung_hpp = hitung_hpp : hitung_hpp = hitung_hpp;
		$("#hasil_hpp").val(formatRupiah(hitung_hpp.toString()));
		
		// HPP TANPA BAHAN BAKU
		let hitung_hpp_tanpa_bb = h_tenaga_kerja + h_upah + h_thr + h_listrik + h_batu_bara_x + h_chemical_x + h_bahan_pembantu + h_solar + h_biaya_pemeliharaan + h_ekspedisi + h_depresiasi + h_lain_lain_rp;
		(isNaN(hitung_hpp_tanpa_bb) || hitung_hpp_tanpa_bb == '' || hitung_hpp_tanpa_bb == 0) ? hitung_hpp_tanpa_bb = hitung_hpp_tanpa_bb : hitung_hpp_tanpa_bb = hitung_hpp_tanpa_bb;
		$("#hasil_hpp_tanpa_bb").val(formatRupiah(hitung_hpp_tanpa_bb.toString()));

		// HPP * TONASE ORDER
		(hitung_hpp != 0) ? $("#"+o+"tonase_order").prop('disabled', false) : $("#"+o+"tonase_order").prop('disabled', true);
		let tonase_order =  $("#"+o+"tonase_order").val()
		$("#"+o+"tonase_order").val(formatRupiah(tonase_order))
		let h_tonase_order = tonase_order.split('.').join('')
		let hasil_x_tonase = 0;
		(hitung_hpp == 0 || h_tonase_order == '') ? hasil_x_tonase = 0 : hasil_x_tonase = Math.round(parseInt(hitung_hpp) / parseInt(h_tonase_order).toFixed()).toFixed();
		$("#hasil_x_tonase").val(formatRupiah(hasil_x_tonase.toString()))

		// HASIL X TONASE TANPA BAHAN BAKU
		let hxt_tanpa_bb = 0;
		(hitung_hpp == 0 || h_tonase_order == '') ? hxt_tanpa_bb = 0 : hxt_tanpa_bb = Math.round(parseInt(hitung_hpp_tanpa_bb) / parseInt(h_tonase_order).toFixed()).toFixed();
		$("#hasil_x_tonase_tanpa_bb").val(formatRupiah(hxt_tanpa_bb.toString()));
		
		// HPP TONASE ORDER PRESENTASE
		(hitung_hpp_tanpa_bb != 0) ? $("#presentase").prop('disabled', false) : $("#presentase").prop('disabled', true);
		let presentase = $("#presentase").val()
		let h_presentase = (presentase == '' || isNaN(presentase)) ? 0 : parseInt(presentase);
		let hxt_x_persen = Math.round((parseInt(hxt_tanpa_bb) * (h_presentase / 100)))
		let fix_hpp = parseInt(hxt_tanpa_bb) + Math.round((parseInt(hxt_tanpa_bb) * (h_presentase / 100)))
		$("#hxt_x_persen").val(formatRupiah(hxt_x_persen.toString()))
		$("#fix_hpp").val(formatRupiah(fix_hpp.toString()))
	}

	function simpanHPP(opsi)
	{
		let id_hpp = $("#id_hpp").val()
		let pilih_id_hpp = $("#pilih_id_hpp").val()

		// PILIH HPP
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()

		// PEMAKAIAN BAHAN
		let bahan_baku_kg = 0
		let bahan_baku_rp = 0
		let bahan_baku_x = 0
		if(pilih_hpp == 'PM2'){
			bahan_baku_kg = $("#bahan_baku_kg").val().split('.').join('')
			bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')
			bahan_baku_x = 0
		}else if(pilih_hpp == 'SHEET' && jenis_hpp == 'BK'){
			bahan_baku_kg = $("#bk_kg").val().split('.').join('')
			bahan_baku_rp = $("#bk_rp").val().split('.').join('')
			bahan_baku_x = $("#bk_x").val().split('.').join('')
		}else if(pilih_hpp == 'SHEET' && jenis_hpp == 'MH'){
			bahan_baku_kg = $("#mh_kg").val().split('.').join('')
			bahan_baku_rp = $("#mh_rp").val().split('.').join('')
			bahan_baku_x = $("#mh_x").val().split('.').join('')
		}else if(pilih_hpp == 'BOX' && jenis_hpp == 'BK'){
			bahan_baku_kg = $("#bk_kg_box").val().split('.').join('')
			bahan_baku_rp = $("#bk_rp_box").val().split('.').join('')
			bahan_baku_x = $("#bk_x_box").val().split('.').join('')
		}else if(pilih_hpp == 'BOX' && jenis_hpp == 'MH'){
			bahan_baku_kg = $("#mh_kg_box").val().split('.').join('')
			bahan_baku_rp = $("#mh_rp_box").val().split('.').join('')
			bahan_baku_x = $("#mh_x_box").val().split('.').join('')
		}

		// BIAYA PRODUKSI
		let o = ''
		if(pilih_hpp == 'PM2'){
			o = ''
		}else if(pilih_hpp == 'SHEET'){
			o = 's_'
		}else if(pilih_hpp == 'BOX'){
			o = 'b_'
		}

		let tenaga_kerja = $("#"+o+"tenaga_kerja").val().split('.').join('')
		let upah = $("#"+o+"upah").val().split('.').join('')
		let thr = $("#"+o+"thr").val().split('.').join('')
		let listrik = $("#"+o+"listrik").val().split('.').join('')
		let batu_bara_kg = $("#"+o+"batu_bara_kg").val().split('.').join('')
		let batu_bara_rp = $("#"+o+"batu_bara_rp").val().split('.').join('')
		let batu_bara_x = $("#"+o+"batu_bara_x").val().split('.').join('')
		let chemical_kg = $("#"+o+"chemical_kg").val().split('.').join('')
		let chemical_rp = $("#"+o+"chemical_rp").val().split('.').join('')
		let chemical_x = $("#"+o+"chemical_x").val().split('.').join('')
		let bahan_pembantu = $("#"+o+"bahan_pembantu").val().split('.').join('')
		let solar = $("#"+o+"solar").val().split('.').join('')
		let biaya_pemeliharaan = $("#"+o+"biaya_pemeliharaan").val().split('.').join('')
		let ekspedisi = $("#"+o+"ekspedisi").val().split('.').join('')
		let depresiasi = $("#"+o+"depresiasi").val().split('.').join('')
		let lain_lain_kg = $("#"+o+"lain_lain_kg").val().split('.').join('')
		let lain_lain_rp = $("#"+o+"lain_lain_rp").val().split('.').join('')

		// HITUNG HPP
		let hasil_hpp = $("#hasil_hpp").val().split('.').join('')
		let tonase_order = $("#"+o+"tonase_order").val().split('.').join('')
		let hasil_x_tonase = $("#hasil_x_tonase").val().split('.').join('')

		let presentase = $("#presentase").val()
		let hasil_hpp_tanpa_bb = $("#hasil_hpp_tanpa_bb").val().split('.').join('')
		let hasil_x_tonase_tanpa_bb = $("#hasil_x_tonase_tanpa_bb").val().split('.').join('')
		let hxt_x_persen = $("#hxt_x_persen").val().split('.').join('')
		let fix_hpp = $("#fix_hpp").val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/simpanHPP')?>',
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
				id_hpp, pilih_id_hpp, pilih_hpp, tgl1_hpp, jenis_hpp, bahan_baku_kg, bahan_baku_rp, bahan_baku_x, tenaga_kerja, upah, thr, listrik, batu_bara_kg, batu_bara_rp, batu_bara_x, chemical_kg, chemical_rp, chemical_x, bahan_pembantu, solar, biaya_pemeliharaan, ekspedisi, depresiasi, lain_lain_kg, lain_lain_rp, hasil_hpp, tonase_order, hasil_x_tonase, hxt_x_persen, presentase, hasil_hpp_tanpa_bb, hasil_x_tonase_tanpa_bb, fix_hpp, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(opsi == ''){
					if(data.valid){
						toastr.success(`<b>BERHASIL SIMPAN!</b>`)
						kembaliHPP()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
					}
					swal.close()
				}
			}
		})
	}

	function editHPP(id_hpp, opsi)
	{
		$(".update-keterangan-bahan").html('')
		$(".update-keterangan-upah").html('')
		$(".update-keterangan-dll").html('')
		$(".update-keterangan-upah-sheet").html('')
		$(".update-keterangan-dll-sheet").html('')
		$(".update-keterangan-upah-box").html('')
		$(".update-keterangan-dll-box").html('')
		$.ajax({
			url: '<?php echo base_url('Transaksi/editHPP')?>',
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
			data: ({ id_hpp, opsi }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".row-list-hpp").hide()
				$(".row-input-hpp").show()

				$("#id_hpp").val(data.data.id_hpp)
				$("#pilih_id_hpp").val("")

				let prop = true;
				(opsi == 'edit') ? prop = false : prop = true;
				$("#pilih_hpp").val(data.data.pilih_hpp).prop('disabled', true).trigger("change")
				$("#tgl1_hpp").val(data.data.tgl_hpp).prop('disabled', true)
				$("#jenis_hpp").html(`<option value="${data.data.jenis_hpp}">${data.data.jenis_hpp}</option>`).prop('disabled', true)
				$(".card-list-hpp-pm").hide()

				if(data.data.pilih_hpp == "PM2"){
					hideAll('pm', 'show')
				}else if(data.data.pilih_hpp == "BOX"){
					hideAll('box', 'show')
				}else if(data.data.pilih_hpp == "SHEET"){
					hideAll('sheet', 'show')
				}else if(data.data.pilih_hpp == "LAMINASI"){
					hideAll('laminasi', 'show')
				}

				if(data.data.pilih_hpp == "SHEET" && data.data.jenis_hpp == "MH"){
					$(".pb-sheet-mh").show()
					$(".pb-sheet-bk").hide()
				}
				if(data.data.pilih_hpp == "SHEET" && data.data.jenis_hpp == "BK"){
					$(".pb-sheet-mh").hide()
					$(".pb-sheet-bk").show()
				}
				if(data.data.pilih_hpp == "BOX" && data.data.jenis_hpp == "MH"){
					$(".pb-box-mh").show()
					$(".pb-box-bk").hide()
				}
				if(data.data.pilih_hpp == "BOX" && data.data.jenis_hpp == "BK"){
					$(".pb-box-mh").hide()
					$(".pb-box-bk").show()
				}

				let o = ''
				if(data.data.pilih_hpp == 'PM2'){
					o = ''
				}else if(data.data.pilih_hpp == 'SHEET'){
					o = 's_'
				}else if(data.data.pilih_hpp == 'BOX'){
					o = 'b_'
				}

				$("#"+o+"ket_bahan_txt").prop('disabled', prop)
				$("#"+o+"ket_bahan_kg").prop('disabled', prop)
				$("#"+o+"ket_bahan_rp").prop('disabled', prop)
				if(data.data.pilih_hpp == 'PM2'){
					$("#"+o+"bahan_baku_kg").val(data.data.bahan_baku_kg)
					$("#"+o+"bahan_baku_rp").val(data.data.bahan_baku_rp)
				}else if(data.data.pilih_hpp == 'SHEET' && data.data.jenis_hpp == 'BK'){
					$("#bk_kg").val(data.data.bahan_baku_kg).prop('disabled', prop)
					$("#bk_rp").val(data.data.bahan_baku_rp).prop('disabled', prop)
					$("#bk_x").val(data.data.bahan_baku_x)
				}else if(data.data.pilih_hpp == 'SHEET' && data.data.jenis_hpp == 'MH'){
					$("#mh_kg").val(data.data.bahan_baku_kg).prop('disabled', prop)
					$("#mh_rp").val(data.data.bahan_baku_rp).prop('disabled', prop)
					$("#mh_x").val(data.data.bahan_baku_x)
				}else if(data.data.pilih_hpp == 'BOX' && data.data.jenis_hpp == 'BK'){
					$("#bk_kg_box").val(data.data.bahan_baku_kg).prop('disabled', prop)
					$("#bk_rp_box").val(data.data.bahan_baku_rp).prop('disabled', prop)
					$("#bk_x_box").val(data.data.bahan_baku_x)
				}else if(data.data.pilih_hpp == 'BOX' && data.data.jenis_hpp == 'MH'){
					$("#mh_kg_box").val(data.data.bahan_baku_kg).prop('disabled', prop)
					$("#mh_rp_box").val(data.data.bahan_baku_rp).prop('disabled', prop)
					$("#mh_x_box").val(data.data.bahan_baku_x)
				}

				$("#"+o+"tenaga_kerja").val(data.data.tenaga_kerja).prop('disabled', prop)
				$("#"+o+"ket_upah_txt").prop('disabled', prop)
				$("#"+o+"ket_upah_rp").prop('disabled', prop)
				$("#"+o+"upah").val(data.data.upah)
				$("#"+o+"thr").val(data.data.thr).prop('disabled', prop)
				$("#"+o+"listrik").val(data.data.listrik).prop('disabled', prop)
				$("#"+o+"batu_bara_kg").val(data.data.batu_bara_kg).prop('disabled', prop)
				$("#"+o+"batu_bara_rp").val(data.data.batu_bara_rp).prop('disabled', prop)
				$("#"+o+"batu_bara_x").val(data.data.batu_bara_x)
				$("#"+o+"chemical_kg").val(data.data.chemical_kg).prop('disabled', prop)
				$("#"+o+"chemical_rp").val(data.data.chemical_rp).prop('disabled', prop)
				$("#"+o+"chemical_x").val(data.data.chemical_x)
				$("#"+o+"bahan_pembantu").val(data.data.bahan_pembantu).prop('disabled', prop)
				$("#"+o+"solar").val(data.data.solar).prop('disabled', prop)
				$("#"+o+"biaya_pemeliharaan").val(data.data.maintenance).prop('disabled', prop)
				$("#"+o+"ekspedisi").val(data.data.ekspedisi).prop('disabled', prop)
				$("#"+o+"depresiasi").val(data.data.depresiasi).prop('disabled', prop)

				$("#"+o+"ket_dll_txt").prop('disabled', prop)
				$("#"+o+"ket_dll_kg").prop('disabled', prop)
				$("#"+o+"ket_dll_rp").prop('disabled', prop)
				$("#"+o+"lain_lain_kg").val(data.data.lain_lain_kg)
				$("#"+o+"lain_lain_rp").val(data.data.lain_lain_rp)

				$("#hasil_hpp").val(data.data.hasil_hpp)
				$("#"+o+"tonase_order").val(data.data.tonase_order).prop('disabled', prop)
				$("#hasil_x_tonase").val(data.data.hasil_x_tonase)

				$("#presentase").val(data.data.presentase).prop('disabled', prop)
				$("#hasil_hpp_tanpa_bb").val(data.data.hasil_hpp_tanpa_bb)
				$("#hasil_x_tonase_tanpa_bb").val(data.data.hasil_x_tonase_tanpa_bb)
				$("#hxt_x_persen").val(data.data.hxt_x_persen)
				$("#fix_hpp").val(data.data.fix_hpp)

				if(data.data.pilih_hpp == 'PM2'){
					$(".update-keterangan-bahan").html(data.htmlBB)
					$(".update-keterangan-upah").html(data.htmlUpah)
					$(".update-keterangan-dll").html(data.htmlLainLain)
				}
				if(data.data.pilih_hpp == 'SHEET'){
					$(".update-keterangan-upah-sheet").html(data.htmlUpah)
					$(".update-keterangan-dll-sheet").html(data.htmlLainLain)
				}
				if(data.data.pilih_hpp == 'BOX'){
					$(".update-keterangan-upah-box").html(data.htmlUpah)
					$(".update-keterangan-dll-box").html(data.htmlLainLain)
				}

				if(opsi == 'edit' && data.data.pilih_hpp == 'PM2'){
					$(".tambah-bahan").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-upah").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-dll").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
				}else{
					$(".tambah-bahan").html('')
					$(".tambah-upah").html('')
					$(".tambah-dll").html('')
				}
				if(opsi == 'edit' && data.data.pilih_hpp == 'SHEET'){
					$(".tambah-upah-sheet").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','sheet','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-dll-sheet").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','sheet','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
				}else{
					$(".tambah-upah-sheet").html('')
					$(".tambah-dll-sheet").html('')
				}
				if(opsi == 'edit' && data.data.pilih_hpp == 'BOX'){
					$(".tambah-upah-box").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','box','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-dll-box").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','box','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
				}else{
					$(".tambah-upah-box").html('')
					$(".tambah-dll-box").html('')
				}

				if(opsi == 'edit'){
					$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP('')"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
				}else{
					$("#btn-simpan").html('')
				}

				statusInput = 'update'
				swal.close()
			}
		})
	}

	function hapusKetEditHPP(id_dtl, id_hpp, jenis, ooo, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusKetEditHPP')?>',
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
				id_dtl, id_hpp, jenis, ooo, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				editHPP(id_hpp, opsi)
			}
		})
	}

	function hapusHPP(id_hpp, pilih_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusHPP')?>',
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
			data: ({ id_hpp, pilih_hpp }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				kembaliHPP()
			}
		})
	}
</script>
