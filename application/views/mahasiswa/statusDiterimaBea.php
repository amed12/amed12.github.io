<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
        <div id="responsive" class="section">
          <div class="row">
            <div class="col s6">
              <h4>
                List Daftar Beasiswa
              </h4>
            </div>
          </div>
          <div class="col m12 s12">
            <div class="row">
              <div class="col m12 s12">
                <div class="card-panel">
                  <div class="row">
                    <div class="col m2 s4">
                      <h6 class="blue-text">NIM</h6>
                    </div>
                    <div class="col m4 s8">
                      <h6>: <span class="blue-text"><?php echo $nim; ?></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col m2 s4">
                      <h6 class="blue-text">Nama</h6>
                    </div>
                    <div class="col m4 s8">
                      
                        <h6>: <span class="blue-text"><?php echo $nama; ?></span></h6>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col m6 s12">
            <h5 class="blue-text" style="text-align: center;">Anda terdaftar sebagai penerima <b>Beasiswa <?php echo $bea;?></b></h5>
            <?php 
            $buka = strtotime($tglBuka);
            $akhirPeriode = strtotime($periodeBerakhir);
            ;?>
            <h6 class="blue-text" style="text-align: center;">Periode tahun <?php echo date('Y', $buka);?> - <?php echo date('Y',$akhirPeriode) ;?></h6>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <!-- container END -->
</main>