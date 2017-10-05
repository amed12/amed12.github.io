<main xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <h3 style="text-align: center;"><span class="blue-text">Manajemen User System</span></h3>

        <?=form_open('C_admin/ajax_update')?>
            <input type="hidden" value="<?=$mhs->id ?>" name="lo"/>
            <div class="input-field">
                <input name="userId" id="to_email" type="text" class="validate" value="<?=$mhs->userId ?>">

                <label for="to_email" data-error="Harap isi dengan angka" data-success="Benar">User ID</label>

            </div>
            <div class="input-field">
                <input name="password" id="subject" type="text" class="validate" value="<?=$mhs->password ?>">
                <label for="subject">Password</label>

            </div>
            <div class="row">

                <div class="input-field col s12">
                    <?php 
                    $jupuk = $mhs->idLevel ?>
                <!-- <select class="form-control" name="idLevel" id="levelPengguna">
                    <option>Pilih Level Pengguna</option>
                    <option value="1">Staff Kemahasiswaan</option>
                    <option value="2">Kasubag</option>
                    <option value="3">Kasubag Fakultas</option>
                    <option value="4">kabag</option>
                    <option value="5">Mahasiswa</option>
                    <option value="6">Admin</option>

                </select> -->
                <select class="form-control" name="idLevel" id="levelPengguna">
                  <option <?=($jupuk=='1')?'selected="selected"':''?>>Staff Kemahasiswaan</option>
                  <option <?=($jupuk=='2')?'selected="selected"':''?>>Kasubag</option>
                  <option <?=($jupuk=='3')?'selected="selected"':''?>>Kasubag Fakultas</option>
                  <option <?=($jupuk=='4')?'selected="selected"':''?>>Kabag</option>
                  <option <?=($jupuk=='5')?'selected="selected"':''?>>Mahasiswa</option>
                  <option <?=($jupuk=='6')?'selected="selected"':''?>>Admin</option>
              </select>
              <label for="levelPengguna">Level Pengguna</label>
              <span class="mdi-action-help"></span>
          </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
            <?php 
            $jupuk2 = $mhs->status ?>
            <select name="status" id="levelPengguna2">
            <option <?=($jupuk2=='open')?'selected="selected"':''?>>Aktif</option>
            <option <?=($jupuk2=='close')?'selected="selected"':''?>>Tidak Aktif</option>
            </select>
          <label for="levelPengguna2">Status user</label>
          <span class="mdi-action-help"></span>
          <p>(Aktif= boleh mengakses sistem/Tidak Aktif = tidak bisa akses sistem)<br><br></p>
      </div>
  </div>
  <div class="buttons">
        <button class="waves-effect waves-light btn" id="btnSave" type="submit"><i class="material-icons right">done</i>Save changes</button>
        <button class="waves-effect waves-light btn blue-grey lighten-2"  name="action2"><i class="material-icons right">clear</i>Cancel</button>
    </div>
</div>
    

</form>


<!-- container END -->

<!-- New message Modal Trigger -->
<script type="text/javascript">
    function save() {

       
        var url;

        url = "<?php echo site_url('C_admin/ajax_update')?>";
        // ajax adding data to database
        $.ajax({
            url: url ,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                window.location.href= '<?php echo site_url('C_admin/mjm_user')?>'
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding/update data');
            }
        });
    }
</script>
