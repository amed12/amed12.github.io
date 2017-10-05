<main id="main">
  <div class="container">
    <h3><span class="blue-text">Laporan Penerima Beasiswa</span></h3>
    <div id="dashboard">
      <div class="section">
        <form action="<?php echo base_url('kasubag/ModulLaporan/searchFilter'); ?>" method="post" class="col s12 m12">
          <div class="row">
            <div class="col s3">
              <label>tahun</label>
              <select name="tahun" id="tahun" onChange="viewTabel()">
                <option value="" disabled selected>Pilih Tahun</option>
                <?php
                foreach ($tahun as $row) {
                  ;?>
                  <option value="<?php echo $row->tahun;?>"><?php echo $row->tahun;?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col s3">
                <label>Fakultas</label>
                <select name="fakultas" id="fakultas" onChange="viewTabel()">
                  <option value="" disabled selected>Pilih Fakultas</option>
                  <?php foreach ($fakultas as $rowFK): ?>
                    <option value="<?php echo $rowFK['id'] ?>"><?php echo $rowFK['namaFk'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col s3">
                <label>jurusan</label>
                <select name="jurusan" id="jurusan" onChange="viewTabel()">
                  <option value="" disabled selected>Pilih Jurusan</option>
                </select>
              </div>
              <div class="col s3">
                <label>Jenis Beasiswa</label>
                <select name="beasiswa" id="beasiswa" onChange="viewTabel()">
                  <option value="" disabled selected>Pilih beasiswa</option>
                  <?php foreach ($beasiswa as $rowsBea): ?>
                    <option value="<?php echo $rowsBea['id'] ?>"><?php echo $rowsBea['namaBeasiswa'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </form>
          <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large red" onclick="print_laporan();">
             <i class="large material-icons">print</i></a>
           </div>
           <table class="striped table-responsive highlight bordered" id="tabelBeasiswa">
            <thead>
              <tr>
                <td data-field="nim">NIM</td>
                <td data-field="nama">NAMA</td>
                <td data-field="fakultas">Fakultas</td>
                <td data-field="jurusan">Jurusan</td>
                <td data-field="beasiswa">Jenis Beasiswa</td>
                <td data-field="angkatan">Tahun</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script type="text/javascript">
    var dataTable;
    var tahun;
    var fakultas;
    var jurusan;
    var beasiswa;
    document.addEventListener("DOMContentLoaded", function (event) {
    // datatable();
  });

    function viewTabel() {
      tahun = $("#tahun").val();
      fakultas = $("#fakultas").val();
      jurusan = $("#jurusan").val();
      beasiswa= $("#beasiswa").val();

      datatable();

      reloadJs('materialize','min');
      reloadJs('initialize','nomin');
    }

    function myTimer() {
      reload_table();
    }

    function datatable() {
      dataTable = $('#tabelBeasiswa').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax":{
          url: "<?php echo base_url('kasubag_fakultas/C_kasubagfk/datatable'); ?>",
          type: "POST",
          data:{'tahun':tahun,'fakultas':fakultas,'jurusan':jurusan,'beasiswa':beasiswa}
        },
        "columnDefs": [
        {
          "targets": [2,-1],
          "orderable":false,
        },
        ],
        "dom": '<"row" <"col s6 m6 l3 left"l><"col s6 m6 l3 right"f>><"bersih tengah" rt><"bottom"ip>'
      });
    }
    function reload_table() {
      dataTable.ajax.reload(null, false);
    }
  </script>
  <script>
    function print_laporan() {

      var tahun;
      var fakultas;
      var jurusan;
      var beasiswa;
      tahun = $('#tahun').val();
      fakultas = $('#fakultas').val();
      jurusan = $('#jurusan').val();
      beasiswa = $('#beasiswa').val();

      window.open("<?=site_url()?>kasubag_fakultas/C_kasubagfk/get_data_print/"+tahun+"/"+fakultas+"/"+jurusan+"/"+beasiswa);

    }
    $(document).ready(function(){
     $('#fakultas').change(function(){
      var fakultas =  $('#fakultas').val();
      $.ajax({
        url: '<?php echo base_url('kasubag_fakultas/C_kasubagfk/getJurusan'); ?>',
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

     $('#tombolPrint').on('click', function(){
       var tahun;
       var fakultas;
       var jurusan;
       var beasiswa;
       tahun = $('#tahun').val();
       fakultas = $('#fakultas').val();
       jurusan = $('#jurusan').val();
       beasiswa = $('#beasiswa').val();
       $.ajax({
        type: 'ajax',
        method: 'GET',
        url : '<?php echo base_url('kasubag_fakultas/C_kasubagfk/DataPenerima'); ?>',
        data: {'thn':tahun,'fk':fakultas,'jrs':jurusan,'bea':beasiswa},
        async: false,
        dataType: 'json',
        success: function(data){

        },
        error: function(e){
          alert('error'+e);
        }
      });

     });
   });
 </script>
