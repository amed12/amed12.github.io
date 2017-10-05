<main xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <h3><span class="blue-text">Ubah Status Mahasiswa</span></h3>
        <!--  Tables Section-->
        <div id="dashboard">
            <div class="section">

                <div class="row">
                    <div class="col s12">
                        <table class="striped" id="tabel">
                            <thead>
                                <tr>
                                    <th data-field="id" style="width: 3%;">#</th>
                                    <th data-field="jenis_scoring">NIM</th>
                                    <th data-field="opsi_scoring">Beasiswa</th>
                                    <th data-field="opsi_scoring">Status</th>
                                    <th data-field="opsi_scoring">Waktu Pendaftaran</th>
                                    <th data-field="aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Beasiswa</th>
                                    <th>Status</th>
                                    <th>Waktu Pendaftaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
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

    document.addEventListener("DOMContentLoaded", function (event) {
        datatable();
    });
    function datatable() {
        dataTable = $('#tabel').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('kasubag/C_ubahStatus/datatable'); ?>",
                type: "POST"
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
    function add_person() {
        arr = 0;
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals


        // show bootstrap modal
        $('.modal-title').text('Tambah user baru'); // Set Title to Bootstrap modal title
    }
    function seleksi(userId, status)
    {
      var url = "<?php echo site_url('kasubag/C_ubahStatus/seleksi')?>";
      $.ajax({
        url : url+"/"+userId+"/"+status,
        type: "POST",
        data: $('#formInput').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          reload_table();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error adding/update data');
      }
  });
  }
</script>
