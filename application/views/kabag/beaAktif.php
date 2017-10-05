<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
        <div id="responsive" class="section">
          <div class="row">
            <div class="col s12">
              <h4>
                Daftar Beasiswa Aktif
              </h4>
            </div>
          </div>
          <div class="row">
            <?php
              $url = base_url('kabag/C_request/mhs_form');
              foreach ($info_bea as $b) {
                $aksi = '
                <form action="'.$url.'" method="post" style="text-align: center;">
                  <button class="btn waves-effect waves-light primary-color" title="Confirmed" type="submit" name="idPengaturan" value="'.$b->id.'">View Form Mahasiswa</button>
                </form>
                ';
                $selektor="";
                if ($b->selektor=='1') {
                  $selektor = "K. Kemahasiswaan";
                }elseif ($b->selektor=='2') {
                  $selektor = "K. Fakultas";
                }elseif ($b->selektor=='3'){
                  $selektor = "K. Kemahasiswaan dan K. Fakultas";
                }
                  $content = '
                  <div class="col s12 m6 l4">
                    <div class="card-panel">
                      <h5>'.$b->namaBeasiswa.'</h5>
                      <p>
                        <div class="">
                          Penyelenggara: <b>'.$b->penyelenggaraBea.'</b> <hr>
                        </div>
                        <div class="">
                          Kuota: <b>'.$b->kuota.'</b> <hr>
                        </div>
                        <div class="">
                          Pendaftaran dibuka: <b>'.$b->beasiswaDibuka.'</b> <hr>
                        </div>
                        <div class="">
                          Pendaftaran ditutup: <b>'.$b->beasiswaTutup.'</b> <hr>
                        </div>
                        <div class="">
                          Periode berakhir: <b>'.$b->periodeBerakhir.'</b> <hr>
                        </div>
                        <div class="">
                          Selektor:<br> <b>'.$selektor.'</b> <hr>
                        </div>
                        '.$aksi.'
                      </p>
                    </div>
                  </div>
                  ';
                  echo $content;
              }
             ?>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- container END -->
</main>
<script type="text/javascript">

var dataTable;

document.addEventListener("DOMContentLoaded", function(event) {
  datatable();
});

function datatable() {
  dataTable = $('#tabel').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"<?php echo base_url('kabag/C_request/datatable'); ?>",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[2,-1],
        "orderable":false,
      },
    ],
    "dom": '<"row" <"col s6 m6 l3 left"l><"col s6 m6 l3 right"f>><"bersih tengah" rt><"bottom"ip>',
    language : {
      sLengthMenu: "Tampilkan _MENU_",
      sSearch: "Cari:"
    }
  });
}
</script>
