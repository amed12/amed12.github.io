<!-- Main START -->
<main>
  <div class="container">
    <h3><span class="blue-text">Tambah Berita</span></h3>
    <div id="dashboard">
      <div class="section">
      <form action="<?php echo base_url('staf_kemahasiswaan/ModulBerita/tambahBerita') ?>" method="POST" >
      	<div class="row">
      		<div class="input-field">
      			<input type="text" name="judulBerita" id="judulBerita" class="validate">
      			<label for="judulBerita">Judul Berita Terbaru</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<input type="text" id="TopikBerita" name="TopikBerita" class="validate">
      			<label for="TopikBerita">Topik Berita</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<input type="text" name="penulisBerita">
      			<label for="penulisBerita">Nama Penulis</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<textarea name="kontenBerita" rows="8" class="materialize-textarea" id="kontenBerita"></textarea>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<a href="<?php echo base_url('staf_kemahasiswaan/C_staff/daftarBerita'); ?>" class="modal-action modal-close waves-effect waves-green btn red z-depth-0" title="kembali ke menu"><i class="mdi-navigation-close left"></i>Batal</a>
      			<button type="submit" class="btn green z-depth-0" title="Tambahkan Berita"><i class="material-icons left">done</i>Simpan</button>
      		</div>
      	</div>
      </form>
      </div>
    </div>
  </div>
  <!-- container END -->
</main>
<script type="text/javascript">
  $(function(){
    CKEDITOR.replace('kontenBerita');
  });
</script>