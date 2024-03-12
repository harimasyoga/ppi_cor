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
								<select id="jenis_hpp" class="form-control select2" onchange="pilihHPP()">
									<option value="">PILIH</option>
									<option value="BK">BK</option>
									<option value="MH">MH</option>
									<option value="WP">WP</option>
								</select>
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
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
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
											<input type="text" id="ket_dll_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled onkeyup="hitungKetLainLain()">
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
								<h3 class="card-title" style="font-weight:bold;font-size:18px">HITUNG HPP</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-12">TOTAL</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<input type="text" id="hasil_hpp" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="HPP" disabled>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">TONASE ORDER</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<input type="text" id="tonase_order" class="form-control" style="color:#000;font-weight:bold;text-align:right" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungBiayaProduksi()">
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">HPP</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">
									<input type="text" id="hasil_x_tonanse" class="form-control" style="color:#000;font-weight:bold;text-align:right" placeholder="HPP / TONASE ORDER" disabled onkeyup="hitungBiayaProduksi()">
								</div>
							</div>
							<!-- <div class="hitung-presentase" style="display:none">
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
							</div> -->
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-3"></div>
								<div class="col-md-9" style="text-align:right">
									<div id="btn-simpan"></div>
								</div>
							</div>
						</div>
						<input type="hidden" id="id_hpp" value="">
						<input type="hidden" id="hxt_x_persen" value="">
						<input type="hidden" id="fix_hpp" value="">
						<input type="hidden" id="load_edit" value="">
					</div>
				</div>
			</div>

			<div class="row row-list-sheet">
				<div class="col-md-12">
					<!-- PEMAKAIAN BAHAN SHEET -->
					<div class="cbx card-pemakaian-bahan-sheet" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">LOCAL OCC</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_local_occ_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_local_occ_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_local_occ_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_local_occ_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_local_occ_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">MIX WASTE</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_mix_waste_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_mix_waste_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_mix_waste_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_mix_waste_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_mix_waste_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">PLUMPUNG</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_plumpung_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_plumpung_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_plumpung_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_plumpung_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_plumpung_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">LAMINATING</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_laminating_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_laminating_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_laminating_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_laminating_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_laminating_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">SLUDGE</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_sludge_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_sludge_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_sludge_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_sludge_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_sludge_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">BROKE LAMINASI</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_broke_laminasi_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_broke_laminasi_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_broke_laminasi_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_broke_laminasi_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_broke_laminasi_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">BROKE CORR</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_broke_corr_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_broke_corr_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_broke_corr_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_broke_corr_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_broke_corr_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">BROKE PM</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_broke_pm_kg" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px">Rp</span>
										</div>
										<input type="text" id="s_broke_pm_rp" class="form-control" style="text-align:right" placeholder="0" onkeyup="HitungSheetBB()">
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_broke_pm_x" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_broke_pm_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_broke_pm_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-12">PEMAKAIAN BAHAN</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" id="s_bahan_baku_kg" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0">
										<div class="input-group-append">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
										</div>
									</div>
								</div>
								<div class="col-md-2"></div>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
										</div>
										<input type="text" id="s_bahan_baku_rp" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(PM)Rp</span>
										</div>
										<input type="text" id="s_bahan_baku_pm" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">(+)Rp</span>
										</div>
										<input type="text" id="s_bahan_baku_plus" class="form-control" style="font-weight:bold;color:#000;text-align:right" placeholder="0" disabled>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- BIAYA PRODUKSI SHEET -->
					<div class="cbx card-biaya-produksi-sheet" style="display:none">
						BIAYA PRODUKSI SHEET
					</div>
				</div>
			</div>

			<div class="row row-list-box">
				<div class="col-md-12">
					<!-- PEMAKAIAN BAHAN BOX -->
					<div class="cbx card-pemakaian-bahan-box" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMAKAIAN BAHAN</h3>
							</div>
						</div>
					</div>
					<!-- BIAYA PRODUKSI BOX -->
					<div class="cbx card-biaya-produksi-box" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">BIAYA PRODUKSI</h3>
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
							<table id="datatable" class="table table-bordered table-striped" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center">#</th>
										<th style="text-align:center">TANGGAL</th>
										<th style="text-align:center">JENIS</th>
										<th style="text-align:center">HASIL</th>
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
		$(".update-keterangan-bahan").html('')
		$(".update-keterangan-upah").html('')
		$(".update-keterangan-dll").html('')

		$("#tgl1_hpp").val("").prop('disabled', false)
		$("#jenis_hpp").val("").prop('disabled', false)
		$("#jenis_cor").val("").prop('disabled', false)

		// PEMAKAIAN BAHAN
		$("#id_cart_bahan").val("777") // cart
		$("#ket_bahan_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_bahan_kg").val("").prop('disabled', false) // cart
		$("#ket_bahan_rp").val("").prop('disabled', false) // cart
		$("#ket_bahan_x").val("").prop('disabled', true) // cart
		$("#bahan_baku_kg").val("").prop('disabled', true)
		$("#bahan_baku_rp").val("").prop('disabled', true)

		// BIAYA PRODUKSI
		$("#tenaga_kerja").val("").prop('disabled', false)

		$("#id_cart_upah").val("111") // cart
		$("#ket_upah_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_upah_rp").val("").prop('disabled', false) // cart
		$("#upah").val("").prop('disabled', true)

		$("#thr").val("").prop('disabled', false)
		$("#listrik").val("").prop('disabled', false)
		$("#batu_bara_kg").val("").prop('disabled', false)
		$("#batu_bara_rp").val("").prop('disabled', false)
		$("#batu_bara_x").val("").prop('disabled', true)
		$("#chemical_kg").val("").prop('disabled', false)
		$("#chemical_rp").val("").prop('disabled', false)
		$("#chemical_x").val("").prop('disabled', true)
		$("#bahan_pembantu").val("").prop('disabled', false)
		$("#solar").val("").prop('disabled', false)
		$("#biaya_pemeliharaan").val("").prop('disabled', false)
		$("#ekspedisi").val("").prop('disabled', false)
		$("#depresiasi").val("").prop('disabled', false)

		$("#id_cart_dll").val("333") // cart
		$("#ket_dll_txt").val("").prop('disabled', false).trigger('change') // cart
		$("#ket_dll_kg").val("").prop('disabled', false) // cart
		$("#ket_dll_rp").val("").prop('disabled', false) // cart
		$("#ket_dll_x").val("").prop('disabled', true) // cart
		$("#lain_lain_kg").val("").prop('disabled', true)
		$("#lain_lain_rp").val("").prop('disabled', true)

		// PERHITUNGAN HPP
		$("#hasil_hpp").val("").prop('disabled', true)
		$("#tonase_order").val("").prop('disabled', true)
		$("#hasil_x_tonanse").val("").prop('disabled', true)
		$("#presentase").val("").prop('disabled', true)

		// HIDDEN
		$("#id_hpp").val("")
		$("#hxt_x_persen").val("")
		$("#fix_hpp").val("")

		$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP('')"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
		swal.close()

		// $(".row-input-hpp").show()
		// $(".card-pemakaian-bahan").show()
		// $(".card-biaya-produksi").show()
		// $(".col-hitung-hpp").show()
	}

	function kembaliHPP()
	{
		reloadTable()
		$(".llll").load("<?php echo base_url('Transaksi/destroyHPP') ?>")
		$("#pilih_hpp").val("").trigger('change').prop('disabled', false)
		$("#tgl1_hpp").val("").prop('disabled', false)
		$("#jenis_hpp").val("").trigger('change').prop('disabled', false)
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
		$(".col-hitung-hpp").attr('style', (opsi == 'show') ? 'position:sticky;top:12px' : 'display:none')

		$(".tambah-bahan").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-bahan_sheet").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','sheet','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-upah").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
		$(".tambah-dll").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','pm','')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
	}

	function pilihHPP()
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		if(pilih_hpp == ''){
			kosong()
		}

		$(".cbx").attr('style', 'display:none')
		if(pilih_hpp == "PM2" && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('pm', 'show')
		}else if(pilih_hpp == "BOX" && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('box', 'show')
		}else if(pilih_hpp == "SHEET" && tgl_hpp != '' && jenis_hpp != ''){
			tampilListHppPM('sheet')
			hideAll('sheet', 'show')
		}else if(pilih_hpp == "LAMINASI" && tgl_hpp != '' && jenis_hpp != ''){
			hideAll('laminasi', 'show')
		}else{
			hideAll('', 'none')
		}
	}

	function tampilListHppPM(opsi)
	{
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		$(".card-list-hpp-pm").show()
		$.ajax({
			url: '<?php echo base_url('Transaksi/tampilListHppPM')?>',
			type: "POST",
			data: ({
				pilih_hpp, tgl1_hpp, jenis_hpp, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".tampil-list-hpp-pm").html(data.html)
			}
		})
	}

	function pilihListHPP(id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/pilihListHPP')?>',
			type: "POST",
			data: ({
				id_hpp
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#s_local_occ_kg").val()
				$("#s_local_occ_rp").val()
				$("#s_local_occ_x").val()
				$("#s_local_occ_pm").val(data.pm.local_occ)
				$("#s_local_occ_plus").val()
				$("#s_mix_waste_kg").val()
				$("#s_mix_waste_rp").val()
				$("#s_mix_waste_x").val()
				$("#s_mix_waste_pm").val(data.pm.mix_waste)
				$("#s_mix_waste_plus").val()
				$("#s_plumpung_kg").val()
				$("#s_plumpung_rp").val()
				$("#s_plumpung_x").val()
				$("#s_plumpung_pm").val(data.pm.plumpung)
				$("#s_plumpung_plus").val()
				$("#s_laminating_kg").val()
				$("#s_laminating_rp").val()
				$("#s_laminating_x").val()
				$("#s_laminating_pm").val(data.pm.laminating)
				$("#s_laminating_plus").val()
				$("#s_sludge_kg").val()
				$("#s_sludge_rp").val()
				$("#s_sludge_x").val()
				$("#s_sludge_pm").val(data.pm.sludge)
				$("#s_sludge_plus").val()
				$("#s_broke_laminasi_kg").val()
				$("#s_broke_laminasi_rp").val()
				$("#s_broke_laminasi_x").val()
				$("#s_broke_laminasi_pm").val(data.pm.broke_laminasi)
				$("#s_broke_laminasi_plus").val()
				$("#s_broke_corr_kg").val()
				$("#s_broke_corr_rp").val()
				$("#s_broke_corr_x").val()
				$("#s_broke_corr_pm").val(data.pm.broke_corr)
				$("#s_broke_corr_plus").val()
				$("#s_broke_pm_kg").val()
				$("#s_broke_pm_rp").val()
				$("#s_broke_pm_x").val()
				$("#s_broke_pm_pm").val(data.pm.broke_pm)
				$("#s_broke_pm_plus").val()

				$("#s_bahan_baku_kg").val()
				$("#s_bahan_baku_rp").val()
				$("#s_bahan_baku_pm").val(data.pm.bahan_baku_rp)
				$("#s_bahan_baku_plus").val()
			}
		})
	}

	function HitungSheetBB()
	{
		let local_occ_kg = $("#s_local_occ_kg").val()
		let local_occ_rp = $("#s_local_occ_rp").val()
		let mix_waste_kg = $("#s_mix_waste_kg").val()
		let mix_waste_rp = $("#s_mix_waste_rp").val()
		let plumpung_kg = $("#s_plumpung_kg").val()
		let plumpung_rp = $("#s_plumpung_rp").val()
		let laminating_kg = $("#s_laminating_kg").val()
		let laminating_rp = $("#s_laminating_rp").val()
		let sludge_kg = $("#s_sludge_kg").val()
		let sludge_rp = $("#s_sludge_rp").val()
		let broke_laminasi_kg = $("#s_broke_laminasi_kg").val()
		let broke_laminasi_rp = $("#s_broke_laminasi_rp").val()
		let broke_corr_kg = $("#s_broke_corr_kg").val()
		let broke_corr_rp = $("#s_broke_corr_rp").val()
		let broke_pm_kg = $("#s_broke_pm_kg").val()
		let broke_pm_rp = $("#s_broke_pm_rp").val()
		$("#s_local_occ_kg").val(formatRupiah(local_occ_kg))
		$("#s_local_occ_rp").val(formatRupiah(local_occ_rp))
		$("#s_mix_waste_kg").val(formatRupiah(mix_waste_kg))
		$("#s_mix_waste_rp").val(formatRupiah(mix_waste_rp))
		$("#s_plumpung_kg").val(formatRupiah(plumpung_kg))
		$("#s_plumpung_rp").val(formatRupiah(plumpung_rp))
		$("#s_laminating_kg").val(formatRupiah(laminating_kg))
		$("#s_laminating_rp").val(formatRupiah(laminating_rp))
		$("#s_sludge_kg").val(formatRupiah(sludge_kg))
		$("#s_sludge_rp").val(formatRupiah(sludge_rp))
		$("#s_broke_laminasi_kg").val(formatRupiah(broke_laminasi_kg))
		$("#s_broke_laminasi_rp").val(formatRupiah(broke_laminasi_rp))
		$("#s_broke_corr_kg").val(formatRupiah(broke_corr_kg))
		$("#s_broke_corr_rp").val(formatRupiah(broke_corr_rp))
		$("#s_broke_pm_kg").val(formatRupiah(broke_pm_kg))
		$("#s_broke_pm_rp").val(formatRupiah(broke_pm_rp))
		let h_local_occ_kg = (local_occ_kg == '' || isNaN(local_occ_kg)) ? 0 : parseInt(local_occ_kg.split('.').join(''));
		let h_local_occ_rp = (local_occ_rp == '' || isNaN(local_occ_rp)) ? 0 : parseInt(local_occ_rp.split('.').join(''));
		let h_mix_waste_kg = (mix_waste_kg == '' || isNaN(mix_waste_kg)) ? 0 : parseInt(mix_waste_kg.split('.').join(''));
		let h_mix_waste_rp = (mix_waste_rp == '' || isNaN(mix_waste_rp)) ? 0 : parseInt(mix_waste_rp.split('.').join(''));
		let h_plumpung_kg = (plumpung_kg == '' || isNaN(plumpung_kg)) ? 0 : parseInt(plumpung_kg.split('.').join(''));
		let h_plumpung_rp = (plumpung_rp == '' || isNaN(plumpung_rp)) ? 0 : parseInt(plumpung_rp.split('.').join(''));
		let h_laminating_kg = (laminating_kg == '' || isNaN(laminating_kg)) ? 0 : parseInt(laminating_kg.split('.').join(''));
		let h_laminating_rp = (laminating_rp == '' || isNaN(laminating_rp)) ? 0 : parseInt(laminating_rp.split('.').join(''));
		let h_sludge_kg = (sludge_kg == '' || isNaN(sludge_kg)) ? 0 : parseInt(sludge_kg.split('.').join(''));
		let h_sludge_rp = (sludge_rp == '' || isNaN(sludge_rp)) ? 0 : parseInt(sludge_rp.split('.').join(''));
		let h_broke_laminasi_kg = (broke_laminasi_kg == '' || isNaN(broke_laminasi_kg)) ? 0 : parseInt(broke_laminasi_kg.split('.').join(''));
		let h_broke_laminasi_rp = (broke_laminasi_rp == '' || isNaN(broke_laminasi_rp)) ? 0 : parseInt(broke_laminasi_rp.split('.').join(''));
		let h_broke_corr_kg = (broke_corr_kg == '' || isNaN(broke_corr_kg)) ? 0 : parseInt(broke_corr_kg.split('.').join(''));
		let h_broke_corr_rp = (broke_corr_rp == '' || isNaN(broke_corr_rp)) ? 0 : parseInt(broke_corr_rp.split('.').join(''));
		let h_broke_pm_kg = (broke_pm_kg == '' || isNaN(broke_pm_kg)) ? 0 : parseInt(broke_pm_kg.split('.').join(''));
		let h_broke_pm_rp = (broke_pm_rp == '' || isNaN(broke_pm_rp)) ? 0 : parseInt(broke_pm_rp.split('.').join(''));
		let x_local_occ_rp = 0
		let x_mix_waste_rp = 0
		let x_plumpung_rp = 0
		let x_laminating_rp = 0
		let x_sludge_rp = 0
		let x_broke_laminasi_rp = 0
		let x_broke_corr_rp = 0
		let x_broke_pm_rp = 0;
		((h_local_occ_kg == '' || h_local_occ_kg == 0 || isNaN(h_local_occ_kg)) && h_local_occ_rp != 0) ? x_local_occ_rp = h_local_occ_rp : x_local_occ_rp = h_local_occ_kg * h_local_occ_rp;
		((h_mix_waste_kg == '' || h_mix_waste_kg == 0 || isNaN(h_mix_waste_kg)) && h_mix_waste_rp != 0) ? x_mix_waste_rp = h_mix_waste_rp : x_mix_waste_rp = h_mix_waste_kg * h_mix_waste_rp;
		((h_plumpung_kg == '' || h_plumpung_kg == 0 || isNaN(h_plumpung_kg)) && h_plumpung_rp != 0) ? x_plumpung_rp = h_plumpung_rp : x_plumpung_rp = h_plumpung_kg * h_plumpung_rp;
		((h_laminating_kg == '' || h_laminating_kg == 0 || isNaN(h_laminating_kg)) && h_laminating_rp != 0) ? x_laminating_rp = h_laminating_rp : x_laminating_rp = h_laminating_kg * h_laminating_rp;
		((h_sludge_kg == '' || h_sludge_kg == 0 || isNaN(h_sludge_kg)) && h_sludge_rp != 0) ? x_sludge_rp = h_sludge_rp : x_sludge_rp = h_sludge_kg * h_sludge_rp;
		((h_broke_laminasi_kg == '' || h_broke_laminasi_kg == 0 || isNaN(h_broke_laminasi_kg)) && h_broke_laminasi_rp != 0) ? x_broke_laminasi_rp = h_broke_laminasi_rp : x_broke_laminasi_rp = h_broke_laminasi_kg * h_broke_laminasi_rp;
		((h_broke_corr_kg == '' || h_broke_corr_kg == 0 || isNaN(h_broke_corr_kg)) && h_broke_corr_rp != 0) ? x_broke_corr_rp = h_broke_corr_rp : x_broke_corr_rp = h_broke_corr_kg * h_broke_corr_rp;
		((h_broke_pm_kg == '' || h_broke_pm_kg == 0 || isNaN(h_broke_pm_kg)) && h_broke_pm_rp != 0) ? x_broke_pm_rp = h_broke_pm_rp : x_broke_pm_rp = h_broke_pm_kg * h_broke_pm_rp;
		$("#s_local_occ_x").val(format_angka(x_local_occ_rp))
		$("#s_mix_waste_x").val(format_angka(x_mix_waste_rp))
		$("#s_plumpung_x").val(format_angka(x_plumpung_rp))
		$("#s_laminating_x").val(format_angka(x_laminating_rp))
		$("#s_sludge_x").val(format_angka(x_sludge_rp))
		$("#s_broke_laminasi_x").val(format_angka(x_broke_laminasi_rp))
		$("#s_broke_corr_x").val(format_angka(x_broke_corr_rp))
		$("#s_broke_pm_x").val(format_angka(x_broke_pm_rp))
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

	function keteranganHPP(opsi, jenis, id_hpp)
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
				swal.close()
				hitungBiayaProduksi()
			}
		})
	}

	function hapusKeteranganHPP(rowid, opsi, jenis, id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusKeteranganHPP')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				listKeteranganHPP(opsi, jenis, id_hpp)
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

		// (HPP * TONASE ORDER) + PRESENTASE %
		// let hxt_x_persen = Math.round((parseInt(hasil_x_tonanse) * (10 / 100)))
		// let fix_hpp = parseInt(hasil_x_tonanse) + Math.round((parseInt(hasil_x_tonanse) * (10 / 100)))
	}

	function simpanHPP(opsi)
	{
		let id_hpp = $("#id_hpp").val()
		// PILIH HPP
		let pilih_hpp = $("#pilih_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		let jenis_cor = $("#jenis_cor").val()
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
		// (HPP * TONASE ORDER) + PRESENTASE %
		let hxt_x_persen = Math.round((parseInt(hasil_x_tonanse) * (10 / 100)))
		let fix_hpp = parseInt(hasil_x_tonanse) + Math.round((parseInt(hasil_x_tonanse) * (10 / 100)))
		console.log("hxt_x_persen : ", hxt_x_persen)
		console.log("fix_hpp : ", fix_hpp)
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
				id_hpp, pilih_hpp, tgl1_hpp, jenis_hpp, jenis_cor, bahan_baku_kg, bahan_baku_rp, tenaga_kerja, upah, thr, listrik, batu_bara_kg, batu_bara_rp, batu_bara_x, chemical_kg, chemical_rp, chemical_x, bahan_pembantu, solar, biaya_pemeliharaan, ekspedisi, depresiasi, lain_lain_kg, lain_lain_rp, hasil_hpp, tonase_order, hasil_x_tonanse, hxt_x_persen, fix_hpp, statusInput
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

	function editHPP(id_hpp, opsi, ket)
	{
		$(".update-keterangan-bahan").html('')
		$(".update-keterangan-upah").html('')
		$(".update-keterangan-dll").html('')
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
			data: ({ id_hpp, opsi, ket }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				console.log(id_hpp)
				$(".row-list-hpp").hide()
				$(".row-input-hpp").show()
				hideAll('', 'show')

				$("#id_hpp").val(data.data.id_hpp)

				let prop = true;
				(opsi == 'edit') ? prop = false : prop = true;
				$("#pilih_hpp").val(data.data.pilih_hpp)
				$("#tgl1_hpp").val(data.data.tgl_hpp).prop('disabled', true)
				$("#jenis_hpp").val(data.data.jenis_hpp).prop('disabled', true).trigger("change")

				$("#ket_bahan_txt").prop('disabled', prop)
				$("#ket_bahan_kg").prop('disabled', prop)
				$("#ket_bahan_rp").prop('disabled', prop)
				$("#bahan_baku_kg").val(data.data.bahan_baku_kg)
				$("#bahan_baku_rp").val(data.data.bahan_baku_rp)

				$("#tenaga_kerja").val(data.data.tenaga_kerja).prop('disabled', prop)
				$("#ket_upah_txt").prop('disabled', prop)
				$("#ket_upah_rp").prop('disabled', prop)
				$("#upah").val(data.data.upah)
				$("#thr").val(data.data.thr).prop('disabled', prop)
				$("#listrik").val(data.data.listrik).prop('disabled', prop)
				$("#batu_bara_kg").val(data.data.batu_bara_kg).prop('disabled', prop)
				$("#batu_bara_rp").val(data.data.batu_bara_rp).prop('disabled', prop)
				$("#batu_bara_x").val(data.data.batu_bara_x)
				$("#chemical_kg").val(data.data.chemical_kg).prop('disabled', prop)
				$("#chemical_rp").val(data.data.chemical_rp).prop('disabled', prop)
				$("#chemical_x").val(data.data.chemical_x)
				$("#bahan_pembantu").val(data.data.bahan_pembantu).prop('disabled', prop)
				$("#solar").val(data.data.solar).prop('disabled', prop)
				$("#biaya_pemeliharaan").val(data.data.maintenance).prop('disabled', prop)
				$("#ekspedisi").val(data.data.ekspedisi).prop('disabled', prop)
				$("#depresiasi").val(data.data.depresiasi).prop('disabled', prop)

				$("#ket_dll_txt").prop('disabled', prop)
				$("#ket_dll_kg").prop('disabled', prop)
				$("#ket_dll_rp").prop('disabled', prop)
				$("#lain_lain_kg").val(data.data.lain_lain_kg)
				$("#lain_lain_rp").val(data.data.lain_lain_rp)

				$("#hasil_hpp").val(data.data.hasil_hpp)
				$("#tonase_order").val(data.data.tonase_order).prop('disabled', prop)
				$("#hasil_x_tonanse").val(data.data.hasil_x_tonanse)

				$(".update-keterangan-bahan").html(data.htmlBB)
				$(".update-keterangan-upah").html(data.htmlUpah)
				$(".update-keterangan-dll").html(data.htmlLainLain)

				if(opsi == 'edit'){
					$(".tambah-bahan").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('bb','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-upah").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('upah','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$(".tambah-dll").html(`<button type="button" class="btn btn-xs btn-success" onclick="keteranganHPP('lainlain','pm','${id_hpp}')"><i class="fa fa-plus"></i> <b>TAMBAH</b></button>`)
					$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP('')"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
				}else{
					$(".tambah-bahan").html('')
					$(".tambah-upah").html('')
					$(".tambah-dll").html('')
					$("#btn-simpan").html('')
				}

				console.log("ket : ", ket)
				if(ket == 'hapusKet'){
					simpanHPP('hapusKet')
				}
				statusInput = 'update'
				swal.close()
			}
		})
	}

	function hapusKetEditHPP(id_dtl, id_hpp, ooo, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusKetEditHPP')?>',
			type: "POST",
			data: ({
				id_dtl, id_hpp, ooo, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				editHPP(id_hpp, opsi, 'hapusKet')
			}
		})
	}

	function hapusHPP(id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusHPP')?>',
			type: "POST",
			data: ({ id_hpp }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}
</script>
