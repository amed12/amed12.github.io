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
          </div>
        <div class="row">
          <div class="col s12">
            <table class="striped" id="tabel">
              <thead>
                <tr>
                    <th data-field="id" style="width: 3%;">#</th>
                    <th data-field="bea">Beasiswa</th>
                    <th data-field="penyelenggara">Penyelenggara</th>
                    <th data-field="tglBuka">Tanggal Buka</th>
                    <th data-field="tglTutup">Tanggal Tutup</th>
                    <th data-field="aksi">Aksi</th>
                </tr>
              </thead>
              <tbody>
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
        url:"<?php echo base_url('mahasiswa/C_daftar_bea/datatable'); ?>",
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
