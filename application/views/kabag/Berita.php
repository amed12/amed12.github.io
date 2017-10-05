<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
      <div id="responsive" class="section">
        <div class="card-panel success" style="display: none;"></div>
      <h4>List Berita <a class="btn-floating modal-trigger waves-effect waves-light primary-color z-depth-0" href="#tambahBerita"><i class="material-icons" title="Tambah Berita Baru">add</i></a></h4>
        <table class="bordered striped" id="tabelBerita">
          <thead>
            <tr>
              <td>#</td>
              <td>Judul Berita</td>
              <td>Topik Berita</td>
              <td>Penulis</td>
              <td>Tanggal Input Berita</td>
              <td>Konten</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody id="dataBerita">
            <?php foreach ($berita as $rows): ?>
              <tr>
                <td><?php echo $rows['idBerita'] ?></td>
                <td><?php echo $rows['judulBerita'] ?></td>
                <td><?php echo $rows['topikBerita'] ?></td>
                <td><?php echo $rows['penulisBerita'] ?></td>
                <td><?php echo $rows['tglInBerita'] ?></td>
                <td><?php echo $rows['kontenBerita'] ?></td>
                <td>
                  <a href="javascript:;" data="<?php echo $rows['idBerita'] ?>" class="btn-floating z-depth-0 btn green btnEditBerita" ><i class="material-icons">mode_edit</i></a>
                  <a href="<?php echo base_url('kasubag/ModulBerita/hapusBerita/'.$rows['idBerita']) ?>" class="btn btn-floating red  z-depth-0" onclick="return alertConfirm()"><i class="material-icons">delete</i></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  <!-- container END -->
</main>
  <div id="tambahBerita" class="modal">
    <div class="modal-content">
      <h4>Tambah Berita</h4>
      <form action="<?php echo base_url('kabag/ModulBerita/tambahBerita') ?>" method="POST" >
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
            <label for="kontenBerita">Isi Berita</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<a href="#!" class="modal-action modal-close waves-effect waves-green btn red z-depth-0" title="kembali ke menu"><i class="mdi-navigation-close left"></i>Batal</a>
      			<button type="submit" class="btn green z-depth-0" title="Tambahkan Berita"><i class="material-icons left">done</i>Simpan</button>
      		</div>
      	</div>
      </form>
    </div>
  </div>

  <div id="editBerita" class="modal">
    <div class="modal-content">
      <h4>EditBerita Berita</h4>
      <form action="<?php echo base_url('kabag/modulBerita/updateBerita') ?>" method="POST" >
      	<div class="row">
      		<div class="input-field">
      		<input type="hidden" name="idBerita">
      			<input type="text" name="editjudulBerita" id="editjudulBerita" placeholder="..">
      			<label for="editjudulBerita">Judul Berita Terbaru</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<input type="text" id="editTopikBerita" name="editTopikBerita" placeholder="..">
      			<label for="editTopikBerita">Topik Berita</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<input type="text" name="editpenulisBerita" placeholder="..">
      			<label for="editpenulisBerita">Nama Penulis</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<textarea name="editkontenBerita" rows="8" class="materialize-textarea"></textarea>
      		</div>
      	</div>
      	<div class="row">
      		<div class="input-field">
      			<a href="#!" class="modal-action modal-close waves-effect red btn"><i class="mdi-navigation-cancel left"></i>Tutup</a>
      			<button type="submit" class="btn green"><i class="mdi-navigation-refresh left"></i>Update</button>
      		</div>
      	</div>
      </form>
    </div>  
  </div>
  <script type="text/javascript">
  	$(function() {
  		$('#dataBerita').on('click','.btnEditBerita', function() {
  			var id = $(this).attr('data');
  			$('#editBerita').openModal('show');
        $.ajax({
          type :'ajax',
          method : 'GET',
          url : '<?php echo base_url('kasubag/modulBerita/editBerita') ?>',
          data : {id:id},
          async : false,
          dataType : 'json',
          success : function(data){
            $('input[name=idBerita]').val(data.idBerita);
            $('input[name=editjudulBerita]').val(data.judulBerita);
            $('input[name=editTopikBerita]').val(data.topikBerita);
            $('input[name=editpenulisBerita]').val(data.penulisBerita);
            $('textarea[name=editkontenBerita]').val(data.kontenBerita);
          },
          error : function(e){
            alert(e);
          }
        });
  		});
  	});
  </script>
<script type="text/javascript">
  $('#tabelBerita').dataTable();
</script>

<script type="text/javascript">
  function alertConfirm() {
      swal({
        title: "Yakin akan menghapus data ini ?",
        text: "Apakah anda yakin akan menghapus data ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        closeOnConfirm: false }, 
        function(){   swal("Deleted!", "Your imaginary file has been deleted.", "success"); });
  }
</script>