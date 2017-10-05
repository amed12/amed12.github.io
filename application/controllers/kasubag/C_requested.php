<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_requested extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    
    $this->load->model("kasubag/Requested",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/requested');
    $this->load->view('attribute/footer');
  }

  public function pengaturan()
  {
    $id = $this->input->post('idPengaturan');
    if ($id != null) {
      $detailBea= $this->mdl->get_by_id_bea($id);
      $data = array(
        'idSetBea' => $id,
        'nama' => $detailBea->namaBeasiswa,
        'penyelenggara' => $detailBea->penyelenggaraBea,
        'selektor' => $detailBea->selektor,
        'keterangan' => $detailBea->keterangan,
        'dibuka' => $detailBea->beasiswaDibuka,
        'ditutup' => $detailBea->beasiswaTutup,
        'periodeBerakhir' =>$detailBea->periodeBerakhir,
        'seleksiTutup' =>$detailBea->seleksiTutup,
        'kuota' => $detailBea->kuota,
        'namaFk' => $detailBea->namaFk,
        'skor' => $this->mdl->get_skor_by_idBea($id),
        'combo' => $this->mdl->get_scoring(),
        'combo_fkltas' => json_encode($this->mdl->get_fakultas())
      );
    }else {
      $data = array(
        'idSetBea' => "",
        'nama' => "",
        'penyelenggara' => "",
        'selektor' => "",
        'keterangan' => "",
        'dibuka' => "",
        'ditutup' => "",
        'periodeBerakhir'=>"",
        'seleksiTutup' =>"",
        'kuota' => "",
        'namaFk' => "",
        'skor' => null,
        'combo_fkltas' => json_encode($this->mdl->get_fakultas())
      );
    }
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/pengaturan', $data);
    $this->load->view('attribute/footer');
  }

  public function datatable(){
    $fetch_data = $this->mdl->make_datatables();
    $data = array();
    $nmr = 0;
    foreach($fetch_data as $row)
    {
      $nmr+=1;
      $sub_array = array();
      $sub_array[] = $nmr;
      $sub_array[] = $row->namaBeasiswa;
      $sub_array[] = $row->penyelenggaraBea;
      if ($row->selektor == "1") {
        # kasubag kemahasiswaan
        $sub_array[] = '<i class="mdi-toggle-radio-button-on" title="Kasubag. Kemahasiswaan"></i> Kms';
      }elseif ($row->selektor == "2") {
        # kasubag kemahasiswaan fakultas
        $sub_array[] = '<i class="mdi-toggle-radio-button-off" title="Kasubag. Kemahasiswaan Fakultas"></i> Fks';
      }elseif ($row->selektor == "3") {
        # keduanya
        $sub_array[] = '<i class="mdi-action-stars" title="Keduanya"></i> 2K';
      }
      $status = $row->statusBeasiswa;
      if ($status=="0" || $status=="1" ||$status=="3") {
        # aktif/confirmed
        $sub_array[] = '<span class="success-text">Telah Dikonfirmasi</span>';
        $sub_array[] = '
          <a class="btn-floating waves-effect waves-light primary-color z-depth-0" title="Confirmed"><i class="mdi-action-done"></i></a>
          ';
      }else{
        # ditolak
        $sub_array[] = '<span class="alert-text">'.$row->keterangan.'</span>';
        $alamat = base_url('kasubag/C_requested/pengaturan');
        $sub_array[] = '
            <form action="'.$alamat.'" method="post">
              <button class="btn-floating waves-effect waves-light red" title="Not Confirmed" type="submit" name="idPengaturan" value="'.$row->id.'"><i class="mdi-action-settings"></i></button>
            </form>
          ';
      }
      $data[] = $sub_array;
    }
    $output = array(
      "draw"            =>  intval($_POST["draw"]),
      "recordsTotal"    =>  $this->mdl->get_all_data(),
      "recordsFiltered" =>  $this->mdl->get_filtered_data(),
      "data"            =>  $data
    );
    echo json_encode($output);
  }

  public function get_scoring_data()
  {
    $data = $this->mdl->get_scoring();
    echo json_encode($data);
  }

  public function add_data()
  {
    $slktr = $this->input->post('selektor');
    if($slktr == "2"){
      $data_bea = array(
        'namaBeasiswa' => $this->input->post('nama'),
        'penyelenggaraBea' => $this->input->post('penyelenggara'),
        'beasiswaDibuka' => $this->input->post('dibuka'),
        'beasiswaTutup' => $this->input->post('ditutup'),
        'periodeBerakhir' => $this->input->post('periodeBerakhir'),
        'seleksiTutup' => $this->input->post('penyeleksianDitutup'),
        'kuota' => $this->input->post('kuota'),
        'selektor' => $this->input->post('selektor'),
        'selektorFakultas' => $this->input->post('selektor_fakultas')
      );
    }else{
      $data_bea = array(
        'namaBeasiswa' => $this->input->post('nama'),
        'penyelenggaraBea' => $this->input->post('penyelenggara'),
        'beasiswaDibuka' => $this->input->post('dibuka'),
        'beasiswaTutup' => $this->input->post('ditutup'),
        'periodeBerakhir' => $this->input->post('periodeBerakhir'),
        'seleksiTutup' => $this->input->post('penyeleksianDitutup'),
        'kuota' => $this->input->post('kuota'),
        'selektor' => $this->input->post('selektor')
      );
    }

    $insert_bea = $this->mdl->save_bea($data_bea);

    $count_score = count($this->input->post('score'));
    if ($this->input->post('score')) {
      $data = array();
      for ($i=0;$i<$count_score;$i++) {
        $skor = $this->input->post('score['.$i.']');
        if ($skor != "HAPUS") {
          $data[]= array(
            'idBea' => $insert_bea,
            'idKategoriSkor' => $skor,
          );
        }
      }
      $insert_sub_bea = $this->mdl->save_sub_bea($data);
    }
    echo json_encode(array("status" => TRUE));
  }

  public function update_data()
  {
    $slktr = $this->input->post('selektor');
    if($slktr == "2"){
      $data_bea = array(
        'namaBeasiswa' => $this->input->post('nama'),
        'penyelenggaraBea' => $this->input->post('penyelenggara'),
        'beasiswaDibuka' => $this->input->post('dibuka'),
        'beasiswaTutup' => $this->input->post('ditutup'),
        'periodeBerakhir' => $this->input->post('periodeBerakhir'),
        'seleksiTutup' => $this->input->post('penyeleksianDitutup'),
        'kuota' => $this->input->post('kuota'),
        'selektor' => $this->input->post('selektor'),
        'selektorFakultas' => $this->input->post('selektor_fakultas')
      );
    }else {
      $data_bea = array(
        'namaBeasiswa' => $this->input->post('nama'),
        'penyelenggaraBea' => $this->input->post('penyelenggara'),
        'beasiswaDibuka' => $this->input->post('dibuka'),
        'beasiswaTutup' => $this->input->post('ditutup'),
        'periodeBerakhir' => $this->input->post('periodeBerakhir'),
        'seleksiTutup' => $this->input->post('penyeleksianDitutup'),
        'kuota' => $this->input->post('kuota'),
        'selektor' => $this->input->post('selektor'),
        'selektorFakultas' => null
      );
    }
    $idSetBea = $this->input->post('idSetBea');
    $this->mdl->update_setting_bea(array('id' => $idSetBea), $data_bea);

    $count_score = count($this->input->post('score'));
    for ($i=0;$i<$count_score;$i++) {
      $skor = $this->input->post('score['.$i.']');
      $idSet = $this->input->post('idSet['.$i.']');
      if ($skor != null && $idSet == null && $skor != "HAPUS") {
        # insert kategori
        $data= array(
          'idBea' => $idSetBea,
          'idKategoriSkor' => $skor,
        );
        $this->mdl->insert_setting_sub_bea($data);
      }elseif ($skor != null && $idSet != null && $skor != "HAPUS") {
        # update kategori
        $data= array(
          'idBea' => $idSetBea,
          'idKategoriSkor' => $skor,
        );
        $this->mdl->update_setting_sub_bea(array('id' => $idSet), $data);
      }elseif ($skor != null && $idSet != null && $skor == "HAPUS") {
        # delete kategori
        $this->mdl->delete_setting_sub_bea($idSet);
      }
    }
    echo json_encode(array("status" => TRUE));
  }

  public function delete_data()
  {
    $id = $this->input->post('idSetBea');
    $this->mdl->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }

}
 ?>
