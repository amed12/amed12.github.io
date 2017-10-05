<!-- Main START -->
<main>
    <div class="container">
        <h3 style="text-align: center;"><span class="blue-text">Grafik perbandingan Pendaftar dan Penerima Beasiswa</span></h3>
        <div id="dashboard">
            <div class="section">

                <div class="row">
                  <?php
                  $nama_bea = array();
                  $terima = array();
                  $daftar = array();
                  foreach ($view_grafik as $vg) {
                    $nama_bea[] = $vg->namaBeasiswa;
                    $terima[] = $vg->penerima;
                    $daftar[] = $vg->mhsDaftar;
                  }
                   ?>
                  <div class="col m6">
                    <font size="4pt" class="blue-text">Pilih periode beasiswa: </font><br>
                    <select class="" name="pilih_tahun" id="pilih_tahun" onChange="refresh_chart()">
                      <option value="kosong">-Pilih Tahun</option>
                      <?php
                      foreach ($tahun as $th) {
                        if ($selected_tahun==$th->tahun) {
                          $selected="selected";
                        }else {
                          $selected="";
                        }
                        echo '<option value="'.$th->tahun.'" '.$selected.'>'.$th->tahun.'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col m12" id="graf" style="visibility: visible;">
                    <canvas id="grafik" style="overflow-x: scroll;"></canvas>
                  </div>
                  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                    <a class="btn-floating btn-large red" onclick="window.print()">
                        <i class="large material-icons">print</i>
                    </a>
                </div>
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
                            <img width="35px" height="35px" src="<?php echo base_url('assets/img/UIN ukuran 512.png'); ?>">&nbsp;Grafik perbandingan Pendaftar dan Penerima Beasiswa <small class="pull-right">Tahun  <?php echo date('Y'); ?></small>
                            
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
                    <div class="col m12">
                    <canvas id="grafik2" style="overflow-x: scroll;"></canvas>

                  </div>
                  
                    
                  
                    <!-- /.col -->      
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
    <!-- container END -->
</main>
<script type="text/javascript">
function refresh_chart() {
  id_data = $('#pilih_tahun').val();
  url = "<?php echo site_url('mahasiswa/C_mahasiswa/viewGrafik')?>";
  window.location.href=url+'/'+id_data;
}
</script>

<script>
    var linechartData = {
        labels: <?php echo json_encode($nama_bea); ?>,
        datasets: [
            {
                label: "Penerima ",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(152,235,239,1)",
                data: <?php echo json_encode($terima) ?>
            },
            {
                label: "Pendaftar ",
                fillColor: "rgba(40,200,10,0.9)",
                strokeColor: "rgba(40,200,10,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(120,235,239,1)",
                data: <?php echo json_encode($daftar) ?>
            }
        ]
    }

    var options = {
      responsive: true,
      pointDotRadius: 10,
      bezierCurve: false,
      scaleShowVerticalLines: false,
    };
    var myLine = new Chart(document.getElementById("grafik").getContext("2d")).Bar(linechartData, options);
    var myLine = new Chart(document.getElementById("grafik2").getContext("2d")).Bar(linechartData, options);
</script>
