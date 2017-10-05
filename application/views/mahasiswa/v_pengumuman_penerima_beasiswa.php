<main xmlns="http://www.w3.org/1999/html">
  <div class="container">
    <h3><span class="blue-text">Pengumuman Penerima Beasiswa</span></h3>
    <!--  Tables Section-->
    <div id="dashboard">
      <div class="section">
        <form action="<?php echo base_url('mahasiswa/C_mahasiswa/searchFilter'); ?>" method="post" class="col s12">
          <div class="col m12 s12">
            <div class="row">
              <div class="card-panel">
                <div class="row">                        
                  <div class="input-field col s3">
                    <select id="tahun" name="tahun" onChange="viewTabel()">
                      <option value="" disabled selected>Pilih Tahun</option>
                      <?php
                      foreach ($tahun as $row) {
                        ;?>
                        <option value="<?php echo $row->tahun;?>"><?php echo $row->tahun;?></option>
                        <?php }?>
                      </select>
                      <label>Tahun</label>
                    </div>
                    <div class="input-field col s3">
                      <select id="fakultas" name="fakultas" onChange="viewTabel()">
                        <option value="" disabled selected>Fakultas</option>
                        <?php
                        foreach ($fakultas as $row) {
                          ;?>
                          <option value="<?php echo $row->id;?>"><?php echo $row->namaFk;?></option>
                          <?php }?>
                        </select> 
                        <label>Fakultas</label>                   
                      </div>
                      <div class="input-field col s3" id="comboJurusan">
                        <select id="jurusan" name="jurusan" onChange="viewTabel()">
                          <option value="">Pilihlah Jurusan</option>
                        </select>
                        <label>Jurusan</label>
                      </div>
                      <div class="input-field col s3">
                        <select id="beasiswa" name="beasiswa" onChange="viewTabel()">
                          <option value="" disabled selected>Beasiswa</option>
                          <?php
                          foreach ($beasiswa as $row) {
                            ;?>
                            <option value="<?php echo $row->id;?>"><?php echo $row->namaBeasiswa;?></option>
                            <?php }?>
                          </select>
                          <label>Nama Beasiswa</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              <div class="row">
                <div class="col s12">
                  <table class="striped" id="tabel">
                    <thead>
                      <tr>
                        <th data-field="id" style="width: 3%;">#</th>
                        <th data-field="nim">Nim</th>
                        <th data-field="nama">Nama</th>
                        <th data-field="fakultas">Fakultas</th>
                        <th data-field="jurusan">Jurusan</th>
                        <th data-field="beasiswa">Beasiswa</th>
                        <th data-field="update">Tahun</th>
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
      var save_method;
      var arr = 0;
      var dataTable;
      var tahun;
      var fakultas;
      var jurusan;
      var beasiswa;
      var myVar;

      document.addEventListener("DOMContentLoaded", function (event) {
    // datatable();
  });
      function viewTabel() {
        tahun = $("#tahun").val();
        fakultas = $("#fakultas").val();
        jurusan = $("#jurusan").val();
        beasiswa = $("#beasiswa").val();

        datatable();

        reloadJs('materialize', 'min');
        reloadJs('initialize', 'nomin');
      }

      function myTimer() {
        reload_table();
      }

      function datatable() {
        dataTable = $('#tabel').DataTable({
          "destroy":true,
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            url:"<?php echo base_url('mahasiswa/C_mahasiswa/datatable');?>",
            type: "POST",
            data:{'tahun':tahun,'fakultas':fakultas,'jurusan':jurusan,'beasiswa':beasiswa}
          },
          "columnDefs": [
          {
            "targets": [2, -1],
            "orderable": false,
          },
          ],
          "dom": '<"row" <"col s6 m6 l3 left"l><"col s6 m6 l3 right"f>><"bersih tengah" rt><"bottom"ip>',
        });
      }
      function reload_table() {
        dataTable.ajax.reload(null, false);
      }
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
       $('#fakultas').change(function(){
        var fakultas =  $('#fakultas').val();
        $.ajax({
          url: '<?php echo base_url('mahasiswa/C_mahasiswa/getjurusan'); ?>',
          type: 'GET',
          data: "fakultas="+fakultas,
          dataType: 'json',
          success: function(data){
           var fakultas=`<select id="jurusan" name="jurusan">
           <option value="null">Pilihlah Jurusan</option>`;
           for (var i = 0; i < data.length; i++) {
            fakultas+='<option value="'+data[i].id+'">'+data[i].namaJur+'</option>';
          }
          fakultas+=`</select>
          <label>Jurusan</label>`;
          $('#jurusan').html(fakultas);
          reloadJs('materialize','min');
          reloadJs('initialize','nomin');
        }
      });
      });
     });
   </script>
