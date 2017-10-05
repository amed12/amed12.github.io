<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Penerima beasiswa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/jquery-2.1.4.min.js')?>"></script>
  <!-- Theme style -->
</head>
<body onload="window.print();setTimeout(window.close, 0);">
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <img width="35px" height="35px" src="<?php echo base_url('assets/img/UIN ukuran 512.png'); ?>">&nbsp;Data Penerima Beasiswa
            <small class="pull-right">Tanggal : <?php echo date('Y-m-d'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Data rekap Penerima beasiswa
          <address>
            <strong>Kemahasiswan UIN Maulana Malik Ibrahim Malang</strong><br>
            Jalan  Gajayana Nomor 50 Kecamatan Lowokwaru Malang<br>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="table1" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>NIM</th>
                <th>NAMA</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Jenis Beasiswa</th>
                <th>Tahun</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($databea as $data): ?>

              <tr style="text-align: left;">

              <td><?php echo $data->nim?></td>
              <td><?php echo $data->namaLengkap?></td>
              <td><?php echo $data->namaFk?></td>
              <td><?php echo $data->namaJur?></td>
              <td><?php echo $data->namaBeasiswa?></td>
              <td><?php echo $data->tahun?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <script type="text/javascript">
    function getParameterByName(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var tahun = getParameterByName('tahun');
    var fakultas = getParameterByName('fakultas');
    var jurusan = getParameterByName('jurusan');
    var beasiswa = getParameterByName('beasiswa');

    $.ajax({
      url : "<?php echo site_url()?>kasubag/ModulLaporan/get_data_print/"+tahun+"/"+fakultas+"/"+jurusan+"/"+beasiswa,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $(data).each(function() {
          $('#table1 tbody').append('<tr><td>'++'</td><td>'+data['nim']+'</td><td style="text-align: justify; padding-left: 10px;">'+data['namaLengkap']+'</td><td>'+data['namaFk']+'</td><td>'+data['namaJur']+'</td><td>'+data['namaBeasiswa']+'</td><td>'+data['angkatan']+'</td></tr>')
        });

        window.print();

        setTimeout(window.close, 0);
      }
    });
    </script>

    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
</body>
</html>
