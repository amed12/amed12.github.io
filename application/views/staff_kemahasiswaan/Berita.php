<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
      <div id="responsive" class="section">
        <div class="card-panel success" style="display: none;"></div>
      <h4>List Berita <a class="btn-floating modal-trigger waves-effect waves-light primary-color z-depth-0" href="<?php echo base_url('staf_kemahasiswaan/C_staff/tambahBerita'); ?>"><i class="material-icons" title="Tambah Berita Baru">add</i></a></h4>
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
          <tbody id="daftarBerita">
            <?php foreach ($berita as $rows): ?>
              <tr>
                <td><?php echo $rows['idBerita'] ?></td>
                <td><?php echo $rows['judulBerita'] ?></td>
                <td><?php echo $rows['topikBerita'] ?></td>
                <td><?php echo $rows['penulisBerita'] ?></td>
                <td><?php echo $rows['tglInBerita'] ?></td>
                <td><?php echo $rows['kontenBerita'] ?></td>
                <td>
                  <a href="<?php echo base_url('staf_kemahasiswaan/ModulBerita/editBerita/'.$rows['idBerita']); ?>" class="btn-floating z-depth-0 btn green" id="btnEditBerita" ><i class="material-icons">mode_edit</i></a>
                  <a href="<?php echo base_url('staf_kemahasiswaan/ModulBerita/hapusBerita/'.$rows['idBerita']) ?>" class="btn btn-floating red  z-depth-0" onclick="return alertConfirm()"><i class="material-icons">delete</i></a>
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