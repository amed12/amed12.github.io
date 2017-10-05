<!-- Main START -->
<main>
  <div class="container">
    <div id="dashboard">
      <div class="section">
        <div id="responsive" class="section">
          <div class="row">
            <div class="col s12 m6">
              <h4>
                Master Scoring Beasiswa
                <button class="btn-floating waves-effect waves-light primary-color z-depth-0" onclick="add_data()" title="Tambah Data"><i class="mdi-content-add"></i></button>
              </h4>
            </div>
          </div>
        <div class="row">
          <div class="col s12">
            <table class="striped" id="tabel">
              <thead>
                <tr>
                    <th data-field="id" style="width: 3%;">#</th>
                    <th data-field="jenis_scoring">Jenis Scoring</th>
                    <th data-field="opsi_scoring">(Bobot) Opsi Scoring</th>
                    <th data-field="aksi">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Rekening Listrik</td>
                  <td>
                    <div class="chip light-blue darken-1 white-text">(2) >100.000</div>
                    <div class="chip light-blue darken-2 white-text">(3) 81.000-100.000</div>
                    <div class="chip light-blue darken-3 white-text">(4) 51.000-80.0000</div>
                    <div class="chip light-blue darken-4 white-text">(5) <50.000</div>
                  </td>
                  <td>
                    <a class="btn-floating waves-effect waves-light yellow accent-4" title="Edit"><i class="material-icons">mode_edit</i></a>
                    <a class="btn-floating waves-effect waves-light red" title="Hapus"><i class="material-icons">delete</i></a>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Pekerjaan Ayah</td>
                  <td>
                    <div class="chip light-blue darken-1 white-text">(2) Almarhum</div>
                    <div class="chip light-blue darken-2 white-text">(3) Tidak Bekerja</div>
                    <div class="chip light-blue darken-3 white-text">(4) Nelayan/Buruh</div>
                    <div class="chip light-blue darken-4 white-text">(5) Petani/Pedagang/Wiraswasta</div>
                    <div class="chip light-blue darken-3 white-text">(6) Pegawai Swasta</div>
                    <div class="chip light-blue darken-2 white-text">(7) Pegawai Negeri/TNI/Polri</div>
                  </td>
                  <td>
                    <a class="btn-floating waves-effect waves-light yellow accent-4" title="Edit"><i class="material-icons">mode_edit</i></a>
                    <a class="btn-floating waves-effect waves-light red" title="Hapus"><i class="material-icons">delete</i></a>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Pekerjaan Ibu</td>
                  <td>
                    <div class="chip light-blue darken-1 white-text">(2) Almarhum</div>
                    <div class="chip light-blue darken-2 white-text">(3) Tidak Bekerja</div>
                    <div class="chip light-blue darken-3 white-text">(4) Nelayan/Buruh</div>
                    <div class="chip light-blue darken-4 white-text">(5) Petani/Pedagang/Wiraswasta</div>
                    <div class="chip light-blue darken-3 white-text">(6) Pegawai Swasta</div>
                    <div class="chip light-blue darken-2 white-text">(7) Pegawai Negeri/TNI/Polri</div>
                  </td>
                  <td>
                    <a class="btn-floating waves-effect waves-light yellow accent-4" title="Edit"><i class="material-icons">mode_edit</i></a>
                    <a class="btn-floating waves-effect waves-light red" title="Hapus"><i class="material-icons">delete</i></a>
                  </td>
                </tr>
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

  document.addEventListener("DOMContentLoaded", function(event) {
    datatable();
  });

  function datatable() {
    dataTable = $('#tabel').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
          url:"<?php echo base_url('kasubag/C_master_scoring/datatable'); ?>",
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

  function reload_table(){
    dataTable.ajax.reload(null,false);
  }

  function add_data() {
    arr = 0;
    save_method = 'add';
    $('#formInput')[0].reset();
    $('#scoreInput').empty();
    $('#modal1').openModal();
  }

  function add_score_input() {
    score_input = `
      <div class="input-field col s10">
        <input type="hidden" id="idSub[`+arr+`]" name="idSub[`+arr+`]" class="validate">
        <input name="score[`+arr+`]" id="score[`+arr+`]" type="text">
        <label for="score[`+arr+`]">Scoring `+(arr+1)+`</label>
      </div>
      <div class="input-field col s2">
        <input name="bobot[`+arr+`]" id="bobot[`+arr+`]" type="text" class="validate">
        <label for="bobot[`+arr+`]">Bobot<label>
      </div>
    `;
    $("#scoreInput").append(score_input);
    arr+=1;
  }

  function save()
  {
    var url;
    if(save_method == 'add')
    {
      url = "<?php echo site_url('kasubag/C_master_scoring/add_data')?>";
    }
    else
    {
      url = "<?php echo site_url('kasubag/C_master_scoring/update_data')?>";
    }
    $.ajax({
      url : url,
      type: "POST",
      data: $('#formInput').serialize(),
      dataType: "JSON",
      success: function(data)
      {
         $('#modal1').closeModal();
         reload_table();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error adding/update data');
      }
    });
  }

  function edit(id) {
    arr = 0;
    save_method = 'update';
    $('#formInput')[0].reset();
    $('#scoreInput').empty();

    $.ajax({
      url : "<?php echo site_url('kasubag/C_master_scoring/edit_data/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#jenisScoring').val(data[0].namaJenis);
        $('#idJenisScoring').val(data[0].idJenis);

        for (var i = 1; i < data.length; i++) {
          idSub = data[i].idSub;
          sub = data[i].sub;
          skor = data[i].skor;
          score_input = `
            <div class="input-field col s10">
              <input type="hidden" id="idSub[`+arr+`]" name="idSub[`+arr+`]" value="`+idSub+`" class="validate">
              <input name="score[`+arr+`]" id="score[`+arr+`]" type="text" value="`+sub+`">
              <label for="score[`+arr+`]">Scoring `+(arr+1)+`</label>
            </div>
            <div class="input-field col s2">
              <input name="bobot[`+arr+`]" id="bobot[`+arr+`]" type="text" value="`+skor+`" class="validate">
              <label for="bobot[`+arr+`]">Bobot<label>
            </div>
          `;
          $("#scoreInput").append(score_input);
          arr+=1;
        }
        reloadJs('materialize', 'min');
        reloadJs('initialize', 'nomin');
        $('#modal1').openModal();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data');
      }
    });
  }

  function remove(id, nama) {
    swal({
  		title: '"'+nama+'"',
  		text: "Apakah anda yakin ingin menghapus jenis scoring ini?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#F44336',
  		confirmButtonText: 'Hapus',
  		cancelButtonText: "Batal",
  		closeOnConfirm: false,
  		closeOnCancel: false
  	},
  	function(isConfirm){
      if (isConfirm){
        $.ajax({
          url : "<?php echo site_url('kasubag/C_master_scoring/delete_data/')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            reload_table();
            swal("Terhapus :(", "Jenis scoring pilihan telah berhasil dihapus!", "success");
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            swal("Erorr!", "Terjadi masalah saat penghapusan data!", "error");
          }
        });
      } else {
        swal("Dibatalkan :)", "Penghapusan jenis scoring dibatalkan!", "error");
      }
  	});
  }
</script>

<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Master Scoring Beasiswa</h4>
    <hr><br>
    <form action="#" id="formInput">
    <div class="">
      <div class="input-field">
        <input type="hidden" id="idJenisScoring" name="idJenisScoring">
        <input id="jenisScoring" type="text" name="jenisScoring" class="validate">
        <label for="jenisScoring">Jenis Scoring</label>
      </div>

      <div class="row">
        <div class="col s12 m12">
          <div class="card blue-grey">
            <div class="card-content white-text center">
              SCORING
            </div>
          </div>
        </div>
      </div>

      <div class="row" id="scoreInput">
      </div>

    </div>
    <hr>
    </form>
    <div class="">
      <button class="btn-floating waves-effect waves-light" title="Tambah Scoring" onclick="add_score_input()"><i class="material-icons">add</i></button>
      Tambahkan scoring beasiswa. <br><br><small class="blue-text">**Untuk menghapus, biarkan kosong pada isian scoring.</small>
    </div>
  </div>
  <div class="modal-footer">
    <button class=" modal-action modal-close waves-effect waves-green btn-flat" onclick="save()">Simpan</button>
  </div>
</div>
