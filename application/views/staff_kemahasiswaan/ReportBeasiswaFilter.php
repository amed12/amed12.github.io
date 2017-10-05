<main>
  <div class="container">
    <h3><span class="blue-text">Laporan Pemohon Beasiswa</span></h3>
    <div id="dashboard">
      <div class="section">
        <form action="" method="post" class="col s12 m12">
          <div class="row">
            <div class="col s3">
            <label>Tahun</label>
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
    <div class="wrapper" id="diprint" style="visibility: hidden;">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img width="35px" height="35px" src="<?php echo base_url('assets/img/UIN ukuran 512.png'); ?>">&nbsp;Grafik perbandingan Pendaftar dan Penerima Beasiswa  <small class="pull-right">Tahun  <?php echo date('Y'); ?></small>

            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">

            <address>
              <strong>Kemahasiswan UIN Maulana Malik Ibrahim Malang</strong><br>
              Jalan  Gajayana Nomor 50 Kecamatan Lowokwaru Malang<br>

            </address>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row"">
          <table class="striped table-responsive highlight bordered" id="tabelBeasiswa2">
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



        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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
     url: "<?php echo base_url('staf_kemahasiswaan/C_staff/datatablePemohon'); ?>",
     type: "POST",
     data:{'tahun':tahun,'fakultas':fakultas,'jurusan':jurusan,'beasiswa':beasiswa}
   },
   "columnDefs": [
   {
    "targets": [2,-1],
    "orderable":false,
  },
  ],
  "dom": '<"row" <"col s6 m6 l3 left"l><"col s6 m6 l3 right"f>><"bersih tengah" rt><"bottom"ip>',
});
   dataTable = $('#tabelBeasiswa2').DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax":{
      url: "<?php echo base_url('staf_kemahasiswaan/C_staff/datatablePemohon'); ?>",
      type: "POST",
      data:{'tahun':tahun,'fakultas':fakultas,'jurusan':jurusan,'beasiswa':beasiswa}
    },
    "columnDefs": [
    {
      "targets": [2,-1],
      "orderable":false,
    },
    ],
    "dom": '<"row" <"col s6 m6 l3 left"l><"col s6 m6 l3 right"f>><"bersih tengah" rt><"bottom"ip>',
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

    window.open("<?=site_url()?>staf_kemahasiswaan/C_staff/get_data_print1/"+tahun+"/"+fakultas+"/"+jurusan+"/"+beasiswa);

  }
  $(document).ready(function(){
   $('#fakultas').change(function(){
    var fakultas =  $('#fakultas').val();
    $.ajax({
      url: '<?php echo base_url('staf_kemahasiswaan/C_staff/getJurusan'); ?>',
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
   });
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
  $('#tabelBeasiswa').DataTable( {
    dom: 'Bfrtip',
    buttons: [
    'print'
    ]
  } );
} );
</script>
