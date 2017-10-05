<main>
	<div class="container">
		<h1 class="thin">Daftar Beasiswa</h1>
		<small>Data Beasiswa yang terdaftar dalam sistem</small>
		<div class="section">
		<div class="card-panel success" style="display: none;"></div>
			<a href="#tambahBeasiswa" class="modal-trigger waves-effect wave-light btn blue btn-floating"><i class="material-icons left">add</i></a>
			<table class="bordered striped highlight">
				<thead>
					<tr>
						<td>Nomor</td>
						<td>Nama Beasiswa</td>
						<td>Penyelenggara</td>
						<td>Beasiswa Dibuka</td>
						<td>Beasiswa Ditutup</td>
						<td>Status</td>
						<td>keterangan</td>
						<td>Aksi</td>
					</tr>
				</thead>
				<tbody id="dataBeasiswa">
					<?php foreach ($bea as $rows): ?>
						<?php if ($rows['statusbeasiswa']==1) {
							$status = 'Beasiswa aktif';
							$kelas ="green";
						}
						if ($rows['statusbeasiswa']==0) {
							$status='beasiswa tidak aktif';
							$kelas="orange";
						}
						 ?>
						<tr>
							<td><?php echo $rows['id'] ?></td>
							<td><?php echo $rows['namaBeasiswa'] ?></td>
							<td><?php echo $rows['penyelenggaraBea'] ?></td>
							<td><?php echo $rows['beasiswadibuka'] ?></td>
							<td><?php echo $rows['beasiswatutup'] ?></td>
							<td>
								<div class="chip <?php echo $kelas ?>">
									<?php echo $status ?>
								</div>
							</td>
							<td><?php echo $rows['statustabel'] ?></td>
							<td>
								<a href="javascript:;" data="<?php echo $rows['id'] ?>" class="btn-floating btn btnEdit orange"><i class="material-icons">mode_edit</i></a>
								<a href="<?php echo base_url('kasubag/ModulBeasiswa/hapusBeasiswa/'.$rows['id']) ?>" class="btn-floating btn red" onclick="return confirm('apakah anda yakin akan menghapus data beasiswa <?php echo $rows['namaBeasiswa'] ?> ?')"><i class="material-icons">delete</i></a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<div class="modal" id="tambahBeasiswa">
	<div class="modal-content">
		<h4>tambah Modul beasiswa baru</h4>
		<form method="POST"  action="<?php echo base_url('kasubag/ModulBeasiswa/tambahBeasiswa') ?>">
			<div class="row">
				<div class="input-field">
					<input type="text" name="namaBeasiswa" id="NamaBeasiswa" id="namaBeasiswa">
					<label for="namaBeasiswa">nama Beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="text" name="penyelenggaraBea" id="penyelenggaraBea">
					<label for="penyelenggaraBea">Badan/lembaga penyelenggara beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="date" name="beaDiBuka" id="beaDiBuka" class="datepicker">
					<label for="beaDiBuka">Tanggal Pembukaan beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="date" name="beaTutup" id="beaTutup" class="datepicker">
					<label for="beaTutup">Tanggal Penutupan Beasiswa</label>
				</div>
			</div>
			<div class="row">
			<label>Status Beasiswa</label>
				<div class="input-field">
					<p>
      					<input name="statusbea" type="radio" id="test1" value="1" />
      					<label for="test1">Aktif</label>
      					<input name="statusbea" type="radio" id="test2"  value="0" />
      					<label for="test2">Tidak Aktif</label>
    				</p>
				</div>
			</div>
			<div class="row">
			<label>status tabel</label>
				<div class="input-field">
					<p>
						<input type="radio" name="statusTabel" id="status1" value="sudah">
						<label for="status1">Aktif</label>
						<input type="radio" name="statusTabel" id="status2" value="belum">
						<label for="status2">Tidak Aktif</label>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="text" name="kuotaBeasiswa" id="kuotaBeasiswa">
					<label for="kuotaBeasiswa">Kuota Beasiswa</label>
				</div>
			</div>
			<div class="row">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn red">Tutup</a>
				<button type="submit" class="btn green">Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<div class="modal" id="editBeasiswa">
	<div class="modal-content">
		<h4>edit Modul beasiswa baru</h4>
		<form method="POST"  action="<?php echo base_url('kasubag/ModulBeasiswa/UpdateBeasiswa') ?>">
			<div class="row">
				<div class="input-field">
					<input type="text" name="editnamaBeasiswa" id="editNamaBeasiswa">
					<label for="editnamaBeasiswa">nama Beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="text" name="editpenyelenggaraBea" id="editpenyelenggaraBea">
					<label for="editpenyelenggaraBea">Badan/lembaga penyelenggara beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="date" name="editbeaDiBuka" id="editbeaDiBuka" class="datepicker">
					<label for="editbeaDiBuka">Tanggal Pembukaan beasiswa</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="date" name="editbeaTutup" id="editbeaTutup" class="datepicker">
					<label for="editbeaTutup">Tanggal Penutupan Beasiswa</label>
				</div>
			</div>
			<div class="row">
			<label>Status Beasiswa</label>
				<div class="input-field">
					<p>
      					<input name="editstatusbea" type="radio" id="test1" value="1" />
      					<label for="test1">Aktif</label>
      					<input name="editstatusbea" type="radio" id="test2"  value="0" />
      					<label for="test2">Tidak Aktif</label>
    				</p>
				</div>
			</div>
			<div class="row">
			<label>status tabel</label>
				<div class="input-field">
					<p>
						<input type="radio" name="editstatusTabel" id="status1" value="sudah">
						<label for="status1">Aktif</label>
						<input type="radio" name="editstatusTabel" id="status2" value="belum">
						<label for="status2">Tidak Aktif</label>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input type="hidden" name="idBeasiswa">
					<input type="text" name="editkuotaBeasiswa" id="kuotaBeasiswa">
					<label for="kuotaBeasiswa">Kuota Beasiswa</label>
				</div>
			</div>
			<div class="row">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn red">Tutup</a>
				<button type="submit" class="btn green">Tambahkan</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#dataBeasiswa').on('click','.btnEdit', function() {
			var id = $(this).attr('data');
			$('#editBeasiswa').openModal('show');
			$.ajax({
				type : 'ajax',
				method : 'GET',
				url : '<?php echo base_url('kasubag/ModulBeasiswa/editBeasiswa') ?>',
				data : {id : id},
				async: false,
				dataType : 'json',
				success : function(data){
					$('input[name=editnamaBeasiswa]').val(data.namaBeasiswa);
				},
				error : function(ex) {
					alert(ex);
				}
			});
		});
	});
</script>