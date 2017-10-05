<!-- Main START -->
<?php
foreach ($grafis as $rows) {
    $beasiswa[] = $rows->namaBeasiswa;
    $penerima[] = (int) $rows->penerima;
}

foreach ($pemohon as $rows2) {
    $beasiswa2[] = $rows2->namaBeasiswa;
    $pemohon_fetch[] = (int) $rows2->pemohon;
}
?>
<main>
    <div class="container">
        <h1 class="thin">Grafik Pemohon dan Penerima</h1>
        <div id="dashboard">
            <div class="section">
                <p>Persentase penerima dan pemohon beasiswa.</p>
                <canvas id="grafik" width="1000" height="280"></canvas>
            </div>
              <a class="btn-floating btn-large red" href="<?php echo base_url('kasubag/ModulLaporan/semuaDataPemohon') ?>">
                        <i class="large material-icons">print</i>
                    </a>
    
        </div>
    </div>
    
                  
    <!-- container END -->
</main>
<script>
    var linechartData = {
        labels: <?php echo json_encode($beasiswa); ?>,
        datasets: [
            {
                label: "Penerima ",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(152,235,239,1)",
                data: <?php echo json_encode($penerima) ?>
            },
            {
                label: "Pemohon ",
                fillColor: "rgba(40,200,10,0.9)",
                strokeColor: "rgba(40,200,10,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(120,235,239,1)",
                data: <?php echo json_encode($pemohon_fetch) ?>
            }
        ]
    }
    var myLine = new Chart(document.getElementById("grafik").getContext("2d")).Bar(linechartData);
</script>