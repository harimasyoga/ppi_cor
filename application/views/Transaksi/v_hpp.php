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
				<div class="col-md-6">
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
									<!-- <option value="PM1">PM1</option> -->
									<option value="PM2">PM2</option>
									<option value="LAMINASI">LAMINASI</option>
									<option value="CORR">CORR</option>
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
								<select id="jenis_hpp" class="form-control select2" onchange="pilihHPP()">
									<option value="">PILIH</option>
									<option value="BK">BK</option>
									<option value="MH">MH</option>
									<option value="WP">WP</option>
								</select>
							</div>
						</div>
						<div class="tampil_corr">
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">PILIH</div>
								<div class="col-md-9">
									<select id="jenis_cor" class="form-control select2" onchange="pilihHPP()">
										<option value="">PILIH</option>
										<option value="CORR">CORR</option>
										<option value="SHEET">SHEET</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="card-pemakaian-bahan" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
							<!-- PEMAKAIAN BAHAN -->
							<div class="card card-info" style="margin:12px;padding-bottom:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">PM</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
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
									<div class="col-md-4">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="ket_bahan_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetBahan()">
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="ket_bahan_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetBahan()">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-7"></div>
									<div class="col-md-5">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
											</div>
											<input type="text" id="ket_bahan_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-7"></div>
									<div class="col-md-5">
										<input type="hidden" id="id_cart_bahan" value="777">
										<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','pm')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>
									</div>
								</div>
								<!-- LIST KETERANGAN LAIN LAIN -->
								<div class="llll list-keterangan-bahan"></div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">PEMAKAIAN BAHAN</div>
									<div class="col-md-4">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="bahan_baku_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
											<div class="input-group-append">
												<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-5">
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
					</div>

					<div class="card-biaya-produksi" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">BIAYA PRODUKSI</h3>
							</div>
							<div class="card card-info" style="margin:12px">
								<div class="card-header" style="padding:12px;margin-bottom:18px">
									<h3 class="card-title" style="font-weight:bold;font-size:16px">PM</h3>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">TENAGA KERJA</div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="tenaga_kerja" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
										</div>
									</div>
								</div>
								<!-- UPAH -->
								<div class="card card-secondary" style="margin:6px 12px 12px;padding-bottom:12px">
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
											<input type="text" id="ket_upah_rp" class="form-control" style="text-align:right" autocomplete="off" placeholder="0">
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<input type="hidden" id="id_cart_upah" value="111">
											<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','pm')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>
										</div>
									</div>
									<!-- LIST KETERANGAN UPAH -->
									<div class="llll list-keterangan-upah"></div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-3">UPAH</div>
										<div class="col-md-9">
											<input type="text" id="upah" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" onkeyup="hitungBiayaProduksi()">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">THR</div>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
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
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="listrik" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
									<div class="col-md-3">BATU BARA</div>
									<div class="col-md-4">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="batu_bara_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBatuBara()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="batu_bara_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungBatuBara()">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-7"></div>
									<div class="col-md-5">
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
									<div class="col-md-4">
										<div class="input-group" style="margin-bottom:3px">
											<input type="text" id="chemical_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBahanKimia()">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Kg</span>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="chemical_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungBahanKimia()">
										</div>
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-7"></div>
									<div class="col-md-5">
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
												<span class="input-group-text" style="padding:6px">Rp</span>
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
												<span class="input-group-text" style="padding:6px">Rp</span>
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
												<span class="input-group-text" style="padding:6px">Rp</span>
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
												<span class="input-group-text" style="padding:6px">Rp</span>
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
												<span class="input-group-text" style="padding:6px">Rp</span>
											</div>
											<input type="text" id="depresiasi" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungBiayaProduksi()">
										</div>
									</div>
								</div>
								<!-- LAIN LAIN -->
								<div class="card card-secondary" style="margin:6px 12px 12px;padding-bottom:12px">
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
										<div class="col-md-4">
											<div class="input-group" style="margin-bottom:3px">
												<input type="text" id="ket_dll_kg" class="form-control" style="text-align:right" autocomplete="off" placeholder="0" onkeyup="hitungKetLainLain()">
												<div class="input-group-prepend">
													<span class="input-group-text" style="padding:6px">Kg</span>
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" style="padding:6px">Rp</span>
												</div>
												<input type="text" id="ket_dll_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="hitungKetLainLain()">
											</div>
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-7"></div>
										<div class="col-md-5">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
												</div>
												<input type="text" id="ket_dll_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled onkeyup="hitungKetLainLain()">
											</div>
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
										<div class="col-md-7"></div>
										<div class="col-md-5">
											<input type="hidden" id="id_cart_dll" value="333">
											<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','pm')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>
										</div>
									</div>
									<!-- LIST KETERANGAN LAIN LAIN -->
									<div class="llll list-keterangan-dll"></div>
									<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
										<div class="col-md-3">LAIN LAIN</div>
										<div class="col-md-4">
											<div class="input-group" style="margin-bottom:3px">
												<input type="text" id="lain_lain_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
												<div class="input-group-prepend">
													<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
												</div>
											</div>
										</div>
										<div class="col-md-5">
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
					</div>
				</div>

				<div class="col-md-6">
					<div class="col-hitung-hpp" style="display:none">
						<div class="card card-primary card-outline" style="position:sticky;top:12px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">HITUNG HPP</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">HPP</div>
								<div class="col-md-9">
									<input type="text" id="hasil_hpp" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="HPP" disabled>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">TONASE ORDER</div>
								<div class="col-md-9">
									<input type="text" id="tonase_order" class="form-control" style="color:#000;font-weight:bold;text-align:right" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungBiayaProduksi()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<input type="text" id="hasil_x_tonanse" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="HPP / TONASE ORDER" disabled onkeyup="hitungBiayaProduksi()">
								</div>
							</div>
							<div class="hitung-presentase" style="display:none">
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3">PRESENTASE</div>
									<div class="col-md-9">
										<input type="number" id="presentase" class="form-control" autocomplete="off" placeholder="PRESENTASE" onkeyup="hitungHPP()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
									<div class="col-md-3"></div>
									<div class="col-md-9">
										<input type="text" id="hxt_x_persen" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HxT X PRESENTASE" onkeyup="hitungHPP()">
									</div>
								</div>
								<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
									<div class="col-md-3">HASIL AKHIR</div>
									<div class="col-md-9">
										<input type="text" id="fix_hpp" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HASIL AKHIR" disabled onkeyup="hitungHPP()">
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
							<table id="datatable" class="table table-bordered table-striped" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;width:6%">#</th>
										<th style="text-align:center;width:14%">PERIODE</th>
										<th style="text-align:center;width:10%">HPP</th>
										<th style="text-align:center;width:18%">HASIL</th>
										<th style="text-align:center;width:18%">TONASE ORDER</th>
										<th style="text-align:center;width:6%">%</th>
										<th style="text-align:center;width:18%">HASIL AKHIR</th>
										<th style="text-align:center;width:10%">AKSI</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
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
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function kosong()
	{
		$("#id_hpp").val("")
		$("#tgl1_hpp").val("").prop('disabled', false)
		$("#jenis_hpp").val("").prop('disabled', false)
		$("#jenis_cor").val("").prop('disabled', false)
		$(".tampil_corr").hide()

		// PEMAKAIAN BAHAN
		$("#id_cart_bahan").val("777") // cart
		$("#ket_bahan_txt").val("").trigger('change') // cart
		$("#ket_bahan_kg").val("") // cart
		$("#ket_bahan_rp").val("") // cart
		$("#ket_bahan_x").val("") // cart
		$("#bahan_baku_kg").val("").prop('disabled', true).removeClass('is-invalid')
		$("#bahan_baku_rp").val("").prop('disabled', true).removeClass('is-invalid')

		// BIAYA PRODUKSI
		$("#tenaga_kerja").val("").prop('disabled', false).removeClass('is-invalid')

		$("#id_cart_upah").val("111") // cart
		$("#ket_upah_txt").val("").trigger('change') // cart
		$("#ket_upah_rp").val("") // cart
		$("#upah").val("").prop('disabled', true).removeClass('is-invalid')

		$("#thr").val("").prop('disabled', false).removeClass('is-invalid')
		$("#listrik").val("").prop('disabled', false).removeClass('is-invalid')
		$("#batu_bara_kg").val("").prop('disabled', false).removeClass('is-invalid')
		$("#batu_bara_rp").val("").prop('disabled', false).removeClass('is-invalid')
		$("#batu_bara_x").val("").prop('disabled', true).removeClass('is-invalid')
		$("#chemical_kg").val("").prop('disabled', false).removeClass('is-invalid')
		$("#chemical_rp").val("").prop('disabled', false).removeClass('is-invalid')
		$("#chemical_x").val("").prop('disabled', true).removeClass('is-invalid')
		$("#bahan_pembantu").val("").prop('disabled', false).removeClass('is-invalid')
		$("#solar").val("").prop('disabled', false).removeClass('is-invalid')
		$("#biaya_pemeliharaan").val("").prop('disabled', false).removeClass('is-invalid')
		$("#ekspedisi").val("").prop('disabled', false).removeClass('is-invalid')
		$("#depresiasi").val("").prop('disabled', false).removeClass('is-invalid')

		$("#id_cart_dll").val("333") // cart
		$("#ket_dll_txt").val("") // cart
		$("#ket_dll_kg").val("") // cart
		$("#ket_dll_rp").val("") // cart
		$("#ket_dll_x").val("") // cart
		$("#lain_lain_kg").val("").prop('disabled', true).removeClass('is-invalid')
		$("#lain_lain_rp").val("").prop('disabled', true).removeClass('is-invalid')

		// PERHITUNGAN HPP
		$("#hasil_hpp").val("").prop('disabled', true).removeClass('is-invalid')
		$("#tonase_order").val("").prop('disabled', true).removeClass('is-invalid')
		$("#hasil_x_tonanse").val("").prop('disabled', true).removeClass('is-invalid')
		$("#presentase").val("").prop('disabled', true).removeClass('is-invalid')
		$("#hxt_x_persen").val("").prop('disabled', true).removeClass('is-invalid')
		$("#fix_hpp").val("").prop('disabled', true).removeClass('is-invalid')
		$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP()"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
		swal.close()

		// $(".row-input-hpp").show()
		// $(".detail-pemakaian-bahan").show()
		// $(".card-pemakaian-bahan").show()
		// $(".card-biaya-produksi").show()
		// $(".col-hitung-hpp").show()
	}

	function hideAll(opsi)
	{
		$(".detail-pemakaian-bahan").attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".card-pemakaian-bahan").attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".card-biaya-produksi").attr('style', (opsi == 'show') ? '' : 'display:none')
		$(".col-hitung-hpp").attr('style', (opsi == 'show') ? '' : 'display:none')
	}

	function kembaliHPP()
	{
		reloadTable()
		$('#pilih_hpp').val("").trigger('change')
		$("#jenis_hpp").val("").trigger('change').prop('disabled', false)
		$("#tgl1_hpp").val("").prop('disabled', false).removeClass('is-invalid')
		$(".row-input-hpp").hide()
		$(".row-list-hpp").show()
		hideAll('none')
		kosong()
	}

	function addHPP()
	{
		statusInput = 'insert'
		$(".row-input-hpp").show()
		$(".row-list-hpp").hide()
		hideAll('none')
		kosong()
	}

	function pilihHPP()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		hideAll('none')
		if(pilih_hpp == ''){
			kosong()
		}

		if((pilih_hpp == "PM2" || pilih_hpp == "LAMINASI") && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('show')
			$(".tampil_corr").hide()
		}else if(pilih_hpp == "CORR" && tgl_hpp != '' && jenis_hpp != ''){
			let jenis_cor = $("#jenis_cor").val()
			$(".tampil_corr").show()
			console.log(jenis_cor)
			if(jenis_cor != ''){
				hideAll('show')
			}else{
				hideAll('none')
			}
		}else{
			hideAll('none')
		}
	}

	$("#ket_upah_rp").on("keyup", function() {
		let ket_upah_rp = $("#ket_upah_rp").val()
		$("#ket_upah_rp").val(formatRupiah(ket_upah_rp))
	});

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

	function hitungKetLainLain()
	{
		let ket_dll_kg = $("#ket_dll_kg").val()
		let ket_dll_rp = $("#ket_dll_rp").val()
		$("#ket_dll_kg").val(formatRupiah(ket_dll_kg))
		$("#ket_dll_rp").val(formatRupiah(ket_dll_rp))
		let h_ket_dll_kg = (ket_dll_kg == '' || isNaN(ket_dll_kg)) ? 0 : parseInt(ket_dll_kg.split('.').join(''));
		let h_ket_dll_rp = (ket_dll_rp == '' || isNaN(ket_dll_rp)) ? 0 : parseInt(ket_dll_rp.split('.').join(''));
		let x_h_ket_dll = 0;
		((h_ket_dll_kg == '' || h_ket_dll_kg == 0 || isNaN(h_ket_dll_kg)) && h_ket_dll_rp != 0) ? x_h_ket_dll = h_ket_dll_rp : x_h_ket_dll = h_ket_dll_kg * h_ket_dll_rp;
		(isNaN(x_h_ket_dll)) ? x_h_ket_dll = 0 : x_h_ket_dll = x_h_ket_dll
		$("#ket_dll_x").val(format_angka(x_h_ket_dll))
	}

	function keteranganHPP(opsi, jenis)
	{
		let ket_txt = ''
		let ket_kg = 0
		let ket_rp = 0
		let ket_x = 0
		if(opsi == 'upah'){
			ket_txt = $("#ket_upah_txt").val()
			ket_kg = 0
			ket_rp = $("#ket_upah_rp").val().split('.').join('')
			ket_x = 0
			id_cart = parseInt($("#id_cart_upah").val()) + 1
			$("#id_cart_upah").val(id_cart)
		}else if(opsi == 'bb'){
			ket_txt = $("#ket_bahan_txt").val()
			ket_kg = $("#ket_bahan_kg").val().split('.').join('')
			ket_rp = $("#ket_bahan_rp").val().split('.').join('')
			ket_x = $("#ket_bahan_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_bahan").val()) + 1
			$("#id_cart_bahan").val(id_cart)
		}else{ // lainlain
			ket_txt = $("#ket_dll_txt").val()
			ket_kg = $("#ket_dll_kg").val().split('.').join('')
			ket_rp = $("#ket_dll_rp").val().split('.').join('')
			ket_x = $("#ket_dll_x").val().split('.').join('')
			id_cart = parseInt($("#id_cart_dll").val()) + 1
			$("#id_cart_dll").val(id_cart)
		}

		$.ajax({
			url: '<?php echo base_url('Transaksi/keteranganHPP')?>',
			type: "POST",
			data: ({
				opsi, jenis, ket_txt, ket_kg, ket_rp, ket_x, id_cart
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				listKeteranganHPP(opsi)
			}
		})
	}

	function listKeteranganHPP(opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/listKeteranganHPP')?>',
			type: "POST",
			data: ({ opsi }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(opsi == 'upah'){
					$("#ket_upah_txt").html('<option value="">PILIH</option><option value="HARIAN LEPAS">HARIAN LEPAS</option><option value="BORONGAN">BORONGAN</option><option value="INSENTIF">INSENTIF</option><option value="PHK">PHK</option>')
					$("#ket_upah_rp").val("")
					$(".list-keterangan-upah").html(data.htmlUpah)
					$("#upah").val(data.sumUpah)
				}else if(opsi == 'bb'){
					$("#ket_bahan_txt").html('<option value="">PILIH</option><option value="LOCAL OCC">LOCAL OCC</option><option value="MIX WASTE">MIX WASTE</option><option value="PLUMPUNG">PLUMPUNG</option><option value="LAMINATING">LAMINATING</option><option value="SLUDGE">SLUDGE</option><option value="BROKE LAMINASI">BROKE LAMINASI</option><option value="BROKE CORR">BROKE CORR</option><option value="BROKE PM">BROKE PM</option>')
					$("#ket_bahan_kg").val("")
					$("#ket_bahan_rp").val("")
					$("#ket_bahan_x").val("")
					$(".list-keterangan-bahan").html(data.htmlBB)
					$("#bahan_baku_kg").val(data.sumBBkg)
					$("#bahan_baku_rp").val(data.sumBBrp)
				}else if(opsi == 'lainlain'){
					$("#ket_dll_txt").val("")
					$("#ket_dll_kg").val("")
					$("#ket_dll_rp").val("")
					$("#ket_dll_x").val("")
					$(".list-keterangan-dll").html(data.htmlLainLain)
					$("#lain_lain_kg").val(data.sumLLkg)
					$("#lain_lain_rp").val(data.sumLLrp)
				}
				hitungBiayaProduksi()
			}
		})
	}

	function hapusKeteranganHPP(rowid, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusKeteranganHPP')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				listKeteranganHPP(opsi)
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

	function hitungBatuBara()
	{
		let batu_bara_kg = $("#batu_bara_kg").val()
		let batu_bara_rp = $("#batu_bara_rp").val()
		$("#batu_bara_kg").val(formatRupiah(batu_bara_kg))
		$("#batu_bara_rp").val(formatRupiah(batu_bara_rp))
		let h_batu_bara_kg = (batu_bara_kg == '' || isNaN(batu_bara_kg)) ? 0 : parseInt(batu_bara_kg.split('.').join(''));
		let h_batu_bara_rp = (batu_bara_rp == '' || isNaN(batu_bara_rp)) ? 0 : parseInt(batu_bara_rp.split('.').join(''));
		let x_batu_bara_rp = 0;
		((h_batu_bara_kg == '' || h_batu_bara_kg == 0 || isNaN(h_batu_bara_kg)) && h_batu_bara_rp != 0) ? x_batu_bara_rp = h_batu_bara_rp : x_batu_bara_rp = h_batu_bara_kg * h_batu_bara_rp;
		(isNaN(x_batu_bara_rp)) ? x_batu_bara_rp = 0 : x_batu_bara_rp = x_batu_bara_rp
		$("#batu_bara_x").val(format_angka(x_batu_bara_rp))
		hitungBiayaProduksi()
	}

	function hitungBahanKimia()
	{
		let chemical_kg = $("#chemical_kg").val()
		let chemical_rp = $("#chemical_rp").val()
		$("#chemical_kg").val(formatRupiah(chemical_kg))
		$("#chemical_rp").val(formatRupiah(chemical_rp))
		let h_chemical_kg = (chemical_kg == '' || isNaN(chemical_kg)) ? 0 : parseInt(chemical_kg.split('.').join(''));
		let h_chemical_rp = (chemical_rp == '' || isNaN(chemical_rp)) ? 0 : parseInt(chemical_rp.split('.').join(''));
		let x_chemical_rp = 0;
		((h_chemical_kg == '' || h_chemical_kg == 0 || isNaN(h_chemical_kg)) && h_chemical_rp != 0) ? x_chemical_rp = h_chemical_rp : x_chemical_rp = h_chemical_kg * h_chemical_rp;
		(isNaN(x_chemical_rp)) ? x_chemical_rp = 0 : x_chemical_rp = x_chemical_rp
		$("#chemical_x").val(format_angka(x_chemical_rp))
		hitungBiayaProduksi()
	}

	function hitungBiayaProduksi()
	{
		let bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')
		let tenaga_kerja = $("#tenaga_kerja").val().split('.').join('')
		let upah = $("#upah").val().split('.').join('')
		let thr = $("#thr").val().split('.').join('')
		let listrik = $("#listrik").val().split('.').join('')
		let batu_bara_x = $("#batu_bara_x").val().split('.').join('')
		let chemical_x = $("#chemical_x").val().split('.').join('')
		let bahan_pembantu = $("#bahan_pembantu").val().split('.').join('')
		let solar = $("#solar").val().split('.').join('')
		let biaya_pemeliharaan = $("#biaya_pemeliharaan").val().split('.').join('')
		let ekspedisi = $("#ekspedisi").val().split('.').join('')
		let depresiasi = $("#depresiasi").val().split('.').join('')
		let lain_lain_rp = $("#lain_lain_rp").val().split('.').join('')

		$("#tenaga_kerja").val(formatRupiah(tenaga_kerja))
		$("#upah").val(formatRupiah(upah))
		$("#thr").val(formatRupiah(thr))
		$("#listrik").val(formatRupiah(listrik))
		$("#bahan_pembantu").val(formatRupiah(bahan_pembantu))
		$("#solar").val(formatRupiah(solar))
		$("#biaya_pemeliharaan").val(formatRupiah(biaya_pemeliharaan))
		$("#ekspedisi").val(formatRupiah(ekspedisi))
		$("#depresiasi").val(formatRupiah(depresiasi))
		$("#lain_lain_rp").val(formatRupiah(lain_lain_rp))

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

		// HPP * TONASE ORDER
		(hitung_hpp != 0) ? $("#tonase_order").prop('disabled', false) : $("#tonase_order").prop('disabled', true);
		let tonase_order =  $("#tonase_order").val()
		$("#tonase_order").val(formatRupiah(tonase_order))
		let h_tonase_order = tonase_order.split('.').join('')
		let hasil_x_tonanse = 0;
		(hitung_hpp == 0 || h_tonase_order == '') ? hasil_x_tonanse = 0 : hasil_x_tonanse = Math.round(parseInt(hitung_hpp) / parseInt(h_tonase_order).toFixed()).toFixed();
		$("#hasil_x_tonanse").val(formatRupiah(hasil_x_tonanse.toString()))
	}

	function simpanHPP()
	{
		// PILIH HPP
		let pilih_hpp = $("#pilih_hpp").val().split('.').join('')
		let tgl1_hpp = $("#tgl1_hpp").val().split('.').join('')
		let jenis_hpp = $("#jenis_hpp").val().split('.').join('')
		let jenis_cor = $("#jenis_cor").val().split('.').join('')

		// PEMAKAIAN BAHAN
		let bahan_baku_kg = $("#bahan_baku_kg").val().split('.').join('')
		let bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')

		// BIAYA PRODUKSI
		let tenaga_kerja = $("#tenaga_kerja").val().split('.').join('')
		let upah = $("#upah").val().split('.').join('')
		let thr = $("#thr").val().split('.').join('')
		let listrik = $("#listrik").val().split('.').join('')
		let batu_bara_kg = $("#batu_bara_kg").val().split('.').join('')
		let batu_bara_rp = $("#batu_bara_rp").val().split('.').join('')
		let batu_bara_x = $("#batu_bara_x").val().split('.').join('')
		let chemical_kg = $("#chemical_kg").val().split('.').join('')
		let chemical_rp = $("#chemical_rp").val().split('.').join('')
		let chemical_x = $("#chemical_x").val().split('.').join('')
		let bahan_pembantu = $("#bahan_pembantu").val().split('.').join('')
		let solar = $("#solar").val().split('.').join('')
		let biaya_pemeliharaan = $("#biaya_pemeliharaan").val().split('.').join('')
		let ekspedisi = $("#ekspedisi").val().split('.').join('')
		let depresiasi = $("#depresiasi").val().split('.').join('')
		let lain_lain_kg = $("#lain_lain_kg").val().split('.').join('')
		let lain_lain_rp = $("#lain_lain_rp").val().split('.').join('')

		// HITUNG HPP
		let hasil_hpp = $("#hasil_hpp").val().split('.').join('')
		let tonase_order = $("#tonase_order").val().split('.').join('')
		let hasil_x_tonanse = $("#hasil_x_tonanse").val().split('.').join('')
	}

	function hitungHPP()
	{
		let batu_bara = $("#batu_bara_kg").val()
		let batu_bara_rp = $("#batu_bara_rp").val()
		let bahan_baku = $("#bahan_baku").val()
		let bahan_baku_rp = $("#bahan_baku_rp").val()
		let listrik = $("#listrik").val()
		let chemical = $("#chemical_kg").val()
		let chemical_rp = $("#chemical_rp").val()
		let tenaga_kerja = $("#tenaga_kerja").val()
		let depresiasi = $("#depresiasi").val()
		let bahan_pembantu = $("#bahan_pembantu").val()
		let solar = $("#solar").val()
		let ekspedisi = $("#ekspedisi").val()
		let lain_lain = $("#lain_lain").val()
		$("#tenaga_kerja").val(formatRupiah(tenaga_kerja))
		$("#batu_bara_kg").val(formatRupiah(batu_bara))
		$("#batu_bara_rp").val(formatRupiah(batu_bara_rp))
		$("#bahan_baku").val(formatRupiah(bahan_baku))
		$("#bahan_baku_rp").val(formatRupiah(bahan_baku_rp))
		$("#listrik").val(formatRupiah(listrik))
		$("#chemical_kg").val(formatRupiah(chemical))
		$("#chemical_rp").val(formatRupiah(chemical_rp))
		$("#depresiasi").val(formatRupiah(depresiasi))
		$("#bahan_pembantu").val(formatRupiah(bahan_pembantu))
		$("#solar").val(formatRupiah(solar))
		$("#ekspedisi").val(formatRupiah(ekspedisi))
		$("#lain_lain").val(formatRupiah(lain_lain))
		let h_batu_bara = batu_bara.split('.').join('')
		let h_bahan_baku = bahan_baku.split('.').join('')
		let h_listrik = listrik.split('.').join('')
		let h_chemical = chemical.split('.').join('')
		let h_tenaga_kerja = tenaga_kerja.split('.').join('')
		let h_depresiasi = depresiasi.split('.').join('')
		let h_bahan_pembantu = bahan_pembantu.split('.').join('')
		let h_solar = solar.split('.').join('')
		let h_ekspedisi = ekspedisi.split('.').join('')
		let h_lain_lain = lain_lain.split('.').join('')

		if(h_batu_bara != '' && h_bahan_baku != '' && h_listrik != '' && h_chemical != '' && h_tenaga_kerja != '' && h_depresiasi != '' && h_bahan_pembantu != '' && h_solar != '' && h_ekspedisi != ''){
			$("#tonase_order").prop('disabled', false)
			$("#presentase").prop('disabled', false)
		}else{
			$("#tonase_order").val("").prop('disabled', true)
			$("#presentase").val("").prop('disabled', true)
		}

		// HPP
		let hitung_hpp = 0
		if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
			hitung_hpp = 0;
		}else{
			(lain_lain == '' || lain_lain == 0 || h_lain_lain == '' || h_lain_lain == 0) ? h_lain_lain = 0 : h_lain_lain = h_lain_lain;
			hitung_hpp = (parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi) + parseInt(h_lain_lain));
		}
		(isNaN(hitung_hpp) || hitung_hpp == '' || hitung_hpp == 0) ? hitung_hpp = hitung_hpp : hitung_hpp = hitung_hpp;
		$("#hasil_hpp").val(formatRupiah(hitung_hpp.toString()))
		
		// HPP * TONASE ORDER
		let tonase_order =  $("#tonase_order").val()
		$("#tonase_order").val(formatRupiah(tonase_order)).removeClass('is-invalid').addClass((tonase_order == '') ? 'is-invalid' : '')
		let h_tonase_order = tonase_order.split('.').join('')

		let hasil_x_tonanse = 0;
		(hitung_hpp == 0 || h_tonase_order == '') ? hasil_x_tonanse = 0 : hasil_x_tonanse = Math.round(parseInt(hitung_hpp) / parseInt(h_tonase_order).toFixed()).toFixed();
		$("#hasil_x_tonanse").val(formatRupiah(hasil_x_tonanse.toString())).removeClass('is-invalid').addClass((hasil_x_tonanse == '') ? 'is-invalid' : '')

		// (HPP * TONASE ORDER) + PRESENTASE %
		let presentase = $("#presentase").val()
		$("#presentase").val(presentase).removeClass('is-invalid').addClass((presentase == '') ? 'is-invalid' : '')
		let h_presentase = presentase
		let fix_hpp = parseInt(hasil_x_tonanse) + Math.round((parseInt(hasil_x_tonanse) * (parseInt(h_presentase) / 100)))
		let hxt_x_persen = Math.round((parseInt(hasil_x_tonanse) * (parseInt(h_presentase) / 100)))
		$("#hxt_x_persen").val((isNaN(hxt_x_persen) || hxt_x_persen == 0) ? 0 : formatRupiah(hxt_x_persen.toString())).removeClass('is-invalid')
		$("#fix_hpp").val(isNaN(fix_hpp) ? 0 : formatRupiah(fix_hpp.toString())).removeClass('is-invalid').addClass((isNaN(fix_hpp) || fix_hpp == '' || fix_hpp == 0) ? 'is-invalid' : '');
	}

	function simpanHPP2()
	{
		let id_hpp = $("#id_hpp").val()
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		// let tgl2_hpp = $("#tgl2_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		let batu_bara = $("#batu_bara_kg").val().split('.').join('')
		let batu_bara_rp = $("#batu_bara_rp").val().split('.').join('')
		let bahan_baku = $("#bahan_baku").val().split('.').join('')
		let bahan_baku_rp = $("#bahan_baku_rp").val().split('.').join('')
		let listrik = $("#listrik").val().split('.').join('')
		let chemical = $("#chemical_kg").val().split('.').join('')
		let chemical_rp = $("#chemical_rp").val().split('.').join('')
		let tenaga_kerja = $("#tenaga_kerja").val().split('.').join('')
		let depresiasi = $("#depresiasi").val().split('.').join('')
		let bahan_pembantu = $("#bahan_pembantu").val().split('.').join('')
		let solar = $("#solar").val().split('.').join('')
		let ekspedisi = $("#ekspedisi").val().split('.').join('')
		let lain_lain = $("#lain_lain").val().split('.').join('')
		let hasil_hpp = $("#hasil_hpp").val().split('.').join('')
		let tonase_order = $("#tonase_order").val().split('.').join('')
		let hasil_x_tonanse = $("#hasil_x_tonanse").val().split('.').join('')
		let presentase = $("#presentase").val().split('.').join('')
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
				id_hpp, pilih_hpp, tgl1_hpp, jenis_hpp, batu_bara, batu_bara_rp, bahan_baku, bahan_baku_rp, listrik, chemical, chemical_rp, tenaga_kerja, depresiasi, bahan_pembantu, solar, ekspedisi, lain_lain, hasil_hpp, tonase_order, hasil_x_tonanse, presentase, hxt_x_persen, fix_hpp, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.insertHPP){
					statusInput = 'insert'
					toastr.success(`<b>${data.msg}</b>`)
					kembaliHPP()
				}else{
					toastr.error(`<b>${data.msg}</b>`)

					$('#pilih_hpp').val(data.data2.pilih_hpp).trigger('change');
					$('#jenis_hpp').val(data.data2.jenis_hpp).trigger('change');
					$("#tgl1_hpp").val(data.data2.tgl1_hpp).removeClass('is-invalid').addClass((data.data2.tgl1_hpp == '') ? 'is-invalid' : '')
					// $("#tgl2_hpp").val(data.data2.tgl2_hpp).removeClass('is-invalid').addClass((data.data2.tgl2_hpp == '') ? 'is-invalid' : '')
					$("#batu_bara_kg").val(data.data2.batu_bara).removeClass('is-invalid').addClass((data.data2.batu_bara == '') ? 'is-invalid' : '')
					$("#batu_bara_rp").val(data.data2.batu_bara_rp).removeClass('is-invalid').addClass((data.data2.batu_bara_rp == '') ? 'is-invalid' : '')
					$("#bahan_baku").val(data.data2.bahan_baku).removeClass('is-invalid').addClass((data.data2.bahan_baku == '') ? 'is-invalid' : '')
					$("#bahan_baku_rp").val(data.data2.bahan_baku_rp).removeClass('is-invalid').addClass((data.data2.bahan_baku_rp == '') ? 'is-invalid' : '')
					$("#listrik").val(data.data2.listrik).removeClass('is-invalid').addClass((data.data2.listrik == '') ? 'is-invalid' : '')
					$("#chemical_kg").val(data.data2.chemical).removeClass('is-invalid').addClass((data.data2.chemical == '') ? 'is-invalid' : '')
					$("#chemical_rp").val(data.data2.chemical_rp).removeClass('is-invalid').addClass((data.data2.chemical_rp == '') ? 'is-invalid' : '')
					$("#tenaga_kerja").val(data.data2.tenaga_kerja).removeClass('is-invalid').addClass((data.data2.tenaga_kerja == '') ? 'is-invalid' : '')
					$("#depresiasi").val(data.data2.depresiasi).removeClass('is-invalid').addClass((data.data2.depresiasi == '') ? 'is-invalid' : '')
					$("#bahan_pembantu").val(data.data2.bahan_pembantu).removeClass('is-invalid').addClass((data.data2.bahan_pembantu == '') ? 'is-invalid' : '')
					$("#solar").val(data.data2.solar).removeClass('is-invalid').addClass((data.data2.solar == '') ? 'is-invalid' : '')
					$("#ekspedisi").val(data.data2.ekspedisi).removeClass('is-invalid').addClass((data.data2.ekspedisi == '') ? 'is-invalid' : '')
					$("#lain_lain").val(data.data2.lain_lain)
					$("#hasil_hpp").val(data.data2.hasil_hpp).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.hasil_hpp == '') ? 'is-invalid' : '')
					$("#tonase_order").val(data.data2.tonase_order).removeClass('is-invalid').addClass((data.data2.tonase_order == '') ? 'is-invalid' : '')
					$("#hasil_x_tonanse").val(data.data2.hasil_x_tonanse).prop('disabled', true).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.hasil_x_tonanse == '') ? 'is-invalid' : '')
					$("#presentase").val(data.data2.presentase).removeClass('is-invalid').addClass((data.data2.presentase == '') ? 'is-invalid' : '')
					$("#hxt_x_persen").val(data.data2.hxt_x_persen).removeClass('is-invalid').addClass((data.data2.hxt_x_persen == '') ? 'is-invalid' : '')
					$("#fix_hpp").val(data.data2.fix_hpp).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.fix_hpp == '') ? 'is-invalid' : '')
					swal.close()
					return
				}
			}
		})
	}

	function editHPP(id_hpp, opsi)
	{
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

				$('#pilih_hpp').val(data.pilih_hpp).trigger('change');
				$(".row-input-hpp").show()
				$(".row-list-hpp").hide()
				hideAll('none')
				pilihHPP()

				let prop = true;
				(opsi == 'edit') ? prop = false : prop = true;
				$('#jenis_hpp').val(data.jenis_hpp).prop('disabled', prop).trigger('change');
				$("#tgl1_hpp").val(data.tgl1_hpp).prop('disabled', prop).removeClass('is-invalid')
				// $("#tgl2_hpp").val(data.tgl2_hpp).prop('disabled', prop).removeClass('is-invalid')
				$("#batu_bara_kg").val(data.batu_bara).prop('disabled', prop).removeClass('is-invalid')
				$("#batu_bara_rp").val(data.batu_bara_rp).prop('disabled', prop).removeClass('is-invalid')
				$("#bahan_baku").val(data.bahan_baku).prop('disabled', prop).removeClass('is-invalid')
				$("#bahan_baku_rp").val(data.bahan_baku_rp).prop('disabled', prop).removeClass('is-invalid')
				$("#listrik").val(data.listrik).prop('disabled', prop).removeClass('is-invalid')
				$("#chemical").val(data.chemical).prop('disabled', prop).removeClass('is-invalid')
				$("#chemical_rp").val(data.chemical_rp).prop('disabled', prop).removeClass('is-invalid')
				$("#tenaga_kerja").val(data.tenaga_kerja).prop('disabled', prop).removeClass('is-invalid')
				$("#depresiasi").val(data.depresiasi).prop('disabled', prop).removeClass('is-invalid')
				$("#bahan_pembantu").val(data.bahan_pembantu).prop('disabled', prop).removeClass('is-invalid')
				$("#solar").val(data.solar).prop('disabled', prop).removeClass('is-invalid')
				$("#ekspedisi").val(data.ekspedisi).prop('disabled', prop).removeClass('is-invalid')
				$("#lain_lain").val((data.lain_lain == 0) ? '' : data.lain_lain).prop('disabled', prop).removeClass('is-invalid')
				$("#hasil_hpp").val(data.hasil_hpp).prop('disabled', true).removeClass('is-invalid')
				$("#tonase_order").val(data.tonase_order).prop('disabled', prop).removeClass('is-invalid')
				$("#hasil_x_tonanse").val(data.hasil_x_tonanse).prop('disabled', true).removeClass('is-invalid')
				$("#presentase").val(data.presentase).prop('disabled', prop).removeClass('is-invalid')
				$("#hxt_x_persen").val(data.hxt_x_persen).prop('disabled', true).removeClass('is-invalid')
				$("#fix_hpp").val(data.fix_hpp).prop('disabled', true).removeClass('is-invalid')

				let simpanLC = `<div class="card-body row" style="font-weight:bold;padding:6px 12px 0">
					<div class="col-md-3"></div>
					<div class="col-md-9">
						<button type="button" class="btn btn-sm btn-warning" onclick="simpanHPP()"><i class="fa fa-edit"></i> <b>EDIT</b></button>
					</div>
				</div>`
				if(opsi == 'edit'){
					$("#id_hpp").val(data.id_hpp)
					if(data.pilih_hpp == 'PM'){
						$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-warning" onclick="simpanHPP()"><i class="fa fa-edit"></i> <b>EDIT</b></button>`)
					}else{
						$(".simpan-lam-cor").html(simpanLC)
					}
				}else{
					$("#id_hpp").val("")
					$("#btn-simpan").html('')
				}

				statusInput = 'update'
				swal.close()
			}
		})
	}

	function hapusHPP(id_hpp)
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
			data: ({ id_hpp }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					statusInput = 'insert'
					toastr.success(`<b>${data.msg}</b>`)
					kosong()
					load_data()
					swal.close()
				}
			}
		})
	}
</script>
