<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
        <div id="responsive" class="section">
          <div class="row">
            <div class="col s6">
              <h4>
                List Beasiswa
              </h4>
            </div>
            <div class="col s6">
              <p>
                <blockquote>
                <font size="4pt">Keterangan: </font><br> <i class="mdi-toggle-radio-button-on"></i> = Kasubag. Kemahasiswaan. <br> <i class="mdi-toggle-radio-button-off"></i> = Kasubag. Kemahasiswaan Fakultas. <br> <i class="mdi-action-stars"></i> = Keduanya.
                </blockquote>
              </p>
            </div>
          </div>
        <div class="row">
          <div class="col s12">
            <table class="striped" id="tabel">
              <thead>
                <tr>
                    <th data-field="id" style="width: 3%;">#</th>
                    <th data-field="bea">Beasiswa</th>
                    <th data-field="penyelenggara">Penyelenggara</th>
                    <th data-field="selektor">Selektor</th>
                    <th data-field="konfirmasi">Keterangan</th>
                    <th data-field="status">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>BRI</td>
                  <td>Bank BRI</td>
                  <td><i class="material-icons" title="Kasubag. Kemahasiswaan">radio_button_checked</i></td>
                  <td class="success-text">Telah Dikonfirmasi</td>
                  <td>
                    <a class="btn-floating waves-effect waves-light primary-color z-depth-0" title="Confirmed"><i class="material-icons">done</i></a>
                  </td
                </tr>
                <tr>
                  <td>2</td>
                  <td>Prestasi</td>
                  <td>UIN Maliki</td>
                  <td><i class="material-icons" title="Kasubag. Kemahasiswaan Fakultas">radio_button_unchecked</i></td>
                  <td class="alert-text" style="max-width: 330px;">Scoring pekerjaan orang tua belum masuk</td>
                  <td>
                    <form action="<?php echo base_url('kasubag/C_requested/pengaturan')?>" method="post">
                      <button class="btn-floating waves-effect waves-light red" title="Not Confirmed" type="submit" name="idPengaturan" value="bismillah"><i class="material-icons">settings</i></button>
                    </form>
                  </td
                </tr>
                <tr>
                  <td>3</td>
                  <td>BNI</td>
                  <td>Bank BNI</td>
                  <td>
                    <i class="material-icons" title="Keduanya">star</i>
                  </td>
                  <td class="alert-text" style="max-width: 330px;"></td>
                  <td>
                    <form action="<?php echo base_url('kasubag/C_requested/pengaturan')?>" method="post">
                      <button class="btn-floating waves-effect waves-light red" title="Not Confirmed" type="submit" name="idPengaturan" value="bisa"><i class="material-icons">settings</i></button>
                    </form>
                  </td
                </tr>
              </tbody>
            </table>
          </div>
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
