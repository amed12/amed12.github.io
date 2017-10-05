<!-- Main START -->
<main>
  <div class="container">
    <?php
    $level =$this->session->userdata('level');
    $yos;
    if ($level == 1) {
      $yos="Staff Kemahasiswaan";
    }elseif ($level == 2) {
      $yos="Kasubag Kemahasiswaan";
    }elseif ($level == 3) {
      $yos="Kasubag fakultas";
    }elseif ($level == 4) {
      $yos="Kabag Kemahasiswaan";
    }elseif ($level == 5) {
      $yos="Mahasiswa";
    }else {
      $yos="Admin";
    } ?>
    <h1 class="thin">Selamat datang bagian <?php echo $yos; ?></h1>
    <div id="dashboard">
      <div class="section">
        <div class="row">
          <div class="col s12">
            <!-- Dropdown Structure -->

            <nav>
              <div class="nav-wrapper">
                <a class="brand-title">Info Penting</a>
              </div>
            </nav>
            <ol>
              <li><p>Dimohon untuk mengisi Profil dan mengganti password anda jika belum terisi atau baru pertama login sistem</p></li>
              <li><p>Pastikan untuk selalu rutin mengganti password untuk menjamin keamanan akun anda</p></li>
            </ol>
          </div>

        </div>

      </div>
    </div>
  </div>
  <!-- container END -->

</main>
